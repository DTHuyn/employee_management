<?php
include 'db_connection.php'; // Kết nối cơ sở dữ liệu
session_start();
// Lấy ID nhân viên từ tham số URL
$employee_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Kiểm tra xem ID có hợp lệ không
if ($employee_id <= 0) {
    die("ID nhân viên không hợp lệ.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Nhận dữ liệu từ form
    $basic_salary = floatval($_POST['basic_salary']);
    $allowances = floatval($_POST['allowances']);

    // Tính lương
    $sql = "SELECT SUM(TIMESTAMPDIFF(HOUR, check_in, check_out)) AS total_hours
            FROM timekeeping
            WHERE employee_id = $employee_id
            GROUP BY employee_id";

    $result = $conn->query($sql);
    $total_hours = 0;

    if ($result && $row = $result->fetch_assoc()) {
        $total_hours = $row['total_hours'];
    }

    // Tính tổng lương
    $total_salary = ($basic_salary * $total_hours) + $allowances;

    // Lưu vào bảng salary
    $insert_sql = "INSERT INTO salary (employee_id, basic_salary, allowances, total_salary, calculation_date) 
                   VALUES ($employee_id, $basic_salary, $allowances, $total_salary, NOW())";

    if ($conn->query($insert_sql) === TRUE) {
        // Chuyển hướng đến báo cáo lương
        header("Location: salary_report.php");
        exit;
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật Lương cho Nhân viên</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Lato" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?> <!-- Nhúng header.php -->
    <div class="content my-5" style="margin-top: 20px;">
        <h1 class="text mb-4" >Cập nhật Lương cho Nhân viên</h1>
        <form method="post">
            <div class="mb-3 col-md-6" style="margin-top: 20px;">
                <label for="basic_salary" class="form-label">Lương cơ bản (VNĐ)</label>
                <input type="number" step="1000" name="basic_salary" id="basic_salary" class="form-control" required>
            </div>
            <div class="clearfix"></div>
            <div class="mb-3 col-md-6" style="margin-bottom: 20px;">
                <label for="allowances" class="form-label">Phụ cấp (VNĐ)</label>
                <input type="number" step="1000" name="allowances" id="allowances" class="form-control" required>
            </div>
            <div class="clearfix"></div>
            <button type="submit" class="btn btn-primary">Tính Lương</button>
        </form>
        <div class="text-left" style="margin-top: 20px;" >
            <a href="dashboard.php" class="btn btn-primary margin-right" >Quay lại</a>
        </div>
    </div>
    
    <?php include 'footer.php'; ?> <!-- Nhúng header.php -->
</body>
</html>
