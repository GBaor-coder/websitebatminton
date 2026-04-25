<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="container py-5">
    <div class="row g-5">
        <?php if (isset($product) && $product): ?>
            <!-- Product Gallery & Info -->
            <div class="col-lg-6">
                <div class="product-gallery">
                    <img src="<?= $product['image'] ? '/websitebatminton/storage/uploads/' . $product['image'] : '/websitebatminton/assets/images/product.jpg'; ?>" 
                         alt="<?= htmlspecialchars($product['name']); ?>" class="img-fluid rounded shadow">
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="product-info">
                    <h1 class="product-title mb-4"><?= htmlspecialchars($product['name']); ?></h1>
                    
                    <div class="product-price mb-4 fs-3 fw-bold text-primary">
                        <?= number_format($product['price'], 0, ',', '.'); ?>đ
                    </div>
                    
                    <div class="product-stock mb-4">
                        <?php if (isset($product['quantity']) && $product['quantity'] == 0): ?>
                            <span class="badge bg-danger fs-6 px-3 py-2">Hết hàng</span>
                        <?php elseif (isset($product['quantity']) && $product['quantity'] < 10): ?>
                            <span class="badge bg-warning text-dark fs-6 px-3 py-2">Còn <?= $product['quantity']; ?> sp</span>
                        <?php else: ?>
                            <span class="badge bg-success fs-6 px-3 py-2">Còn hàng</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="product-description mb-4">
                        <h5>Mô tả sản phẩm:</h5>
                        <p><?= nl2br(htmlspecialchars($product['description'] ?? 'Chưa có mô tả.')); ?></p>
                    </div>
                    
                    <?php if (isset($product['quantity']) && $product['quantity'] > 0): ?>
                        <a href="/websitebatminton/cart/add?product_id=<?= $product['id']; ?>" 
                           class="btn btn-primary btn-lg w-100 mb-3 btn-add-cart">
                            <i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ hàng
                        </a>
                    <?php else: ?>
                        <button class="btn btn-outline-secondary btn-lg w-100 disabled" disabled>
                            <i class="bi bi-x-circle me-2"></i>Hết hàng
                        </button>
                    <?php endif; ?>
                    
                    <div class="product-meta">
                        <p><strong>Danh mục:</strong> <?= htmlspecialchars($product['category_name'] ?? 'Chưa phân loại'); ?></p>
                        <?php if (isset($product['brand_name'])): ?>
                            <p><strong>Thương hiệu:</strong> <?= htmlspecialchars($product['brand_name']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Related Products -->
            <?php if (!empty($relatedProducts)): ?>
                <div class="col-12 mt-5">
                    <h3 class="mb-4">Sản phẩm liên quan</h3>
                    <div class="row g-4">
                        <?php foreach (array_slice($relatedProducts, 0, 4) as $related): ?>
                            <div class="col-md-3">
                                <div class="product-card h-100">
                                    <div class="product-image">
                                        <a href="/websitebatminton/products/<?= htmlspecialchars($related['slug']); ?>">
                                            <img src="<?= $related['image'] ? '/websitebatminton/storage/uploads/' . $related['image'] : '/websitebatminton/assets/images/product.jpg'; ?>" 
                                                 alt="<?= htmlspecialchars($related['name']); ?>" class="img-fluid">
                                        </a>
                                    </div>
                                    <div class="p-3">
                                        <h6 class="product-name">
                                            <a href="/websitebatminton/products/<?= htmlspecialchars($related['slug']); ?>" class="text-decoration-none">
                                                <?= htmlspecialchars(substr($related['name'], 0, 50)); ?>
                                            </a>
                                        </h6>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
             <div class="col-12 text-center py-5">
                <i class="bi bi-exclamation-triangle display-1 text-warning mb-4"></i>
                <h2>Sản phẩm không tồn tại</h2>
                <p class="lead text-muted">Sản phẩm bạn tìm không có trong hệ thống hoặc đã bị xóa.</p>
                <a href="/websitebatminton/products" class="btn btn-primary btn-lg">
                    <i class="bi bi-arrow-left me-2"></i>Xem tất cả sản phẩm
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>