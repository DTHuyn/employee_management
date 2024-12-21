<?php
// add_timekeeping_process.php


include 'db_connection.php'; // Kết nối cơ sở dữ liệu

// Xử lý việc thêm chấm công
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    $sql = "INSERT INTO timekeeping (employee_id, check_in, check_out) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $employee_id, $check_in, $check_out);
    
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Thêm chấm công thành công!</div>";
    } else {
        echo "<div class='alert alert-danger'>Lỗi: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

$conn->close(); // Đóng kết nối

header("Location: timekeeping_management.php"); // Quay lại trang quản lý chấm công
exit();
?>
