<?php
include 'includes/dbconnection.php';
include 'includes/header.php';

if (!isset($_SESSION['username'])) {
    header('Location: dang-nhap.php');
    exit;
}

$matk = $_SESSION['matk'];

// Lấy mã ứng viên
$sql_uv = "SELECT MAUV FROM UNGVIEN WHERE MATK = ?";
$stmt_uv = $conn->prepare($sql_uv);
$stmt_uv->execute([$matk]);
$row_uv = $stmt_uv->fetch(PDO::FETCH_ASSOC);
$mauv = $row_uv['MAUV'] ?? 0;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID thư không hợp lệ!";
    exit;
}

$id = (int)$_GET['id'];

// Lấy thông tin thư theo id và mã ứng viên để bảo mật
$sql_thu = "
    SELECT H.MAHT, H.TIEUDE, H.THONGDIEP, H.MANTD, NTD.TENNTD
    FROM HOPTHU H
    LEFT JOIN NHATUYENDUNG NTD ON H.MANTD = NTD.MANTD
    WHERE H.MAHT = ? AND H.MAUV = ?
";
$stmt_thu = $conn->prepare($sql_thu);
$stmt_thu->execute([$id, $mauv]);
$thu = $stmt_thu->fetch(PDO::FETCH_ASSOC);

if (!$thu) {
    echo "Thư không tồn tại hoặc không có quyền xem.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Xem thư - TalentHub</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
</head>
<body>

<section class="message-detail py-5">
  <div class="container">
    <h3 class="mb-4 fw-bold">Chi tiết thư</h3>
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="card-title">
          <?= $thu['TENNTD'] ? "Công ty: " . htmlspecialchars($thu['TENNTD']) : "Hệ thống" ?>
        </h5>
        <h6 class="card-subtitle mb-2 text-primary"><?= htmlspecialchars($thu['TIEUDE']) ?></h6>
        <p class="card-text"><?= nl2br(htmlspecialchars($thu['THONGDIEP'])) ?></p>
        <a href="hop-thu.php" class="btn btn-secondary mt-3">Quay lại Hộp thư</a>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.html'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>