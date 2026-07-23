<?php
require 'connect.php';
// 1. Lấy từ khóa tìm kiếm
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

// 2. LẤY BẾN SẮP XẾP TRƯỚC (Đưa đoạn này lên trên)
$sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'id';
$sortOrder = isset($_GET['order']) ? strtoupper($_GET['order']) : 'DESC';

$allowedSorts = ['id', 'name', 'email'];
if (!in_array($sortBy, $allowedSorts)) {
    $sortBy = 'id';
}
$sortOrder = ($sortOrder === 'ASC') ? 'ASC' : 'DESC';

// 3. Thiết lập phân trang
$limit = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// 4. Truy vấn tổng số bản ghi
$sqlCount = "SELECT COUNT(*) FROM students WHERE name LIKE :keyword";
$stmtCount = $conn->prepare($sqlCount);
$stmtCount->execute([':keyword' => "%$keyword%"]);
$totalRecords = $stmtCount->fetchColumn();
$totalPages = ceil($totalRecords / $limit);

// 5. Truy vấn dữ liệu (Dùng duy nhất 1 câu SQL đã ghép $sortBy và $sortOrder)
$sql = "SELECT * FROM students
        WHERE name LIKE :keyword
        ORDER BY $sortBy $sortOrder
        LIMIT :limit OFFSET :offset";

$stmt = $conn->prepare($sql);
$stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

// Dữ liệu lấy ra bây giờ ĐÃ ĐƯỢC SẮP XẾP chính xác
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

function getSortUrl($column, $currentSort, $currentOrder, $keyword) {
    $newOrder = ($currentSort === $column && $currentOrder === 'ASC') ? 'DESC' : 'ASC';
    return "?keyword=" . urlencode($keyword) . "&sort_by=$column&order=$newOrder";
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Danh sách sinh viên</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css
" rel="stylesheet">
</head>

<body class="container mt-4">
    <h2>Danh sách sinh viên</h2>
    <a href="add_student.php" style="margin-bottom: 10px; display: inline-block;">+ Thêm sinh viên mới</a>
    <!-- Form tìm kiếm -->
    <form method="get" class="row mb-3">
        <div class="col-md-4">
            <input type="text" name="keyword" value="<?=htmlspecialchars($keyword) ?>"
                class="form-control" placeholder="Nhập tên cần tìm">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </div>
    </form>
    <!-- Bảng hiển thị dữ liệu -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>
                    <a href="<?= getSortUrl('name', $sortBy, $sortOrder, $keyword) ?>" class="text-dark text-decoration-none">
                        Họ và tên <?= $sortBy === 'name' ? ($sortOrder === 'ASC' ? '▲' : '▼') : '⇕' ?>
                    </a>
                </th>
                <th>
                    <a href="<?= getSortUrl('email', $sortBy, $sortOrder, $keyword) ?>" class="text-dark text-decoration-none">
                        Email <?= $sortBy === 'email' ? ($sortOrder === 'ASC' ? '▲' : '▼') : '⇕' ?>
                    </a>
                </th>
                <th>Số điện thoại</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($students): ?>
                <?php foreach ($students as $index => $row): ?>
                    <tr>
                        <td><?= $offset + $index + 1 ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td>
                            <a href="edit_student.php?id=<?= $row['id'] ?>">Sửa</a> | 
                            <a href="delete_student.php?id=<?= $row['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Không có dữ liệu</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <!-- Phân trang -->
    <nav>
        <ul class="pagination">
            <?php if ($page > 1): ?>
                <li class="page-item"><a class="page-link" href="?keyword=<?=urlencode($keyword) ?>&page=1">Đầu</a></li>
                <li class="page-item"><a class="page-link" href="?keyword=<?=urlencode($keyword) ?>&page=<?= $page - 1 ?>">Trước</a></li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?keyword=<?=urlencode($keyword) ?>&page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?>
                <li class="page-item"><a class="page-link" href="?keyword=<?=urlencode($keyword) ?>&page=<?= $page + 1 ?>">Sau</a></li>
                <li class="page-item"><a class="page-link" href="?keyword=<?=urlencode($keyword) ?>&page=<?= $totalPages ?>">Cuối</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</body>

</html>