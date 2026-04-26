<?php
/**
 * Guide Controller - Admin CRUD for Guide Categories & Contents
 */

require_once __DIR__ . '/AdminBaseController.php';
require_once __DIR__ . '/../Models/Guide.php';

class GuideController extends AdminBaseController {
    private $guideModel;
    
    public function __construct($params = []) {
        parent::__construct($params);
        $this->guideModel = new Guide();
    }
    
    // ========================
    // Guide Contents
    // ========================
    
    /**
     * List all guide contents
     */
    public function index() {
        $search = $this->getSearch();
        $page = $this->getPage();
        $perPage = 10;
        
        $contents = $this->guideModel->getContentsPaginated($page, $perPage, $search);
        $total = $this->guideModel->countContents($search);
        $pagination = $this->paginate($total, $perPage);
        
        $data = [
            'title' => 'Quản lý hướng dẫn',
            'contents' => $contents,
            'search' => $search,
            'pagination' => $pagination
        ];
        
        $this->render('guides/index', $data);
    }
    
    /**
     * Show create content form
     */
    public function create() {
        $categories = $this->guideModel->getCategories();
        
        $data = [
            'title' => 'Thêm nội dung hướng dẫn',
            'content' => null,
            'categories' => $categories
        ];
        
        $this->render('guides/form', $data);
    }
    
