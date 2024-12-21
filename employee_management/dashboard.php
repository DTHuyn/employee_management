<?php
 // Đảm bảo kết nối được bao gồm
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
    <title>Dashboard Quản lý Nhân viên</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Lato" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <?php include 'header.php'; ?> <!-- Nhúng header.php -->
    <div class="content">
        <?php include 'charts.php'; ?> <!-- Nhúng header.php -->
        <?php
        include 'db_connection.php'; // Đảm bảo kết nối được bao gồm
        // Xử lý tìm kiếm
        $search_query = "";
        if (isset($_POST['search_query'])) {
            $search_query = $_POST['search_query'];
        }
        // Truy vấn để lấy danh sách nhân viên, có thể tìm kiếm theo tên hoặc ID
        $sql = "SELECT * FROM employees WHERE name LIKE ? OR id LIKE ?";
        $stmt = $conn->prepare($sql);
        $search_param = "%" . $search_query . "%";
        $stmt->bind_param("ss", $search_param, $search_param);
        $stmt->execute();
        $result = $stmt->get_result();

        // Tính tổng số nhân viên
        $total_employees = $result->num_rows;
        ?>
        <h2 class="h2">Danh sách Nhân viên</h2>
        <a href="add_employee.php" class="btn btn-primary margin-left">Thêm Nhân viên</a>
        
         <!-- Form tìm kiếm -->
        <form method="POST" class="mb-3">
            <div class="input-group">
                <input type="text" name="search_query" class="form-control" placeholder="Nhập tên hoặc ID" value="<?php echo htmlspecialchars($search_query); ?>">
                <div class="clearfix" style="margin-top: 40px;"></div>
                <button class="btn btn-outline-secondary" type="submit" name="search">Tìm kiếm</button>
            </div>
        </form>

        <div class="table-responsive" style="margin-top: 20px;">
            <table class="table table-striped">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Email</th>
                        <th scope="col">Chức vụ</th>
                        <th scope="col" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='clickable-row' onclick=\"window.location='employee_details.php?id=" . $row['id'] . "';\">";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['position']) . "</td>";
                            echo "<td class='text-center'>";
                            echo "<a href='edit_employee.php?id=" . $row['id'] . "' class='btn btn-sm btn-success mx-1'>Sửa</a>";
                            echo "<a href='delete_employee.php?id=" . $row['id'] . "' onclick='return confirm(\"Bạn có chắc chắn muốn xóa nhân viên này?\");' class='btn btn-sm btn-danger mx-1'>Xóa</a>";
                            echo "<a href='set_salary.php?id=" . $row['id'] . "' class='btn btn-sm btn-primary mx-1'>Tính Lương</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>Không có nhân viên nào.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Hiển thị tổng số nhân viên -->
        <div class="total-employees">
            Tổng số nhân viên: <strong><?php echo $total_employees; ?></strong>
        </div>
    </div>
    
    <?php include 'footer.php'; ?> <!-- Nhúng footer.php -->
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
</body>
</html>

<?php
$stmt->close(); // Đóng câu lệnh
$conn->close(); // Đóng kết nối
?>
