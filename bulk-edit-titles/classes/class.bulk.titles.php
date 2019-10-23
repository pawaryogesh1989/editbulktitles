<?php

class Custom_Bulk_Edit_Title
{

    /**
     * Constructor of the class
     * Author : Yogesh Pawar
     * Date : 5th Feb 2019
     */
    function __construct()
    {
        $this->initBulkAction();

        add_action('wp_ajax_bulk_update_post_titles', array(&$this, 'bulkUpdatePostTitles'));
        add_action('wp_ajax_edit_bulk_titles', array(&$this, 'editBulkTitles'));
        add_action('admin_init', array(&$this, 'addBulkEditScripts'));
        add_action('admin_menu', array($this, 'bulkEditMenu'));
        add_action('wp_ajax_bulkAddRemovePostTypes', array($this, 'bulkAddRemovePostTypes'));
    }

    /**
     * Function to init the bulk action
     * Author : Yogesh Pawar
     * Date : 5th Feb 2019
     */
    function initBulkAction()
    {
        if (is_admin()) {
            add_action('admin_footer-edit.php', array(&$this, 'bulkCustomAdminFooter'));
            add_action('admin_notices', array(&$this, 'bulkEditSuccess'));
        }
    }

    /**
     * Function to Load Settings Page
     */
    function bulkEditMenu()
    {

        add_management_page('Bulk Edit Settings', 'Bulk Edit Settings', 'manage_options', 'bulk-edit-settings', array($this, 'loadBulkEditSettings'), '', 86);
    }

    /**
     * function to load settings Page
     */
    function loadBulkEditSettings()
    {
        if (current_user_can('manage_options')) {
            if (file_exists(plugin_dir_path(__DIR__) . '/views/bulk-edit-options.php')) {
                require plugin_dir_path(__DIR__) . '/views/bulk-edit-options.php';
            } else {
                die('<br /><h3>Plugin Installation is Incomplete. Please install the plugin again or make sure you have copied all the plugin files.</h3>');
            }
        } else {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
    }

    /**
     * Function to enqueue scripts
     * Author : Yogesh Pawar
     * Date : 6th Feb 2019
     */
    function addBulkEditScripts()
    {
        if (is_user_logged_in() && is_admin()) {

            $current_page = filter_input(INPUT_GET, 'page');

            if ($current_page == "bulk-edit-settings") {
                wp_register_style('bulk-bootstrap', plugins_url('/assets/css/bootstrap.min.css', __DIR__));
                wp_register_style('bulk-backend-css', plugins_url('/assets/css/bulk-multi-select.css', __DIR__));
                wp_enqueue_style('bulk-bootstrap');
                wp_enqueue_style('bulk-backend-css');

                wp_register_script('bulk-multi-js', plugins_url('/assets/js/jquery.multi-select.js', __DIR__));
                wp_enqueue_script('bulk-multi-js');
            }

            wp_enqueue_style('bulk-action-style', plugins_url('assets/css/bulk-style.css', __DIR__));
            wp_enqueue_script('bulk-action-script', plugins_url('/assets//js/bulk-action.js', __DIR__), array(), '1.0.0', true);

            wp_localize_script('bulk-action-script', 'bulkactionscript', array(
                'pluginsUrl' => BULK_FILE_DIRECTORY,
                'site_url' => site_url(),
                'bulk_ajax_url' => admin_url('admin-ajax.php')
            ));

            add_thickbox();
        }
    }

    /**
     * Function to append the bulk edit title
     * @global type $post_type
     * Author: Yogesh Pawar
     * Date : 6th Feb 2019
     */
    function bulkCustomAdminFooter()
    {
        global $post_type;

        $postTypes = get_option("bulk_edit_posts");

        if (!empty($postTypes)) {
            $postTypeList = explode(",", $postTypes);
        } else {
            $postTypeList = array('post', 'page');
        }

        if (in_array($post_type, $postTypeList)) {

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

    /**
     * Function which bulk updates the post titles
     * Author : Yogesh Pawar
     * Date : 5th Feb 2019
     */
    function bulkUpdatePostTitles()
    {
        $post_bulk_titles = ($_REQUEST['post_title']);
        $post_bulk_id = ($_REQUEST['post_id']);

        for ($i = 0; $i < sizeof($post_bulk_id); $i++) {

            if ($post_bulk_titles[$i] != "") {

                $bulk_post = array(
                    'ID' => intval($post_bulk_id[$i]),
                    'post_title' => sanitize_text_field($post_bulk_titles[$i]),
                );
                wp_update_post($bulk_post);
            }
        }
        echo "done";
        exit;
    }

    /**
     * Function to display the sucess the message
     * Author : Yogesh Pawar
     * Date : 6th Feb 2019
     */
    function bulkEditSuccess()
    {
        if (!empty(($_REQUEST["method"]))) {
            if (esc_attr($_REQUEST['method']) == "success") {

                ?>
                <div class="notice notice-success is-dismissible">
                    <p><?php _e('<b>Titles Updated Sucessfully!</b>', 'sample-text-domain'); ?></p>
                </div>
                <?php
            }
        }
    }

    /**
     * Function to load the bulk edit template
     * Author : Yogesh Pawar
     * Date : 5th Feb 2019
     */
    function editBulkTitles()
    {
        require(plugin_dir_path(__DIR__) . "views/edit-bulk-titles.php");
        exit;
    }

    /**
     * Function to update posts for which user wants to enable bulk edit of titles
     */
    function bulkAddRemovePostTypes()
    {

        if (empty($_POST['bulk_edit_posts'])) {
            echo json_encode(array('status' => 'failure', 'message' => 'Please select atleast one Post type'));
            exit();
        } else {
            $allowed_posts = implode(",", $_POST['bulk_edit_posts']);
            update_option("bulk_edit_posts", $allowed_posts);

            echo json_encode(array('status' => 'success', 'message' => 'Bulk Edit Permissions updated for selected Post Types!'));
            exit();
        }
    }
}

new Custom_Bulk_Edit_Title();

?>