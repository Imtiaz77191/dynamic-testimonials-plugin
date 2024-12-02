<?php
function td_display_testimonials() {
    $query = new WP_Query(['post_type' => 'testimonial', 'posts_per_page' => -1]);
    ob_start();

    if ($query->have_posts()) {
        echo '<div class="testimonials-grid">';
        while ($query->have_posts()) {
            $query->the_post();
            echo '<div class="testimonial-item">';
            if (has_post_thumbnail()) {
                the_post_thumbnail('thumbnail');
            }
            echo '<h3>' . get_the_title() . '</h3>';
            echo '<p>' . get_the_content() . '</p>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<p>No testimonials found.</p>';
    }
    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('td_testimonials', 'td_display_testimonials');
