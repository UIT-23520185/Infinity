<?php
session_start();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php">TalentHub</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
      <ul class="navbar-nav">
        <?php if (isset($_SESSION['username'])): ?>
          <?php if ($_SESSION['vaitro'] == 'Nhà tuyển dụng'): ?>
            <li class="nav-item"><a class="nav-link" href="dang-tin.php">Đăng tin tuyển dụng</a></li>
            <li class="nav-item"><a class="nav-link" href="quan-ly-tin.php">Quản lý tin</a></li>
          <?php elseif ($_SESSION['vaitro'] == 'Ứng viên'): ?>
            <li class="nav-item"><a class="nav-link" href="tim-viec.php">Tìm việc</a></li>
            <li class="nav-item"><a class="nav-link" href="ho-so.php">Hồ sơ của tôi</a></li>
          <?php endif; ?>
          <li class="nav-item"><a class="nav-link" href="lien-he.php">Liên hệ</a></li>
        <?php else: ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="jobsDropdown" role="button" data-bs-toggle="dropdown">
              Tìm việc
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Việc làm theo ngành</a></li>
              <li><a class="dropdown-item" href="#">Việc làm theo khu vực</a></li>
            </ul>
          </li>
          <li class="nav-item"><a class="nav-link" href="gioi-thieu.php">Giới thiệu</a></li>
          <li class="nav-item"><a class="nav-link" href="lien-he.php">Liên hệ</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Cẩm nang nghề nghiệp</a></li>
        <?php endif; ?>
      </ul>

      <ul class="navbar-nav">
        <?php if (isset($_SESSION['username'])): ?>
          <li class="nav-item">
            <a class="btn btn-primary me-2" href="inbox.php">Hộp thư đến</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
              <img src="img/user.png" alt="avatar" class="rounded-circle" width="30" height="30">
              <span class="ms-2"><?php echo htmlspecialchars($_SESSION['hoten']); ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="tai-khoan.php">Thông tin tài khoản</a></li>
              <li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="btn btn-outline-light me-2" href="dang-nhap.php">Đăng nhập</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-primary" href="dang-ky.php">Đăng ký</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-light fw-bold" href="nha-tuyen-dung/trang-chu.html">Dành cho nhà tuyển dụng</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>