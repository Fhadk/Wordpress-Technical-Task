# Wordpress-Technical-Task

# WordPress Book Manager Plugin 

## Your Mission

Fork this repository and complete the WordPress plugin by submitting a Pull Request (PR).

**Time limit:** 12 hours from fork to PR submission

##  Requirements

Complete the `book-manager.php` file to create a WordPress plugin that:

### Must Have Features

1. **Custom Post Type "Book"**
   - Register `book` post type
   - Slug: `/books/`
   - Supports: title, editor, featured image

2. **Custom Fields** (Meta boxes)
   - Author name (text field)
   - Publication year (number field, 4 digits)

3. **Shortcode** `[book_list]`
   - Outputs all book titles as links

4. **AJAX Button**
   - On single book page
   - Shows alert: "Interested in [Book Title]"

### Bonus Points (Optional)
- [ ] Publisher taxonomy
- [ ] ISBN field
- [ ] Basic CSS styling

##  Getting Started

### Step 1: Fork this repository
Click the **Fork** button (top right of this page)

### Step 2: Clone your fork
```bash
git clone https://github.com/kashif2041/Wordpress-Technical-Task.git
cd wordpress-book-manager-test
