<?php
/**
 * Meta boxes: Author Name, Publication Year, ISBN (bonus).
 */

if (!defined('ABSPATH')) {
    exit;
}

function bm_add_meta_boxes() {
    add_meta_box(
        'bm_book_details',
        __('Book Details', 'book-manager'),
        'bm_render_meta_box',
        'book',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'bm_add_meta_boxes');

function bm_render_meta_box($post) {
    wp_nonce_field('bm_save_meta', 'bm_meta_nonce');

    $author_name  = get_post_meta($post->ID, '_bm_author_name', true);
    $pub_year     = get_post_meta($post->ID, '_bm_pub_year', true);
    $isbn         = get_post_meta($post->ID, '_bm_isbn', true);
    ?>
    <table class="form-table" style="width:100%;">
        <tr>
            <th scope="row">
                <label for="bm_author_name"><?php _e('Author Name', 'book-manager'); ?></label>
            </th>
            <td>
                <input
                    type="text"
                    id="bm_author_name"
                    name="bm_author_name"
                    value="<?php echo esc_attr($author_name); ?>"
                    class="regular-text"
                    placeholder="e.g. J.K. Rowling"
                />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="bm_pub_year"><?php _e('Publication Year', 'book-manager'); ?></label>
            </th>
            <td>
                <input
                    type="number"
                    id="bm_pub_year"
                    name="bm_pub_year"
                    value="<?php echo esc_attr($pub_year); ?>"
                    class="small-text"
                    min="1000"
                    max="9999"
                    placeholder="e.g. 1997"
                />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="bm_isbn"><?php _e('ISBN (Bonus)', 'book-manager'); ?></label>
            </th>
            <td>
                <input
                    type="text"
                    id="bm_isbn"
                    name="bm_isbn"
                    value="<?php echo esc_attr($isbn); ?>"
                    class="regular-text"
                    placeholder="e.g. 978-3-16-148410-0"
                    maxlength="17"
                />
                <p class="description"><?php _e('ISBN-10 or ISBN-13', 'book-manager'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

function bm_save_meta($post_id) {
    // Security checks
    if (!isset($_POST['bm_meta_nonce']) || !wp_verify_nonce($_POST['bm_meta_nonce'], 'bm_save_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Author Name
    if (isset($_POST['bm_author_name'])) {
        update_post_meta($post_id, '_bm_author_name', sanitize_text_field($_POST['bm_author_name']));
    }

    // Publication Year — must be exactly 4 digits
    if (isset($_POST['bm_pub_year'])) {
        $year = absint($_POST['bm_pub_year']);
        if ($year >= 1000 && $year <= 9999) {
            update_post_meta($post_id, '_bm_pub_year', $year);
        }
    }

    // ISBN (bonus)
    if (isset($_POST['bm_isbn'])) {
        update_post_meta($post_id, '_bm_isbn', sanitize_text_field($_POST['bm_isbn']));
    }
}
add_action('save_post_book', 'bm_save_meta');
