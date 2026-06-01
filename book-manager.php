<?php
/**
 * Plugin Name: Book Manager Test
 * Description: Complete this plugin for WordPress developer test
 * Version: 0.1.0
 * Author: Hamza Naqvi
 * License: GPL v2 or later
 * Text Domain: book-manager
 */

if (!defined('ABSPATH')) {
    exit;
}

define('BOOK_MANAGER_VERSION', '0.1.0');
define('BOOK_MANAGER_PATH', plugin_dir_path(__FILE__));
define('BOOK_MANAGER_URL', plugin_dir_url(__FILE__));

require_once BOOK_MANAGER_PATH . 'includes/class-cpt.php';
require_once BOOK_MANAGER_PATH . 'includes/class-meta.php';
require_once BOOK_MANAGER_PATH . 'includes/class-shortcode.php';

/**
 * AJAX button on single book page
 */
function add_ajax_button() {

    if (!is_singular('book')) {
        return;
    }
    ?>
    <div style="margin:20px 0;text-align:center;">
        <button id="requestInfoBtn" class="bm-request-btn">
            📖 <?php esc_html_e('Request Info', 'book-manager'); ?>
        </button>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('requestInfoBtn');
        if (btn) {
            btn.addEventListener('click', function () {
                const bookTitle = <?php echo wp_json_encode(get_the_title()); ?>;
                alert('Interested in ' + bookTitle);
            });
        }
    });
    </script>
    <?php
}
add_action('wp_footer', 'add_ajax_button');

/**
 * Enqueue front-end styles
 */
function enqueue_book_manager_styles() {
    if (!is_singular('book') && !is_post_type_archive('book')) {
        return;
    }
    wp_add_inline_style('wp-block-library', bm_get_inline_css());
}
add_action('wp_enqueue_scripts', 'enqueue_book_manager_styles');

function bm_get_inline_css() {
    return "
        /* === Book Manager Styles === */

        /* Book list shortcode */
        .bm-book-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .bm-book-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            font-size: 1rem;
        }
        .bm-book-item a {
            color: #0073aa;
            text-decoration: none;
            font-weight: 600;
        }
        .bm-book-item a:hover {
            text-decoration: underline;
            color: #005177;
        }
        .bm-book-meta {
            color: #777;
            font-size: 0.875rem;
            margin-left: 6px;
        }
        .bm-no-books {
            color: #888;
            font-style: italic;
        }

        /* Request Info button */
        .bm-request-btn {
            background: #0073aa;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.2s ease;
        }
        .bm-request-btn:hover {
            background: #005177;
        }
    ";
}

/**
 * Activation / Deactivation
 */
function book_manager_activate() {
    bm_register_book_post_type();
    bm_register_publisher_taxonomy();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'book_manager_activate');

function book_manager_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'book_manager_deactivate');
