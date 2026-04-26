<!-- Guide Category Form (Create/Edit) -->
<div class="card">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">
            <i class="fas fa-folder me-2"></i>
            <?php echo $category ? 'Chỉnh sửa danh mục hướng dẫn' : 'Thêm danh mục hướng dẫn'; ?>
        </h5>
    </div>
    
    <div class="card-body">
        <form method="POST" action="<?php echo $category ? '/websitebatminton/admin/guide-categories/update' : '/websitebatminton/admin/guide-categories/store'; ?>">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <?php if ($category): ?>
            <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
            <?php endif; ?>
            
            <div class="mb-3">
                <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="<?php echo htmlspecialchars($category['name'] ?? ''); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($category['description'] ?? ''); ?></textarea>
            </div>
            
            <div class="text-end">
                <a href="/websitebatminton/admin/guide-categories" class="btn btn-secondary">Hủy</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Lưu
                </button>
            </div>
        </form>
    </div>
</div>

