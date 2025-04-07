<?php
/*
Plugin Name: Vercel Revalidate
Plugin URI: https://www.digital-advantage.com
Description: Trigger Next.js ISR revalidation on post update or publish.
Version: 1.4
Author: Arnaud Martin
Author URI: https://www.digital-advantage.com
License: GPL2
Text Domain: vercel-revalidate
Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Load translations
function vercel_revalidate_load_textdomain() {
    load_plugin_textdomain('vercel-revalidate', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'vercel_revalidate_load_textdomain');

// Core files
require_once plugin_dir_path(__FILE__) . 'includes/functions.php';
require_once plugin_dir_path(__FILE__) . 'admin/settings.php';
require_once plugin_dir_path(__FILE__) . 'admin/logs.php';
require_once plugin_dir_path(__FILE__) . 'admin/about.php';
require_once plugin_dir_path(__FILE__) . 'admin/help.php';
