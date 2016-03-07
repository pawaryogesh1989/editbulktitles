<?php
if (!class_exists('Custom_Bulk_Edit_Title')) {

    class Custom_Bulk_Edit_Title {

        public $bulk_post_type;

        function __construct() {

            $defaults = array(
                'post_type' => 'post'
            );
            $args = wp_parse_args($args, $defaults);
            extract($args, EXTR_SKIP);

            add_thickbox();
            wp_enqueue_style('bulk-action-style', plugins_url('assets/css/bulk-style.css', __DIR__));
            wp_enqueue_script('bulk-action-script', plugins_url('/js/bulk-action.js', __DIR__), array(), '1.0.0', true);
            wp_localize_script('bulk-action-script', 'bulkactionscript', array(
                'pluginsUrl' => BULK_FILE_DIRECTORY,
                'site_url' => site_url(),
            ));
            $this->bulk_post_type = $post_type;
            $this->bulk_action_init();
        }

        public function bulk_action_init() {
            if (is_admin()) {
                add_action('admin_footer-edit.php', array(&$this, 'bulk_custom_admin_footer'));
                add_action('admin_notices', array(&$this, 'bulk_edit_success'));
            }
        }

        public function bulk_custom_admin_footer() {
            global $post_type;

            if ($post_type == $this->bulk_post_type) {
                ?>
                <script type="text/javascript">
                    jQuery(document).ready(function () {
                        jQuery('<option>').val('bulk-edit-title').text('Edit Title').appendTo("select[name='action']");
                        jQuery('<option>').val('bulk-edit-title').text('Edit Title').appendTo("select[name='action2']");
                    });
                </script>
                <?php
            }
        }

        public function Ajax_Bulk_Update_Post_Titles() {
            $post_bulk_titles = ($_REQUEST['post_title']);
            $post_bulk_id = ($_REQUEST['post_id']);

            for ($i = 0; $i < sizeof($post_bulk_id); $i++) {

                if ($post_bulk_titles[$i] != "") {
                    $bulk_post = array(
                        'ID' => $post_bulk_id[$i],
                        'post_title' => $post_bulk_titles[$i],
                    );
                    wp_update_post($bulk_post);
                }
            }
            echo "done";
            exit;
        }

        public function bulk_edit_success() {
            if (esc_attr($_REQUEST['method']) == "success") {
                ?>
                <div class="notice notice-success is-dismissible">
                    <p><?php _e('<b>Titles Updated Sucessfully!</b>', 'sample-text-domain'); ?></p>
                </div>
                <?php
            }
        }

    }

}
?>