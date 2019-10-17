<?php

namespace KaliForms\Inc\Utils;

class Emailer
{
    /**
     * Plugin slug
     *
     * @var string
     */
    public $slug = 'kaliforms';
    /**
     * Current form id
     *
     * @var [Number]
     */
    public $form = null;
    /**
     * Submission id
     *
     * @var [type]
     */
    public $submission = null;
    /**
     * Placeholders
     *
     * @var array
     */
    public $placeholders = [];
    /**
     * Data
     *
     * @var [type]
     */
    public $data = [];
    /**
     * Class constructor
     *
     * @param [type] $form_id
     */
    public function __construct($form_id = null, $rawData = null, $placeholders = null)
    {
        $this->form = $form_id;
        if ($this->form === null) {
            return new \WP_Error(500, esc_html__('Something went wrong', 'kaliforms'));
        }
        $this->data = $rawData;
        $this->placeholders = $placeholders;
    }

    /**
     * Attaches a submission id and popuplates 'data' and 'placeholders' with its values
     *
     * @param [type] $id
     * @return void
     */
    public function attach_submission($id)
    {
        $this->submission = $id;
        if ($this->submission === null) {
            return new \WP_Error(500, esc_html__('Something went wrong', 'kaliforms'));
        }

        $this->prepare_data();
        $this->prepare_placeholders();
    }

    /**
     * Prepares data to be used in the email
     *
     * @return void
     */
    public function prepare_data()
    {
        $components = $this->get('form', true, 'field_components', '[]');
        if ($components === null || $components === '' && $components !== null) {
            return $columns;
        }

        $components = json_decode($components);
        $arr = [];

        foreach ($components as $component) {
            $name = $this->pluck_value_from_properties('name', $component);
            if ($name !== null) {
                $arr[$name] = esc_html($this->get('submission', false, $name, ''));
            }
        }

        $this->data = $arr;
    }

    /**
     * Prepares placeholders
     *
     * @return void
     */
    public function prepare_placeholders()
    {
		// @todo just like on thankyou message
        foreach ($this->data as $k => $v) {
            $this->placeholders['{' . $k . '}'] = is_array($v)
            ? implode($this->get('form', true, 'multiple_selections_separator', ''), $v)
            : $v;
        }

        $this->placeholders = array_merge((new GeneralPlaceholders())->general_placeholders, $this->placeholders);

        if (isset($this->placeholders['{submission_link}'])) {
            $this->placeholders['{submission_link}'] = call_user_func(
                $this->placeholders['{submission_link}'],
                $this->get('form', true, 'submission_view_page', get_bloginfo('url')),
                $this->submission,
                $this->form,
                true
            );
        }
    }

    /**
     * Plucks values from the properties array
     *
     * @param [String] $key
     * @param [stdClass] $obj
     * @return String
     */
    public function pluck_value_from_properties($key, $obj)
    {
        if (isset($obj->properties->{$key})) {
            return $obj->properties->{$key};
        }
    }

    /**
     * Send emails
     *
     * @return void
     */
    public function send()
    {
		$emails = json_decode($this->get('form', true, 'emails', '[]'));
        $sent = [];
        foreach ($emails as $email) {
            $sent[] = $this->_send($email);
        }

        if (count($sent) === count($emails)) {
            return 'ok';
        }

        return new \WP_Error();
    }

    /**
     * Send emails one by one
     */
    private function _send($email)
    {
        $props = [];
        foreach ($email as $prop => $value) {
            $initialParse = is_string($value) ? strtr($value, $this->placeholders) : $value;
            $arr = [];
            $previews = $this->get_strings_between($initialParse, '{', '}');
            foreach ($previews as $preview) {
                $arr[$preview] = $this->get_image_html($preview);
            }

            $props[$prop] = strtr($initialParse, $arr);
        }

        add_filter('wp_mail_from_name', function () use ($props) {
            return $props['fromName'];
        });
        add_filter('wp_mail_from', function () use ($props) {
            return $props['fromEmail'];
        });
        add_filter('wp_mail_content_type', function () use ($props) {
            return 'text/html';
        });

        $headers = $this->_get_headers($props);

        // add_action('phpmailer_init', function ($phpmailer) use ($props) {
        //     $phpmailer->isSMTP();
        //     $phpmailer->Host = SMTP_HOST;
        //     $phpmailer->SMTPAuth = SMTP_AUTH;
        //     $phpmailer->Port = SMTP_PORT;
        //     $phpmailer->SMTPSecure = SMTP_SECURE;
        //     $phpmailer->Username = SMTP_USERNAME;
        //     $phpmailer->Password = SMTP_PASSWORD;
        //     $phpmailer->From = SMTP_FROM;
        //     $phpmailer->FromName = SMTP_FROMNAME;
        // });
        return wp_mail($props['toEmail'], $props['emailSubject'], $props['emailBody'], $headers);
    }

    /**
     * Get email headers
     *
     * @param [type] $props
     * @return void
     */
    protected function _get_headers($props)
    {
        $headers = [];
        if (!empty($props['ccEmail'])) {
            $arr = explode(',', $props['ccEmail']);
            foreach ($arr as $email) {
                $headers[] = 'CC: <' . $email . '>;';
            }
        }
        if (!empty($props['bccEmail'])) {
            $arr = explode(',', $props['bccEmail']);
            foreach ($arr as $email) {
                $headers[] = 'BCC: <' . $email . '>;';
            }
        }
        if (!empty($props['replyTo'])) {
            $arr = explode(',', $props['ccEmail']);
            foreach ($arr as $email) {
                $headers[] = 'Reply-to: <' . $email . '>;';
            }
        }
        return $headers;
    }
    /**
     * Shortcut for get_post_meta
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($entity = 'form', $prefix = true, $key = '', $default = null)
    {
        $string = $prefix ? $this->slug . '_' . $key : $key;
        $value = get_post_meta($this->{$entity}, $string, true);
        if ($value === null || $value === '' && $default !== null) {
            return $default;
        }

        return $value;
    }

    /**
     * Get images and render them as previews
     */
    public function get_image_html($string)
    {
        $trimmed = substr($string, 1, -1);
        $trimmedArray = explode(':', $trimmed);
        $id = end($trimmedArray);

        return '<img src="' . esc_url(wp_get_attachment_url($id)) . '" />';
    }

    /**
     * Gets strings between delimiters
     *
     * @param [type] $str
     * @param string $start
     * @param string $end
     * @param boolean $with_from_to
     * @return void
     */
    public function get_strings_between($str, $start = '[', $end = ']', $with_from_to = true)
    {
        $arr = [];
        $last_pos = 0;
        $last_pos = strpos($str, $start, $last_pos);
        while ($last_pos !== false) {
            $t = strpos($str, $end, $last_pos);
            $arr[] = ($with_from_to ? $start : '') . substr($str, $last_pos + 1, $t - $last_pos - 1) . ($with_from_to ? $end : '');
            $last_pos = strpos($str, $start, $last_pos + 1);
        }
        return $arr;
    }
}
