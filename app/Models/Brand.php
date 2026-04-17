<?php
/**
 * Brand Model
 * Handles brand-related database operations
 */

require_once __DIR__ . '/Model.php';

class Brand extends Model {
    protected $table = 'brands';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'slug', 'category_id', 'status'];

    /**
     * Get all brands
     * @return array
     */
    public function getAllBrands() {
        return $this->all();
    }

    /**
     * Get all active brands
     * @return array
     */
    public function getActiveBrands() {
        return $this->db->fetchAll(
            "SELECT * FROM {$this->table} WHERE status = 'active' ORDER BY name ASC"
        );
    }

    /**
     * Get brand by id
     * @param int $id
     * @return array|null
     */
    public function getBrandById($id) {
        return $this->find((int)$id);
    }

    /**
     * Create a new brand record
     * @param array $data
     * @return int Last insert id
     */
    public function createBrand($data) {
        return $this->create($data);
    }

    /**
     * Update brand record
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateBrand($id, $data) {
        return $this->update((int)$id, $data);
    }

    /**
     * Delete brand record
     * @param int $id
     * @return bool
     */
    public function deleteBrand($id) {
        return $this->delete((int)$id);
    }

    /**
     * Get brands filtered by category
     * @param int|null $categoryId
     * @return array
     */
    public function getBrandsByCategory($categoryId = null) {
        if ($categoryId) {
            return $this->db->fetchAll(
                "SELECT * FROM {$this->table} WHERE category_id = ? AND status = 'active' ORDER BY name ASC",
                [(int)$categoryId]
            );
        }

        return $this->getActiveBrands();
    }

    /**
     * Get brands with pagination and optional search
     * @param int $page
     * @param int $perPage
     * @param string $search
     * @return array
     */
    public function getPaginated($page = 1, $perPage = 10, $search = '') {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT b.*, c.name as category_name FROM {$this->table} b " .
               "LEFT JOIN categories c ON b.category_id = c.id";
        $params = [];

        if ($search) {
            $sql .= " WHERE b.name LIKE ? OR b.slug LIKE ?";
            $searchTerm = "%{$search}%";
            $params = [$searchTerm, $searchTerm];
        }

        $sql .= " ORDER BY b.id DESC LIMIT ? OFFSET ?";
        $params[] = $perPage;
        $params[] = $offset;

        return $this->db->fetchAll($sql, $params);
    }

    /**
     * Count brands with optional search
     * @param string $search
     * @return int
     */
    public function countBrands($search = '') {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $params = [];

        if ($search) {
            $sql .= " WHERE name LIKE ? OR slug LIKE ?";
            $searchTerm = "%{$search}%";
            $params = [$searchTerm, $searchTerm];
        }

        $result = $this->db->fetchOne($sql, $params);
        return $result['total'] ?? 0;
    }

    /**
     * Generate slug string from name
     * @param string $name
     * @param int|null $excludeId
     * @return string
     */
    public function generateSlug($name, $excludeId = null) {
        $slug = strtolower(trim($name));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');

        $params = [$slug];
        $sql = "SELECT id FROM {$this->table} WHERE slug = ?";

        if ($excludeId !== null) {
            $sql .= " AND id != ?";
            $params[] = (int)$excludeId;
        }

        $existing = $this->db->fetchOne($sql, $params);

        if ($existing) {
            $slug = $slug . '-' . time();
        }

        return $slug;
    }
}
