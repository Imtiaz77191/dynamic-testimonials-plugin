





<?php

/*
Plugin Name: Dynamic Testimonials Plugin
Description: A plugin to manage and display testimonials dynamically.
Version: 1.0
Author: Imtiaz Ahmed Mahar
License: GPL2
Text Domain: dynamic-testimonials-plugin
*/




// Ensure direct access is blocked
if (!defined('ABSPATH')) exit;

// Enqueue assets (CSS & JS)
function tp_enqueue_assets() {
    wp_enqueue_style('tp-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_script('tp-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', [], false, true);
}
add_action('wp_enqueue_scripts', 'tp_enqueue_assets');

// Create database table on plugin activation
function tp_create_testimonial_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'testimonials';

    // SQL to create the testimonials table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        image_url VARCHAR(255),
        rating INT NOT NULL,
        date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    );";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'tp_create_testimonial_table');

// Handle form submission (Insert data into DB)
function tp_handle_submission() {
    if (isset($_POST['tp_submit_testimonial'])) {
        global $wpdb;

        // Sanitize inputs
        $name = sanitize_text_field($_POST['tp_name']);
        $message = sanitize_textarea_field($_POST['tp_message']);
        $rating = intval($_POST['tp_rating']);
        
        // Handle image upload
        if (!empty($_FILES['tp_image']['name'])) {
            $uploaded_file = wp_handle_upload($_FILES['tp_image'], ['test_form' => false]);
            if (!isset($uploaded_file['error'])) {
                $image_url = $uploaded_file['url'];
            }
        }

        // Insert data into database
        $table_name = $wpdb->prefix . 'testimonials';
        $wpdb->insert($table_name, [
            'name' => $name,
            'message' => $message,
            'image_url' => isset($image_url) ? $image_url : '',
            'rating' => $rating
        ]);
    }
}
add_action('init', 'tp_handle_submission');

// Shortcode for testimonial submission form
function tp_submission_form() {
    ob_start();
    ?>
    <form method="POST" enctype="multipart/form-data" class="testimonial-form">
        <input type="text" name="tp_name" placeholder="Your Name" required>
        <textarea name="tp_message" placeholder="Your Testimonial" required></textarea>
        <input type="file" name="tp_image" accept="image/*">

        <!-- Image preview -->
        <div class="image-preview"></div>

        <label>Rating:</label>
        <select name="tp_rating" required>
            <option value="5">5 Stars</option>
            <option value="4">4 Stars</option>
            <option value="3">3 Stars</option>
            <option value="2">2 Stars</option>
            <option value="1">1 Star</option>
        </select>

        <!-- Dynamic Star Rating -->
        <div class="rating">
            <span>☆</span>
            <span>☆</span>
            <span>☆</span>
            <span>☆</span>
            <span>☆</span>
        </div>

        <button type="submit" name="tp_submit_testimonial">Submit</button>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('tp_testimonial_form', 'tp_submission_form');

// Shortcode to display testimonials
function tp_display_testimonials() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'testimonials';

    // Fetch testimonials from the database
    $testimonials = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date DESC");

    ob_start();
    ?>
    <div class="testimonials-grid">
        <?php foreach ($testimonials as $testimonial): ?>
            <div class="testimonial-item">
                <?php if ($testimonial->image_url): ?>
                    <img src="<?php echo esc_url($testimonial->image_url); ?>" alt="<?php echo esc_attr($testimonial->name); ?>">
                <?php endif; ?>
                <h3><?php echo esc_html($testimonial->name); ?></h3>
                <p><?php echo esc_textarea($testimonial->message); ?></p>
                <div class="rating">
                    <?php for ($i = 0; $i < $testimonial->rating; $i++): ?>
                        <span>★</span>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('tp_display_testimonials', 'tp_display_testimonials');
?>
