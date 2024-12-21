<?php
session_start();
require 'db_connection.php'; // Kết nối đến cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ biểu mẫu
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $position = trim($_POST['position']);
    $salary = trim($_POST['salary']);
    $gender = trim($_POST['gender']);
    $birth_date = trim($_POST['birth_date']); // Đổi tên biến từ birth_year thành birth_date

    // Kiểm tra nếu các trường không rỗng
    if (empty($name) || empty($email) || empty($phone) || empty($position) || empty($salary) || empty($gender) || empty($birth_date)) {
        echo "Tất cả các trường đều phải được điền!";
        exit();
    }

    // Câu lệnh SQL để thêm nhân viên
    $sql = "INSERT INTO employees (name, email, phone, position, salary, gender, birth_date) VALUES (?, ?, ?, ?, ?, ?, ?)"; // Cập nhật tên trường trong câu lệnh SQL
    
    // Chuẩn bị câu lệnh
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo "Lỗi chuẩn bị câu lệnh: " . $conn->error;
        exit();
    }

    // Liên kết các tham số
    $stmt->bind_param("ssssiss", $name, $email, $phone, $position, $salary, $gender, $birth_date); // Cập nhật kiểu dữ liệu của tham số

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        echo "Thêm nhân viên thành công!";
        // Chuyển hướng về trang danh sách nhân viên hoặc trang chủ
        header("Location: dashboard.php"); // Hoặc trang danh sách nhân viên
        exit();
    } else {
        echo "Lỗi thêm nhân viên: " . $stmt->error;
    }

    // Đóng câu lệnh và kết nối
    $stmt->close();
    $conn->close();
}
?>
