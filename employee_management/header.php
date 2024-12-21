<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">                      
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="dashboard.php">HUYỀN</a>
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
            <button type="submit"><i class="fas fa-user "></i> QL Nhân Viên</button>
        </form>
        <form action="timekeeping_management.php" method="get">
            <button type="submit"><i class="fas fa-calendar-alt "></i> QL Chấm Công</button>
        </form>
        <form action="salary_report.php" method="get">
            <button type="submit"><i class="fas fa-tasks"></i> Báo Cáo Lương</button>
        </form>
        <form action="#" method="get">
            <button type="submit"><i class="fas fa-flag"></i> Giới Thiệu</button>
        </form>
        <form action="#" method="get">
            <button type="submit"><i class="fas fa-cog"></i> Đánh Giá</button>
        </form>
    </div>
    <hr>
    <ul>
        <li><a href="#">Kế hoạch</a></li>
        <li><a href="birthday_calendar.php">Sự kiện</a></li>
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
<div class="chat-form" id="chatForm">
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
