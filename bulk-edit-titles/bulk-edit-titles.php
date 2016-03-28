<?php

/**
 * @package Bulk Edit Post Titles
 */
/*
  Plugin Name: Bulk Edit Post Titles
  Plugin URI: http://clariontechnologies.co.in
  Description: Bulk Edit Post Titles
  Version: 1.0.0
  Author: Yogesh Pawar, clarionwpdeveloper
  Author URI: http://clariontechnologies.co.in
  License: GPLv2 or later
  Text Domain: Bulk Edit Post Titles
 */


//Plugin Constant
defined('ABSPATH') or die('Restricted direct access!');
define('BULK_FILE_DIRECTORY', plugin_dir_url(__FILE__));

if (!class_exists('Custom_Bulk_Edit_Title')) {
    require_once 'classes/class.bulk.titles.php';
}

//Initialising Class Plugin
new Custom_Bulk_Edit_Title();
?>