<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra nếu ID có tồn tại
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Kiểm tra các trường dữ liệu khác
        if (isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['position'], $_POST['salary'], $_POST['gender'], $_POST['birth_date'])) {
            // Sử dụng prepared statement để tránh SQL Injection
            $stmt = $conn->prepare("UPDATE employees SET name = ?, email = ?, phone = ?, position = ?, salary = ?, gender = ?, birth_date = ? WHERE id = ?");
            $stmt->bind_param("ssssdssi", $name, $email, $phone, $position, $salary, $gender, $birth_date, $id);

            // Lấy dữ liệu từ POST
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $position = $_POST['position'];
            $salary = $_POST['salary'];
            $gender = $_POST['gender'];
            $birth_date = $_POST['birth_date'];

            // Thực hiện câu lệnh UPDATE
            if ($stmt->execute()) {
                // Chuyển hướng đến trang dashboard.php
                header("Location: dashboard.php");
                exit(); // Dừng thực hiện thêm mã
            } else {
                echo "Lỗi: " . $stmt->error;
            }

            // Đóng statement
            $stmt->close();
        } else {
            echo "Dữ liệu không hợp lệ.";
        }
    } else {
        echo "ID không hợp lệ.";
    }
} else {
    echo "Phương thức không hợp lệ.";
}

// Đóng kết nối
$conn->close();
?>
