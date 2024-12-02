<?php
function tp_testimonial_submission_form() {
    if ($_POST['tp_submit_testimonial']) {
        $title = sanitize_text_field($_POST['tp_name']);
        $content = sanitize_textarea_field($_POST['tp_message']);
        $attachment_id = media_handle_upload('tp_picture', 0);

        $testimonial_id = wp_insert_post([
            'post_title' => $title,
            'post_content' => $content,
            'post_type' => 'testimonial',
            'post_status' => 'pending',
        ]);

        if ($attachment_id) {
            set_post_thumbnail($testimonial_id, $attachment_id);
        }
        echo '<p>Thank you! Your testimonial is under review.</p>';
    }

    ob_start();
    ?>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="tp_name" placeholder="Your Name" required>
        <textarea name="tp_message" placeholder="Your Testimonial" required></textarea>
        <input type="file" name="tp_picture" accept="image/*" required>
        <button type="submit" name="tp_submit_testimonial">Submit</button>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('tp_submission_form', 'tp_testimonial_submission_form');
