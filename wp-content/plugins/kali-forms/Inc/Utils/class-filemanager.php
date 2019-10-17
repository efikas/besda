<?php
namespace KaliForms\Inc\Utils;

trait FileManager
{
    /**
     * Load files needed for image upload
     *
     * @return void
     */
    public function load_files()
    {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/post.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
    }
    /**
     * Runs security checks, should improve
     *
     * @return void
     */
    public function run_checks()
    {
        if (empty($_FILES)) {
            $this->display_error(esc_html__('There are no files', 'kaliforms'));
        }
	}
    /**
     * File upload
     *
     * @return void
     */
    public function upload_file()
    {
        /**
         * Run checks so we dont have any surprises
         */
        $this->run_checks();

        /**
         * Load files needed for the media handling
         */
        $this->load_files();

        // Is multiple? Split
        $uploaded = count($_FILES) > 1 ? $this->_upload_multiple() : $this->_upload_single();

        // SCHEDULE IT FOR DELETE
        wp_schedule_single_event(time() + 900, $this->slug . '_delete_transient_file', [$uploaded]);

        wp_die($uploaded);
    }

    /**
     * Upload single file
     *
     * @return void
     */
    private function _upload_single()
    {
        $file = reset($_FILES);
        $id = media_handle_sideload($file, 0, sanitize_file_name($file['name']));
        if (is_wp_error($id)) {
            unlink($file['tmp_name']);
            wp_die(
                wp_json_encode(absint($id))
            );
        }

        return $id;
    }

    private function _upload_multiple()
    {

    }

    /**
     * Deletes a files from wp
     *
     * @return void
     */
    public function delete_file()
    {
        $_POST['id'] = absint(wp_unslash($_POST['id']));
        return wp_delete_post($_POST['id'], true);
    }
}
