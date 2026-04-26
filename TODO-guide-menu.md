# TODO: Guide Menu Dropdown with Categories

## Steps

- [x] Step 1: Update `app/Models/Guide.php` — Add `getCategories()` and `getContentsByCategory()` methods
- [x] Step 2: Update `app/Controllers/HomeController.php` — Improve `guide()` action to handle category/item params
- [x] Step 3: Update `resources/views/layouts/header.php` — Show category names in dropdown, make categories clickable
- [x] Step 4: Update `resources/views/guide.php` — Show categories list / category contents / item detail

## Goal
Display `guide_categories.name` in the "Hướng dẫn" dropdown and link to `/guide?category=X`, with contents listed under each category.


