<?php
/*
Plugin Name: Dynamic Testimonials
Description: A plugin to dynamically manage and display user testimonials.
Version: 1.0
Author: Imtiaz Ahmed Mahar
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/cpt-testimonials.php';
require_once plugin_dir_path(__FILE__) . 'includes/form-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcodes.php';

// Enqueue styles and scripts
function td_enqueue_assets() {
    wp_enqueue_style('td-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
}
add_action('wp_enqueue_scripts', 'td_enqueue_assets');
