<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <title>Quản lý Nhân Viên</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Lato" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="styles.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body id="myPage">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">                      
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#myPage">EMS</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <?php if (isset($_SESSION['user_id'])): ?>
          <li><a href="logout.php" class="btn btn-danger navbar-btn">Logout</a></li>
        <?php else: ?>
          <li><a href="login.php" class="btn btn-danger navbar-btn">Login</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="sidebar">
    <div class="sidebar-buttons">
        <form action="dashboard.php" method="get">
            <button type="submit"><i class="fas fa-tasks"></i> QL Nhân Viên</button>
        </form>
        <form action="timekeeping_management.php" method="get">
            <button type="submit"><i class="fas fa-cog"></i> QL Chấm Công</button>
        </form>
        <form action="salary_report.php" method="get">
            <button type="submit"><i class="fas fa-user"></i> Báo Cáo Lương</button>
        </form>
        <form action="#" method="get">
            <button type="submit"><i class="fas fa-flag"></i> Giới Thiệu</button>
        </form>
        <form action="#" method="get">
            <button type="submit"><i class="fas fa-calendar-alt"></i> Đánh Giá</button>
        </form>
    </div>
    <hr>
    <ul>
        <li><a href="#">Kế hoạch</a></li>
        <li><a href="#">Sự kiện</a></li>
        <li><a href="#">Khác</a></li>
    </ul>
    <hr>
</div>

<!-- Bong bóng chat Messenger -->
<div class="chat-bubble" onclick="toggleChatForm();">
  <i class="fab fa-facebook-messenger"></i> <!-- Icon Messenger -->
</div>

<!-- Bong bóng chat điện thoại -->
<div class="phone-chat-bubble" onclick="makeCall();">
  <i class="fas fa-phone-alt"></i> <!-- Icon điện thoại -->
</div>

<!-- Chat form -->
<div class="chat-form" id="chatForm" style="display:none;">
  <h4>Nhắn Tin</h4>
  <form action="send_message.php" method="POST">
    <div class="form-group">
      <label for="name">Tên của bạn:</label>
      <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="form-group">
      <label for="message">Tin nhắn:</label>
      <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Gửi</button>
    <button type="button" class="btn btn-default" onclick="toggleChatForm();">Đóng</button>
  </form>
</div>

<!-- Optional JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
  function toggleChatForm() {
    $('#chatForm').toggle(); // Bật/tắt hiển thị form chat
  }
</script>

</body>
</html>
