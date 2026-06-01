<?php
/**
 * Plugin Name: Book Manager
 * Plugin URI:  https://github.com/Fhadk/Wordpress-Technical-Task
 * Description: Adds a Book custom post type with author/year/ISBN meta, a publisher taxonomy, a [book_list] shortcode, and an AJAX "Interested" button on single book pages.
 * Version:     1.0.0
 * Author:      Muhammad Owais Jalal
 * License:     GPL v2 or later
 * Text Domain: book-manager
 */

if (!defined('ABSPATH')) {
    exit;
}

define('BOOK_MANAGER_VERSION', '1.0.0');
define('BOOK_MANAGER_PATH', plugin_dir_path(__FILE__));
define('BOOK_MANAGER_URL', plugin_dir_url(__FILE__));

require_once BOOK_MANAGER_PATH . 'includes/class-cpt.php';
require_once BOOK_MANAGER_PATH . 'includes/class-meta.php';
require_once BOOK_MANAGER_PATH . 'includes/class-shortcode.php';

/**
 * Enqueue frontend assets. The AJAX script only loads on single book pages.
 */
function book_manager_enqueue_assets() {
    wp_enqueue_style(
        'book-manager-style',
        BOOK_MANAGER_URL . 'assets/css/style.css',
        array(),
        BOOK_MANAGER_VERSION
    );

    if (is_singular('book')) {
        wp_enqueue_script(
            'book-manager-script',
            BOOK_MANAGER_URL . 'assets/js/script.js',
            array('jquery'),
            BOOK_MANAGER_VERSION,
            true
        );

        wp_localize_script('book-manager-script', 'BookManager', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('book_manager_interest'),
            'bookId'  => get_queried_object_id(),
        ));
    }
}
add_action('wp_enqueue_scripts', 'book_manager_enqueue_assets');

/**
 * Append the "Interested" button to single book content.
 */
function book_manager_append_interest_button($content) {
    if (is_singular('book') && in_the_loop() && is_main_query()) {
        $button = '<div class="book-manager-interest-wrap">'
                . '<button type="button" id="book-manager-interest-btn" class="book-manager-interest-btn">'
                . 'I\'m Interested'
                . '</button>'
                . '<span class="book-manager-interest-status" aria-live="polite"></span>'
                . '</div>';
        $content .= $button;
    }
    return $content;
}
add_filter('the_content', 'book_manager_append_interest_button');

/**
 * AJAX handler: returns the alert message "Interested in [Book Title]".
 * Registered for both logged-in and anonymous visitors.
 */
function book_manager_handle_interest() {
    check_ajax_referer('book_manager_interest', 'nonce');

    $book_id = isset($_POST['book_id']) ? absint($_POST['book_id']) : 0;
    $book = $book_id ? get_post($book_id) : null;

    if (!$book || $book->post_type !== 'book' || $book->post_status !== 'publish') {
        wp_send_json_error(array('message' => 'Invalid book.'), 400);
    }

    wp_send_json_success(array(
        'message' => 'Interested in ' . get_the_title($book),
        'title'   => get_the_title($book),
    ));
}
add_action('wp_ajax_book_interest',        'book_manager_handle_interest');
add_action('wp_ajax_nopriv_book_interest', 'book_manager_handle_interest');

/**
 * Activation/deactivation: flush rewrite rules so /books/ permalinks work.
 */
function book_manager_activate() {
    if (class_exists('Book_CPT')) {
        $cpt = new Book_CPT();
        $cpt->register_book_post_type();
        $cpt->register_publisher_taxonomy();
    }
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'book_manager_activate');

function book_manager_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'book_manager_deactivate');
