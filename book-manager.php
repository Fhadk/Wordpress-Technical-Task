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
// TODO 4: Add AJAX Button on Single Book Page
// ============================================
// HINT: Hook into wp_footer
// HINT: Check is_singular('book')
// HINT: Output button and JavaScript

function add_ajax_button() {
    // Only show on single book pages
    if (is_singular('book')) {
        ?>
        <div style="margin: 20px 0; text-align: center;">
            <button id="requestInfoBtn" style="
                background-color: #0073aa;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            ">
                📖 Request Info
            </button>
        </div>
        
        <script>
        document.getElementById('requestInfoBtn').addEventListener('click', function() {
            var bookTitle = '<?php echo esc_js(get_the_title()); ?>';
            //alert('Thanks for your interest in ' + bookTitle);
            alert('Interested in ' + bookTitle);
        });
        </script>
        <?php
    }
}
add_action('wp_footer', 'add_ajax_button');

// ============================================
// TODO 5: Enqueue Styles (Optional)
// ============================================

function enqueue_book_manager_styles() {
    // Uncomment to use external CSS file
    // wp_enqueue_style(
    //     'book-manager-style',
    //     BOOK_MANAGER_URL . 'assets/css/style.css',
    //     array(),
    //     BOOK_MANAGER_VERSION
    // );
}
add_action('wp_enqueue_scripts', 'enqueue_book_manager_styles');

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