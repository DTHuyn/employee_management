<?php
// Bắt đầu phiên làm việc
session_start();
require 'db_connection.php'; // Kết nối tới cơ sở dữ liệu
//Xử lý yêu cầu POST (khi người dùng gửi form):
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy tên đăng nhập và mật khẩu từ biểu mẫu
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Kiểm tra nếu tên người dùng và mật khẩu không rỗng
    if (empty($username) || empty($password)) {
        $error_message = "Tên đăng nhập và mật khẩu không được để trống!";
    } else {
        // Câu lệnh SQL để tìm người dùng
        $sql = "SELECT id, password FROM users WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result === false) {
            $error_message = "Lỗi truy vấn: " . $conn->error;
        } else if ($result->num_rows > 0) {
            // Lấy thông tin từ cơ sở dữ liệu
            $row = $result->fetch_assoc();
            $db_password = $row['password'];
            $user_id = $row['id']; // Lưu ID người dùng

            // Kiểm tra mật khẩu
            if ($password === $db_password) {
                // Đăng nhập thành công
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $user_id; // Lưu ID vào session
                header("Location: dashboard.php"); // Chuyển hướng đến trang chủ
                exit();
            } else {
                $error_message = "Mật khẩu không chính xác!";
            }
        } else {
            $error_message = "Tên người dùng không tồn tại!";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Lato', sans-serif;
            background-color: #f6f6f6;
            margin: 0; /* Đảm bảo không có khoảng trắng xung quanh */
        }
        .login-container {
            max-width: 350px;
            width: 100%; /* Đảm bảo form có thể mở rộng đến 100% */
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin: 15px; /* Thêm một khoảng cách để đảm bảo form không bị chèn vào các cạnh */
        }
        .login-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Đăng Nhập</h2>
    <?php if (isset($error_message)): ?>
        <p class="error-message"><?= $error_message ?></p>
    <?php endif; ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Đăng Nhập</button>
    </form>
</div>

</body>
</html>
