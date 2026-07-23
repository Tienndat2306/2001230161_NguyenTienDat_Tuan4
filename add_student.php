<form method="post">
    <label>Họ tên:</label> <input type="text" name="name" required><br>
    <label>Email:</label> <input type="email" name="email" required><br>
    <label>SĐT:</label> <input type="text" name="phone"><br>
    <button type="submit">Thêm</button>
</form>

<?php
require 'connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("INSERT INTO students (name, email, phone) VALUES
(?, ?, ?)");
    $stmt->execute([$_POST['name'], $_POST['email'], $_POST['phone']]);
    echo "Thêm thành công!";
    header("Location: list_students.php");
}
?>