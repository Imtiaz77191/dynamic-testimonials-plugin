<?php
/*
Plugin Name: Testimonials Pro
Description: A dynamic plugin to manage and display testimonials with text, image, and ratings.
Version: 1.0
Author: Imtiaz Ahmed Mahar
*/

if (!defined('ABSPATH')) exit;

// Include plugin files
require_once plugin_dir_path(__FILE__) . 'includes/cpt-testimonials.php';
require_once plugin_dir_path(__FILE__) . 'includes/form-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcodes.php';

// Enqueue CSS and JavaScript
function tp_enqueue_assets() {
    wp_enqueue_style('tp-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_script('tp-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', ['jquery'], false, true);
}
add_action('wp_enqueue_scripts', 'tp_enqueue_assets');
