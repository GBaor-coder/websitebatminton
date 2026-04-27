<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="auth-page">
    <div class="auth-box">
        <h3>TẠO TÀI KHOẢN</h3>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form method="POST" action="/websitebatminton/register">
            <div class="mb-3">
                <label class="form-label">Họ và tên</label>
                <input type="text" name="name" class="form-control" placeholder="Họ và tên" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Số điện thoại</label>
                <input type="tel" name="phone" class="form-control" placeholder="Số điện thoại" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nhập lại mật khẩu</label>
                <input type="password" name="password_confirm" class="form-control" placeholder="Nhập lại mật khẩu" required>
            </div>
            <button class="btn btn-primary" type="submit">ĐĂNG KÝ</button>
        </form>

        <div class="auth-links">
            <a href="/websitebatminton/login">↩ Quay lại đăng nhập</a>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>