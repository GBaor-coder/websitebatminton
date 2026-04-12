<?php
$current_page = basename($_SERVER['PHP_SELF']);
$is_profile = ($current_page === 'profile.php' || $current_page === 'thanh-vien.php');
$is_orders = ($current_page === 'my-orders.php');
$is_addresses = ($current_page === 'profile-addresses.php');
?>

<aside class="profile-sidebar p-4 bg-white rounded-4 shadow-sm h-100">
    <div class="text-center mb-4">
        <div class="avatar mb-3 mx-auto">
            PB
        </div>
        <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($user['name'] ?? $profile['name'] ?? 'Người dùng'); ?></h5>
        <p class="text-muted small mb-0"><?php echo htmlspecialchars($user['email'] ?? $profile['email'] ?? ''); ?></p>
    </div>

    <div class="profile-menu">
        <a href="/websitebatminton/thanh-vien" class="menu-item <?php echo $is_profile ? 'active' : ''; ?>">
            <i class="bi bi-person me-2"></i>Thông tin cá nhân
        </a>
        <a href="/websitebatminton/my-orders" class="menu-item <?php echo $is_orders ? 'active' : ''; ?>">
            <i class="bi bi-bag-check me-2"></i>Đơn hàng của bạn
        </a>
        <a href="/websitebatminton/profile/addresses" class="menu-item <?php echo $is_addresses ? 'active' : ''; ?>">
            <i class="bi bi-geo-alt me-2"></i>Địa chỉ giao hàng
        </a>
    </div>
</aside>

<style>
.profile-sidebar {
    border-radius: 24px;
    box-shadow: 0 20px 45px rgba(43, 60, 255, 0.08);
}
.avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: 700;
    color: #ffffff;
    background: linear-gradient(135deg, #2b3cff, #1e90ff);
    margin: 0 auto;
}
.profile-menu .menu-item {
    display: block;
    padding: 16px 20px;
    margin-bottom: 10px;
    border-radius: 18px;
    color: #253858;
    text-decoration: none;
    transition: all 0.25s ease;
    border: none;
    background: transparent;
    width: 100%;
    text-align: left;
    font-weight: 500;
}
.profile-menu .menu-item:hover {
    background: rgba(43, 60, 255, 0.08);
    color: #1e3ff1;
    transform: translateX(4px);
}
.profile-menu .menu-item.active {
    background: linear-gradient(135deg, #2b3cff, #1e90ff);
    color: #ffffff;
    box-shadow: 0 18px 30px rgba(43, 60, 255, 0.18);
}
@media (max-width: 768px) {
    .profile-sidebar { margin-bottom: 2rem; }
}
</style>
