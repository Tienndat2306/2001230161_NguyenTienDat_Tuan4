<?php
$host = "localhost";
$db = "labdb";
$username = "root";
$password = "";

try {
    // Kết nối MySQL Server
    $conn = new PDO(
        "mysql:host=$host;charset=utf8mb4",
        $username,
        $password
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Tạo Database nếu chưa có
    $conn->exec("
        CREATE DATABASE IF NOT EXISTS `$db`
        CHARACTER SET utf8mb4
        COLLATE utf8mb4_unicode_ci
    ");

    // Kết nối lại vào Database
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

    $conn = new PDO($dsn, $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (basename($_SERVER['SCRIPT_FILENAME']) === 'connect.php') {
        echo "<h3>Kết nối thành công!</h3>";
    }

    $conn->exec("
        CREATE TABLE IF NOT EXISTS students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) UNIQUE,
        phone VARCHAR(20)
        );
    ");

    $conn->exec("
        INSERT IGNORE INTO students(name,email,phone)
        VALUES
        ('Nguyen Van A','a@example.com','0123456789'),
        ('Tran Thi B','b@example.com','0987654321')
    ");

    $checkColumn = $conn->query("
        SELECT COUNT(*) 
        FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = '$db' 
        AND TABLE_NAME = 'students' 
        AND COLUMN_NAME = 'birthday'
    ")->fetchColumn();

    if ($checkColumn == 0) {
        $conn->exec("ALTER TABLE students ADD COLUMN birthday DATE;");
    }
} catch (PDOException $e) {

    die($e->getMessage());
}
