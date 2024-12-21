<!DOCTYPE html>
<html lang="vi">
<head>
  <title>Quản lý Nhân Viên</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Lato" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="styles.css">
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
      <a class="navbar-brand" href="#myPage">HUYỀN</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li class=""><a href="#about">GIỚI THIỆU</a></li>
        <li class=""><a href="#features">TÍNH NĂNG</a></li>
        <li class=""><a href="#loiich">LỢI ÍCH</a></li>
        <li class=""><a href="#contact">LIÊN HỆ</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
          <li><a href="logout.php" class="btn btn-danger navbar-btn">Logout</a></li>
        <?php else: ?>
          <li><a href="login.php" class="btn btn-danger navbar-btn">Login</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="jumbotron text-center">
  <h1>QUẢN LÝ NHÂN VIÊN</h1> 
  <p>Chào Mừng Đến Với Hệ Thống Quản Lý Nhân Viên.</p> 
</div>

<section id="about" class="about containerr slideanim slide">
    <h2>WEBSTIE:</h2>
    <img src="https://res.cloudinary.com/pragra/image/upload/v1596224595/pragraweb/corporate.png" alt="About Image">
    <p>Website quản lý nhân viên là công cụ hữu ích giúp doanh nghiệp tổ chức và theo dõi các thông tin liên quan đến nhân viên 
      một cách hiệu quả và chính xác. Với hệ thống này, người quản lý có thể dễ dàng quản lý thông tin cá nhân của nhân viên, chấm công, 
      tính lương, và theo dõi hiệu suất làm việc. Ngoài ra, website còn giúp giảm thiểu các sai sót khi nhập liệu thủ công, tiết kiệm thời 
      gian và tăng năng suất công việc.</p>
    <hr>
    <img src="https://www.bizmanualz.com/wp-content/uploads/2013/02/grow-your-business.jpg" alt="About Image">
    <p>Bên cạnh đó, hệ thống quản lý nhân viên trực tuyến còn cho phép truy cập dữ liệu từ bất kỳ đâu, miễn là có kết nối internet, 
      giúp nhà quản lý dễ dàng giám sát và điều hành từ xa. Các nhân viên cũng có thể tự cập nhật thông tin cá nhân, xem bảng lương, 
      và kiểm tra giờ làm việc của mình, tạo nên sự minh bạch và rõ ràng trong tổ chức.</p>
    <hr>
    <img src="https://i.pinimg.com/564x/b0/37/30/b037305bf02e5c7e2c288de059ce3f8b.jpg" alt="About Image">
    <p>Hệ thống báo cáo chi tiết cung cấp thông tin về các khía cạnh quan trọng trong quản lý nhân sự như chấm công, lương thưởng, 
      hiệu suất làm việc, và tiến độ hoàn thành công việc. Với tính năng này, nhà quản lý có thể dễ dàng theo dõi và phân tích dữ liệu, 
      từ đó đưa ra các quyết định chiến lược về nhân sự dựa trên những thông tin chính xác và kịp thời.</p>
</section>

<section id="features" class="containerr slideanim slide">
  <h2>TÍNH NĂNG</h2>
  <div class="features">
    <div class="feature">
      <h3>Quản lý nhân viên hiệu quả</h3>
      <p>Hệ thống quản lý nhân viên cung cấp công cụ để theo dõi thông tin cá nhân, chấm công, tính lương,
         quản lý hiệu suất làm việc, và tổ chức đào tạo, nhằm nâng cao hiệu quả quản lý.</p>
    </div>
    <div class="feature">
      <h3>Tích hợp chấm công</h3>
      <p>Tích hợp chấm công trong hệ thống quản lý nhân viên cho phép ghi nhận giờ vào, giờ ra tự động,
         giúp theo dõi chính xác thời gian làm việc và tăng cường hiệu quả quản lý.</p>
    </div>
    <div class="feature">
      <h3>Quản lý nhân sự và công việc</h3>
      <p>Quản lý nhân sự và công việc trong hệ thống giúp theo dõi thông tin nhân viên, phân công nhiệm vụ, giám sát tiến độ công việc, 
        và đánh giá hiệu suất làm việc hiệu quả hơn.</p>
    </div>
    <div class="feature">
      <h3>Báo cáo và phân tích chi tiết</h3>
      <p>Báo cáo và phân tích chi tiết trong hệ thống quản lý nhân viên cung cấp thông tin về hiệu suất làm việc,
         chấm công, lương thưởng, giúp quản lý đưa ra quyết định chính xác và kịp thời.</p>
    </div>
  </div>
