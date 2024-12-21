<?php
include 'db_connection.php'; // Kết nối cơ sở dữ liệu

session_start();
// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
    exit();
}
// Truy vấn để lấy danh sách chấm công và thông tin nhân viên
$sql = "SELECT t.id, e.id AS employee_id, e.name, t.check_in, t.check_out 
        FROM timekeeping t 
        JOIN employees e ON t.employee_id = e.id";
$result = $conn->query($sql);
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
    <title>Quản Lý Chấm Công</title>
</head>
<body>
<?php include 'header.php'; ?> <!-- Nhúng header.php -->
<div class="content mt-4" style="margin-top: 20px;">
    <h2>Danh Sách Chấm Công</h2>
    <div class="clearfix" style="margin-top: 20px;"></div>
    <!-- Nút thêm chấm công -->
    <a href="add_timekeeping.php" class="btn btn-primary mb-3">Thêm Chấm Công</a>

    <!-- Bảng hiển thị danh sách chấm công -->
    <table class="table table-striped" style="margin-top: 20px;">
        <thead>
            <tr>
                <th>ID Nhân Viên</th>
                <th>Tên Nhân Viên</th>
                <th>Giờ Vào</th>
                <th>Giờ Ra</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['employee_id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo date("Y-m-d H:i:s", strtotime($row['check_in'])); ?></td>
                        <td><?php echo date("Y-m-d H:i:s", strtotime($row['check_out'])); ?></td>
                        <td>
                            <a href="edit_timekeeping.php?id=<?php echo $row['id']; ?>" class="btn btn-success">Sửa</a>
                            <a href="delete_timekeeping.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa chấm công này không?');">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Không có chấm công nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
<?php include 'footer.php'; ?> <!-- Nhúng footer.php -->
</html>

<?php
$conn->close(); // Đóng kết nối
?>
