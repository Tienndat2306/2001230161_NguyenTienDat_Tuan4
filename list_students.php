<?php
// BÀI TẬP 01: Nạp cấu hình kết nối cơ sở dữ liệu MySQL bằng PDO
require 'connect.php';

// BÀI TẬP 07 & 09: Lấy từ khóa tìm kiếm theo tên sinh viên từ tham số GET
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

// BÀI TẬP 11: Cấu hình tính năng Sắp xếp danh sách (Sort) theo tên hoặc email
$allowedSortColumns = ['id', 'name', 'email', 'phone', 'birthday'];
$sort = isset($_GET['sort']) && in_array($_GET['sort'], $allowedSortColumns) ? $_GET['sort'] : 'id';
$order = isset($_GET['order']) && strtolower($_GET['order']) === 'asc' ? 'ASC' : 'DESC';

// Xác định hướng sắp xếp tiếp theo cho các liên kết tiêu đề cột
$nextOrder = ($order === 'ASC') ? 'desc' : 'asc';

// BÀI TẬP 07: Cấu hình phân trang dữ liệu (Pagination)
$limit = 5; // Số lượng bản ghi hiển thị trên mỗi trang
$page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// BÀI TẬP 10: Sử dụng Prepared Statement để truy vấn tổng số bản ghi sinh viên (để phân trang) nhằm tránh SQL Injection
$sqlCount = "SELECT COUNT(*) FROM students WHERE name LIKE :keyword";
$stmtCount = $conn->prepare($sqlCount);
$stmtCount->execute([':keyword' => "%$keyword%"]);
$totalRecords = $stmtCount->fetchColumn();
$totalPages = ceil($totalRecords / $limit);

// Đảm bảo trang hiện tại không vượt quá tổng số trang hiện có
if ($totalPages > 0 && $page > $totalPages) {
    $page = $totalPages;
    $offset = ($page - 1) * $limit;
}

// BÀI TẬP 10: Sử dụng Prepared Statement để truy vấn lấy dữ liệu sinh viên có phân trang, tìm kiếm và sắp xếp động an toàn
$sql = "SELECT * FROM students 
        WHERE name LIKE :keyword 
        ORDER BY {$sort} {$order} 
        LIMIT :limit OFFSET :offset";

$stmt = $conn->prepare($sql);
$stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

/**
 * Hàm hỗ trợ tạo URL sắp xếp động giữ nguyên từ khóa tìm kiếm
 */
function getSortUrl($column, $currentSort, $currentOrder, $keyword) {
    $nextOrder = ($currentSort === $column && $currentOrder === 'ASC') ? 'desc' : 'asc';
    return "?keyword=" . urlencode($keyword) . "&sort={$column}&order={$nextOrder}&page=1";
}

/**
 * Hàm hỗ trợ hiển thị biểu tượng mũi tên sắp xếp tăng/giảm trên giao diện
 */
