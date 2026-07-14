<?php
// BÀI TẬP 01: Nhập file cấu hình kết nối CSDL dùng PDO
require 'connect.php';

$error = '';
$success = '';
$student = null;

// BÀI TẬP 06: Lấy thông tin sinh viên cũ dựa trên tham số ID từ GET để hiển thị lên Form sửa
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    try {
        // BÀI TẬP 10: Sử dụng Prepared Statement để truy vấn thông tin sinh viên theo ID (Bảo mật SQL Injection)
        $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->execute([$id]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$student) {
            $error = 'Không tìm thấy sinh viên có ID này.';
        }
    } catch (PDOException $e) {
        $error = 'Lỗi cơ sở dữ liệu: ' . $e->getMessage();
    }
} else {
    // Điều hướng về trang danh sách nếu thiếu ID
    header("Location: list_students.php");
    exit;
}

// BÀI TẬP 06: Xử lý cập nhật thông tin sinh viên khi Form được gửi (submit) qua POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    // BÀI TẬP 08: Nhận giá trị ngày sinh (birthday) được gửi từ Form sửa đổi
    $birthday = isset($_POST['birthday']) ? trim($_POST['birthday']) : '';

    if (empty($name) || empty($email)) {
        $error = 'Họ tên và Email không được để trống.';
    } else {
        try {
            // BÀI TẬP 10: Sử dụng Prepared Statement cho câu lệnh UPDATE để bảo mật dữ liệu
            $stmt = $conn->prepare("UPDATE students SET name = ?, email = ?, phone = ?, birthday = ? WHERE id = ?");
            $stmt->execute([
                $name,
                $email,
                $phone === '' ? null : $phone,
                $birthday === '' ? null : $birthday, // BÀI TẬP 08: Lưu giá trị ngày sinh cập nhật vào CSDL
                $id
            ]);
            $success = 'Cập nhật thông tin sinh viên thành công!';
            
            // Tải lại thông tin sinh viên mới cập nhật để hiển thị lên Form
            $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
            $stmt->execute([$id]);
            $student = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Kiểm tra trùng lặp email với sinh viên khác trong CSDL
            if ($e->getCode() == '23000') {
                $error = 'Email này đã tồn tại trên hệ thống. Vui lòng chọn email khác.';
            } else {
                $error = 'Lỗi cập nhật dữ liệu: ' . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=device-width, initial-scale=1.0">
    <title>Cập nhật sinh viên</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Nhúng file CSS tùy chỉnh đã thiết kế -->
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <!-- Tiêu đề Header với dải màu Gradient -->
    <header class="app-header">
        <div class="container text-center">
            <h1 class="app-title">Cập Nhật Thông Tin</h1>
            <p class="lead mb-0 text-white-50">Sửa thông tin chi tiết của sinh viên và lưu thay đổi</p>
        </div>
    </header>

    <main class="container mb-5" style="max-width: 600px;">
        <div class="card p-4">
            
            <!-- Thông báo Lỗi / Thành công -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success" role="alert">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <?php if ($student): ?>
                <!-- Form cập nhật thông tin sinh viên -->
                <form method="post" action="">
                    <!-- Input ẩn chứa ID sinh viên -->
                    <input type="hidden" name="id" value="<?= (int)$student['id'] ?>">

                    <!-- Trường Họ và tên -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?= htmlspecialchars($student['name']) ?>" required>
                    </div>

                    <!-- Trường Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= htmlspecialchars($student['email']) ?>" required>
                    </div>

                    <!-- Trường Số điện thoại -->
                    <div class="mb-3">
                        <label for="phone" class="form-label fw-semibold">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone" 
                               value="<?= htmlspecialchars($student['phone'] ?: '') ?>">
                    </div>

                    <!-- BÀI TẬP 08: Form sửa đổi hỗ trợ chỉnh sửa trường Ngày sinh (birthday) -->
                    <div class="mb-4">
                        <label for="birthday" class="form-label fw-semibold">Ngày sinh</label>
                        <input type="date" class="form-control" id="birthday" name="birthday" 
                               value="<?= htmlspecialchars($student['birthday'] ?: '') ?>">
                    </div>

                    <!-- Các nút hành động -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="list_students.php" class="btn btn-secondary">Quay lại danh sách</a>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            <?php else: ?>
                <div class="text-center mt-3">
                    <a href="list_students.php" class="btn btn-primary">Quay lại danh sách</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Bản quyền cuối trang -->
    <footer class="text-center py-4 bg-white border-top text-muted mt-auto">
        <div class="container">
            <small>&copy; 2026 - Nguyễn Anh Quân (2001230717) - Lập trình mã nguồn mở</small>
        </div>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
