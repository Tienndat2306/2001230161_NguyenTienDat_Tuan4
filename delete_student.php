<?php
require 'connect.php';
if (isset($_GET['id'])) {
$stmt = $conn->prepare("DELETE FROM students WHERE id=?");

$stmt->execute([$_GET['id']]);
}
header("Location: list_students.php");
exit;
?>