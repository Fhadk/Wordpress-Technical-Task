<?php
/**
 * Plugin Name: Book Manager Test
 * Plugin URI: https://github.com/yourcompany/wordpress-book-manager-test
 * Description: Complete this plugin for WordPress developer test
 * Version: 0.1.0
 * Author: Candidate
 * License: GPL v2 or later
 * Text Domain: book-manager
 * 
 * Instructions: 
 * TODO: Implement all features marked with TODO
 * Requirements:
 * 1. Custom Post Type "Book"
 * 2. Meta boxes: Author and Year
 * 3. Shortcode [book_list]
 * 4. AJAX button on single book page
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('BOOK_MANAGER_VERSION', '0.1.0');
define('BOOK_MANAGER_PATH', plugin_dir_path(__FILE__));
define('BOOK_MANAGER_URL', plugin_dir_url(__FILE__));

// Include required files
require_once BOOK_MANAGER_PATH . 'includes/class-cpt.php';
require_once BOOK_MANAGER_PATH . 'includes/class-meta.php';
require_once BOOK_MANAGER_PATH . 'includes/class-shortcode.php';

// ============================================
// TODO 1: Register Book Custom Post Type
// (Already in includes/class-cpt.php)
// ============================================

// ============================================
// TODO 2: Add Meta Boxes (Author & Year)
// (Already in includes/class-meta.php)
// ============================================

// ============================================
// TODO 3: Create Shortcode [book_list]
// (Already in includes/class-shortcode.php)
// ============================================

// ============================================
// AJAX Button on Single Book Page
// ============================================

// Print the button in the footer of a single book page. The click is
// handled over AJAX in assets/js/script.js.
function add_ajax_button() {
    if (is_singular('book')) {
        ?>
        <div class="book-request-info">
            <button id="requestInfoBtn" type="button" class="book-request-btn">
                📖 Request Info
            </button>
        </div>
        <?php
    }
}

add_action('wp_footer', 'add_ajax_button');

// Ajax Start here.

function book_manager_request_info() {

    check_ajax_referer('book_request_info', 'nonce');

    $post_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;

    if (!$post_id || get_post_type($post_id) !== 'book') {

        wp_send_json_error('Invalid book.');
    }

    $title = get_the_title($post_id);

    wp_send_json_success(array(
        'message' => 'Title in ' . $title,
    ));
}
add_action('wp_ajax_book_request_info', 'book_manager_request_info');
add_action('wp_ajax_nopriv_book_request_info', 'book_manager_request_info');

// ============================================
// Enqueue Styles & Scripts
// ============================================

function enqueue_book_manager_assets() {

    wp_enqueue_style(
        'book-manager-style',
        BOOK_MANAGER_URL . 'assets/css/style.css',
        array(),
        BOOK_MANAGER_VERSION
    );

    if (!is_singular('book')) {
        return;
    }

    wp_enqueue_script(
        'book-manager-script',
        BOOK_MANAGER_URL . 'assets/js/script.js',
        array('jquery'),
        BOOK_MANAGER_VERSION,
        true
    );

    wp_localize_script(
        'book-manager-script',
        'bookManager',
        array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('book_request_info'),
            'bookId'  => get_the_ID()
        )
    );
}
add_action('wp_enqueue_scripts', 'enqueue_book_manager_assets');

// ============================================
// Activation/Deactivation Hooks
// ============================================

function book_manager_activate() {
    // Flush rewrite rules on activation
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'book_manager_activate');

function book_manager_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'book_manager_deactivate');