<?php
// Kết nối đến cơ sở dữ liệu
include 'db_connection.php';
session_start();

// Lấy dữ liệu ngày sinh nhật từ cơ sở dữ liệu
$birthdays = [];
$query = "SELECT DATE_FORMAT(birth_date, '%m-%d') AS birth_date, name FROM employees"; // Lấy tháng và ngày
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $birthdays[$row['birth_date']][] = $row['name'];
}

// Lấy thông tin tháng và năm hiện tại
$currentYear = date("Y");
$currentMonth = date("n") - 1; // Lấy tháng hiện tại (0-11)

if (isset($_GET['month']) && isset($_GET['year'])) {
    $currentMonth = intval($_GET['month']);
    $currentYear = intval($_GET['year']);
}

// Mảng chứa tên các tháng bằng tiếng Việt
$monthNames = [
    "Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
    "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
];

// Hàm lấy số ngày trong tháng
function getDaysInMonth($year, $month) {
    return cal_days_in_month(CAL_GREGORIAN, $month + 1, $year);
}

// Hàm lấy ngày bắt đầu của tháng
function getStartDay($year, $month) {
    return date('w', mktime(0, 0, 0, $month + 1, 1, $year));
}

$daysInMonth = getDaysInMonth($currentYear, $currentMonth);
$startDay = getStartDay($currentYear, $currentMonth);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch Sinh Nhật Nhân Viên</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Các kiểu CSS cho giao diện lịch */
        #calendar-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 1px;
        }

        #calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin-bottom: 10px;
            margin-top: 1px;
        }

        #calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            width: 100%;
        }

        .day {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 5px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 90px;
        }

        .day-header {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .birthday {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
            overflow-y: auto;
            font-size: 12px;
        }

        .birthday {
            background: #4c3d9e6d;
            color: #fff;
            padding: 2px 5px;
            border-radius: 3px;
            margin-bottom: 3px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?> <!-- Nhúng header.php -->
    <div class="content" style="margin-top: 20px;">
        <div id="calendar-container">
            <div id="calendar-header">
                <a href="?month=<?php echo ($currentMonth - 1 + 12) % 12; ?>&year=<?php echo $currentMonth == 0 ? $currentYear - 1 : $currentYear; ?>" id="prev-month">Trước</a>
                <h1 id="current-month-year"><?php echo $monthNames[$currentMonth] . " " . $currentYear; ?></h1>
                <a href="?month=<?php echo ($currentMonth + 1) % 12; ?>&year=<?php echo $currentMonth == 11 ? $currentYear + 1 : $currentYear; ?>" id="next-month">Tiếp</a>
            </div>
            <div id="calendar">
                <?php
                // Thêm các ô trống cho những ngày không thuộc tháng này
                for ($i = 0; $i < $startDay; $i++) {
                    echo '<div class="day"></div>';
                }

                // Tạo các ô cho từng ngày trong tháng
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    // Tạo khóa định dạng ngày để kiểm tra sinh nhật (chỉ lấy tháng và ngày)
                    $dateKey = sprintf('%02d-%02d', $currentMonth + 1, $day); // Thay đổi ở đây

                    echo '<div class="day">';
                    echo '<div class="day-header">' . $day . '</div>';

                    // Danh sách sinh nhật
                    echo '<ul class="birthdays">';
                    if (isset($birthdays[$dateKey])) {
                        foreach ($birthdays[$dateKey] as $birthday) {
                            echo '<li class="birthday">Sinh nhật: ' . htmlspecialchars($birthday) . '</li>';
                        }
                    } 
                    echo '</ul>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?> <!-- Nhúng footer.php -->
</body>
</html>