function getSortIcon($column, $currentSort, $currentOrder) {
    if ($currentSort !== $column) {
        return '<span class="text-muted" style="font-size: 0.8rem;">↕</span>';
    }
    return $currentOrder === 'ASC' ? '▲' : '▼';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Nhúng file CSS phong cách tùy chỉnh đã tạo ở Bài tập 03 -->
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <!-- Tiêu đề Header của ứng dụng với dải màu Gradient hiện đại -->
    <header class="app-header">
        <div class="container text-center">
            <h1 class="app-title">Hệ Thống Quản Lý Sinh Viên</h1>
            <p class="lead mb-0 text-white-50">Bài tập thực hành Lập trình mã nguồn mở - Lab 4 (PDO & MySQL)</p>
        </div>
    </header>

    <main class="container mb-5">
        
        <!-- Dòng điều khiển Tìm kiếm và Thêm mới sinh viên -->
        <div class="row align-items-center mb-4">
            <!-- BÀI TẬP 07 & 09: Form Tìm kiếm Sinh Viên theo Tên -->
            <div class="col-md-8 mb-3 mb-md-0">
                <form method="get" class="row g-2">
                    <!-- Giữ nguyên tùy chọn sắp xếp hiện tại khi thực hiện tìm kiếm -->
                    <?php if (isset($_GET['sort'])): ?>
                        <input type="hidden" name="sort" value="<?= htmlspecialchars($_GET['sort']) ?>">
                    <?php endif; ?>
                    <?php if (isset($_GET['order'])): ?>
                        <input type="hidden" name="order" value="<?= htmlspecialchars($_GET['order']) ?>">
                    <?php endif; ?>
                    
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search text-muted" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                </svg>
                            </span>
                            <input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>" 
                                   class="form-control border-start-0" placeholder="Nhập họ tên sinh viên cần tìm...">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                    </div>
                </form>
            </div>
            
            <!-- BÀI TẬP 04: Liên kết mở Form Thêm sinh viên mới (add_student.php) -->
            <div class="col-md-4 text-md-end">
                <a href="add_student.php" class="btn btn-primary d-inline-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                    </svg>
                    Thêm sinh viên mới
                </a>
            </div>
        </div>

        <!-- BÀI TẬP 03: Hiển thị danh sách sinh viên dưới dạng Bảng HTML -->
        <div class="card p-0 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>
                                    <!-- BÀI TẬP 11: Cho phép click tiêu đề để Sắp xếp theo ID -->
                                    <a class="sort-link" href="<?= getSortUrl('id', $sort, $order, $keyword) ?>">
                                        # <?= getSortIcon('id', $sort, $order) ?>
                                    </a>
                                </th>
                                <th>
                                    <!-- BÀI TẬP 11: Cho phép click tiêu đề để Sắp xếp theo Họ và tên -->
                                    <a class="sort-link" href="<?= getSortUrl('name', $sort, $order, $keyword) ?>">
                                        Họ và tên <?= getSortIcon('name', $sort, $order) ?>
                                    </a>
                                </th>
                                <th>
                                    <!-- BÀI TẬP 11: Cho phép click tiêu đề để Sắp xếp theo Email -->
                                    <a class="sort-link" href="<?= getSortUrl('email', $sort, $order, $keyword) ?>">
                                        Email <?= getSortIcon('email', $sort, $order) ?>
                                    </a>
                                </th>
                                <th>Số điện thoại</th>
                                <th>
                                    <!-- BÀI TẬP 11: Cho phép click tiêu đề để Sắp xếp theo Ngày sinh -->
                                    <a class="sort-link" href="<?= getSortUrl('birthday', $sort, $order, $keyword) ?>">
                                        Ngày sinh <?= getSortIcon('birthday', $sort, $order) ?>
                                    </a>
                                </th>
                                <th class="text-center" style="width: 180px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($students): ?>
                                <?php foreach ($students as $index => $row): ?>
                                    <tr>
                                        <td><?= $offset + $index + 1 ?></td>
                                        <td class="fw-semibold text-dark"><?= htmlspecialchars($row['name']) ?></td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <td><?= htmlspecialchars($row['phone'] ?: '-') ?></td>
                                        <!-- BÀI TẬP 08: Hiển thị thông tin Ngày sinh sinh viên theo định dạng Ngày/Tháng/Năm -->
                                        <td>
                                            <?= $row['birthday'] ? date('d/m/Y', strtotime($row['birthday'])) : '-' ?>
                                        </td>
                                        <!-- Cột liên kết Sửa / Xóa dữ liệu -->
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <!-- BÀI TẬP 06: Mở trang Sửa thông tin sinh viên theo ID -->
                                                <a href="edit_student.php?id=<?= $row['id'] ?>" class="action-btn action-btn-edit">
                                                    Sửa
                                                </a>
                                                <!-- BÀI TẬP 05: Thực hiện Xóa sinh viên với hộp thoại JS xác nhận trước khi xóa (confirm) -->
                                                <a href="delete_student.php?id=<?= $row['id'] ?>" 
                                                   class="action-btn action-btn-delete"
                                                   onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên: <?= htmlspecialchars(addslashes($row['name'])) ?> không?')">
                                                    Xóa
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <div class="mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-people text-black-50" viewBox="0 0 16 16">
                                                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM6 2a2 2 0 1 1-3.998-.002A2 2 0 0 1 6 2ZM3 0a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z"/>
                                            </svg>
                                        </div>
                                        Không tìm thấy sinh viên nào.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- BÀI TẬP 07: Hiển thị bộ điều hướng Phân trang (Pagination) -->
        <?php if ($totalPages > 1): ?>
            <nav class="d-flex justify-content-center mt-4">
                <ul class="pagination">
                    <!-- Nút Trang Đầu & Trang Trước -->
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?keyword=<?= urlencode($keyword) ?>&sort=<?= $sort ?>&order=<?= $order ?>&page=1">Đầu</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="?keyword=<?= urlencode($keyword) ?>&sort=<?= $sort ?>&order=<?= $order ?>&page=<?= $page - 1 ?>">Trước</a>
                        </li>
                    <?php endif; ?>

                    <!-- Danh sách các số trang -->
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?keyword=<?= urlencode($keyword) ?>&sort=<?= $sort ?>&order=<?= $order ?>&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Nút Trang Sau & Trang Cuối -->
                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?keyword=<?= urlencode($keyword) ?>&sort=<?= $sort ?>&order=<?= $order ?>&page=<?= $page + 1 ?>">Sau</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="?keyword=<?= urlencode($keyword) ?>&sort=<?= $sort ?>&order=<?= $order ?>&page=<?= $totalPages ?>">Cuối</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>

    </main>

    <!-- Bản quyền chân trang -->
    <footer class="text-center py-4 bg-white border-top text-muted mt-auto">
        <div class="container">
            <small>&copy; 2026 - Nguyễn Anh Quân (2001230717) - Lập trình mã nguồn mở</small>
        </div>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
