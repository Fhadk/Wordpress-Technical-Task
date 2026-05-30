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
        // TODO: Query all books
        // TODO: Return HTML list of book titles with links
        
        $args = array(
            'post_type'      => 'book',
            'posts_per_page' => -1,
            'post_status'    => 'publish'
        );
        
        $books = new WP_Query($args);
        
        if (!$books->have_posts()) {
            return '<p>No books found.</p>';
        }
        
        $output = '<ul class="book-list">';
        while ($books->have_posts()) {
            $books->the_post();
            $output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
        }
        $output .= '</ul>';
        
        wp_reset_postdata();
        
        return $output;
    }
}

// Initialize
new Book_Shortcode();