<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="auth-page">
    <div class="auth-box">
        <h3>ĐĂNG NHẬP</h3>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
            <?php if (!empty($_SESSION['verification_link'])): ?>
                <div class="alert alert-info">Link xác thực: <a href="<?= htmlspecialchars($_SESSION['verification_link']) ?>">Xác thực email</a></div>
                <?php unset($_SESSION['verification_link']); ?>
            <?php endif; ?>
        <?php endif; ?>

        <form method="POST" action="/websitebatminton/login">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
            </div>
            <button class="btn btn-primary" type="submit">ĐĂNG NHẬP</button>
        </form>

        <div class="auth-links">
            <a href="/websitebatminton/register">Khách hàng mới? Tạo tài khoản</a><br>
            <a href="#">Quên mật khẩu? Khôi phục mật khẩu</a>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>