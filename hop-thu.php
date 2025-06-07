<?php
include 'includes/dbconnection.php';
include 'includes/header.php';

if (!isset($_SESSION['username'])) {
    header('Location: dang-nhap.php');
    exit;
}

$matk = $_SESSION['matk'];
$message = '';

// Lấy mã ứng viên
$sql_uv = "SELECT MAUV FROM UNGVIEN WHERE MATK = ?";
$stmt_uv = $conn->prepare($sql_uv);
$stmt_uv->execute([$matk]);
$row_uv = $stmt_uv->fetch(PDO::FETCH_ASSOC);
$mauv = $row_uv['MAUV'] ?? 0;

// Xử lý xóa thư khi có POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = (int)$_POST['delete_id'];

    // Kiểm tra thư có thuộc về ứng viên hay không trước khi xóa
    $sql_check = "SELECT MAHT FROM HOPTHU WHERE MAHT = ? AND MAUV = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->execute([$delete_id, $mauv]);
    if ($stmt_check->rowCount() > 0) {
        $sql_delete = "DELETE FROM HOPTHU WHERE MAHT = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        if ($stmt_delete->execute([$delete_id])) {
            $message = '<div class="alert alert-success">Xóa thư thành công.</div>';
        } else {
            $message = '<div class="alert alert-danger">Xóa thư thất bại.</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">Thư không tồn tại hoặc không có quyền xóa.</div>';
    }
}

// Lấy thư
$sql_thu = "
    SELECT H.MAHT, H.TIEUDE, H.THONGDIEP, H.MANTD, H.MAUV, NTD.TENNTD
    FROM HOPTHU H
    LEFT JOIN NHATUYENDUNG NTD ON H.MANTD = NTD.MANTD
    WHERE H.MAUV = ?
    ORDER BY H.MAHT DESC
";
$stmt_thu = $conn->prepare($sql_thu);
$stmt_thu->execute([$mauv]);
$kq_thu = $stmt_thu->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Hộp thư đến - TalentHub</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
</head>
<body>

<section class="inbox py-5">
  <div class="container">
    <h3 class="mb-4 fw-bold">Hộp thư đến</h3>

    <?= $message ?>

    <?php if (count($kq_thu) > 0): ?>
      <?php foreach ($kq_thu as $thu): ?>
        <div class="card mb-3 shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h5 class="card-title mb-1">
                <?= $thu['TENNTD'] ? "Công ty: " . htmlspecialchars($thu['TENNTD']) : "Hệ thống" ?>
              </h5>
              <p class="card-subtitle mb-1 text-primary fw-semibold">
                <?= $thu['TIEUDE'] ? "Tiêu đề: " . htmlspecialchars($thu['TIEUDE']) : "Hệ thống" ?>
            </div>
            <div>
              <a href="xem-thu.php?id=<?= $thu['MAHT'] ?>" class="btn btn-outline-primary me-2">Xem thư</a>
              <form method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa thư này?');">
                <input type="hidden" name="delete_id" value="<?= $thu['MAHT'] ?>" />
                <button type="submit" class="btn btn-outline-danger">Xóa</button>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="alert alert-info">Không có thư nào trong hộp thư đến.</div>
    <?php endif; ?>

  </div>
</section>

<?php include 'includes/footer.html'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
