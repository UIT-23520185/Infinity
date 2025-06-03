<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Hộp thư đến - TalentHub</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background-color: #f2f2f2;
    }

    header {
      background-color: #2d2d2d;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 12px 20px;
    }

    header .logo {
      font-weight: bold;
      font-size: 20px;
    }

    nav a {
      color: white;
      margin: 0 10px;
      text-decoration: none;
      font-size: 14px;
    }

    .inbox-button {
      background-color: #1e90ff;
      color: white;
      padding: 8px 16px;
      border: none;
      border-radius: 6px;
      font-size: 14px;
      margin-left: auto;
      margin-right: 10px;
    }

    .profile-icon {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background-color: #ddd;
    }

    .main-container {
      padding: 20px;
    }

    h2 {
      margin-bottom: 20px;
    }

    .mail {
      background-color: #e0f2bd;
      border-radius: 12px;
      padding: 10px 20px;
      margin-bottom: 15px;
      position: relative;
    }

    .mail strong {
      display: block;
    }

    .mail .time {
      font-size: 13px;
      color: #666;
      margin-top: 5px;
    }

    .mail a {
      color: #0077cc;
      font-size: 13px;
      text-decoration: none;
    }

    .mail-buttons {
      position: absolute;
      top: 10px;
      right: 10px;
    }

    .mail-buttons button {
      margin-left: 8px;
      padding: 5px 10px;
      border: none;
      border-radius: 6px;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }

    .archive-btn {
      background-color: #1e90ff;
    }

    .delete-btn {
      background-color: #cc0000;
    }

    .see-more {
      display: block;
      text-align: center;
      margin: 25px 0;
    }

    .see-more button {
      padding: 8px 20px;
      font-size: 14px;
      border-radius: 10px;
      border: none;
      background-color: #ddd;
      cursor: pointer;
    }

    footer {
      background-color: #2d2d2d;
      color: white;
      padding: 20px;
      font-size: 13px;
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
    }

    footer div {
      margin: 10px 0;
      max-width: 250px;
    }

    footer a {
      color: white;
      text-decoration: none;
      display: block;
      margin: 5px 0;
    }

    .social-icons img {
      width: 24px;
      margin-right: 8px;
    }

    .copyright {
      text-align: center;
      width: 100%;
      margin-top: 10px;
      font-size: 12px;
    }
  </style>
</head>
<body>

  <header>
    <div class="logo">TalentHub</div>
    <nav>
      <a href="#">Tìm việc</a>
      <a href="#">Giới thiệu</a>
      <a href="#">Liên hệ</a>
      <a href="#">Cẩm nang nghề nghiệp</a>
    </nav>
    <button class="inbox-button">Hộp thư đến</button>
    <div class="profile-icon"></div>
  </header>

  <div class="main-container">
    <h2>Hộp thư đến</h2>

    <div class="mail">
      <strong>Người gửi:</strong> Hệ thống<br>
      <strong>Tiêu đề:</strong> Đăng ký tài khoản doanh nghiệp thành công<br>
      <strong>Nội dung:</strong> Chúc mừng bạn đã đăng ký tài khoản doanh nghiệp thành công...
      <div class="time">16:40 - <a href="#">Đọc thư</a></div>
      <div class="mail-buttons">
        <button class="archive-btn">Lưu trữ</button>
        <button class="delete-btn">Xóa</button>
      </div>
    </div>

    <div class="mail">
      <strong>Người gửi:</strong> Công ty ABC<br>
      <strong>Tiêu đề:</strong> Lịch phỏng vấn<br>
      <strong>Nội dung:</strong> Cập nhật lịch phỏng vấn...
      <div class="time">16:40 - <a href="#">Đọc thư</a></div>
      <div class="mail-buttons">
        <button class="archive-btn">Lưu trữ</button>
        <button class="delete-btn">Xóa</button>
      </div>
    </div>

    <div class="mail">
      <strong>Người gửi:</strong> Công ty A<br>
      <strong>Tiêu đề:</strong> Kết quả bài test<br>
      <strong>Nội dung:</strong> Sau đây là kết quả bài test của bạn ...
      <div class="time">16:40 - <a href="#">Đọc thư</a></div>
      <div class="mail-buttons">
        <button class="archive-btn">Lưu trữ</button>
        <button class="delete-btn">Xóa</button>
      </div>
    </div>

    <div class="mail">
      <strong>Người gửi:</strong> Công ty B<br>
      <strong>Tiêu đề:</strong> Kết quả bài test<br>
      <strong>Nội dung:</strong> Sau đây là kết quả bài test của bạn ...
      <div class="time">16:40 - <a href="#">Đọc thư</a></div>
      <div class="mail-buttons">
        <button class="archive-btn">Lưu trữ</button>
        <button class="delete-btn">Xóa</button>
      </div>
    </div>

    <div class="mail">
      <strong>Người gửi:</strong> Công ty C<br>
      <strong>Tiêu đề:</strong> Kết quả bài test<br>
      <strong>Nội dung:</strong> Sau đây là kết quả bài test của bạn ...
      <div class="time">16:40 - <a href="#">Đọc thư</a></div>
      <div class="mail-buttons">
        <button class="archive-btn">Lưu trữ</button>
        <button class="delete-btn">Xóa</button>
      </div>
    </div>

    <div class="see-more">
      <button>Xem thêm</button>
    </div>
  </div>

  <footer>
    <div>
      <strong>Công ty tư vấn hỗ trợ việc làm TalentHub</strong><br><br>
      Giấy có phép đăng ký kinh doanh số: 1234567890<br>
      Giấy phép hoạt động dịch vụ việc làm số: 0123456789<br>
      Địa chỉ: Phường Linh Trung, Thành phố Thủ Đức, Thành phố Hồ Chí Minh, Việt Nam
    </div>

    <div>
      <strong>Thông tin</strong><br>
      <a href="#">Giới thiệu</a>
      <a href="#">Liên hệ</a>
      <a href="#">Thỏa thuận sử dụng</a>
      <a href="#">Quy định bảo mật</a>
      <a href="#">Sơ đồ Website</a>
    </div>

    <div class="social-icons">
      <strong>Kết nối với chúng tôi</strong><br><br>
      <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="FB">
      <img src="https://cdn-icons-png.flaticon.com/512/733/733579.png" alt="IG">
      <img src="https://cdn-icons-png.flaticon.com/512/1384/1384060.png" alt="YouTube">
      <img src="https://cdn-icons-png.flaticon.com/512/2504/2504947.png" alt="TikTok">
      <img src="https://cdn-icons-png.flaticon.com/512/2111/2111710.png" alt="Zalo">
    </div>

    <div class="copyright">
      © 5/2025 - Team Infinity Tech
    </div>
  </footer>

</body>
</html>
