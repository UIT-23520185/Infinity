<?php
include 'includes/dbconnection.php'; // Kết nối CSDL
 include 'includes/header.php';
// Lấy dữ liệu từ form
$keyword = $_POST['keyword'] ?? '';
$nganh = $_POST['nganh'] ?? '';
$diachi = $_POST['diachi'] ?? '';
$luong = $_POST['luong'] ?? '';
$htlv = $_POST['htlv'] ?? '';

// Tạo câu truy vấn SQL
$sql = "SELECT * FROM BAIDANG WHERE 1=1";
$params = [];

if (!empty($keyword)) {
    $sql .= " AND (TENCV LIKE ? OR TENNGANH LIKE ? OR DIACHI LIKE ?)";
    $params[] = "%$keyword%";
    $params[] = "%$keyword%";
    $params[] = "%$keyword%";
}
if (!empty($nganh)) {
    $sql .= " AND TENNGANH = ?";
    $params[] = $nganh;
}
if (!empty($diachi)) {
    $sql .= " AND DIACHI = ?";
    $params[] = $diachi;
}
if (!empty($luong)) {
    $sql .= " AND LUONG = ?";
    $params[] = $luong;
}
if (!empty($htlv)) {
    $sql .= " AND HTLV = ?";
    $params[] = $htlv;
}

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$jobs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tìm việc - TalentHub</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
</head>
<body>



<!-- Bộ lọc tìm việc -->
<section class="search-bar py-4 mt-5">
  <div class="container bg-light p-4 rounded shadow-sm">
    <form method="POST" action="tim-viec.php">
      <h5 class="mb-3 fw-bold">Tìm việc</h5>
      <div class="row g-2">
        <div class="col-md-3">
          <input type="text" name="keyword" class="form-control" placeholder="Chức danh, công ty, từ khoá..." value="<?= htmlspecialchars($keyword) ?>" />
        </div>
        <div class="col-md-2">
          <select name="nganh" class="form-select">
            <option value="">Tất cả ngành nghề</option>
            <option value="CNTT" <?= $nganh == 'CNTT' ? 'selected' : '' ?>>Công nghệ thông tin</option>
            <option value="Kinh doanh" <?= $nganh == 'Kinh doanh' ? 'selected' : '' ?>>Kinh doanh</option>
            <!-- Thêm ngành khác nếu cần -->
          </select>
        </div>
        <div class="col-md-2">
          <select name="diachi" class="form-select">
            <option value="">Tất cả địa điểm</option>
            <option value="Hồ Chí Minh" <?= $diachi == 'Hồ Chí Minh' ? 'selected' : '' ?>>Hồ Chí Minh</option>
            <option value="Hà Nội" <?= $diachi == 'Hà Nội' ? 'selected' : '' ?>>Hà Nội</option>
          </select>
        </div>
        <div class="col-md-2">
          <select name="luong" class="form-select">
            <option value="">Mức lương</option>
            <option value="Thỏa thuận" <?= $luong == 'Thỏa thuận' ? 'selected' : '' ?>>Thỏa thuận</option>
            <option value="10-15 triệu" <?= $luong == '10-15 triệu' ? 'selected' : '' ?>>10-15 triệu</option>
          </select>
        </div>
        <div class="col-md-2">
          <select name="htlv" class="form-select">
            <option value="">Hình thức</option>
            <option value="Toàn thời gian" <?= $htlv == 'Toàn thời gian' ? 'selected' : '' ?>>Toàn thời gian</option>
            <option value="Bán thời gian" <?= $htlv == 'Bán thời gian' ? 'selected' : '' ?>>Bán thời gian</option>
          </select>
        </div>
        <div class="col-md-1">
          <button type="submit" class="btn btn-primary w-100">Tìm</button>
        </div>
      </div>
    </form>
  </div>
</section>

<!-- Danh sách công việc -->
<section class="job-list py-5">
  <div class="container">
    <h5 class="fw-bold mb-4">Danh sách công việc</h5>

    <?php if (count($jobs) > 0): ?>
      <?php foreach ($jobs as $job): ?>
        <div class="job-card p-4 mb-3 border rounded shadow-sm">
          <h5><?= htmlspecialchars($job['TENCV']) ?></h5>
          <p class="text-muted mb-1"><strong>Ngành:</strong> <?= htmlspecialchars($job['TENNGANH']) ?></p>
          <p class="text-muted mb-1"><strong>Địa chỉ:</strong> <?= htmlspecialchars($job['DIACHI']) ?></p>
          <p class="text-muted mb-1"><strong>Lương:</strong> <?= htmlspecialchars($job['LUONG']) ?></p>
          <p class="text-muted mb-1"><strong>Hình thức:</strong> <?= htmlspecialchars($job['HTLV']) ?></p>
          <a href="chi-tiet-cong-viec.php?id=<?= $job['MABD'] ?>" class="btn btn-outline-primary mt-2">Xem chi tiết</a>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="job-card p-4 mb-3 border rounded shadow-sm">
        <p class="text-muted">Không tìm thấy công việc phù hợp.</p>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php include 'includes/footer.html'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>