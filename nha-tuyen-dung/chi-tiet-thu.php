<?php
$page_name = "Chi tiết thư";
include("../includes/dbconnection.php");
include("includes/header.php");

// Kiểm tra đăng nhập
if (!isset($_SESSION['matk'])) {
    echo "<div class='alert alert-danger'>Vui lòng đăng nhập</div>";
    exit();
}

$matk = $_SESSION['matk'];

// Lấy ID thư
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>Thư không tồn tại.</div>";
    exit();
}
$maht = intval($_GET['id']);

// Xác định type (received hay sent), mặc định là received
$type = isset($_GET['type']) ? $_GET['type'] : 'received';

// Truy vấn thư theo kiểu gửi hoặc nhận
if ($type == 'sent') {
    $sql = "SELECT * FROM hop_thu WHERE MAHT = :maht AND MANGUOIGUI = :matk";
} else {
    $sql = "SELECT * FROM hop_thu WHERE MAHT = :maht AND MANGUOINHAN = :matk";
}

$stmt = $conn->prepare($sql);
$stmt->execute([':maht' => $maht, ':matk' => $matk]);
$thu = $stmt->fetch();

if (!$thu) {
    echo "<div class='alert alert-danger'>Không tìm thấy thư.</div>";
    exit();
}
?>

<div class="container my-5">
  <div class="row">
    <div class="col-md-4 mb-4"><?php include("includes/sidebar.php"); ?></div>
    <div class="col-md-8">
      <div class="p-4 rounded" style="background-color: #e6f4c3;">
        <h4 class="fw-bold mb-4 text-center">Chi tiết thư</h4>

        <p><strong>Tiêu đề:</strong> <?php echo htmlspecialchars($thu['TIEUDE']); ?></p>

        <?php if ($type == 'sent'): ?>
            <p><strong>Người nhận:</strong> <?php echo htmlspecialchars($thu['USERNAME_NGUOINHAN']); ?></p>
        <?php else: ?>
            <p><strong>Người gửi:</strong> <?php echo htmlspecialchars($thu['TEN_NGUOIGUI']); ?></p>
        <?php endif; ?>

        <p><strong>Thời gian gửi:</strong> <?php echo htmlspecialchars($thu['NGAYGUI']); ?></p>
        <hr>
        <p><strong>Nội dung thư:</strong></p>
        <p><?php echo nl2br(htmlspecialchars($thu['THONGDIEP'])); ?></p>

        <a href="hop-thu.php?type=<?php echo $type; ?>" class="btn btn-secondary mt-3">Quay lại hộp thư</a>
      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>
