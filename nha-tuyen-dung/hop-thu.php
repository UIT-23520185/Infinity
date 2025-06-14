<?php
$page_name = "Hộp thư nhà tuyển dụng";
include("../includes/dbconnection.php");
include("includes/header.php");

// Kiểm tra đăng nhập
if (!isset($_SESSION['matk'])) {
    echo "<div class='alert alert-danger'>Vui lòng đăng nhập</div>";
    exit();
}

$matk = $_SESSION['matk'];

// Xử lý xóa thư
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $maht = intval($_GET['delete']);
    $type = isset($_GET['type']) ? $_GET['type'] : 'received';

    if ($type == 'sent') {
        // Xóa thư đã gửi
        $sql_del = "DELETE FROM hop_thu WHERE MAHT = :maht AND MANGUOIGUI = :matk";
    } else {
        // Xóa thư nhận
        $sql_del = "DELETE FROM hop_thu WHERE MAHT = :maht AND MANGUOINHAN = :matk";
    }

    $stmt_del = $conn->prepare($sql_del);
    $stmt_del->execute([':maht' => $maht, ':matk' => $matk]);
    echo "<script>alert('Đã xóa thư thành công!'); window.location.href='hop-thu.php?type=$type';</script>";
    exit();
}

// Xác định loại hộp thư: nhận hay gửi
$type = isset($_GET['type']) ? $_GET['type'] : 'received';

if ($type == 'sent') {
    $sql = "SELECT * FROM hop_thu WHERE MANGUOIGUI = :matk ORDER BY NGAYGUI DESC";
} else {
    $sql = "SELECT * FROM hop_thu WHERE MANGUOINHAN = :matk ORDER BY NGAYGUI DESC";
}

$stmt = $conn->prepare($sql);
$stmt->execute([':matk' => $matk]);
$thuthus = $stmt->fetchAll();
?>

<div class="container my-5">
  <div class="row">
    <div class="col-md-4 mb-4"><?php include("includes/sidebar.php"); ?></div>
    <div class="col-md-8">
      <div class="p-4 rounded" style="background-color: #e6f4c3;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Hộp thư</h4>
            <a href="soan-thu.php" class="btn btn-primary btn-sm">Soạn thư</a>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link <?php if ($type == 'received') echo 'active'; ?>" href="hop-thu.php?type=received">Thư nhận</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($type == 'sent') echo 'active'; ?>" href="hop-thu.php?type=sent">Thư đã gửi</a>
            </li>
        </ul>

        <?php if (count($thuthus) == 0): ?>
            <div class='alert alert-warning text-center'>Hiện tại chưa có thư nào.</div>
        <?php else: ?>
            <?php foreach ($thuthus as $thu): ?>
              <div class="p-3 mb-3 bg-light rounded shadow-sm d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1"><?php echo htmlspecialchars($thu['TIEUDE']); ?></h5>
                    <?php if ($type == 'sent'): ?>
                        <p class="mb-1"><strong>Người nhận:</strong> <?php echo htmlspecialchars($thu['USERNAME_NGUOINHAN']); ?></p>
                    <?php else: ?>
                        <p class="mb-1"><strong>Người gửi:</strong> <?php echo htmlspecialchars($thu['TEN_NGUOIGUI']); ?></p>
                    <?php endif; ?>
                    <p class="mb-0"><strong>Thời gian:</strong> <?php echo htmlspecialchars($thu['NGAYGUI']); ?></p>
                </div>
                <div class="d-flex flex-column gap-2">
                    <a href="chi-tiet-thu.php?id=<?php echo $thu['MAHT']; ?>&type=<?php echo $type; ?>" class="btn btn-success btn-sm">Đọc thư</a>
                    <a href="?delete=<?php echo $thu['MAHT']; ?>&type=<?php echo $type; ?>" onclick="return confirm('Xác nhận xóa thư?')" class="btn btn-danger btn-sm">Xóa</a>
                </div>
              </div>
            <?php endforeach; ?>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>
