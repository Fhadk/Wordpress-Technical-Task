## Submission Details

**Candidate Name:** Muhammad Owais Jalal
**Total Time Spent:** ~2 hours

##  Feature Checklist

- [x] Custom Post Type "Book" works
- [x] Author field saves/loads correctly
- [x] Year field saves/loads correctly
- [x] Shortcode `[book_list]` displays books
- [x] AJAX button shows alert on book page
- [x] No PHP notices or warnings
- [x] Plugin activates without errors

##  Git Integrity

- [x] All changes committed before deadline

##  Testing Instructions

1. Drop the plugin folder into `wp-content/plugins/` and activate **Book Manager** from the Plugins screen.
2. Re-save permalinks (Settings -> Permalinks -> Save) so the `/books/` slug works.
3. Add a new book at **Books -> Add New**:
   - Title: `Test Book`
   - Author: `Test Author`
   - Publication Year: `2024`
   - (Optional) ISBN: `978-0-14-303499-5`
   - (Optional) Assign a Publisher term
   - Set a featured image and publish.
4. Visit the single book page (`/books/test-book/`) and click **I'm Interested** -- you should see the alert `Interested in Test Book`.
5. Create or edit any page and add the `[book_list]` shortcode. The page should render a list of all published books, each linking to its single page.

##  Notes to Reviewer

**Implemented (Must Have):**
- Custom Post Type `book` with `/books/` slug, REST-enabled, `dashicons-book-alt` menu icon, and `title`/`editor`/`thumbnail` support.
- Author + Publication Year meta fields with proper nonce verification, autosave/capability guards, sanitization, and 4-digit year validation (1000-9999).
- `[book_list]` shortcode rendering all published books as anchor links (supports optional `limit`, `orderby`, `order` attributes).
- Single book page button that calls `admin-ajax.php` (action `book_interest`), validates the nonce + post type/status server-side, and returns the exact message `Interested in [Book Title]` for the JS alert.

**Implemented (Bonus):**
- Publisher hierarchical taxonomy attached to the `book` CPT, REST-enabled, with admin column.
- ISBN meta field with 10/13-digit validation.
- CSS styling for the book list, single-page button (with disabled/loading state), and AJAX status text.

**Notable choices:**
- Used `wp_localize_script` to expose the AJAX URL, nonce, and current book ID -- keeps the script free of inline PHP and avoids globals.
- AJAX handler validates that the requested post is a published `book`, so the action can't be misused for other post types.

##  Live Demo (Optional)

N/A
