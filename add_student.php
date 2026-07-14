<?php
// BÀI TẬP 01: Nhập file cấu hình kết nối CSDL
require 'connect.php';

$error = '';
$success = '';

// BÀI TẬP 04: Xử lý thêm sinh viên mới qua phương thức POST nhận từ Form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    // BÀI TẬP 08: Nhận giá trị trường ngày sinh (birthday) từ Form gửi lên
    $birthday = isset($_POST['birthday']) ? trim($_POST['birthday']) : '';

    if (empty($name) || empty($email)) {
        $error = 'Họ tên và Email là bắt buộc.';
    } else {
        try {
            // BÀI TẬP 10: Sử dụng Prepared Statement thay thế cho các truy vấn SQL trực tiếp để phòng chống SQL Injection
            $stmt = $conn->prepare("INSERT INTO students (name, email, phone, birthday) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $name,
                $email,
                $phone === '' ? null : $phone,
                $birthday === '' ? null : $birthday // BÀI TẬP 08: Lưu giá trị birthday vào DB
            ]);
            $success = 'Thêm sinh viên mới thành công!';
            // Xóa thông tin đã nhập sau khi thêm thành công để cho phép nhập tiếp
            $_POST = [];
        } catch (PDOException $e) {
            // Bắt lỗi trùng lặp Email (ràng buộc UNIQUE)
            if ($e->getCode() == '23000') {
                $error = 'Email này đã tồn tại trong hệ thống. Vui lòng nhập email khác.';
            } else {
                $error = 'Lỗi kết nối cơ sở dữ liệu: ' . $e->getMessage();
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
    <title>Thêm sinh viên</title>
    <!-- Gói giao diện Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- File CSS tùy chỉnh đã thiết kế -->
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <!-- Phần tiêu đề trang (Header) với dải màu gradient -->
    <header class="app-header">
        <div class="container text-center">
            <h1 class="app-title">Thêm Sinh Viên Mới</h1>
            <p class="lead mb-0 text-white-50">Nhập thông tin sinh viên và lưu vào cơ sở dữ liệu</p>
        </div>
    </header>

    <main class="container mb-5" style="max-width: 600px;">
        <div class="card p-4">
            
            <!-- Vùng hiển thị thông báo lỗi hoặc thành công -->
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

            <!-- Form điền thông tin -->
            <form method="post" action="">
                <!-- Ô nhập Họ và tên -->
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" required>
                </div>

                <!-- Ô nhập Email -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
                </div>

                <!-- Ô nhập Số điện thoại -->
                <div class="mb-3">
                    <label for="phone" class="form-label fw-semibold">Số điện thoại</label>
                    <input type="text" class="form-control" id="phone" name="phone" 
                           value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>">
                </div>

                <!-- BÀI TẬP 08: Nhập thông tin Ngày sinh trong Form thêm mới -->
                <div class="mb-4">
                    <label for="birthday" class="form-label fw-semibold">Ngày sinh</label>
                    <input type="date" class="form-control" id="birthday" name="birthday" 
                           value="<?= isset($_POST['birthday']) ? htmlspecialchars($_POST['birthday']) : '' ?>">
                </div>

                <!-- Các nút nhấn chuyển trang và lưu dữ liệu -->
                <div class="d-flex justify-content-between align-items-center">
                    <a href="list_students.php" class="btn btn-secondary">Quay lại danh sách</a>
                    <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                </div>
            </form>
        </div>
    </main>

    <!-- Chân trang hiển thị thông tin bản quyền -->
    <footer class="text-center py-4 bg-white border-top text-muted mt-auto">
        <div class="container">
            <small>&copy; 2026 - Nguyễn Anh Quân (2001230717) - Lập trình mã nguồn mở</small>
        </div>
    </footer>

    <!-- Tập tin Javascript của Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