    /**
     * Store new content
     */
    public function store() {
        if (!$this->isPost()) {
            $this->redirect('/websitebatminton/admin/guides');
        }
        
        if (!$this->validateCsrf()) {
            $this->redirect('/websitebatminton/admin/guides/create');
        }
        
        $errors = $this->validateContent($_POST);
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->session->flash('error', $error);
            }
            $this->redirect('/websitebatminton/admin/guides/create');
        }
        
        $data = [
            'category_id' => (int)$_POST['category_id'],
            'title' => trim($_POST['title']),
            'slug' => $this->guideModel->generateSlug($_POST['title']),
            'content' => $_POST['content']
        ];
        
        try {
            $this->guideModel->createContent($data);
            $this->session->flash('success', 'Thêm nội dung hướng dẫn thành công');
        } catch (Exception $e) {
            $this->session->flash('error', 'Lỗi khi thêm nội dung: ' . $e->getMessage());
        }
        
        $this->redirect('/websitebatminton/admin/guides');
    }
    
    /**
     * Show edit content form
     */
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $content = $this->guideModel->getById($id);
        
        if (!$content) {
            $this->session->flash('error', 'Nội dung không tồn tại');
            $this->redirect('/websitebatminton/admin/guides');
        }
        
        $categories = $this->guideModel->getCategories();
        
        $data = [
            'title' => 'Chỉnh sửa nội dung hướng dẫn',
            'content' => $content,
            'categories' => $categories
        ];
        
        $this->render('guides/form', $data);
    }
    
    /**
     * Update content
     */
    public function update() {
        if (!$this->isPost()) {
            $this->redirect('/websitebatminton/admin/guides');
        }
        
        $id = $_POST['id'] ?? 0;
        $content = $this->guideModel->getById($id);
        
        if (!$content) {
            $this->session->flash('error', 'Nội dung không tồn tại');
            $this->redirect('/websitebatminton/admin/guides');
        }
        
        if (!$this->validateCsrf()) {
            $this->redirect('/websitebatminton/admin/guides/edit?id=' . $id);
        }
        
        $errors = $this->validateContent($_POST);
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->session->flash('error', $error);
            }
            $this->redirect('/websitebatminton/admin/guides/edit?id=' . $id);
        }
        
        $data = [
            'category_id' => (int)$_POST['category_id'],
            'title' => trim($_POST['title']),
            'slug' => $this->guideModel->generateSlug($_POST['title']),
            'content' => $_POST['content']
        ];
        
        try {
            $this->guideModel->updateContent($id, $data);
            $this->session->flash('success', 'Cập nhật nội dung thành công');
        } catch (Exception $e) {
            $this->session->flash('error', 'Lỗi khi cập nhật: ' . $e->getMessage());
        }
        
        $this->redirect('/websitebatminton/admin/guides');
    }
    
    /**
     * Delete content
     */
    public function delete() {
        if (!$this->isPost()) {
            $this->redirect('/websitebatminton/admin/guides');
        }
        
        if (!$this->validateCsrf()) {
            $this->redirect('/websitebatminton/admin/guides');
        }
        
        $id = $_POST['id'] ?? 0;
        $content = $this->guideModel->getById($id);
        
        if (!$content) {
            $this->session->flash('error', 'Nội dung không tồn tại');
            $this->redirect('/websitebatminton/admin/guides');
        }
        
        try {
            $this->guideModel->deleteContent($id);
            $this->session->flash('success', 'Xóa nội dung thành công');
        } catch (Exception $e) {
            $this->session->flash('error', 'Lỗi khi xóa nội dung');
        }
        
        $this->redirect('/websitebatminton/admin/guides');
    }
    
    // ========================
    // Guide Categories
    // ========================
    
    /**
     * List all guide categories
     */
    public function categories() {
        $search = $this->getSearch();
        $page = $this->getPage();
        $perPage = 10;
        
        $categories = $this->guideModel->getCategoriesPaginated($page, $perPage, $search);
        $total = $this->guideModel->countCategories($search);
        $pagination = $this->paginate($total, $perPage);
        
        // Count contents for each category
        foreach ($categories as &$category) {
            $db = \Database::getInstance();
            $result = $db->fetchOne(
                "SELECT COUNT(*) as total FROM guide_contents WHERE category_id = ?",
                [$category['id']]
            );
            $category['content_count'] = $result['total'] ?? 0;
        }
        
        $data = [
            'title' => 'Quản lý danh mục hướng dẫn',
            'categories' => $categories,
            'search' => $search,
            'pagination' => $pagination
        ];
        
        $this->render('guides/categories', $data);
    }
    
    /**
     * Show create category form
     */
    public function createCategory() {
        $data = [
            'title' => 'Thêm danh mục hướng dẫn',
            'category' => null
        ];
        
        $this->render('guides/category_form', $data);
    }
    
    /**
     * Store new category
     */
    public function storeCategory() {
        if (!$this->isPost()) {
            $this->redirect('/websitebatminton/admin/guide-categories');
        }
        
        if (!$this->validateCsrf()) {
            $this->redirect('/websitebatminton/admin/guide-categories/create');
        }
        
        $errors = $this->validateCategory($_POST);
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->session->flash('error', $error);
            }
            $this->redirect('/websitebatminton/admin/guide-categories/create');
        }
        
        $data = [
            'name' => trim($_POST['name']),
            'description' => trim($_POST['description'] ?? '')
        ];
        
        try {
            $this->guideModel->createCategory($data);
            $this->session->flash('success', 'Thêm danh mục thành công');
        } catch (Exception $e) {
            $this->session->flash('error', 'Lỗi khi thêm danh mục: ' . $e->getMessage());
        }
        
        $this->redirect('/websitebatminton/admin/guide-categories');
    }
    
    /**
     * Show edit category form
     */
    public function editCategory() {
        $id = $_GET['id'] ?? 0;
        $category = $this->guideModel->getCategoryById($id);
        
        if (!$category) {
            $this->session->flash('error', 'Danh mục không tồn tại');
            $this->redirect('/websitebatminton/admin/guide-categories');
        }
        
        $data = [
            'title' => 'Chỉnh sửa danh mục hướng dẫn',
            'category' => $category
        ];
        
        $this->render('guides/category_form', $data);
    }
    
    /**
     * Update category
     */
    public function updateCategory() {
        if (!$this->isPost()) {
            $this->redirect('/websitebatminton/admin/guide-categories');
        }
        
        $id = $_POST['id'] ?? 0;
        $category = $this->guideModel->getCategoryById($id);
        
        if (!$category) {
            $this->session->flash('error', 'Danh mục không tồn tại');
            $this->redirect('/websitebatminton/admin/guide-categories');
        }
        
        if (!$this->validateCsrf()) {
            $this->redirect('/websitebatminton/admin/guide-categories/edit?id=' . $id);
        }
        
        $errors = $this->validateCategory($_POST);
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->session->flash('error', $error);
            }
            $this->redirect('/websitebatminton/admin/guide-categories/edit?id=' . $id);
        }
        
        $data = [
            'name' => trim($_POST['name']),
            'description' => trim($_POST['description'] ?? '')
        ];
        
        try {
            $this->guideModel->updateCategory($id, $data);
            $this->session->flash('success', 'Cập nhật danh mục thành công');
        } catch (Exception $e) {
            $this->session->flash('error', 'Lỗi khi cập nhật danh mục: ' . $e->getMessage());
        }
        
        $this->redirect('/websitebatminton/admin/guide-categories');
    }
    
    /**
     * Delete category
     */
    public function deleteCategory() {
        if (!$this->isPost()) {
            $this->redirect('/websitebatminton/admin/guide-categories');
        }
        
        if (!$this->validateCsrf()) {
            $this->redirect('/websitebatminton/admin/guide-categories');
        }
        
        $id = $_POST['id'] ?? 0;
        $category = $this->guideModel->getCategoryById($id);
        
        if (!$category) {
            $this->session->flash('error', 'Danh mục không tồn tại');
            $this->redirect('/websitebatminton/admin/guide-categories');
        }
        
        // Check if category has contents
        $db = \Database::getInstance();
        $result = $db->fetchOne(
            "SELECT COUNT(*) as total FROM guide_contents WHERE category_id = ?",
            [$id]
        );
        
        if (($result['total'] ?? 0) > 0) {
            $this->session->flash('error', 'Không thể xóa danh mục đang có nội dung');
            $this->redirect('/websitebatminton/admin/guide-categories');
        }
        
        try {
            $this->guideModel->deleteCategory($id);
            $this->session->flash('success', 'Xóa danh mục thành công');
        } catch (Exception $e) {
            $this->session->flash('error', 'Lỗi khi xóa danh mục');
        }
        
        $this->redirect('/websitebatminton/admin/guide-categories');
    }
    
    // ========================
    // Validation
    // ========================
    
    private function validateContent($data) {
        $errors = [];
        
        if (empty($data['title'])) {
            $errors[] = 'Tiêu đề không được để trống';
        }
        
        if (empty($data['content'])) {
            $errors[] = 'Nội dung không được để trống';
        }
        
        if (empty($data['category_id'])) {
            $errors[] = 'Vui lòng chọn danh mục';
        }
        
        return $errors;
    }
    
    private function validateCategory($data) {
        $errors = [];
        
        if (empty($data['name'])) {
            $errors[] = 'Tên danh mục không được để trống';
        }
        
        return $errors;
    }
}

