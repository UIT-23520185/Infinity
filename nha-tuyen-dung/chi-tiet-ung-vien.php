<?php 
$page_name = "Chi tiết ứng viên";
include("../includes/dbconnection.php");
include("includes/header.php"); 

// Kiểm tra quyền đăng nhập
if (!isset($_SESSION['matk'])) {
    echo "<div class='alert alert-danger'>Vui lòng đăng nhập</div>";
    exit();
}

// Lấy id ứng viên từ URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>Không tìm thấy ứng viên!</div>";
    exit();
}

$mauv = intval($_GET['id']);

// Truy vấn thông tin ứng viên
$sql = "SELECT uv.*, tk.USERNAME, tk.HOTEN, tk.NGDKTK 
        FROM ungvien uv
        LEFT JOIN taikhoan tk ON uv.MATK = tk.MATK
        WHERE uv.MAUV = :mauv";
$stmt = $conn->prepare($sql);
$stmt->execute([':mauv' => $mauv]);
$ungvien = $stmt->fetch();

if (!$ungvien) {
    echo "<div class='alert alert-danger'>Ứng viên không tồn tại!</div>";
    exit();
}
?>

<div class="container my-5">
  <div class="row">
    <div class="col-md-4 mb-4">
      <?php include("includes/sidebar.php"); ?>
    </div>
    <div class="col-md-8">
      <div class="p-4 rounded" style="background-color: #e6f4c3;">
        <h4 class="fw-bold mb-4 text-center">Chi tiết ứng viên</h4>

        <div class="mb-3"><strong>Tên ứng viên:</strong> <?php echo htmlspecialchars($ungvien['TENUV']); ?></div>
        <div class="mb-3"><strong>Giới tính:</strong> <?php echo htmlspecialchars($ungvien['GIOITINH']); ?></div>
        <div class="mb-3"><strong>Chuyên môn:</strong> <?php echo htmlspecialchars($ungvien['CHUYENMON']); ?></div>
        <div class="mb-3"><strong>Công việc hiện tại:</strong> <?php echo htmlspecialchars($ungvien['CVHT']); ?></div>
        <div class="mb-3"><strong>Kinh nghiệm:</strong> <?php echo htmlspecialchars($ungvien['SONAMKN']); ?> năm</div>
        <div class="mb-3"><strong>Ngày sinh:</strong> <?php echo htmlspecialchars($ungvien['NGAYSINH']); ?></div>
        <div class="mb-3"><strong>Ngày đăng ký:</strong> <?php echo htmlspecialchars($ungvien['NGDKTK']); ?></div>
        <div class="mb-3"><strong>Tài khoản hệ thống:</strong> <?php echo htmlspecialchars($ungvien['USERNAME']); ?></div>

        <?php if (!empty($ungvien['CV_IMAGE'])): ?>
        <div class="mb-3">
          <strong>File CV:</strong><br>
          <a href="../uploads/<?php echo htmlspecialchars($ungvien['CV_IMAGE']); ?>" target="_blank">Xem CV</a>
        </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>
