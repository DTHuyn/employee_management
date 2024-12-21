<?php
include 'db_connection.php'; // Kết nối cơ sở dữ liệu

session_start();

// Lấy ID nhân viên từ URL
$employee_id = $_GET['id'];

// Truy vấn để lấy thông tin nhân viên
$sql = "SELECT * FROM employees WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $employee = $result->fetch_assoc();
} else {
    echo "Không tìm thấy nhân viên.";
    exit;
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông Tin Chi Tiết Nhân Viên</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Lato" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?> <!-- Nhúng header.php -->
    <div class="content my-5">
        <h1 class="text-center mb-4">Thông Tin Chi Tiết Nhân Viên</h1>
        
        <table class="table table-bordered custom-table">
            <tr>
                <th>ID</th>
                <td><?php echo $employee['id']; ?></td>
            </tr>
            <tr>
                <th>Tên</th>
                <td><?php echo $employee['name']; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $employee['email']; ?></td>
            </tr>
            <tr>
                <th>Chức vụ</th>
                <td><?php echo $employee['position']; ?></td>
            </tr>
            <tr>
                <th>Số Điện Thoại</th>
                <td><?php echo $employee['phone']; ?></td>
            </tr>
            <tr>
                <th>Giới tính</th>
                <td><?php echo $employee['gender']; ?></td>
            </tr>
            <tr>
                <th>Ngày tháng năm sinh</th>
                <td><?php echo date('d/m/Y', strtotime($employee['birth_date'])); ?></td>
            </tr>
            <!-- Thêm các trường thông tin khác nếu cần -->
        </table>

        <div class="text-left" style="margin-top: 20px;" >
            <a href="dashboard.php" class="btn btn-primary margin-right" >Quay lại</a>
            <a href="edit_employee.php?id=<?php echo $employee['id']; ?>" class="btn btn-success">Sửa</a>
            <a href="delete_employee.php?id=<?php echo $employee['id']; ?>" 
               onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?');" class="btn btn-danger">Xóa</a>
            <a href="set_salary.php?id=<?php echo $employee['id']; ?>" class="btn btn-primary">Tính Lương</a>
        </div>
    </div>
    <?php include 'footer.php'; ?> <!-- Nhúng header.php -->
</body>
</html>

<?php
$conn->close(); // Đóng kết nối
?>
