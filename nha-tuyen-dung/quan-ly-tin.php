<?php 
$page_name = "Quản lý tin";
include("../includes/dbconnection.php");
include("includes/header.php"); 

// Giả định nhà tuyển dụng đang login
// Ví dụ: $_SESSION['MANTD'] = 1;
if (!isset($_SESSION['vaitro'])) {
    echo "<div class='alert alert-danger'>Vui lòng đăng nhập</div>";
    exit();
}

$mantd = $_SESSION['matk'];

// Xử lý XÓA bài đăng
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $mabd = intval($_GET['delete']);

    // Xóa bài đăng
    $stmt = $conn->prepare("DELETE FROM baidang WHERE MABD = :mabd AND MANTD = :mantd");
    $stmt->execute([':mabd' => $mabd, ':mantd' => $mantd]);

    echo "<div class='alert alert-success'>Đã xóa bài đăng thành công!</div>";
}

// Xử lý tìm kiếm
$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

// Truy vấn danh sách bài đăng
$sql = "SELECT bd.MABD, bd.TENCV, bd.MOTACV, bd.LUONG, bd.MOTACV, bd.PHUCLOI, bd.YEUCAUCV, bd.THOIGIANLV, 
        bd.TTKHAC, bd.HINHANH, bd.MANTD, COUNT(ct.MACT) AS SoLuongUngTuyen
        FROM baidang bd
        LEFT JOIN chitiet_ungtuyen ct ON bd.MABD = ct.MABD
        WHERE bd.MANTD = :mantd";

if ($search != "") {
    $sql .= " AND bd.TENCV LIKE :search";
}

$sql .= " GROUP BY bd.MABD ORDER BY bd.MABD DESC";

$stmt = $conn->prepare($sql);
$params = [':mantd' => $mantd];
if ($search != "") {
    $params[':search'] = "%$search%";
}
$stmt->execute($params);
$baidangs = $stmt->fetchAll();
?>

<div class="container my-5">
  <div class="row">
    <div class="col-md-4 mb-4">
      <?php include("includes/sidebar.php"); ?>
    </div>
    <div class="col-md-8">
      <div class="p-4 rounded" style="background-color: #e6f4c3;">
        <h4 class="fw-bold mb-4 text-center">Quản lý tin</h4>

        <!-- Form tìm kiếm -->
        <form class="input-group mb-4" method="get">
          <input type="text" name="search" class="form-control" placeholder="Tìm kiếm tin đã đăng" value="<?php echo htmlspecialchars($search); ?>">
          <button class="btn btn-primary" type="submit">Tìm</button>
        </form>

        <div class="d-grid gap-3">
        <?php if (count($baidangs) == 0): ?>
            <div class='alert alert-warning text-center'>Chưa có bài đăng nào!</div>
        <?php endif; ?>

        <?php foreach ($baidangs as $bd): ?>
          <div class="p-3 bg-light rounded">
            <p class="mb-1"><strong>Tiêu đề:</strong> <?php echo htmlspecialchars($bd['TENCV']); ?></p>
            <p class="mb-1"><strong>Ứng tuyển:</strong> <?php echo $bd['SoLuongUngTuyen']; ?></p>
            <div class="d-flex gap-2">
              <a href="chi-tiet-bai-dang.php?id=<?php echo $bd['MABD']; ?>" class="btn btn-primary btn-sm">Xem chi tiết</a>
              <a href="quan-ly-tin.php?delete=<?php echo $bd['MABD']; ?>" onclick="return confirm('Bạn có chắc muốn xóa?');" class="btn btn-danger btn-sm">Xóa</a>
            </div>
          </div>
        <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>
