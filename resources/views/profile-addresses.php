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
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <h4 class="mt-3 mb-1 fw-bold"><?= htmlspecialchars($user['name']) ?></h4>
                                <small class="text-muted"><?= htmlspecialchars($user['email']) ?></small>
                            </div>

                            <div class="list-group">
                                <a href="/websitebatminton/profile" class="list-group-item list-group-item-action">Thông tin cá nhân</a>
                                <a href="/websitebatminton/my-orders" class="list-group-item list-group-item-action">Đơn hàng của bạn</a>
                                <a href="/websitebatminton/profile/addresses" class="list-group-item list-group-item-action active">Địa chỉ giao hàng</a>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="col-md-8">
                        <div class="p-4 rounded-4 bg-white shadow-sm h-100">
                            <h3 class="fw-bold mb-4">Địa chỉ giao hàng mặc định</h3>

                            <?php if (!empty($_SESSION['success'])): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($_SESSION['error'])): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Địa chỉ hiện tại</h5>
                                    <?php if (empty(trim($user['address'] ?? ''))): ?>
                                        <p class="text-muted">Bạn chưa có địa chỉ giao hàng. Vui lòng thêm địa chỉ mặc định.</p>
                                    <?php else: ?>
                                        <div class="mb-3">
                                            <h6 class="fw-bold mb-2"><?= htmlspecialchars($user['name']) ?></h6>
                                            <p class="mb-1"><?= htmlspecialchars($user['address']) ?></p>
                                            <p class="mb-1"><?= htmlspecialchars($user['city']) ?>, <?= htmlspecialchars($user['country']) ?></p>
                                            <p class="mb-0 text-muted">SĐT: <?= htmlspecialchars($user['phone']) ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <h5 class="fw-bold mb-3">Cập nhật địa chỉ giao hàng</h5>
                            <form action="/websitebatminton/profile/addresses" method="POST" class="row g-3">
                                <?php echo \CSRF::field(); ?>
                                <div class="col-12">
                                    <label class="form-label">Địa chỉ chi tiết <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="address" rows="3" placeholder="Số nhà, tên đường, xã/phường, quận/huyện" required><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="city" value="<?= htmlspecialchars($user['city'] ?? '') ?>" placeholder="Tỉnh/Thành phố" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Quốc gia</label>
                                    <input type="text" class="form-control" name="country" value="<?= htmlspecialchars($user['country'] ?? 'Việt Nam') ?>" placeholder="Quốc gia">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="0xxxxxxxxx" required>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-5">Cập nhật địa chỉ</button>
                                    <a href="/websitebatminton/profile" class="btn btn-outline-secondary ms-2">Quay lại</a>
                                </div>
                            </form>
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
</style>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>
