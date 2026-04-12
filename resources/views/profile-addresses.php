<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<?php
$fullName = trim($user['name'] ?? 'Người dùng');
$nameParts = explode(' ', $fullName);
$firstName = $nameParts[0] ?? '';
$lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : '';
$country = htmlspecialchars($user['country'] ?? 'Việt Nam');
$city = htmlspecialchars($user['city'] ?? '');
$address = htmlspecialchars($user['address'] ?? '');
$phone = htmlspecialchars($user['phone'] ?? '');
$email = htmlspecialchars($user['email'] ?? '');
?>

<div class="profile-page py-5" style="background: linear-gradient(180deg, #eef4ff 0%, #f8fbff 100%);">
    <div class="container">
        <div class="row gy-4">
            <!-- Sidebar -->
            <div class="col-md-3">
                <?php include ROOT_PATH . '/resources/views/partials/sidebar-profile.php'; ?>
            </div>

            <!-- Content -->
            <div class="col-md-9">
                <!-- Default Address Card -->
                <div id="default-address-card" class="card profile-card border-0 rounded-4 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-start">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="icon-circle bg-primary bg-opacity-10 text-primary p-2 rounded-circle">
                                        <i class="bi bi-person-fill fs-5"></i>
                                    </span>
                                    <h5 class="mb-0 fw-bold"><?= htmlspecialchars($fullName) ?></h5>
                                </div>
                                <div class="mb-3 text-secondary fs-6">
                                    <i class="bi bi-house-door-fill me-2"></i>
                                    <?= $address ? $address . ', ' . $city : 'Chưa có địa chỉ giao hàng mặc định' ?>
                                </div>
                                <div class="text-secondary mb-2 fs-6">
                                    <i class="bi bi-telephone-fill me-2"></i>
                                    <?= $phone ?: 'Chưa có số điện thoại' ?>
                                </div>
                                <span class="badge badge-default px-3 py-2 fw-medium">Địa chỉ mặc định</span>
                            </div>
                            <div class="d-flex gap-2 align-items-center">
                                <button type="button" class="btn btn-outline-primary btn-icon rounded-circle" title="Sửa" onclick="editAddress()">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-icon rounded-circle" title="Xóa">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="edit-address-form-card" class="card profile-card border-0 rounded-4 shadow-sm d-none mb-4">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-4 pb-2 border-bottom">Sửa địa chỉ giao hàng</h4>
                        <form id="edit-shipping-form" action="/websitebatminton/profile/addresses" method="POST" class="row g-4">
                            <?php echo \CSRF::field(); ?>
                            <input type="hidden" name="form_action" id="edit-form-action" value="edit">
                            <div class="col-md-12">
                                <label class="form-label fw-medium mb-2">HỌ *</label>
                                <input type="text" class="form-control form-control-sm rounded-pill px-4" 
                                    name="first_name" id="edit-first-name" placeholder="Nhập họ của bạn" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-medium mb-2">TÊN *</label>
                                <input type="text" class="form-control form-control-sm rounded-pill px-4" 
                                    name="last_name" id="edit-last-name" placeholder="Nhập tên của bạn" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-medium mb-2">SỐ ĐIỆN THOẠI *</label>
                                <input type="tel" class="form-control form-control-sm rounded-pill px-4" 
                                    name="phone" id="edit-phone" placeholder="09xxxxxxxxx" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-medium mb-2">QUỐC GIA</label>
                                <input type="text" class="form-control form-control-sm rounded-pill px-4" 
                                    name="country" id="edit-country" placeholder="Nhập tên quốc gia">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-medium mb-2">TỈNH/THÀNH PHỐ</label>
                                <input type="text" class="form-control form-control-sm rounded-pill px-4" 
                                    name="city" id="edit-city" placeholder="Nhập tỉnh/thành phố">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-medium mb-2">ĐỊA CHỈ CỤ THỂ</label>
                                <input type="text" class="form-control form-control-sm rounded-pill px-4" 
                                    name="address" id="edit-address" placeholder="Số nhà, tên đường, phường/xã...">
                            </div>
                            <div class="col-12">
                                <div class="custom-checkbox mb-4">
                                    <input type="checkbox" name="is_default" id="edit-default-address" value="1">
                                    <label for="edit-default-address" class="d-flex align-items-center gap-3 cursor-pointer">
                                        <span class="checkbox-box"></span>
                                        <span class="fw-medium">Đặt làm địa chỉ mặc định</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 d-flex flex-column flex-sm-row gap-3">
                                <button id="edit-submit-button" type="submit" class="btn btn-primary btn-sm rounded-pill px-5 py-3 flex-fill fw-bold shadow-sm">
                                    <i class="bi bi-pencil-fill me-2"></i>CẬP NHẬT
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-5 py-3 flex-fill" onclick="hideEditForm()">
                                    HỦY BỎ
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Add Address Button -->
                <button class="btn btn-primary btn-add-address mb-4 w-100 rounded-pill py-1 fw-bold shadow" 
                        type="button" onclick="showAddressForm()">
                    <i class="bi bi-plus-circle me-2"></i>Bổ sung địa chỉ mới
                </button>

                <!-- Add Address Button -->
                <div id="address-form-card" class="card profile-card border-0 rounded-4 shadow-sm d-none">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-4 pb-2 border-bottom">Thêm địa chỉ giao hàng mới</h4>
                        
                        <?php if (!empty($_SESSION['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form id="shipping-form" action="/websitebatminton/profile/addresses" method="POST" class="row g-4">
                            <?php echo \CSRF::field(); ?>
                            <div class="col-md-12">
                                <label class="form-label fw-medium mb-2">HỌ *</label>
                                <input type="text" class="form-control form-control-sm rounded-pill px-4" 
                                    name="first_name" value="<?= htmlspecialchars($firstName) ?>" placeholder="Nhập họ của bạn" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-medium mb-2">TÊN *</label>
                                <input type="text" class="form-control form-control-sm rounded-pill px-4" 
                                    name="last_name" value="<?= htmlspecialchars($lastName) ?>" placeholder="Nhập tên của bạn" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-medium mb-2">SỐ ĐIỆN THOẠI *</label>
                                <input type="tel" class="form-control form-control-sm rounded-pill px-4" 
                                    name="phone" value="<?= $phone ?>" placeholder="09xxxxxxxxx" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-medium mb-2">QUỐC GIA</label>
                                <input type="text" class="form-control form-control-sm rounded-pill px-4" 
                                    name="country" value="<?= $country ?>" placeholder="Nhập tên quốc gia">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-medium mb-2">ĐỊA CHỈ CỤ THỂ</label>
                                <input class="form-control form-control-sm rounded-pill px-4" 
                                name="address" value="<?= $address ?>" placeholder="Số nhà, tên đường, phường/xã...">
                            </div>
                            <div class="col-12">
                                <div class="custom-checkbox mb-4">
                                    <input type="checkbox" name="is_default" id="default-address" value="1" checked>
                                    <label for="default-address" class="d-flex align-items-center gap-3 cursor-pointer">
                                        <span class="checkbox-box"></span>
                                        <span class="fw-medium">Đặt làm địa chỉ mặc định</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 d-flex flex-column flex-sm-row gap-3">
                                <button type="submit" class="btn btn-primary btn-sm rounded-pill px-5 py-3 flex-fill fw-bold shadow-sm">
                                    <i class="bi bi-plus-circle me-2"></i>THÊM MỚI
                                </button>
                                <button type="button" onclick="history.back()" class="btn btn-outline-secondary btn-sm rounded-pill px-5 py-3 flex-fill">
                                    HỦY BỎ
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var existingAddress = {
        firstName: <?= json_encode($firstName) ?>,
        lastName: <?= json_encode($lastName) ?>,
        phone: <?= json_encode($phone) ?>,
        country: <?= json_encode($country) ?>,
        city: <?= json_encode($city) ?>,
        address: <?= json_encode($address) ?>,
        isDefault: true
    };

    function showAddressForm() {
        var card = document.getElementById('address-form-card');
        if (card) {
            var isHidden = card.classList.toggle('d-none');
            var form = document.getElementById('shipping-form');
            if (!isHidden && form) {
                form.querySelectorAll('input[type="text"], input[type="tel"], textarea').forEach(function(input) {
                    input.value = '';
                });
                form.scrollIntoView({ behavior: 'smooth' });
            }
        }
    }

    function editAddress() {
        var editCard = document.getElementById('edit-address-form-card');
        var defaultCard = document.getElementById('default-address-card');
        if (!editCard) {
            return;
        }
        if (defaultCard) {
            defaultCard.classList.add('d-none');
        }
        editCard.classList.remove('d-none');

        document.getElementById('edit-first-name').value = existingAddress.firstName || '';
        document.getElementById('edit-last-name').value = existingAddress.lastName || '';
        document.getElementById('edit-phone').value = existingAddress.phone || '';
        document.getElementById('edit-country').value = existingAddress.country || '';
        document.getElementById('edit-city').value = existingAddress.city || '';
        document.getElementById('edit-address').value = existingAddress.address || '';
        document.getElementById('edit-default-address').checked = !!existingAddress.isDefault;

        editCard.scrollIntoView({ behavior: 'smooth' });
    }

    function hideEditForm() {
        var editCard = document.getElementById('edit-address-form-card');
        var defaultCard = document.getElementById('default-address-card');
        if (editCard) {
            editCard.classList.add('d-none');
        }
        if (defaultCard) {
            defaultCard.classList.remove('d-none');
        }
    }
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>

<style>
.profile-page {
    min-height: calc(100vh - 120px);
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}
.profile-card {
    border-radius: 24px !important;
    box-shadow: 0 25px 50px rgba(43, 60, 255, 0.08);
}
.icon-circle { min-width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; }
.badge-default {
    background: rgba(43, 60, 255, 0.12);
    color: #2b3cff;
    font-weight: 600;
    border-radius: 999px;
}
.btn-icon {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    transition: all .2s ease;
}
.btn-icon:hover { transform: translateY(-1px) scale(1.05); }
.btn-add-address {
    background: linear-gradient(135deg, #2b3cff, #1e90ff);
    border: none;
    font-size: 1.1rem;
    box-shadow: 0 15px 28px rgba(43, 60, 255, 0.2);
    transition: all .25s ease;
}
.btn-add-address:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 40px rgba(43, 60, 255, 0.3);
}
.form-control-lg, .form-select {
    border-radius: 50px !important;
    border: 1px solid #dfe8ff;
    padding: 14px 20px;
    font-weight: 500;
    background: #ffffff;
    transition: all .25s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}
.form-control-lg:focus, .form-select:focus {
    border-color: #2b3cff;
    box-shadow: 0 0 0 0.25rem rgba(43, 60, 255, 0.15);
    transform: translateY(-1px);
}
.custom-checkbox {
    cursor: pointer;
    user-select: none;
}
.custom-checkbox input {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}
.checkbox-box {
    width: 24px;
    height: 24px;
    border: 2px solid #dfe8ff;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all .25s ease;
    background: #ffffff;
    flex-shrink: 0;
}
.custom-checkbox input:checked + .checkbox-box {
    background: linear-gradient(135deg, #2b3cff, #1e90ff);
    border-color: transparent;
}
.custom-checkbox input:checked + .checkbox-box::after {
    content: '✔';
    color: white;
    font-size: 14px;
    font-weight: bold;
}
.btn-primary {
    background: linear-gradient(135deg, #2b3cff, #1e90ff);
    border: none;
}
.btn-primary:hover {
    background: linear-gradient(135deg, #1e3ff1, #1674e0);
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(43, 60, 255, 0.3);
}
@media (max-width: 768px) {
    .profile-card .card-body { padding: 2rem 1.5rem !important; }
    .btn { width: 100%; margin-bottom: 1rem; }
}
</style>
