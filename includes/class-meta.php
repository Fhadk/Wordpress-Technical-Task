<?php
/**
 * Meta Boxes for Book Details
 */

if (!defined('ABSPATH')) {
    exit;
}

class Book_Meta {

    const NONCE_ACTION = 'book_meta_save';
    const NONCE_FIELD  = 'book_meta_nonce';

    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post_book', array($this, 'save_meta_data'), 10, 2);
    }

    public function add_meta_boxes() {
        add_meta_box(
            'book_details',
            'Book Details',
            array($this, 'render_meta_box'),
            'book',
            'normal',
            'high'
        );
    }

    public function render_meta_box($post) {
        wp_nonce_field(self::NONCE_ACTION, self::NONCE_FIELD);

        $author = get_post_meta($post->ID, 'book_author', true);
        $year   = get_post_meta($post->ID, 'book_year', true);
        $isbn   = get_post_meta($post->ID, 'book_isbn', true);

        $current_year = (int) date('Y');
        ?>
        <p>
            <label for="book_author"><strong>Author:</strong></label><br />
            <input type="text"
                   id="book_author"
                   name="book_author"
                   value="<?php echo esc_attr($author); ?>"
                   style="width: 100%;"
                   placeholder="e.g., Jane Austen" />
        </p>
        <p>
            <label for="book_year"><strong>Publication Year:</strong></label><br />
            <input type="number"
                   id="book_year"
                   name="book_year"
                   value="<?php echo esc_attr($year); ?>"
                   min="1000"
                   max="<?php echo esc_attr($current_year + 5); ?>"
                   step="1"
                   maxlength="4"
                   placeholder="YYYY"
                   style="width: 120px;" />
            <span class="description">4-digit year (e.g., 1998)</span>
        </p>
        <p>
            <label for="book_isbn"><strong>ISBN:</strong></label><br />
            <input type="text"
                   id="book_isbn"
                   name="book_isbn"
                   value="<?php echo esc_attr($isbn); ?>"
                   style="width: 100%;"
                   placeholder="e.g., 978-0-14-303499-5" />
            <span class="description">Optional. 10 or 13 digit ISBN.</span>
        </p>
        <?php
    }

    public function save_meta_data($post_id, $post) {
        if (!isset($_POST[self::NONCE_FIELD]) ||
            !wp_verify_nonce($_POST[self::NONCE_FIELD], self::NONCE_ACTION)) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (isset($_POST['book_author'])) {
            update_post_meta(
                $post_id,
                'book_author',
                sanitize_text_field(wp_unslash($_POST['book_author']))
            );
        }

        if (isset($_POST['book_year']) && $_POST['book_year'] !== '') {
            $year = (int) $_POST['book_year'];
            if ($year >= 1000 && $year <= 9999) {
                update_post_meta($post_id, 'book_year', $year);
            } else {
                delete_post_meta($post_id, 'book_year');
            }
        } else {
            delete_post_meta($post_id, 'book_year');
        }

        if (isset($_POST['book_isbn'])) {
            $isbn = sanitize_text_field(wp_unslash($_POST['book_isbn']));
            $isbn_digits = preg_replace('/[^0-9Xx]/', '', $isbn);
            if ($isbn === '' || strlen($isbn_digits) === 10 || strlen($isbn_digits) === 13) {
                update_post_meta($post_id, 'book_isbn', $isbn);
            }
        }
    }
}

new Book_Meta();
