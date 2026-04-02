<?php
/**
 * Dashboard Controller
 * Handles admin dashboard and statistics
 */

require_once __DIR__ . '/AdminBaseController.php';
require_once __DIR__ . '/../Models/Product.php';
require_once __DIR__ . '/../Models/Order.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Category.php';

class DashboardController extends AdminBaseController {
    private $productModel;
    private $orderModel;
    private $userModel;
    private $categoryModel;
    
    public function __construct($params = []) {
        parent::__construct($params);
        
        $this->productModel = new Product();
        $this->orderModel = new Order();
        $this->userModel = new User();
        $this->categoryModel = new Category();
    }
    
    /**
     * Dashboard index
     */
    public function profile() {
        $session = new \Session();
        if (!$session->isLoggedIn() || (($session->user()['role'] ?? '') !== 'admin')) {
            header('Location: /websitebatminton/login');
            exit;
        }

        $user = $session->user();
        $profile = [
            'id' => $user['id'],
            'name' => $user['name'] ?? 'Administrator',
            'email' => $user['email'] ?? '',
            'phone' => $user['phone'] ?? '',
            'gender' => $user['gender'] ?? 'male',
            'address' => $user['address'] ?? '',
            'country' => $user['country'] ?? 'Việt Nam',
            'city' => $user['city'] ?? '',
            'birthdate' => $user['birthdate'] ?? ''
        ];

        // render public profile view (user-style)
        $this->view('profile', ['profile' => $profile]);
    }

    public function index() {
        // Get statistics
        $productStats = $this->productModel->getStats();
        $orderStats = $this->orderModel->getStats();
        
        // Get recent orders
        $recentOrders = $this->orderModel->getWithUser(1, 5);
        
        // Get low stock products
        $lowStockProducts = $this->productModel->getLowStock(10);
        
        // Get monthly revenue
        $monthlyRevenue = $this->orderModel->getMonthlyRevenue();
        
        $data = [
            'title' => 'Dashboard',
            'product_stats' => $productStats,
            'order_stats' => $orderStats,
            'recent_orders' => $recentOrders,
            'low_stock_products' => $lowStockProducts,
            'monthly_revenue' => $monthlyRevenue
        ];
        
        $this->render('dashboard/index', $data);
    }
    
    /**
     * Get dashboard statistics (AJAX)
     */
    public function stats() {
        $productStats = $this->productModel->getStats();
        $orderStats = $this->orderModel->getStats();
        
        $this->jsonResponse([
            'success' => true,
            'data' => [
                'products' => $productStats,
                'orders' => $orderStats
            ]
        ]);
    }
}

