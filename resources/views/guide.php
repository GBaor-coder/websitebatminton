<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="container py-5">
    <?php if (!empty($guide)): ?>
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/websitebatminton/guide">Hướng dẫn</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($guide['title'] ?? '') ?></li>
            </ol>
        </nav>
        <h1 class="fw-bold text-primary mb-4">
            <?= htmlspecialchars($guide['title'] ?? '') ?>
        </h1>
        <div class="guide-content">
            <?= $guide['content'] ?>
        </div>

    <?php elseif (!empty($categories)): ?>
        <h1 class="fw-bold text-primary mb-4 text-center">Hướng dẫn</h1>
        <div class="row g-4">
            <?php foreach ($categories as $cat): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold text-primary">
                                <a href="/websitebatminton/guide?category=<?= $cat['id'] ?>" class="text-decoration-none">
                                    <?= htmlspecialchars($cat['name']) ?>
                                </a>
                            </h5>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="/websitebatminton/guide?category=<?= $cat['id'] ?>" class="btn btn-outline-primary btn-sm w-100">
                                Xem chi tiết
                            </a>
                        </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php else: ?>
        <p class="text-muted">Chưa có dữ liệu hướng dẫn</p>
    <?php endif; ?>
</div>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>
