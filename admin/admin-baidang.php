<?php
$page_name = "Quản lý tin tuyển dụng";
include("../includes/dbconnection.php");
include("includes/header.php");

// Xử lý xóa bài đăng
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $mabd = intval($_GET['delete']);
    $stmt_del = $conn->prepare("DELETE FROM baidang WHERE MABD = :mabd");
    $stmt_del->execute([':mabd' => $mabd]);
    echo "<script>alert('Đã xóa tin tuyển dụng thành công!'); window.location.href='admin-baidang.php';</script>";
    exit();
}

// Phân trang
$limit = 15;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page-1) * $limit;

// Lấy danh sách bài đăng (join để lấy thêm tên nhà tuyển dụng)
$sql = "SELECT bd.*, ntd.TENNTD 
        FROM baidang bd
        JOIN nhatuyendung ntd ON bd.MANTD = ntd.MANTD
        ORDER BY MABD DESC
        LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$baidangs = $stmt->fetchAll();

// Tổng số bản ghi
$total = $conn->query("SELECT COUNT(*) FROM baidang")->fetchColumn();
$total_pages = ceil($total / $limit);
?>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 rounded p-3" style="background-color: #CCF2E0;">
      <div class="text-center mb-4">
        <h5 class="mt-2"><?php echo $_SESSION['hoten'] ?? 'Admin TalentHub'; ?></h5>
        <p class="text-muted">Admin</p>
      </div>

      <div class="list-group">
        <a href="admin-ntd.php" class="list-group-item">Quản lý nhà tuyển dụng</a>
        <a href="admin-ungvien.php" class="list-group-item">Quản lý ứng viên</a>
        <a href="admin-baidang.php" class="list-group-item active">Quản lý tin tuyển dụng</a>
      </div>
    </div>

    <!-- Content -->
    <div class="col-md-9">
      <div class="p-4 rounded">
        <h4 class="fw-bold mb-4 text-center">Danh sách tin tuyển dụng</h4>

        <div class="table-responsive">
          <table class="table table-bordered text-center align-middle bg-white">
            <thead class="table-success">
              <tr>
                <th>Mã bài đăng</th>
                <th>Nhà tuyển dụng</th>
                <th>Tên công việc</th>
                <th>Thao tác</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($baidangs as $bd): ?>
              <tr>
                <td><?php echo $bd['MABD']; ?></td>
                <td><?php echo htmlspecialchars($bd['TENNTD']); ?></td>
                <td><?php echo htmlspecialchars($bd['TENCV']); ?></td>
                <td>
                  <a href="?delete=<?php echo $bd['MABD']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa tin tuyển dụng này?')" class="btn btn-danger btn-sm">Xóa</a>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <!-- Phân trang -->
        <div class="text-center mt-3">
          <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page+1; ?>" class="btn btn-outline-primary">Xem thêm</a>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>
