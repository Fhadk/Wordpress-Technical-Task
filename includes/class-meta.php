<?php
/**
 * Meta Boxes for Book Details
 * TODO: Add author and year fields
 */

class Book_Meta {
    
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post_book', array($this, 'save_meta_data'));
    }
    
    public function add_meta_boxes() {
        // TODO: Add meta box for book details
        
        add_meta_box(
            'book_details',
            'Book Details',
            array($this, 'render_meta_box'),
            'book',
            'normal',
            'default'
        );
    }
    
    public function render_meta_box($post) {
        // TODO: Create HTML form for author and year
        // TODO: Add nonce for security
        
        $author = get_post_meta($post->ID, 'book_author', true);
        $year = get_post_meta($post->ID, 'book_year', true);
        
        ?>
        <p>
            <label for="book_author">Author:</label>
            <input type="text" id="book_author" name="book_author" value="<?php echo esc_attr($author); ?>" />
        </p>
        <p>
            <label for="book_year">Year:</label>
            <input type="number" id="book_year" name="book_year" value="<?php echo esc_attr($year); ?>" />
        </p>
        <?php
    }
    
    public function save_meta_data($post_id) {
        // TODO: Save author and year
        // TODO: Verify nonce
        // TODO: Sanitize input
        
        if (isset($_POST['book_author'])) {
            update_post_meta($post_id, 'book_author', sanitize_text_field($_POST['book_author']));
        }
        
        if (isset($_POST['book_year'])) {
            update_post_meta($post_id, 'book_year', intval($_POST['book_year']));
        }
    }
}

// Initialize
new Book_Meta();