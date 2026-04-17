<!-- Brand Edit View -->
<div class="card">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">
            <i class="fas fa-industry me-2"></i>
            Chỉnh sửa hãng
        </h5>
    </div>

    <div class="card-body">
        <form method="POST" action="/websitebatminton/admin/brands/update">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <input type="hidden" name="id" value="<?php echo $brand['id'] ?? 0; ?>">

            <div class="mb-3">
                <label for="name" class="form-label">Tên hãng <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $brand['name'] ?? ''; ?>" required>
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control" id="slug" name="slug" value="<?php echo $brand['slug'] ?? ''; ?>" readonly>
                <div class="form-text">Slug sẽ tự động tạo từ tên hãng.</div>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">Chọn danh mục</option>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"
                                <?php echo ($brand['category_id'] ?? '') == $category['id'] ? 'selected' : ''; ?>>
                            <?php echo $category['name']; ?>
                        </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Trạng thái</label>
                <select class="form-select" id="status" name="status">
                    <option value="active" <?php echo ($brand['status'] ?? 'active') == 'active' ? 'selected' : ''; ?>>Hoạt động</option>
                    <option value="inactive" <?php echo ($brand['status'] ?? '') == 'inactive' ? 'selected' : ''; ?>>Ẩn</option>
                </select>
            </div>

            <div class="text-end">
                <a href="/websitebatminton/admin/brands" class="btn btn-secondary">Hủy</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Lưu
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function slugify(text) {
        return text.toString().toLowerCase().trim()
            .replace(/[^a-z0-9-]+/g, '-')
            .replace(/--+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    document.getElementById('name').addEventListener('input', function() {
        document.getElementById('slug').value = slugify(this.value);
    });
</script>
