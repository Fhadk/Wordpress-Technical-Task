<?php
/**
 * Custom Post Type Registration
 */

if (!defined('ABSPATH')) {
    exit;
}

class Book_CPT {

    public function __construct() {
        add_action('init', array($this, 'register_book_post_type'));
        add_action('init', array($this, 'register_publisher_taxonomy'));
    }

    public function register_book_post_type() {
        $labels = array(
            'name'               => 'Books',
            'singular_name'      => 'Book',
            'menu_name'          => 'Books',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Book',
            'edit_item'          => 'Edit Book',
            'new_item'           => 'New Book',
            'view_item'          => 'View Book',
            'view_items'         => 'View Books',
            'search_items'       => 'Search Books',
            'not_found'          => 'No books found',
            'not_found_in_trash' => 'No books found in trash',
            'all_items'          => 'All Books',
            'archives'           => 'Book Archives',
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'show_in_rest'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'books', 'with_front' => false),
            'capability_type'    => 'post',
            'has_archive'        => 'books',
            'hierarchical'       => false,
            'menu_position'      => 20,
            'menu_icon'          => 'dashicons-book-alt',
            'supports'           => array('title', 'editor', 'thumbnail'),
        );

        register_post_type('book', $args);
    }

    public function register_publisher_taxonomy() {
        $labels = array(
            'name'              => 'Publishers',
            'singular_name'     => 'Publisher',
            'search_items'      => 'Search Publishers',
            'all_items'         => 'All Publishers',
            'edit_item'         => 'Edit Publisher',
            'update_item'       => 'Update Publisher',
            'add_new_item'      => 'Add New Publisher',
            'new_item_name'     => 'New Publisher Name',
            'menu_name'         => 'Publishers',
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'publisher'),
        );

        register_taxonomy('publisher', array('book'), $args);
    }
}

new Book_CPT();
