<?php 
$page_name = "Tìm kiếm ứng viên";
include("../includes/dbconnection.php");
include("includes/header.php"); 

// Kiểm tra đăng nhập
if (!isset($_SESSION['matk'])) {
    echo "<div class='alert alert-danger'>Vui lòng đăng nhập</div>";
    exit();
}

$mantd = $_SESSION['matk'];


// Thực hiện lưu ứng viên
if (isset($_GET['luu']) && is_numeric($_GET['luu'])) {
    $mauv = intval($_GET['luu']);

    // Kiểm tra đã lưu chưa
    $sql_check = "SELECT * FROM luu_ungvien WHERE MANTD = :mantd AND MAUV = :mauv";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->execute([':mantd' => $mantd, ':mauv' => $mauv]);
    
    if ($stmt_check->rowCount() == 0) {
        $sql_insert = "INSERT INTO luu_ungvien (MANTD, MAUV) VALUES (:mantd, :mauv)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->execute([':mantd' => $mantd, ':mauv' => $mauv]);

        echo "<script>alert('Đã lưu ứng viên thành công!'); window.location.href='tim-ung-vien.php';</script>";
        exit();
    } else {
        echo "<script>alert('Ứng viên này đã được lưu trước đó!'); window.location.href='tim-ung-vien.php';</script>";
        exit();
    }
}

// Xử lý lọc tìm kiếm như trước:
$chuyenmon = isset($_GET['chuyenmon']) ? trim($_GET['chuyenmon']) : '';
$sonamkn = isset($_GET['sonamkn']) ? intval($_GET['sonamkn']) : 0;

$sql = "SELECT * FROM ungvien WHERE 1=1";
$params = [];

if ($chuyenmon != '') {
    $sql .= " AND CHUYENMON LIKE :chuyenmon";
    $params[':chuyenmon'] = "%$chuyenmon%";
}
if ($sonamkn > 0) {
    $sql .= " AND SONAMKN >= :sonamkn";
    $params[':sonamkn'] = $sonamkn;
}

$sql .= " ORDER BY MAUV DESC";
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$ungviens = $stmt->fetchAll();
?>

<div class="container my-5">
  <div class="row">
    <div class="col-md-4 mb-4">
      <?php include("includes/sidebar.php"); ?>
    </div>
    <div class="col-md-8">

        <!-- Search -->
        <h4 class="mb-3">Tìm kiếm ứng viên</h4>
        <form method="get" class="row mb-4">
            <div class="mb-2">
				Chuyên môn:
                <input type="text" class="form-control" name="chuyenmon" placeholder="Chuyên môn (VD: Backend)" value="<?php echo htmlspecialchars($chuyenmon); ?>">
            </div>
            <div class="mb-2">
				Số năm kinh nghiệm:
                <input type="number" class="form-control" name="sonamkn" placeholder="Số năm kinh nghiệm" value="<?php echo htmlspecialchars($sonamkn); ?>">
            </div>
            <div class="mb-2" align="center">
                <button class="btn btn-primary w-25">Tìm</button>
            </div>
        </form>

        <!-- Candidate list -->
        <div class="list-group">
            <?php if (count($ungviens) == 0): ?>
                <div class="alert alert-warning text-center">Không tìm thấy ứng viên nào.</div>
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
                    <a href="?luu=<?php echo $uv['MAUV']; ?>" class="btn btn-outline-primary btn-sm">Lưu</a>
                    <a href="gui_thu.php?id=<?php echo $uv['MAUV']; ?>" class="btn btn-outline-secondary btn-sm">Gửi tin nhắn</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>
