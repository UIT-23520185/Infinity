<?php 
$page_name = "Ứng viên đã lưu";
include("../includes/dbconnection.php");
include("includes/header.php"); 

// Kiểm tra đăng nhập
if (!isset($_SESSION['matk'])) {
    echo "<div class='alert alert-danger'>Vui lòng đăng nhập</div>";
    exit();
}

// Lấy mã nhà tuyển dụng từ tài khoản hiện tại
$mantd = $_SESSION['matk'];

// Xử lý xóa ứng viên khỏi danh sách lưu
if (isset($_GET['xoa']) && is_numeric($_GET['xoa'])) {
    $mauv = intval($_GET['xoa']);
    $sql_del = "DELETE FROM luu_ungvien WHERE MANTD = :mantd AND MAUV = :mauv";
    $stmt_del = $conn->prepare($sql_del);
    $stmt_del->execute([':mantd' => $mantd, ':mauv' => $mauv]);

    echo "<script>alert('Đã xóa ứng viên khỏi danh sách lưu!'); window.location.href='ung-vien-da-luu.php';</script>";
    exit();
}

// Truy vấn danh sách ứng viên đã lưu
$sql = "SELECT uv.*
        FROM luu_ungvien lu
        JOIN ungvien uv ON lu.MAUV = uv.MAUV
        WHERE lu.MANTD = :mantd
        ORDER BY uv.MAUV DESC";

$stmt = $conn->prepare($sql);
$stmt->execute([':mantd' => $mantd]);
$ungviens = $stmt->fetchAll();
?>

<div class="container my-5">
  <div class="row">
    <div class="col-md-4 mb-4">
      <?php include("includes/sidebar.php"); ?>
    </div>
    <div class="col-md-8">

        <h4 class="mb-3">Danh sách ứng viên đã lưu</h4>

        <div class="list-group">
            <?php if (count($ungviens) == 0): ?>
                <div class="alert alert-warning text-center">Hiện tại chưa lưu ứng viên nào.</div>
            <?php endif; ?>

            <?php foreach ($ungviens as $uv): ?>
            <div class="list-group-item d-flex align-items-center">
                <img src="<?php echo (!empty($uv['CV_IMAGE'])) ? "../uploads/".$uv['CV_IMAGE'] : "https://via.placeholder.com/80"; ?>" class="rounded me-3" width="80" height="80" alt="Avatar">
                <div class="flex-grow-1">
                    <p class="mb-1"><strong>Họ tên:</strong> <?php echo htmlspecialchars($uv['TENUV']); ?></p>
                    <p class="mb-1"><strong>Chuyên môn:</strong> <?php echo htmlspecialchars($uv['CHUYENMON']); ?></p>
                    <p class="mb-1"><strong>Công việc hiện tại:</strong> <?php echo htmlspecialchars($uv['CVHT']); ?></p>
                    <p class="mb-0"><strong>Số năm kinh nghiệm:</strong> <?php echo htmlspecialchars($uv['SONAMKN']); ?></p>
                </div>
                <div class="d-flex flex-column gap-2">
                    <a href="chi-tiet-ung-vien.php?id=<?php echo $uv['MAUV']; ?>" class="btn btn-success btn-sm">Xem chi tiết</a>
                    <a href="?xoa=<?php echo $uv['MAUV']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa ứng viên này khỏi danh sách lưu?')">Xóa</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>
