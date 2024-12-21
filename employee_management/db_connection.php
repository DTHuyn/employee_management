<?php
// db_connection.php

$servername = "localhost";
$username = "root"; // Đổi tên người dùng MySQL nếu cần
$password = ""; // Đổi mật khẩu nếu có
$dbname = "employee_management";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
