<?php
function tp_handle_form_submission() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tp_submit_testimonial'])) {
        $name = sanitize_text_field($_POST['tp_name']);
        $message = sanitize_textarea_field($_POST['tp_message']);
        $rating = intval($_POST['tp_rating']);

        // Handle image upload
        if (!empty($_FILES['tp_image']['name'])) {
            $attachment_id = media_handle_upload('tp_image', 0);
            if (is_wp_error($attachment_id)) {
                echo '<p class="error">Error uploading image.</p>';
                return;
            }
        } else {
            $attachment_id = null;
        }

        // Insert testimonial as a post
        $testimonial_id = wp_insert_post([
            'post_title' => $name,
            'post_content' => $message,
            'post_type' => 'testimonial',
            'post_status' => 'publish',
            'meta_input' => [
                'rating' => $rating,
                'image' => $attachment_id,
            ],
        ]);

        if ($testimonial_id) {
            echo '<p class="success">Thank you for your testimonial!</p>';
        } else {
            echo '<p class="error">There was an error submitting your testimonial.</p>';
        }
    }
}
add_action('init', 'tp_handle_form_submission');
