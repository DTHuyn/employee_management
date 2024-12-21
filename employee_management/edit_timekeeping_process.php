<?php
// edit_timekeeping_process.php

include 'db_connection.php'; // Kết nối cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $employee_id = $_POST['employee_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    // Cập nhật thông tin chấm công
    $sql = "UPDATE timekeeping SET employee_id=?, check_in=?, check_out=? WHERE id=?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issi", $employee_id, $check_in, $check_out, $id);

    if ($stmt->execute()) {
        echo "Cập nhật chấm công thành công!";
    } else {
        echo "Lỗi: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
header("Location: timekeeping_management.php"); // Quay lại trang quản lý chấm công
exit();
?>
