<?php
/**
 * Brand Controller
 * Handles admin brand management
 */

require_once __DIR__ . '/AdminBaseController.php';
require_once __DIR__ . '/../Models/Brand.php';
require_once __DIR__ . '/../Models/Category.php';
require_once __DIR__ . '/../Models/Product.php';

class BrandController extends AdminBaseController {
    private $brandModel;
    private $categoryModel;
    private $productModel;

    public function __construct($params = []) {
        parent::__construct($params);

        $this->brandModel = new Brand();
        $this->categoryModel = new Category();
        $this->productModel = new Product();
    }

    /**
     * List all brands
     */
    public function index() {
        $search = $this->getSearch();
        $page = $this->getPage();
        $perPage = 10;

        $brands = $this->brandModel->getPaginated($page, $perPage, $search);
        $total = $this->brandModel->countBrands($search);
        $pagination = $this->paginate($total, $perPage);

        $data = [
            'title' => 'Quản lý hãng',
            'brands' => $brands,
            'search' => $search,
            'pagination' => $pagination
        ];

        $this->render('brands/index', $data);
    }

    /**
     * Show create brand form
     */
    public function create() {
        $categories = $this->categoryModel->getActiveCategories();

        $data = [
            'title' => 'Thêm hãng mới',
            'brand' => null,
            'categories' => $categories
        ];

        $this->render('brands/create', $data);
    }

    /**
     * Store new brand
     */
    public function store() {
        if (!$this->isPost()) {
            $this->redirect('/websitebatminton/admin/brands');
        }

        if (!$this->validateCsrf()) {
            $this->redirect('/websitebatminton/admin/brands/create');
        }

        $errors = $this->validateBrand($_POST);

        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->session->flash('error', $error);
            }
            $this->redirect('/websitebatminton/admin/brands/create');
        }

        $data = [
            'name' => trim($_POST['name']),
            'slug' => $this->brandModel->generateSlug($_POST['name']),
            'category_id' => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
            'status' => $_POST['status'] ?? 'active'
        ];

        try {
            $this->brandModel->createBrand($data);
            $this->session->flash('success', 'Thêm hãng thành công');
        } catch (Exception $e) {
            $this->session->flash('error', 'Lỗi khi thêm hãng: ' . $e->getMessage());
        }

        $this->redirect('/websitebatminton/admin/brands');
    }

    /**
     * Show edit brand form
     */
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $brand = $this->brandModel->getBrandById($id);

        if (!$brand) {
            $this->session->flash('error', 'Hãng không tồn tại');
            $this->redirect('/websitebatminton/admin/brands');
        }

        $categories = $this->categoryModel->getActiveCategories();

        $data = [
            'title' => 'Chỉnh sửa hãng',
            'brand' => $brand,
            'categories' => $categories
        ];

        $this->render('brands/edit', $data);
    }

    /**
     * Update brand
     */
    public function update() {
        if (!$this->isPost()) {
            $this->redirect('/websitebatminton/admin/brands');
        }

        $id = $_POST['id'] ?? 0;
        $brand = $this->brandModel->getBrandById($id);

        if (!$brand) {
            $this->session->flash('error', 'Hãng không tồn tại');
            $this->redirect('/websitebatminton/admin/brands');
        }

        if (!$this->validateCsrf()) {
            $this->redirect('/websitebatminton/admin/brands/edit?id=' . $id);
        }

        $errors = $this->validateBrand($_POST);

        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->session->flash('error', $error);
            }
            $this->redirect('/websitebatminton/admin/brands/edit?id=' . $id);
        }

        $data = [
            'name' => trim($_POST['name']),
            'slug' => $this->brandModel->generateSlug($_POST['name'], $id),
            'category_id' => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
            'status' => $_POST['status'] ?? 'active'
        ];

        try {
            $this->brandModel->updateBrand($id, $data);
            $this->session->flash('success', 'Cập nhật hãng thành công');
        } catch (Exception $e) {
            $this->session->flash('error', 'Lỗi khi cập nhật hãng: ' . $e->getMessage());
        }

        $this->redirect('/websitebatminton/admin/brands');
    }

    /**
     * Delete brand
     */
    public function delete() {
        if (!$this->isPost()) {
            $this->redirect('/websitebatminton/admin/brands');
        }

        if (!$this->validateCsrf()) {
            $this->redirect('/websitebatminton/admin/brands');
        }

        $id = $_POST['id'] ?? 0;
        $brand = $this->brandModel->getBrandById($id);

        if (!$brand) {
            $this->session->flash('error', 'Hãng không tồn tại');
            $this->redirect('/websitebatminton/admin/brands');
        }

        $products = $this->productModel->findAllBy('brand_id', $id);
        if (!empty($products)) {
            $this->session->flash('error', 'Không thể xóa hãng đang có sản phẩm');
            $this->redirect('/websitebatminton/admin/brands');
        }

        try {
            $this->brandModel->deleteBrand($id);
            $this->session->flash('success', 'Xóa hãng thành công');
        } catch (Exception $e) {
            $this->session->flash('error', 'Lỗi khi xóa hãng');
        }

        $this->redirect('/websitebatminton/admin/brands');
    }

    /**
     * Filter brands by category (AJAX)
     */
    public function filter() {
        $categoryId = $_GET['category_id'] ?? null;
        $categoryId = $categoryId !== null ? (int)$categoryId : null;

        $brands = $this->brandModel->getBrandsByCategory($categoryId);

        $this->jsonResponse(['success' => true, 'brands' => $brands]);
    }

    /**
     * Validate input data for brand
     * @param array $data
     * @return array
     */
    private function validateBrand($data) {
        $errors = [];

        if (empty($data['name'])) {
            $errors[] = 'Tên hãng không được để trống';
        }

        if (empty($data['category_id'])) {
            $errors[] = 'Vui lòng chọn danh mục cho hãng';
        }

        return $errors;
    }
}
