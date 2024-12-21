<?php
include 'db_connection.php'; // Kết nối cơ sở dữ liệu

session_start();
// Kiểm tra xem có ID không
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Chuyển đổi ID thành số nguyên để bảo mật

    // Lấy thông tin chấm công hiện tại
    $sql = "SELECT t.id, t.employee_id, t.check_in, t.check_out, e.name 
            FROM timekeeping t 
            JOIN employees e ON t.employee_id = e.id 
            WHERE t.id = ?";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Lỗi chuẩn bị câu truy vấn: " . $conn->error;
        exit();
    }

    $stmt->bind_param("i", $id); // Bảo mật với prepared statement
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy chấm công với ID: " . $id; // Thêm thông tin ID vào thông báo
        exit();
    }
} else {
    echo "ID không hợp lệ.";
    exit();
}
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
    <title>Sửa Chấm Công</title>
</head>
<body>
<?php include 'header.php'; ?> <!-- Nhúng header.php -->
<div class="content mt-4">
    <h2>Sửa Chấm Công</h2>
    <form action="edit_timekeeping_process.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
        <div class="form-group col-md-6" >
            <label for="employee_id">Nhân Viên</label>
            <select class="form-control" id="employee_id" name="employee_id" required>
                <option value="<?php echo $row['employee_id']; ?>" selected><?php echo htmlspecialchars($row['name']); ?></option>
                <?php
                // Truy vấn để lấy danh sách nhân viên
                $employee_sql = "SELECT id, name FROM employees";
                $employee_result = $conn->query($employee_sql);
                while ($employee = $employee_result->fetch_assoc()) {
                    if ($employee['id'] != $row['employee_id']) {
                        echo "<option value='{$employee['id']}'>" . htmlspecialchars($employee['name']) . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-md-6" >
            <label for="check_in">Giờ Vào</label>
            <input type="datetime-local" class="form-control" id="check_in" name="check_in" value="<?php echo date("Y-m-d\TH:i", strtotime($row['check_in'])); ?>" required>
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-md-6" >
            <label for="check_out">Giờ Ra</label>
            <input type="datetime-local" class="form-control" id="check_out" name="check_out" value="<?php echo date("Y-m-d\TH:i", strtotime($row['check_out'])); ?>" required>
        </div>
        <div class="clearfix" style="margin-bottom: 20px;"></div>
        <button type="submit" class="btn btn-primary">Cập Nhật Chấm Công</button>
        <div class="clearfix"></div>
        <div class="text-left" style="margin-top: 20px;" >
            <a href="timekeeping_management.php" class="btn btn-primary margin-right" >Quay lại</a>
        </div>
    </form>
</div>
</body>
<?php include 'footer.php'; ?> <!-- Nhúng header.php -->
</html>

<?php
$stmt->close(); // Đóng statement
$conn->close(); // Đóng kết nối
?>
