<?php
// BÀI TẬP 01: Nhập file cấu hình kết nối CSDL
require 'connect.php';

// BÀI TẬP 05: Xử lý chức năng xóa sinh viên theo id nhận từ tham số GET
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    try {
        // BÀI TẬP 10: Chuyển truy vấn xóa sang Prepared Statement để tránh lỗi bảo mật SQL Injection
        $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
        $stmt->execute([$id]);
    } catch (PDOException $e) {
        // Xử lý lỗi nếu có ngoại lệ cơ sở dữ liệu xảy ra
    }
}

// Điều hướng quay lại trang danh sách sinh viên sau khi xóa thành công hoặc thất bại
header("Location: list_students.php");
exit;
?>

