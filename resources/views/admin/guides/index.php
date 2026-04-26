<!-- Guide Contents List View -->
<div class="card">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0"><i class="fas fa-book me-2"></i>Quản lý hướng dẫn</h5>
            </div>
            <div class="col-md-6 text-end">
                <a href="/websitebatminton/admin/guides/create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm nội dung
                </a>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link active" href="/websitebatminton/admin/guides">
                    <i class="fas fa-file-alt me-1"></i> Nội dung
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/websitebatminton/admin/guide-categories">
                    <i class="fas fa-folder me-1"></i> Danh mục
                </a>
            </li>
        </ul>
        
        <!-- Search -->
        <div class="row mb-4">
            <div class="col-md-6">
                <form method="GET" action="/websitebatminton/admin/guides" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm nội dung..." 
                           value="<?php echo $search ?? ''; ?>">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search"></i> Tìm
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Contents Table -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề</th>
                        <th>Danh mục</th>
                        <th>Slug</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($contents)): ?>
                        <?php foreach ($contents as $item): ?>
                        <tr>
                            <td><?php echo $item['id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($item['title']); ?></strong></td>
                            <td>
                                <span class="badge bg-info"><?php echo htmlspecialchars($item['category_name'] ?? 'N/A'); ?></span>
                            </td>
                            <td><code><?php echo htmlspecialchars($item['slug']); ?></code></td>
                            <td><?php echo !empty($item['created_at']) ? date('d/m/Y', strtotime($item['created_at'])) : 'N/A'; ?></td>
                            <td>
                                <a href="/websitebatminton/admin/guides/edit?id=<?php echo $item['id']; ?>" 
                                   class="btn btn-sm btn-outline-primary" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="/websitebatminton/admin/guides/delete" 
                                      class="d-inline" onsubmit="return confirmDelete();">
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <p class="text-muted mb-0">Không tìm thấy nội dung nào</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if ($pagination['total_pages'] > 1): ?>
        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                <li class="page-item <?php echo $pagination['page'] == $i ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>

