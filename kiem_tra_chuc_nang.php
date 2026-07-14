<?php
// BÀI TẬP 01: Nhập file cấu hình kết nối CSDL
require 'connect.php';

echo "\n=== BẮT ĐẦU KIỂM TRA CHỨC NĂNG HỆ THỐNG (CRUD) ===\n";

// 1. Kiểm tra kết nối cơ sở dữ liệu qua file connect.php
if (isset($conn) && $conn instanceof PDO) {
    echo "[THÀNH CÔNG] connect.php đã thiết lập kết nối PDO thành công.\n";
} else {
    echo "[THẤT BẠI] connect.php không kết nối được CSDL.\n";
    exit(1);
}

// 2. Dọn dẹp dữ liệu thử nghiệm cũ nếu có
$conn->exec("DELETE FROM students WHERE email LIKE 'test_%'");

// 3. Kiểm tra tính năng thêm mới sinh viên (Bài tập 04, 08, 10)
try {
    $stmt = $conn->prepare("INSERT INTO students (name, email, phone, birthday) VALUES (?, ?, ?, ?)");
    $stmt->execute(['Sinh Vien Thu Nghiem', 'test_student@example.com', '0888888888', '2005-09-15']);
    $insertedId = $conn->lastInsertId();
    echo "[THÀNH CÔNG] Đã thêm sinh viên thử nghiệm có ID: $insertedId (Kết hợp Ngày sinh & Prepared Statement)\n";
} catch (Exception $e) {
    echo "[THẤT BẠI] Lỗi khi thêm sinh viên: " . $e->getMessage() . "\n";
    exit(1);
}

// 4. Kiểm tra tính năng tìm kiếm sinh viên (Bài tập 03, 07, 09, 10)
try {
    $stmt = $conn->prepare("SELECT * FROM students WHERE name LIKE ?");
    $stmt->execute(['%Thu Nghiem%']);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($rows) === 1 && $rows[0]['email'] === 'test_student@example.com') {
        echo "[THÀNH CÔNG] Tìm kiếm sinh viên bằng Prepared Statement hoạt động chính xác.\n";
    } else {
        echo "[THẤT BẠI] Không tìm thấy sinh viên thử nghiệm bằng từ khóa.\n";
    }
} catch (Exception $e) {
    echo "[THẤT BẠI] Lỗi khi tìm kiếm: " . $e->getMessage() . "\n";
}

// 5. Kiểm tra tính năng sửa đổi cập nhật thông tin sinh viên (Bài tập 06, 08, 10)
try {
    $stmt = $conn->prepare("UPDATE students SET name = ?, birthday = ? WHERE id = ?");
    $stmt->execute(['Sinh Vien Da Chinh Sua', '2005-12-25', $insertedId]);
    
    $stmtSelect = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmtSelect->execute([$insertedId]);
    $student = $stmtSelect->fetch(PDO::FETCH_ASSOC);
    
    if ($student['name'] === 'Sinh Vien Da Chinh Sua' && $student['birthday'] === '2005-12-25') {
        echo "[THÀNH CÔNG] Cập nhật thông tin họ tên và ngày sinh thành công.\n";
    } else {
        echo "[THẤT BẠI] Thông tin sửa đổi không khớp với CSDL.\n";
    }
} catch (Exception $e) {
    echo "[THẤT BẠI] Lỗi khi cập nhật: " . $e->getMessage() . "\n";
}

// 6. Kiểm tra tính năng kiểm soát email trùng lặp (Bài tập 04, 06)
try {
    $stmt = $conn->prepare("INSERT INTO students (name, email) VALUES ('Sinh Vien Khac', 'test_student@example.com')");
    $stmt->execute();
    echo "[THẤT BẠI] CSDL cho phép chèn email trùng lặp (Không bắt được ràng buộc UNIQUE).\n";
} catch (PDOException $e) {
    if ($e->getCode() == '23000') {
        echo "[THÀNH CÔNG] Ràng buộc CSDL ngăn trùng lặp Email hoạt động tốt.\n";
    } else {
        echo "[THẤT BẠI] Báo lỗi trùng lặp không chính xác: " . $e->getMessage() . "\n";
    }
}

// 7. Kiểm tra tính năng xóa sinh viên (Bài tập 05, 10)
try {
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->execute([$insertedId]);
    
    $stmtSelect = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmtSelect->execute([$insertedId]);
    $student = $stmtSelect->fetch();
    if (!$student) {
        echo "[THÀNH CÔNG] Xóa sinh viên thử nghiệm khỏi CSDL thành công.\n";
    } else {
        echo "[THẤT BẠI] Sinh viên vẫn tồn tại sau khi xóa.\n";
    }
} catch (Exception $e) {
    echo "[THẤT BẠI] Lỗi khi xóa sinh viên: " . $e->getMessage() . "\n";
}

echo "=== KIỂM TRA HOÀN TẤT ===\n\n";
?>
