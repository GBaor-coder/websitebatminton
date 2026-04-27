<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="container py-5">
    <div class="row g-5">
        <!-- Product Image -->
        <div class="col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <img src="<?= $product['image'] ? '/websitebatminton/storage/uploads/' . htmlspecialchars($product['image']) : '/websitebatminton/assets/images/product.jpg'; ?>" 
                         alt="<?= htmlspecialchars($product['name']); ?>" 
                         class="img-fluid w-100 rounded" style="object-fit: cover;">
                </div>
            </div>
            <?php if (!empty($product['images'])): ?>
            <div class="row g-2 mt-3">
                <?php 
                $extraImages = json_decode($product['images'], true); 
                if (!empty($extraImages) && is_array($extraImages)): 
                    foreach ($extraImages as $img): 
                ?>
                <div class="col-3">
                    <img src="/websitebatminton/storage/uploads/<?= htmlspecialchars($img); ?>" 
                         class="img-fluid rounded border" style="object-fit: cover; height: 80px; width: 100%;">
                </div>
                <?php endforeach; endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Product Info -->
        <div class="col-lg-7">
            <div class="product-detail-info">
                <!-- Badges -->
                <div class="mb-3">
                    <?php if (!empty($product['sale_price'])): ?>
                        <span class="badge bg-danger me-2">-<?= round((1 - $product['sale_price'] / $product['price']) * 100); ?>%</span>
                    <?php endif; ?>
                    <?php if (!empty($product['featured'])): ?>
                        <span class="badge bg-warning text-dark me-2">Hot</span>
                    <?php endif; ?>
                    <?php if (isset($product['quantity'])): ?>
                        <?php if ($product['quantity'] == 0): ?>
                            <span class="badge bg-secondary">Hết hàng</span>
                        <?php elseif ($product['quantity'] < 10): ?>
                            <span class="badge bg-warning text-dark">Còn <?= $product['quantity']; ?></span>
                        <?php else: ?>
                            <span class="badge bg-success">Còn hàng</span>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Product Name -->
                <h1 class="h3 fw-bold mb-2"><?= htmlspecialchars($product['name']); ?></h1>
                
                <?php if (!empty($product['sku'])): ?>
                    <p class="text-muted mb-3">SKU: <?= htmlspecialchars($product['sku']); ?></p>
                <?php endif; ?>

                <!-- Price -->
                <div class="mb-4">
                    <?php if (!empty($product['sale_price'])): ?>
                        <span class="fs-2 fw-bold text-danger"><?= number_format($product['sale_price'], 0, ',', '.'); ?>đ</span>
                        <span class="fs-5 text-muted text-decoration-line-through ms-3"><?= number_format($product['price'], 0, ',', '.'); ?>đ</span>
                    <?php else: ?>
                        <span class="fs-2 fw-bold text-primary"><?= number_format($product['price'], 0, ',', '.'); ?>đ</span>
                    <?php endif; ?>
                </div>

                <!-- Description -->
                <?php if (!empty($product['description'])): ?>
                    <div class="mb-4">
                        <p class="text-muted"><?= nl2br(htmlspecialchars($product['description'])); ?></p>
                    </div>
                <?php endif; ?>

                <!-- Actions -->
                <div class="d-flex gap-3 mb-4">
                    <?php if (isset($product['quantity']) && $product['quantity'] > 0): ?>
                        <a href="/websitebatminton/cart/add?product_id=<?= htmlspecialchars($product['id']); ?>" class="btn btn-primary btn-lg flex-grow-1">
                            <i class="bi bi-cart-plus me-2"></i>Thêm giỏ hàng
                        </a>
                    <?php else: ?>
                        <button class="btn btn-secondary btn-lg flex-grow-1" disabled>
                            <i class="bi bi-cart-x me-2"></i>Hết hàng
                        </button>
                    <?php endif; ?>
                </div>

                <!-- Details Table -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Thông tin sản phẩm</h5>
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <?php if (!empty($product['sku'])): ?>
                                <tr>
                                    <td class="text-muted" style="width: 140px;">Mã sản phẩm</td>
                                    <td class="fw-medium"><?= htmlspecialchars($product['sku']); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if (!empty($product['category_name'])): ?>
                                <tr>
                                    <td class="text-muted">Danh mục</td>
                                    <td class="fw-medium"><?= htmlspecialchars($product['category_name']); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if (!empty($product['brand_name'])): ?>
                                <tr>
                                    <td class="text-muted">Thương hiệu</td>
                                    <td class="fw-medium"><?= htmlspecialchars($product['brand_name']); ?></td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <td class="text-muted">Tình trạng</td>
                                    <td class="fw-medium">
                                        <?php if (isset($product['quantity'])): ?>
                                            <?php if ($product['quantity'] == 0): ?>
                                                <span class="text-danger">Hết hàng</span>
                                            <?php elseif ($product['quantity'] < 10): ?>
                                                <span class="text-warning">Còn <?= $product['quantity']; ?> sản phẩm</span>
                                            <?php else: ?>
                                                <span class="text-success">Còn hàng</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-success">Còn hàng</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Content -->
    <?php if (!empty($product['content'])): ?>
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h4 class="fw-bold mb-0">Chi tiết sản phẩm</h4>
                </div>
                <div class="card-body">
                    <?= $product['content']; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="fw-bold mb-4">Sản phẩm liên quan</h3>
            <div class="row g-4">
                <?php foreach ($relatedProducts as $related): ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-card h-100">
                        <div class="product-badges">
                            <?php if (isset($related['quantity']) && $related['quantity'] == 0): ?>
                                <span class="badge badge-outofstock">Hết hàng</span>
                            <?php endif; ?>
                            <?php if (isset($related['featured']) && $related['featured']): ?>
                                <span class="badge badge-hot">Hot</span>
                            <?php endif; ?>
                            <?php if (isset($related['sale_price']) && $related['sale_price']): ?>
                                <span class="badge badge-sale">-<?= round((1 - $related['sale_price'] / $related['price']) * 100); ?>%</span>
                            <?php endif; ?>
                        </div>
                        <div class="product-image">
                            <a href="/websitebatminton/products/<?= htmlspecialchars($related['slug']); ?>">
                                <img src="<?= $related['image'] ? '/websitebatminton/storage/uploads/' . $related['image'] : '/websitebatminton/assets/images/product.jpg'; ?>" 
                                     alt="<?= htmlspecialchars($related['name']); ?>" class="img-fluid">
                            </a>
                        </div>
                        <div class="product-info p-3">
                            <h6 class="product-name mb-2">
                                <a href="/websitebatminton/products/<?= htmlspecialchars($related['slug']); ?>" class="text-decoration-none">
                                    <?= htmlspecialchars($related['name']); ?>
                                </a>
                            </h6>
                            <div class="product-price mb-3">
                                <?php if (isset($related['sale_price']) && $related['sale_price']): ?>
                                    <span class="sale-price fw-bold text-danger"><?= number_format($related['sale_price'], 0, ',', '.'); ?>đ</span>
                                    <span class="original-price text-muted text-decoration-line-through ms-2"><?= number_format($related['price'], 0, ',', '.'); ?>đ</span>
                                <?php else: ?>
                                    <span class="price fw-bold text-primary"><?= number_format($related['price'], 0, ',', '.'); ?>đ</span>
                                <?php endif; ?>
                            </div>
                            <?php if (isset($related['quantity']) && $related['quantity'] == 0): ?>
                                <button class="btn btn-primary w-100 disabled opacity-50" disabled>Hết hàng</button>
                            <?php else: ?>
                                <a href="/websitebatminton/cart/add?product_id=<?= htmlspecialchars($related['id']); ?>" class="btn btn-primary w-100 btn-add-cart">
                                    <i class="bi bi-cart-plus me-1"></i>Thêm giỏ hàng
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>

