<?php
/*
Plugin Name: Testimonials Manager Pro
Description: A plugin to manage and display testimonials with a modern landing page.
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) exit;

// Enqueue assets
function tmp_enqueue_assets() {
    wp_enqueue_style('tmp-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_script('tmp-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', [], false, true);
}
add_action('admin_enqueue_scripts', 'tmp_enqueue_assets');

// Register menu page
function tmp_add_menu_page() {
    add_menu_page(
        'Testimonials Pro',
        'Testimonials Pro',
        'manage_options',
        'testimonials-manager-pro',
        'tmp_render_landing_page',
        'dashicons-admin-generic',
        20
    );
}
add_action('admin_menu', 'tmp_add_menu_page');

// Include landing page
function tmp_render_landing_page() {
    include plugin_dir_path(__FILE__) . 'includes/landing-page.php';
}
