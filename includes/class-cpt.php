<?php
/**
 * Custom Post Type Registration
 * TODO: Implement book post type
 */

class Book_CPT {
    
    public function __construct() {
        add_action('init', array($this, 'register_book_post_type'));
    }
    
    public function register_book_post_type() {
        $labels = array(
            'name'               => 'Books',
            'singular_name'      => 'Book',
            'menu_name'         => 'Books',
            'add_new'           => 'Add New',
            'add_new_item'      => 'Add New Book',
            'edit_item'         => 'Edit Book',
            'view_item'         => 'View Book',
            'search_items'      => 'Search Books',
            'not_found'         => 'No books found',
            'not_found_in_trash'=> 'No books found in trash'
        );

        $args = array(
            'labels'       => $labels,
            'public'       => true,
            'has_archive'  => true,
            'rewrite'      => array('slug' => 'books'),
            'supports'     => array('title', 'editor', 'thumbnail'),
            
        );

        register_post_type('book', $args);
    }
}

// Initialize
new Book_CPT();