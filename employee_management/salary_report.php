<?php
include 'db_connection.php'; // Kết nối cơ sở dữ liệu

session_start();
// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
    exit();
}
// Khởi tạo biến để lưu tháng, năm và phương thức sắp xếp
$month = isset($_POST['month']) ? $_POST['month'] : date('m');
$year = isset($_POST['year']) ? $_POST['year'] : date('Y');
$sort_order = isset($_POST['sort_order']) ? $_POST['sort_order'] : 'date_desc'; // Mặc định sắp xếp theo ngày giảm dần

// Xác định điều kiện sắp xếp
$order_by = '';
if ($sort_order === 'date_asc') {
    $order_by = 's.calculation_date ASC';
} elseif ($sort_order === 'salary_desc') {
    $order_by = 's.total_salary DESC';
} elseif ($sort_order === 'salary_asc') {
    $order_by = 's.total_salary ASC';
} else {
    $order_by = 's.calculation_date DESC'; // Mặc định
}

$sql = " SELECT s.id, e.id AS employee_id, e.name, s.basic_salary, s.allowances, s.total_salary, s.calculation_date,
        IFNULL(SUM(TIMESTAMPDIFF(HOUR, t.check_in, t.check_out)), 0) AS total_hours
        FROM salary s
        JOIN employees e ON s.employee_id = e.id
        LEFT JOIN timekeeping t ON s.employee_id = t.employee_id
        WHERE MONTH(s.calculation_date) = ? AND YEAR(s.calculation_date) = ?
        GROUP BY s.id, e.id, e.name, s.basic_salary, s.allowances, s.total_salary, s.calculation_date
        ORDER BY $order_by";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $month, $year); // Liên kết tháng và năm vào truy vấn
$stmt->execute();
$result = $stmt->get_result();
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
    <title>Bảng Lương Nhân Viên</title>
</head>
<body>
<?php include 'header.php'; ?> <!-- Nhúng footer.php -->
<div class="content mt-4" style="margin-top: 20px;">
    <h2>Bảng Lương Nhân Viên</h2>

    <!-- Form để chọn tháng, năm và phương thức sắp xếp -->
    <form method="post" class="mb-4">
        <div class="form-row col-md-6" style="margin-top: 20px;">
            <div class="col col-md-3">
                <label for="month">Tháng:</label>
                <select name="month" class="form-control" id="month">
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?php echo $m; ?>" <?php echo ($m == $month) ? 'selected' : ''; ?>><?php echo $m; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col col-md-3" >
                <label for="year">Năm:</label>
                <input type="number" name="year" class="form-control" id="year" value="<?php echo $year; ?>" min="2000" max="<?php echo date('Y'); ?>">
            </div>
            <div class="col col-md-6" >
                <label for="sort_order">Sắp xếp theo:</label>
                <select name="sort_order" class="form-control" id="sort_order">
                    <option value="date_desc" <?php echo ($sort_order == 'date_desc') ? 'selected' : ''; ?>>Ngày tính lương (Giảm dần)</option>
                    <option value="date_asc" <?php echo ($sort_order == 'date_asc') ? 'selected' : ''; ?>>Ngày tính lương (Tăng dần)</option>
                    <option value="salary_desc" <?php echo ($sort_order == 'salary_desc') ? 'selected' : ''; ?>>Lương (Cao đến Thấp)</option>
                    <option value="salary_asc" <?php echo ($sort_order == 'salary_asc') ? 'selected' : ''; ?>>Lương (Thấp đến Cao)</option>
                </select>
            </div>
            <div class="clearfix" style="margin-top: 20px;"></div>
            <div class="col align-self-end" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary">Xem Bảng Lương</button>
            </div>
        </div>
    </form>
    <div class="clearfix"></div>               
    <?php if ($result->num_rows > 0): ?>
        <table class="table table-striped" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th>ID Nhân Viên</th>
                    <th>Tên Nhân Viên</th>
                    <th>Lương Cơ Bản</th>
                    <th>Phụ Cấp</th>
                    <th>Số Giờ Làm</th>
                    <th>Tổng Lương</th>
                    <th>Ngày Tính Lương</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['employee_id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo number_format($row['basic_salary'], 0, ',', '.'); ?> VNĐ</td>
                        <td><?php echo number_format($row['allowances'], 0, ',', '.'); ?> VNĐ</td>
                        <td><?php echo number_format($row['total_hours'], 0, ',', '.'); ?> giờ</td> <!-- Hiển thị số giờ làm việc -->
                        <td><?php echo number_format($row['total_salary'], 0, ',', '.'); ?> VNĐ</td>
                        <td><?php echo date("d/m/Y", strtotime($row['calculation_date'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
    <?php else: ?>
        <div class="clearfix" style="margin-top: 20px;"></div>
        <p>Không có dữ liệu bảng lương nào cho tháng <?php echo $month; ?> năm <?php echo $year; ?>.</p>
    <?php endif; ?>
</div>
<?php include 'footer.php'; ?> <!-- Nhúng footer.php -->
</body>
</html>

<?php
$stmt->close(); // Đóng câu lệnh
$conn->close(); // Đóng kết nối
?>
