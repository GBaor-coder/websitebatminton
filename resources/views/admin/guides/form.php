<!-- Guide Content Form (Create/Edit) -->
<div class="card">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">
            <i class="fas fa-book me-2"></i>
            <?php echo $content ? 'Chỉnh sửa nội dung hướng dẫn' : 'Thêm nội dung hướng dẫn'; ?>
        </h5>
    </div>
    
    <div class="card-body">
        <form method="POST" action="<?php echo $content ? '/websitebatminton/admin/guides/update' : '/websitebatminton/admin/guides/store'; ?>">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <?php if ($content): ?>
            <input type="hidden" name="id" value="<?php echo $content['id']; ?>">
            <?php endif; ?>
            
            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>" 
                        <?php echo ($content['category_id'] ?? '') == $cat['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title" name="title" 
                       value="<?php echo htmlspecialchars($content['title'] ?? ''); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="content" class="form-label">Nội dung <span class="text-danger">*</span></label>
                <textarea class="form-control" id="content" name="content" rows="15"><?php echo htmlspecialchars($content['content'] ?? ''); ?></textarea>
                <div class="form-text">Hỗ trợ HTML. Có thể dùng thẻ <p>, <h2>, <ul>, <ol>, <li>, <strong>, <em>...</div>
            </div>
            
            <div class="text-end">
                <a href="/websitebatminton/admin/guides" class="btn btn-secondary">Hủy</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Lưu
                </button>
            </div>
        </form>
    </div>
</div>

