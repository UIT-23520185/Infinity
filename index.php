<?php
include 'includes/header.php';

$daDangNhap = isset($_SESSION['username']);
if ($daDangNhap) {
    $hoten = $_SESSION['hoten'];
    $vaitro = $_SESSION['vaitro'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Trang chủ</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>
    .carousel-item img {
      width: 100%;
      height: auto;
      max-height: 400px;
      object-fit: contain;
    }
    footer {
      background-color: #2f3640;
      color: white;
      padding: 40px 20px;
    }
    .social-icons i {
      font-size: 1.5rem;
      margin-right: 10px;
    }
    .carousel {
      position: relative;
    }
    .carousel-control-prev,
    .carousel-control-next {
      z-index: 10;
      top: 50%;
      transform: translateY(-50%);
      width: 50px;
      height: 50px;
    }
    .custom-icon {
      background-color: rgba(0, 0, 0, 0.5);
      border-radius: 50%;
      padding: 10px;
    }
    .carousel-inner img {
      max-height: 400px;
      object-fit: cover;
    }
  </style>
</head>
<body>

<div style="background-color: #e5f3c7;" class="p-3 mb-2">

  <div class="container mb-3">
    <?php if ($daDangNhap): ?>
      <div class="alert alert-success text-center">
        Xin chào <strong><?php echo htmlspecialchars($hoten); ?></strong>!
        Bạn đang đăng nhập với vai trò <strong><?php echo htmlspecialchars($vaitro); ?></strong>.
      </div>
    <?php else: ?>
      <div class="alert alert-warning text-center">
        Bạn chưa đăng nhập. <a href="dang-nhap.php" class="alert-link">Đăng nhập ngay</a> để sử dụng đầy đủ chức năng!
      </div>
    <?php endif; ?>
  </div>

  <div class="text-center py-2 text-dark">
    <strong>Tìm việc làm nhanh 24h, việc làm mới nhất trên toàn quốc</strong><br>
    Tiếp cận 40,000+ tin tuyển dụng việc làm mới mỗi ngày từ hàng nghìn doanh nghiệp uy tín tại Việt Nam
  </div>

  <div class="container mb-4 position-relative">
    <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner rounded">
        <div class="carousel-item active text-center">
          <img src="img/anh1.png" class="d-block w-100" alt="Ảnh 1">
        </div>
        <div class="carousel-item text-center">
          <img src="img/anh2.png" class="d-block w-100" alt="Ảnh 2">
        </div>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon custom-icon" aria-hidden="true"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon custom-icon" aria-hidden="true"></span>
      </button>
    </div>
  </div>
</div>

<div class="text-center mb-5">
  <?php if ($daDangNhap): ?>
    <?php if ($vaitro == 'Ứng viên'): ?>
      <a class="btn btn-primary px-4 py-2 me-3" href="tim-viec.php">Tìm việc ngay</a>
    <?php elseif ($vaitro == 'Nhà tuyển dụng'): ?>
      <a class="btn btn-primary px-4 py-2 me-3" href="dang-tin.php">Đăng tin tuyển dụng</a>
    <?php endif; ?>
    <a class="btn btn-secondary px-4 py-2" href="logout.php">Đăng xuất</a>
  <?php else: ?>
    <a class="btn btn-primary px-4 py-2" href="dang-nhap.php">Đăng nhập để bắt đầu</a>
  <?php endif; ?>
</div>

<?php include 'includes/footer.html'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>