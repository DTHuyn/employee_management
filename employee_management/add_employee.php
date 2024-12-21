<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Chuyển hướng đến trang đăng nhập
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Nhân Viên</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Lato" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body id="myPage">

<?php include 'header.php'; ?> <!-- Nhúng header.php -->
<div class="container mt-5" style="margin-top: 70px;"> <!-- Bổ sung khoảng cách cho navbar cố định -->
    <h2>Thêm Nhân Viên</h2>
    <form action="add_employee_process.php" method="POST">
        <div class="form-group">
            <label for="name">Tên:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="phone">Số điện thoại:</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="position">Vị trí:</label>
            <input type="text" class="form-control" id="position" name="position" required>
        </div>
        <div class="form-group">
            <label for="salary">Lương:</label>
            <input type="number" step="100" class="form-control" id="salary" name="salary" required>
        </div>
        <div class="form-group">
            <label for="gender">Giới tính:</label>
            <select name="gender" id="gender" class="form-control" required>
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
                <option value="Khác">Khác</option>
            </select>
        </div>
        <div class="form-group">
            <label for="birth_date">Ngày tháng năm sinh:</label>
            <input type="date" name="birth_date" id="birth_date" class="form-control" required min="1924-01-01" max="<?php echo date('Y-m-d'); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Thêm Nhân Viên</button>
    </form>
    <div class="text-left" style="margin-top: 20px;">
        <a href="dashboard.php" class="btn btn-primary margin-right">Quay lại</a>
    </div>
</div>
<div class="clearfix" style="margin-top: 100px;"></div>

<?php include 'footer.php'; ?> <!-- Nhúng footer.php -->

</body>
</html>
