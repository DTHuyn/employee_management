<?php
include 'db_connection.php'; // Kết nối cơ sở dữ liệu

session_start();
// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
    exit();
}

// Truy vấn để lấy danh sách nhân viên
$employees = $conn->query("SELECT id, name FROM employees");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Lato" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Thêm Chấm Công</title>
</head>
<body>
<?php include 'header.php'; ?> <!-- Nhúng header.php -->

<div class="content mt-4" >
    
    <h2>Thêm Chấm Công</h2>
    
    <!-- Form thêm chấm công -->
    <form action="add_timekeeping_process.php" method="post">
        <div class="form-group col-md-6">
            <label for="employee_id">Nhân Viên:</label>
            <select name="employee_id" id="employee_id" class="form-control" required>
                <?php
                while ($row = $employees->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-md-6">
            <label for="check_in">Giờ Vào:</label>
            <input type="datetime-local" name="check_in" id="check_in" class="form-control" required>
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-md-6">
            <label for="check_out">Giờ Ra:</label>
            <input type="datetime-local" name="check_out" id="check_out" class="form-control" required>
        </div>
        <div class="clearfix"></div>
        <div class="btn-group col-md-6" >
            <button type="submit" class="btn btn-primary">Thêm Chấm Công</button>
            <div class="clearfix" style="margin-bottom: 20px;"></div>
            <a href="timekeeping_management.php" class="btn btn-primary">Quay lại</a>
</div>
</div>
<?php include 'header.php'; ?> <!-- Nhúng header.php -->

</body>
</html>

<?php
$conn->close(); // Đóng kết nối
?>
