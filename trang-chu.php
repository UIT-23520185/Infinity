<?php
include 'includes/header.php';

if (!isset($_SESSION['username'])) {
    header("Location: dang-nhap.php");
    exit();
}

$hoten = $_SESSION['hoten'];
$vaitro = $_SESSION['vaitro'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
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

  <!-- Chào mừng -->
  <div class="container mb-3">
    <div class="alert alert-success text-center">
      Xin chào <strong><?php echo htmlspecialchars($hoten); ?></strong>! 
      Bạn đang đăng nhập với vai trò <strong><?php echo htmlspecialchars($vaitro); ?></strong>.
    </div>
  </div>

  <!-- Banner text -->
  <div class="text-center py-2 text-dark">
    <strong>Tìm việc làm nhanh 24h, việc làm mới nhất trên toàn quốc</strong><br>
    Tiếp cận 40,000+ tin tuyển dụng việc làm mới mỗi ngày từ hàng nghìn doanh nghiệp uy tín tại Việt Nam
  </div>

  <!-- Banner carousel -->
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

      <!-- Nút điều hướng -->
      <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon custom-icon" aria-hidden="true"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon custom-icon" aria-hidden="true"></span>
      </button>
    </div>
  </div>
</div>

<!-- Nút hành động -->
<div class="text-center mb-5">
    <a class="btn btn-primary px-4 py-2 me-3" href="tim-viec.php">Tìm việc ngay</a>
  <a class="btn btn-secondary px-4 py-2" href="logout.php">Đăng xuất</a>
</div>

<?php include 'includes/footer.html'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
