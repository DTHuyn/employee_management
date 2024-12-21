<?php
include 'db_connection.php'; // Kết nối đến cơ sở dữ liệu

// Truy vấn số lượng nhân viên theo giới tính
$sql = "SELECT gender, COUNT(*) as count FROM employees GROUP BY gender";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[$row['gender']] = $row['count'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Biểu đồ Doughnut Giới Tính Nhân Viên</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php include 'header.php'; ?> <!-- Nhúng header.php -->

<div class="container my-5">


    <!-- Đặt kích thước canvas -->
    <div class="chart-container" style="width: 20%; margin: auto; margin-top: 20px;">
        <canvas id="genderChart"></canvas>
    </div>
</div>

<script>
const genderData = <?php echo json_encode($data); ?>;
const ctx = document.getElementById('genderChart').getContext('2d');

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: Object.keys(genderData),
        datasets: [{
            data: Object.values(genderData),
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)', // Màu cho 'Nam'
                'rgba(255, 99, 132, 0.2)', // Màu cho 'Nữ'
                'rgba(255, 206, 86, 0.2)', // Màu cho 'Khác'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Tỷ lệ Giới tính Nhân viên'
            }
        }
    }
});
</script>
<?php include 'footer.php'; ?> <!-- Nhúng header.php -->

</body>
</html>
