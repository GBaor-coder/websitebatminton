<!-- Brands List View -->
<div class="card">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0"><i class="fas fa-industry me-2"></i>Quản lý hãng</h5>
            </div>
            <div class="col-md-6 text-end">
                <a href="/websitebatminton/admin/brands/create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm hãng
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <form method="GET" action="/websitebatminton/admin/brands" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm hãng..." 
                           value="<?php echo $search ?? ''; ?>">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search"></i> Tìm
                    </button>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên hãng</th>
                        <th>Danh mục</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($brands)): ?>
                        <?php foreach ($brands as $brand): ?>
                        <tr>
                            <td><?php echo $brand['id']; ?></td>
                            <td><strong><?php echo $brand['name']; ?></strong><br><small><code><?php echo $brand['slug']; ?></code></small></td>
                            <td><?php echo $brand['category_name'] ?? 'Không xác định'; ?></td>
                            <td>
                                <span class="badge bg-<?php echo $brand['status'] == 'active' ? 'success' : 'secondary'; ?>">
                                    <?php echo $brand['status'] == 'active' ? 'Hoạt động' : 'Ẩn'; ?>
                                </span>
                            </td>
                            <td>
                                <a href="/websitebatminton/admin/brands/edit?id=<?php echo $brand['id']; ?>" 
                                   class="btn btn-sm btn-outline-primary" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="/websitebatminton/admin/brands/delete" 
                                      class="d-inline" onsubmit="return confirmDelete();">
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                    <input type="hidden" name="id" value="<?php echo $brand['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <p class="text-muted mb-0">Không tìm thấy hãng nào</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($pagination['total_pages'] > 1): ?>
        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                <li class="page-item <?php echo $pagination['page'] == $i ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?><?php echo $search ? '&search=' . $search : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>
