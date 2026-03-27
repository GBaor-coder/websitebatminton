<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="p-4 rounded-4" style="background: #f3f6ff;">
                <div class="row g-4">
                    <!-- Sidebar Profile -->
                    <div class="col-md-4">
                        <div class="p-4 rounded-4 bg-white shadow-sm h-100">
                            <div class="text-center mb-4">
                                <div class="mx-auto" style="width: 90px; height: 90px; border-radius: 50%; background: #dbe4ff;
                                    display: flex; align-items: center; justify-content: center; font-size: 32px; color: #1c42f3;">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <h4 class="mt-3 mb-1 fw-bold"><?= htmlspecialchars($user['name']) ?></h4>
                                <small class="text-muted"><?= htmlspecialchars($user['email']) ?></small>
                            </div>

                            <div class="list-group">
                                <a href="/websitebatminton/profile" class="list-group-item list-group-item-action">Thông tin cá nhân</a>
                                <a href="/websitebatminton/my-orders" class="list-group-item list-group-item-action active">Đơn hàng của bạn</a>
<a href="/websitebatminton/profile/addresses" class="list-group-item list-group-item-action">Địa chỉ giao hàng</a>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content - Orders List -->
                    <div class="col-md-8">
                        <div class="p-4 rounded-4 bg-white shadow-sm h-100">
                            <h3 class="fw-bold mb-4">Đơn hàng của bạn</h3>

                            <?php if (empty($orders)): ?>
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i> Bạn chưa có đơn hàng nào. <a href="/websitebatminton/products">Tiếp tục mua sắm</a>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Mã đơn hàng</th>
                                                <th>Ngày đặt</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($orders as $order): ?>
                                                <tr>
                                                    <td>
                                                        <strong><?= htmlspecialchars($order['order_number']) ?></strong>
                                                    </td>
                                                    <td>
                                                        <?= date('d/m/Y', strtotime($order['created_at'])) ?>
                                                    </td>
                                                    <td>
                                                        <strong><?= number_format($order['total_amount'], 0, ',', '.') ?>₫</strong>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $statusClass = 'badge-secondary';
                                                        $statusText = $order['status'];
                                                        
                                                        switch($order['status']) {
                                                            case 'pending':
                                                                $statusClass = 'badge-warning';
                                                                $statusText = 'Chờ xử lý';
                                                                break;
                                                            case 'processing':
                                                                $statusClass = 'badge-info';
                                                                $statusText = 'Đang xử lý';
                                                                break;
                                                            case 'shipped':
                                                                $statusClass = 'badge-primary';
                                                                $statusText = 'Đã gửi';
                                                                break;
                                                            case 'completed':
                                                                $statusClass = 'badge-success';
                                                                $statusText = 'Hoàn thành';
                                                                break;
                                                            case 'cancelled':
                                                                $statusClass = 'badge-danger';
                                                                $statusText = 'Đã hủy';
                                                                break;
                                                        }
                                                        ?>
                                                        <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                                    </td>
                                                    <td>
                                                        <a href="/websitebatminton/order/<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary">Chi tiết</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .container { max-width: 1100px; }
    .list-group-item.active { background: #1c42f3; border-color: #1c42f3; color: #fff; }
    .list-group-item { border-radius: 12px; margin-bottom: 8px; }
    .table { font-size: 14px; }
    .table thead th { font-weight: 700; }
</style>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>
