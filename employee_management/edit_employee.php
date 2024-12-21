<?php
include 'db_connection.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Lấy thông tin nhân viên từ cơ sở dữ liệu
    $sql = "SELECT * FROM employees WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy nhân viên.";
        exit();
    }
} else {
    echo "ID nhân viên không hợp lệ.";
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
</head>
<body>
<?php include 'header.php'; ?>
    <div class="content mt-4">
        <h1>Sửa Nhân Viên</h1>
        <form action="edit_employee_process.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $employee['id']; ?>">
            <div class="form-group col-md-6">
                <label for="name">Họ Tên</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($employee['name']); ?>" required>
            </div>
            <div class="clearfix"></div>
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($employee['email']); ?>" required>
            </div>
            <div class="clearfix"></div>
            <div class="form-group col-md-6">
                <label for="phone">Số Điện Thoại</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($employee['phone']); ?>" required>
            </div>
            <div class="clearfix"></div>
            <div class="form-group col-md-6">
                <label for="position">Chức Vụ</label>
                <input type="text" class="form-control" id="position" name="position" value="<?php echo htmlspecialchars($employee['position']); ?>" required>
            </div>
            <div class="clearfix"></div>
            <div class="form-group col-md-6">
                <label for="salary">Lương</label>
                <input type="number" class="form-control" id="salary" name="salary" value="<?php echo htmlspecialchars($employee['salary']); ?>" step="0.01" required>
            </div>
            <div class="clearfix"></div>
            <div class="form-group col-md-6">
                <label for="gender">Giới tính</label>
                <select class="form-control" id="gender" name="gender" required>
                    <option value="Nam" <?php if ($employee['gender'] == 'Nam') echo 'selected'; ?>>Nam</option>
                    <option value="Nữ" <?php if ($employee['gender'] == 'Nữ') echo 'selected'; ?>>Nữ</option>
                    <option value="Khác" <?php if ($employee['gender'] == 'Khác') echo 'selected'; ?>>Khác</option>
                </select>
            </div>
            <div class="clearfix"></div>
            <div class="form-group col-md-6">
                <label for="birth_date">Ngày sinh</label>
                <input type="date" class="form-control" id="birth_date" name="birth_date" value="<?php echo htmlspecialchars($employee['birth_date']); ?>" required>
            </div>
            <div class="clearfix"></div>
            <button type="submit" class="btn btn-primary">Cập Nhật Nhân Viên</button>
        </form>
        <div class="text-left" style="margin-top: 20px;">
            <a href="dashboard.php" class="btn btn-primary margin-right">Quay lại</a>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
