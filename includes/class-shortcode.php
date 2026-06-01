<?php
/**
 * Shortcode for Book List
 * TODO: Create [book_list] shortcode
 */

class Book_Shortcode {
    
    public function __construct() {
        add_shortcode('book_list', array($this, 'render_book_list'));
    }
    
    public function render_book_list($atts) {
        $args = array(
            'post_type'      => 'book',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'title',
            'order'          => 'ASC'
        );

        $books = new WP_Query($args);

        if (!$books->have_posts()) {
            return '<p>No books found.</p>';
        }

        $output = '<ul class="book-list">';
        while ($books->have_posts()) {

            $books->the_post();

            $author = get_post_meta(get_the_ID(), 'book_author', true);
            $year   = get_post_meta(get_the_ID(), 'book_year', true);

            $output .= '<li>';

            $output .= '<a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a>';

            if ($author || $year) {

                $output .= ' <span class="book-meta">(';

                if ($author) {
                    $output .= esc_html($author);
                }

                if ($author && $year) {
                    $output .= ', ';
                }

                if ($year) {
                    $output .= esc_html($year);
                }

                $output .= ')</span>';
            }

            $output .= '</li>';
        }
        $output .= '</ul>';

        wp_reset_postdata();

        return $output;
    }
}

// Initialize
new Book_Shortcode();