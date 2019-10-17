<?php
namespace KaliForms\Inc\Frontend;

use KaliForms\Inc\Utils;

if (!defined('ABSPATH')) {
    exit;
}

class Form_Shortcode
{
    /**
     * Metahelper trait
     */
    use Utils\MetaHelper;
    /**
     * Grid helper trait
     */
    use Utils\GridHelper;
    /**
     * Fields helper
     */
    use Utils\FieldsHelper;
    /**
     * Plugin slug
     *
     * @var string
     */
    protected $slug = 'kaliforms';
    /**
     * Post id
     *
     * @var [id]
     */
    public $id;
    /**
     * Post
     *
     * @var [post]
     */
    public $post;
    /**
     * Fields array
     *
     * @var array
     */
    public $fields = [];
    /**
     * Rows
     *
     * @var array
     */
    protected $rows = [];
    /**
     * Actual HTML being outputted
     *
     * @var string
     */
    public $html = '';
    /**
     * Load recaptcha ?
     *
     * @var boolean
     */
    public $load_grecaptcha = false;
    /**
     * Creates an instance of the form shortcode
     *
     * @param [Array] $args
     */
    public function __construct($args)
    {
        if (!isset($args['id'])) {
            return $this->display_error(esc_html__('The shortcode does not provide an id for the form', 'kaliforms'));
        }

        $this->post = get_post($args['id']);
        if ($this->post === null) {
            return $this->display_error(esc_html__('There is no form associated with this id. Make sure you copied it correctly', 'kaliforms'));
        }
        if ($this->post->post_status !== 'publish') {
            return $this->display_error(esc_html__('This form is not published.', 'kaliforms'));
        }

        $fields = json_decode($this->get('field_components', '[]'));
        foreach ($fields as $field) {
            if ($field->id === 'grecaptcha') {
                $this->load_grecaptcha = true;
            }
            $this->fields[$field->internalId] = $field;
        }

        $this->prepare_data();
        $this->load_grecaptcha_if_needed();

        apply_filters($this->slug . '_form_shortcode_init', $this);

        $form = new Form($args['id'], $this->rows, $this->get_form_info());
        $this->html = $form->render_fields();
    }

    /**
     * Grabs form info from the database
     *
     * @return void
     */
    public function get_form_info()
    {
        return apply_filters($this->slug . '_shortcode_form_info', [
            'form_id' => $this->post->ID,
            'required_field_mark' => $this->get('required_field_mark', ''),
            'global_error_message' => $this->get('global_error_message', ''),
            'multiple_selections_separator' => $this->get('multiple_selections_separator', ''),
			'remove_captcha_for_logged_users' => $this->get('remove_captcha_for_logged_users', '0'),
			'hide_form_name' => $this->get('hide_form_name', '0'),
            'css_id' => $this->get('css_id', ''),
            'css_class' => $this->get('css_class', ''),
            'form_name' => get_the_title($this->post),
            'google_site_key' => $this->get('google_site_key', ''),
            'google_secret_key' => $this->get('google_secret_key', ''),
            'currency' => $this->get('currency', ''),
        ]);
    }

    /**
     * Loads recaptcha if needed
     *
     * @return void
     */
    public function load_grecaptcha_if_needed()
    {
        if ($this->load_grecaptcha) {
            wp_enqueue_script('kali-grecaptcha');
        }
    }

    /**
     * Displays an error in the frontend
     *
     */
    public function display_error($err)
    {
        $this->html = $err;
    }

    /**
     * Prepares data so we can use it
     *
     * @return void
     */
    public function prepare_data()
    {
        $grid = json_decode($this->get('grid', '[]'));
        $this->walk_array($grid);
    }
}
