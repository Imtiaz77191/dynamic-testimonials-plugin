<?php
// Register Testimonials Custom Post Type
function tp_register_testimonials_cpt() {
    register_post_type('testimonial', [
        'labels' => [
            'name' => 'Testimonials',
            'singular_name' => 'Testimonial',
        ],
        'public' => true,
        'has_archive' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
    ]);
}
add_action('init', 'tp_register_testimonials_cpt');
