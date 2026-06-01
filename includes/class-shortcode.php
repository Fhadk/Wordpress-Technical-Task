<?php
/**
 * Shortcode for Book List
 */

if (!defined('ABSPATH')) {
    exit;
}

class Book_Shortcode {

    public function __construct() {
        add_shortcode('book_list', array($this, 'render_book_list'));
    }

    public function render_book_list($atts) {
        $atts = shortcode_atts(array(
            'limit'   => -1,
            'orderby' => 'title',
            'order'   => 'ASC',
        ), $atts, 'book_list');

        $args = array(
            'post_type'      => 'book',
            'posts_per_page' => (int) $atts['limit'],
            'post_status'    => 'publish',
            'orderby'        => sanitize_key($atts['orderby']),
            'order'          => in_array(strtoupper($atts['order']), array('ASC', 'DESC'), true)
                                ? strtoupper($atts['order'])
                                : 'ASC',
        );

        $books = new WP_Query($args);

        if (!$books->have_posts()) {
            return '<p class="book-list-empty">No books found.</p>';
        }

        $output  = '<ul class="book-list">';
        while ($books->have_posts()) {
            $books->the_post();
            $output .= sprintf(
                '<li class="book-list__item"><a href="%s">%s</a></li>',
                esc_url(get_permalink()),
                esc_html(get_the_title())
            );
        }
        $output .= '</ul>';

        wp_reset_postdata();

        return $output;
    }
}

new Book_Shortcode();
