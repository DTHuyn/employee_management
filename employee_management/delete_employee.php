<?php
// delete_employee.php

include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM employees WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Xóa nhân viên thành công!";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
header("Location: dashboard.php"); // Quay lại trang quản lý nhân viên
exit();
?>
