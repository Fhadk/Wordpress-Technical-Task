<?php
/**
 * [book_list] shortcode — outputs all books as linked titles.
 */

if (!defined('ABSPATH')) {
    exit;
}

function bm_book_list_shortcode($atts) {
    $atts = shortcode_atts([
        'orderby'    => 'title',
        'order'      => 'ASC',
        'posts_per_page' => -1,
        'publisher'  => '',   // BONUS: filter by publisher slug
    ], $atts, 'book_list');

    $query_args = [
        'post_type'      => 'book',
        'post_status'    => 'publish',
        'posts_per_page' => intval($atts['posts_per_page']),
        'orderby'        => sanitize_key($atts['orderby']),
        'order'          => in_array(strtoupper($atts['order']), ['ASC', 'DESC']) ? $atts['order'] : 'ASC',
        'no_found_rows'  => true,
    ];

    // BONUS: optional publisher filter
    if (!empty($atts['publisher'])) {
        $query_args['tax_query'] = [[
            'taxonomy' => 'publisher',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($atts['publisher']),
        ]];
    }

    $books = new WP_Query($query_args);

    if (!$books->have_posts()) {
        return '<p class="bm-no-books">' . esc_html__('No books found.', 'book-manager') . '</p>';
    }

    $output  = '<ul class="bm-book-list">';
    while ($books->have_posts()) {
        $books->the_post();

        $author = get_post_meta(get_the_ID(), '_bm_author_name', true);
        $year   = get_post_meta(get_the_ID(), '_bm_pub_year', true);

        $meta_parts = [];
        if ($author) $meta_parts[] = esc_html($author);
        if ($year)   $meta_parts[] = esc_html($year);
        $meta_html = $meta_parts ? ' <span class="bm-book-meta">(' . implode(', ', $meta_parts) . ')</span>' : '';

        $output .= sprintf(
            '<li class="bm-book-item"><a href="%s">%s</a>%s</li>',
            esc_url(get_permalink()),
            esc_html(get_the_title()),
            $meta_html
        );
    }
    $output .= '</ul>';

    wp_reset_postdata();
    return $output;
}
add_shortcode('book_list', 'bm_book_list_shortcode');
