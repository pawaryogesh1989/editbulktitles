<?php
/*
  Plugin Name: Bulk Edit Post Titles
  Plugin URI: http://clariontech.com
  Description: Bulk Edit Post Titles
  Version: 5.0.0
  Author: Yogesh Pawar, Clarion Technologies
  Author URI: http://clariontech.com
  License: GPLv2 or later
  Text Domain: Bulk Edit Post Titles
 */


//Plugin Constant
defined('ABSPATH') or die('Restricted direct access!');
define('BULK_FILE_DIRECTORY', plugin_dir_url(__FILE__));

if (!class_exists('Custom_Bulk_Edit_Title')) {
    require_once 'classes/class.bulk.titles.php';
}

?>