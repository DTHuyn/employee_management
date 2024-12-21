<?php
// Kết nối tới cơ sở dữ liệu
include 'db_connection.php'; // Bao gồm tệp kết nối

// Truy vấn tổng số nhân viên
$totalSql = "SELECT COUNT(*) AS total_count FROM employees";
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$total_count = $totalRow['total_count'];

// Truy vấn số lượng nhân viên theo giới tính
$genderSql = "SELECT gender, COUNT(*) AS total FROM employees GROUP BY gender";
$genderResult = $conn->query($genderSql);

// Khởi tạo mảng để lưu trữ số liệu cho biểu đồ giới tính
$genderData = [];

if ($genderResult->num_rows > 0) {
    while ($row = $genderResult->fetch_assoc()) {
        $genderData[$row['gender']] = $row['total'];
    }
}

// Truy vấn số lượng nhân viên theo độ tuổi
$sql = "SELECT 
            COUNT(*) AS total, 
            CASE 
                WHEN DATE_FORMAT(FROM_DAYS(DATEDIFF(CURDATE(), birth_date)), '%Y') + 0 <= 25 THEN '<=25'
                WHEN DATE_FORMAT(FROM_DAYS(DATEDIFF(CURDATE(), birth_date)), '%Y') + 0 BETWEEN 26 AND 35 THEN '26-35'
                WHEN DATE_FORMAT(FROM_DAYS(DATEDIFF(CURDATE(), birth_date)), '%Y') + 0 BETWEEN 36 AND 45 THEN '36-45'
                WHEN DATE_FORMAT(FROM_DAYS(DATEDIFF(CURDATE(), birth_date)), '%Y') + 0 BETWEEN 46 AND 55 THEN '46-55'
                ELSE 'Khác'
            END AS age_group
        FROM employees
        GROUP BY age_group
        HAVING age_group != 'Khác'"; // Chỉ lấy các nhóm tuổi đã định nghĩa

$result = $conn->query($sql);

// Khởi tạo mảng để lưu trữ số liệu cho biểu đồ độ tuổi
$age_groups = [];
$percentages = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $age_groups[] = $row['age_group'];
        $percentages[] = ($row['total'] / $total_count) * 100; // Tính phần trăm so với tổng số nhân viên
    }
}

// Kiểm tra nếu không có nhân viên nào
if ($total_count === 0) {
    $age_groups = ['Không có nhân viên'];
    $percentages = [0]; // Không có phần trăm
}

// Đóng kết nối
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biểu Đồ Nhân Viên</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            display: flex; /* Hiển thị các biểu đồ trong cùng một hàng */
            justify-content: space-around; /* Khoảng cách đều giữa các biểu đồ */
        }
        .chart {
            width: 300px; /* Chiều rộng của biểu đồ giới tính */
            height: 300px; /* Chiều cao của biểu đồ giới tính */
        }
        .chart.age {
            width: 600px; /* Chiều rộng của biểu đồ độ tuổi */
            height: 300px; /* Chiều cao của biểu đồ độ tuổi */
        }
    </style>
</head>
<body>

<div class="chart-container">
    <div class="chart">
        <canvas id="genderChart"></canvas> <!-- Biểu đồ giới tính -->
    </div>
    <div class="chart age">
        <canvas id="ageChart"></canvas> <!-- Biểu đồ độ tuổi -->
    </div>
</div>

<script>
// Biểu Đồ Doughnut Giới Tính
const genderData = <?php echo json_encode($genderData); ?>; // Dữ liệu giới tính từ cơ sở dữ liệu

// Kiểm tra và thông báo nếu không có dữ liệu giới tính
if (Object.keys(genderData).length === 0) {
    alert('Không có dữ liệu giới tính để hiển thị.');
    document.getElementById('genderChart').style.display = 'none'; // Ẩn biểu đồ giới tính
} else {
    const ctx1 = document.getElementById('genderChart').getContext('2d');

    new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: Object.keys(genderData),
            datasets: [{
                data: Object.values(genderData),
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
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
}

// Biểu Đồ Cột Độ Tuổi
const ctx2 = document.getElementById('ageChart').getContext('2d');
const ageChart = new Chart(ctx2, {
    type: 'bar', // Loại biểu đồ cột dọc
    data: {
        labels: <?php echo json_encode($age_groups); ?>,
        datasets: [{
            label: 'Phần trăm nhân viên (%)',
            data: <?php echo json_encode($percentages); ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            x: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Nhóm tuổi'
                }
            },
            y: {
                beginAtZero: true,
                max: 100,
                title: {
                    display: true,
                    text: 'Phần trăm (%)'
                }
            }
        },
        plugins: {
            title: {
                display: true,
                text: 'Tỷ lệ Tuổi Nhân viên'
            }
        }
    }
});

// Kiểm tra và thông báo nếu không có dữ liệu độ tuổi
if (ageChart.data.labels.length === 0) {
    alert('Không có dữ liệu độ tuổi để hiển thị.');
    document.getElementById('ageChart').style.display = 'none'; // Ẩn biểu đồ độ tuổi
}
</script>

</body>
</html>
