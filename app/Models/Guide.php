<?php
class Guide {
    public function getCategoriesWithItems() {
        $db = \Database::getInstance();
        $rows = $db->fetchAll("
            SELECT c.id, c.name, g.id AS item_id, g.title AS item_name
            FROM guide_categories c
            LEFT JOIN guide_contents g ON c.id = g.category_id
            ORDER BY c.id, g.id
        ");

        $guideMenu = [];
        foreach ($rows as $row) {
            $catId = $row['id'];
            if (!isset($guideMenu[$catId])) {
                $guideMenu[$catId] = [
                    'id' => $catId,
                    'name' => $row['name'],
                    'items' => []
                ];
            }
            if ($row['item_id']) {
                $guideMenu[$catId]['items'][] = [
                    'id' => $row['item_id'],
                    'name' => $row['item_name']
                ];
            }
        }
        return $guideMenu;
    }

    public function getById($id) {
        $db = \Database::getInstance();
        return $db->fetchOne("SELECT * FROM guide_contents WHERE id = ?", [$id]);
    }

    /**
     * Get all guide categories
     */
    public function getCategories() {
        $db = \Database::getInstance();
        return $db->fetchAll("SELECT * FROM guide_categories ORDER BY id ASC");
    }

    /**
     * Get single category by ID
     */
    public function getCategoryById($id) {
        $db = \Database::getInstance();
        return $db->fetchOne("SELECT * FROM guide_categories WHERE id = ?", [$id]);
    }

    /**
     * Get first guide content by category ID
     */
    public function getFirstContentByCategory($categoryId) {
        $db = \Database::getInstance();
        return $db->fetchOne(
            "SELECT * FROM guide_contents WHERE category_id = ? ORDER BY id ASC LIMIT 1",
            [$categoryId]
        );
    }

    // ========================
    // CRUD for Guide Categories
    // ========================

    /**
     * Create a new guide category
     */
    public function createCategory($data) {
        $db = \Database::getInstance();
        return $db->query(
            "INSERT INTO guide_categories (name, description) VALUES (?, ?)",
            [$data['name'], $data['description'] ?? null]
        );
    }

    /**
     * Update a guide category
     */
    public function updateCategory($id, $data) {
        $db = \Database::getInstance();
        return $db->query(
            "UPDATE guide_categories SET name = ?, description = ? WHERE id = ?",
            [$data['name'], $data['description'] ?? null, $id]
        );
    }

    /**
     * Delete a guide category
     */
    public function deleteCategory($id) {
        $db = \Database::getInstance();
        return $db->query(
            "DELETE FROM guide_categories WHERE id = ?",
            [$id]
        );
    }

    /**
     * Count guide categories
     */
    public function countCategories($search = '') {
        $db = \Database::getInstance();
        if ($search) {
            $result = $db->fetchOne(
                "SELECT COUNT(*) as total FROM guide_categories WHERE name LIKE ?",
                ["%{$search}%"]
            );
        } else {
            $result = $db->fetchOne("SELECT COUNT(*) as total FROM guide_categories");
        }
        return $result['total'] ?? 0;
    }

    /**
     * Get paginated guide categories
     */
    public function getCategoriesPaginated($page = 1, $perPage = 10, $search = '') {
        $db = \Database::getInstance();
        $offset = ($page - 1) * $perPage;
        if ($search) {
            return $db->fetchAll(
                "SELECT * FROM guide_categories WHERE name LIKE ? ORDER BY id DESC LIMIT ? OFFSET ?",
                ["%{$search}%", $perPage, $offset]
            );
        }
        return $db->fetchAll(
            "SELECT * FROM guide_categories ORDER BY id DESC LIMIT ? OFFSET ?",
            [$perPage, $offset]
        );
    }

    // ========================
    // CRUD for Guide Contents
    // ========================

    /**
     * Get all guide contents
     */
    public function getAllContents() {
        $db = \Database::getInstance();
        return $db->fetchAll("
            SELECT gc.*, c.name as category_name
            FROM guide_contents gc
            LEFT JOIN guide_categories c ON gc.category_id = c.id
            ORDER BY gc.id DESC
        ");
    }

    /**
     * Get paginated guide contents with optional search
     */
    public function getContentsPaginated($page = 1, $perPage = 10, $search = '') {
        $db = \Database::getInstance();
        $offset = ($page - 1) * $perPage;
        if ($search) {
            return $db->fetchAll("
                SELECT gc.*, c.name as category_name
                FROM guide_contents gc
                LEFT JOIN guide_categories c ON gc.category_id = c.id
                WHERE gc.title LIKE ? OR c.name LIKE ?
                ORDER BY gc.id DESC LIMIT ? OFFSET ?
            ", ["%{$search}%", "%{$search}%", $perPage, $offset]);
        }
        return $db->fetchAll("
            SELECT gc.*, c.name as category_name
            FROM guide_contents gc
            LEFT JOIN guide_categories c ON gc.category_id = c.id
            ORDER BY gc.id DESC LIMIT ? OFFSET ?
        ", [$perPage, $offset]);
    }

    /**
     * Count guide contents
     */
    public function countContents($search = '') {
        $db = \Database::getInstance();
        if ($search) {
            $result = $db->fetchOne("
                SELECT COUNT(*) as total FROM guide_contents gc
                LEFT JOIN guide_categories c ON gc.category_id = c.id
                WHERE gc.title LIKE ? OR c.name LIKE ?
            ", ["%{$search}%", "%{$search}%"]);
        } else {
            $result = $db->fetchOne("SELECT COUNT(*) as total FROM guide_contents");
        }
        return $result['total'] ?? 0;
    }

    /**
     * Create a new guide content
     */
    public function createContent($data) {
        $db = \Database::getInstance();
        return $db->query(
            "INSERT INTO guide_contents (category_id, title, slug, content) VALUES (?, ?, ?, ?)",
            [$data['category_id'], $data['title'], $data['slug'], $data['content']]
        );
    }

    /**
     * Update a guide content
     */
    public function updateContent($id, $data) {
        $db = \Database::getInstance();
        return $db->query(
            "UPDATE guide_contents SET category_id = ?, title = ?, slug = ?, content = ? WHERE id = ?",
            [$data['category_id'], $data['title'], $data['slug'], $data['content'], $id]
        );
    }

    /**
     * Delete a guide content
     */
    public function deleteContent($id) {
        $db = \Database::getInstance();
        return $db->query(
            "DELETE FROM guide_contents WHERE id = ?",
            [$id]
        );
    }

    /**
     * Generate slug from title
     */
    public function generateSlug($title) {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9\-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }
}
