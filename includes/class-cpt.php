<?php
/**
 * Registers the Book custom post type and Publisher taxonomy.
 */

if (!defined('ABSPATH')) {
    exit;
}

function bm_register_book_post_type() {
    $labels = [
        'name'               => __('Books', 'book-manager'),
        'singular_name'      => __('Book', 'book-manager'),
        'add_new'            => __('Add New Book', 'book-manager'),
        'add_new_item'       => __('Add New Book', 'book-manager'),
        'edit_item'          => __('Edit Book', 'book-manager'),
        'new_item'           => __('New Book', 'book-manager'),
        'view_item'          => __('View Book', 'book-manager'),
        'search_items'       => __('Search Books', 'book-manager'),
        'not_found'          => __('No books found', 'book-manager'),
        'not_found_in_trash' => __('No books found in Trash', 'book-manager'),
        'menu_name'          => __('Books', 'book-manager'),
    ];

    $args = [
        'labels'       => $labels,
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => ['slug' => 'books'],
        'supports'     => ['title', 'editor', 'thumbnail'],
        'menu_icon'    => 'dashicons-book-alt',
        'show_in_rest' => true,
    ];

    register_post_type('book', $args);
}
add_action('init', 'bm_register_book_post_type');

/**
 * BONUS: Publisher taxonomy
 */
function bm_register_publisher_taxonomy() {
    $labels = [
        'name'          => __('Publishers', 'book-manager'),
        'singular_name' => __('Publisher', 'book-manager'),
        'search_items'  => __('Search Publishers', 'book-manager'),
        'all_items'     => __('All Publishers', 'book-manager'),
        'edit_item'     => __('Edit Publisher', 'book-manager'),
        'update_item'   => __('Update Publisher', 'book-manager'),
        'add_new_item'  => __('Add New Publisher', 'book-manager'),
        'new_item_name' => __('New Publisher Name', 'book-manager'),
        'menu_name'     => __('Publishers', 'book-manager'),
    ];

    $args = [
        'labels'       => $labels,
        'hierarchical' => true,
        'public'       => true,
        'rewrite'      => ['slug' => 'publisher'],
        'show_in_rest' => true,
    ];

    register_taxonomy('publisher', 'book', $args);
}
add_action('init', 'bm_register_publisher_taxonomy');
