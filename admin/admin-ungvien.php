<?php
$page_name = "Quản lý ứng viên";
include("../includes/dbconnection.php");
include("includes/header.php");

// Xử lý xóa ứng viên
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $mauv = intval($_GET['delete']);
    $stmt_del = $conn->prepare("DELETE FROM ungvien WHERE MAUV = :mauv");
    $stmt_del->execute([':mauv' => $mauv]);
    echo "<script>alert('Đã xóa ứng viên thành công!'); window.location.href='admin-ungvien.php';</script>";
    exit();
}

// Phân trang
$limit = 15;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page-1) * $limit;

// Lấy danh sách ứng viên
$sql = "SELECT * FROM ungvien ORDER BY MAUV LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$ungviens = $stmt->fetchAll();

// Tổng số bản ghi
$total = $conn->query("SELECT COUNT(*) FROM ungvien")->fetchColumn();
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
        <a href="admin-ungvien.php" class="list-group-item active">Quản lý ứng viên</a>
        <a href="admin-baidang.php" class="list-group-item">Quản lý tin tuyển dụng</a>
      </div>
    </div>

    <!-- Content -->
    <div class="col-md-9">
      <div class="p-4 rounded">
        <h4 class="fw-bold mb-4 text-center">Danh sách ứng viên</h4>

        <div class="table-responsive">
          <table class="table table-bordered text-center align-middle bg-white">
            <thead class="table-success">
              <tr>
                <th>Mã UV</th>
                <th>Tên ứng viên</th>
                <th>Chuyên môn</th>
                <th>Công việc hiện tại</th>
                <th>Kinh nghiệm (năm)</th>
                <th>Thao tác</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($ungviens as $uv): ?>
              <tr>
                <td><?php echo $uv['MAUV']; ?></td>
                <td><?php echo htmlspecialchars($uv['TENUV']); ?></td>
                <td><?php echo htmlspecialchars($uv['CHUYENMON']); ?></td>
                <td><?php echo htmlspecialchars($uv['CVHT']); ?></td>
                <td><?php echo $uv['SONAMKN']; ?></td>
                <td>
                  <a href="?delete=<?php echo $uv['MAUV']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?')" class="btn btn-danger btn-sm">Xóa</a>
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
