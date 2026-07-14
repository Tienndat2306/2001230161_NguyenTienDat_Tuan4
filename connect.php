<?php
// BÀI TẬP 01: Thiết lập kết nối tới CSDL MySQL bằng lớp PDO (PHP Data Objects)
$dsn = "mysql:host=localhost;dbname=labdb;charset=utf8mb4";
$username = "root";
$password = "";

try {
    // Khởi tạo đối tượng PDO
    $conn = new PDO($dsn, $username, $password);
    
    // Thiết lập thuộc tính báo lỗi của PDO dưới dạng ngoại lệ (Exception)
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // In thông báo nếu chạy trực tiếp file connect.php
    if (basename($_SERVER['SCRIPT_FILENAME']) === 'connect.php') {
        echo "<div style='color: green; font-weight: bold;'>Kết nối thành công!</div>";
    }
} catch (PDOException $e) {
    // Xử lý lỗi nếu kết nối thất bại
    die("<div style='color: red; font-weight: bold;'>Kết nối thất bại: " . $e->getMessage() . "</div>");
}
?>