</section>
<div class="clearfix" style="margin-top: 40px;"></div>

<section id="loiich" class="contentt slideanim slide">
  <div class="text-start ">
    <h2>LỢI ÍCH CỦA HỆ THỐNG QUẢN LÝ NHÂN VIÊN</h2>
    <p>
      Hệ thống quản lý nhân viên giúp tối ưu hóa quy trình làm việc, tăng cường hiệu quả trong việc quản lý thông tin nhân viên, thời gian làm việc và tiến độ công việc.
    </p>
    <ul>
      <li><strong>Tiết kiệm thời gian:</strong> Giúp giảm thiểu thời gian xử lý thông tin và giấy tờ, cho phép nhân viên tập trung vào công việc quan trọng hơn.</li>
      <li><strong>Tăng cường khả năng theo dõi:</strong> Dễ dàng theo dõi và báo cáo về hiệu suất làm việc của nhân viên, từ đó đưa ra quyết định hợp lý về tuyển dụng và thăng tiến.</li>
      <li><strong>Nâng cao sự hài lòng của nhân viên:</strong> Cung cấp cho nhân viên công cụ và tài nguyên cần thiết để họ có thể làm việc hiệu quả hơn, từ đó tăng cường sự hài lòng và giữ chân nhân tài.</li>
      <li><strong>Quản lý tài chính hiệu quả:</strong> Theo dõi lương bổng, phúc lợi và các khoản chi phí liên quan đến nhân viên một cách chính xác và hiệu quả.</li>
    </ul>
  </div>
  <div class="chart-containerr">
    <img src="https://hocvienagile.com/wp-content/uploads/2022/08/quan-tri-nhan-su-thuc-hien-nhung-nhiem-vu-chu-chot-trong-doanh-nghiep.jpg" alt="Biểu đồ minh họa lợi ích hệ thống quản lý nhân viên" style="max-width: 300px; height: auto; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
  </div>
</section>
<div class="clearfix" style="margin-top: 40px;"></div>

<div id="contact" class="container-fluid bg-grey">
  <h2 class="text-center">LIÊN HỆ</h2>
  <div class="row">
    <div class="col-sm-5 slideanim slide">
      <p>Hãy liên hệ với chúng tôi và chúng tôi sẽ liên hệ lại với bạn trong vòng 24 giờ.</p>
      <p><span class="glyphicon glyphicon-map-marker"></span> Hà Đông, Hà Nội</p>
      <p><span class="glyphicon glyphicon-phone"></span> +00 1515151515</p>
      <p><span class="glyphicon glyphicon-envelope"></span> dhuyen632@gmail.com</p>
    </div>
    <div class="col-sm-7 slideanim slide">
      <div class="row">
        <div class="col-sm-6 form-group">
          <input class="form-control" id="name" name="name" placeholder="Tên" type="text" required="">
        </div>
        <div class="col-sm-6 form-group">
          <input class="form-control" id="email" name="email" placeholder="Email" type="email" required="">
        </div>
      </div>
      <textarea class="form-control" id="comments" name="comments" placeholder="Tin nhắn" rows="5"></textarea><br>
      <div class="row">
        <div class="col-sm-12 form-group">
          <button class="btn btn-default pull-right" type="submit">Gửi</button>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Bong bóng chat Messenger -->
<div class="chat-bubble" onclick="toggleChatForm();">
  <i class="fa-brands fa-facebook-messenger"></i> <!-- Icon Messenger -->
</div>

<!-- Bong bóng chat điện thoại -->
<div class="phone-chat-bubble" onclick="makeCall();">
  <i class="fas fa-phone-alt"></i> <!-- Icon điện thoại -->
</div>

<!-- Chat form -->
<div class="chat-form" id="chatForm">
  <h4>Nhắn Tin</h4>
  <form action="" method="POST">
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
<iframe 
  class="embed-responsive-item" 
  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3725.2924013038964!2d105.78484157509168!3d20.98091298065657!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135accdd8a1ad71%3A0xa2f9b16036648187!2zSOG7jWMgdmnhu4duIEPDtG5nIG5naOG7hyBCxrB1IGNow61uaCB2aeG7hW4gdGjDtG5n!5e0!3m2!1svi!2s!4v1733409526296!5m2!1svi!2s"
     width="1600" height="550" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</iframe>
<footer class="container-fluid text-center footer">
  <p>© 11/2024. Bản quyền của em Thầy ơi!!.</p>
</footer>

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
