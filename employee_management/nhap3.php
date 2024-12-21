<?php
// Bước 1: Kết nối tới cơ sở dữ liệu
include 'db_connection.php'; // Bao gồm tệp kết nối

// Bước 2: Truy vấn tổng số nhân viên
$totalSql = "SELECT COUNT(*) AS total_count FROM employees";
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$total_count = $totalRow['total_count'];

// Bước 3: Truy vấn số lượng nhân viên theo độ tuổi
$sql = "SELECT 
            COUNT(*) AS total, 
            CASE 
                WHEN YEAR(CURDATE()) - birth_year <= 25 THEN '<=25'
                WHEN YEAR(CURDATE()) - birth_year BETWEEN 26 AND 35 THEN '26-35'
                WHEN YEAR(CURDATE()) - birth_year BETWEEN 36 AND 45 THEN '36-45'
                WHEN YEAR(CURDATE()) - birth_year BETWEEN 46 AND 55 THEN '46-55'
                ELSE 'Khác'
            END AS age_group
        FROM employees
        GROUP BY age_group
        HAVING age_group != 'Khác'"; // Chỉ lấy các nhóm tuổi đã định nghĩa

$result = $conn->query($sql);

// Khởi tạo mảng để lưu trữ số liệu cho biểu đồ
$age_groups = [];
$percentages = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $age_groups[] = $row['age_group'];
        $percentages[] = ($row['total'] / $total_count) * 100; // Tính phần trăm so với tổng số nhân viên
    }
}

// Đóng kết nối
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biểu Đồ Tuổi Nhân Viên</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        canvas {
            max-width: 50%; /* Đảm bảo chiều rộng tối đa của canvas là 100% */
            height: auto; /* Chiều cao tự động */
        }
    </style>
</head>
<body>

<canvas id="ageChart" width="200" height="50"></canvas>

<script>
    const ctx = document.getElementById('ageChart').getContext('2d');
    const ageChart = new Chart(ctx, {
        type: 'bar', // Loại biểu đồ cột dọc
        data: {
            labels: <?php echo json_encode($age_groups); ?>,
            datasets: [{
                label: 'Phần trăm nhân viên (%)',
                data: <?php echo json_encode($percentages); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)', // Màu cho nhóm <=25
                    'rgba(54, 162, 235, 0.2)', // Màu cho nhóm 26-35
                    'rgba(255, 206, 86, 0.2)', // Màu cho nhóm 36-45
                    'rgba(75, 192, 192, 0.2)'  // Màu cho nhóm 46-55
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)', // Màu viền cho nhóm <=25
                    'rgba(54, 162, 235, 1)', // Màu viền cho nhóm 26-35
                    'rgba(255, 206, 86, 1)', // Màu viền cho nhóm 36-45
                    'rgba(75, 192, 192, 1)'  // Màu viền cho nhóm 46-55
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: { // Trục x
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Nhóm tuổi'
                    }
                },
                y: { // Trục y
                    beginAtZero: true,
                    max: 100, // Đặt giá trị tối đa cho trục y là 100
                    title: {
                        display: true,
                        text: 'Phần trăm (%)'
                    }
                }
            }
        }
    });
</script>

</body>
</html>
