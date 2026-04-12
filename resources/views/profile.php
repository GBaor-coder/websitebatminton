<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="profile-page py-5" style="background: linear-gradient(180deg, #eef4ff 0%, #f8fbff 100%); min-height: calc(100vh - 140px);">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-md-3">
                <?php include ROOT_PATH . '/resources/views/partials/sidebar-profile.php'; ?>
            </div>
            
            <!-- Content -->
            <div class="col-md-9">
                <div class="profile-card rounded-4 shadow-sm border-0 bg-white h-100">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-4">Thông tin cá nhân</h3>

                        <?php if (!empty($_SESSION['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="/websitebatminton/profile/update" method="POST" class="row g-4">
                            <?php echo \CSRF::field(); ?>
                            <div class="col-md-12">
                                <label class="form-label fw-medium mb-2">Họ và tên</label>
                                <input type="text" class="form-control form-control-sm rounded-pill px-4 " name="name" 
                                    value="<?= htmlspecialchars($profile['name']) ?>" placeholder="Nhập họ và tên" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-medium mb-2">Giới tính</label>
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" <?= ($profile['gender'] === 'male') ? 'checked' : '' ?>>
                                        <label class="form-check-label fw-medium" for="male">Nam</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input " type="radio" name="gender" id="female" value="female" <?= ($profile['gender'] === 'female') ? 'checked' : '' ?>>
                                        <label class="form-check-label fw-medium" for="female">Nữ</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-medium mb-2">Email</label>
                                <input type="email" class="form-control form-control-sm rounded-pill px-4 " name="email" 
                                    value="<?= htmlspecialchars($profile['email']) ?>" placeholder="example@email.com" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-medium mb-2">Số điện thoại</label>
                                <input type="tel" class="form-control form-control-sm rounded-pill px-4" name="phone" 
                                    value="<?= htmlspecialchars($profile['phone']) ?>" placeholder="09xxxxxxxx">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-medium mb-2">Ngày sinh</label>
                                <input type="date" class="form-control form-control-sm rounded-pill px-4" name="birthdate" 
                                    value="<?= htmlspecialchars($profile['birthdate']) ?>">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-medium mb-2">Quốc gia</label>
                                <input type="text" class="form-control form-control-sm rounded-pill px-4" name="country" 
                                    value="<?= htmlspecialchars($profile['country']) ?>" placeholder="Việt Nam">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-medium mb-2">Tỉnh/Thành phố</label>
                                <input type="text" class="form-control form-control-sm rounded-pill px-4" name="city" 
                                    value="<?= htmlspecialchars($profile['city']) ?>" placeholder="Hà Nội">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-medium mb-2">Địa chỉ cụ thể</label>
                                <input class="form-control form-control-sm rounded-pill px-4" name="address" 
                                    placeholder="Số nhà, tên đường, phường/xã..." value="<?= htmlspecialchars($profile['address']) ?>">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-sm rounded-pill px-5 py-3 w-100 fw-bold shadow-sm">
                                    <i class="bi bi-save me-2"></i>Cập nhật thông tin
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>

