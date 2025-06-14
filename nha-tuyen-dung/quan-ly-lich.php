<?php
$page_name = "Quản lý lịch phỏng vấn";
include("../includes/dbconnection.php");
include("includes/header.php");

// Kiểm tra đăng nhập
if (!isset($_SESSION['matk'])) {
    echo "<div class='alert alert-danger'>Vui lòng đăng nhập</div>";
    exit();
}

// Lấy mã nhà tuyển dụng
$mantd = $_SESSION['matk'];

// Xử lý cập nhật hoàn thành hoặc hủy
if (isset($_GET['hoanthanh'])) {
    $id = intval($_GET['hoanthanh']);
    $stmt = $conn->prepare("UPDATE lich_phongvan SET HOANTHANH = TRUE WHERE MALICH = :id AND MANTD = :mantd");
    $stmt->execute([':id' => $id, ':mantd' => $mantd]);
}
if (isset($_GET['huy'])) {
    $id = intval($_GET['huy']);
    $stmt = $conn->prepare("UPDATE lich_phongvan SET HUYPHONGVAN = TRUE WHERE MALICH = :id AND MANTD = :mantd");
    $stmt->execute([':id' => $id, ':mantd' => $mantd]);
}

// Truy vấn dữ liệu lịch phỏng vấn
$sql = "SELECT lp.*, uv.TENUV, bd.TENCV
        FROM lich_phongvan lp
        JOIN ungvien uv ON lp.MAUV = uv.MAUV
        JOIN baidang bd ON lp.MABD = bd.MABD
        WHERE lp.MANTD = :mantd
        ORDER BY lp.NGAYPHONGVAN DESC";
$stmt = $conn->prepare($sql);
$stmt->execute([':mantd' => $mantd]);
$lichphongvans = $stmt->fetchAll();
?>

<div class="container my-5">
  <div class="row">
    <div class="col-md-4 mb-4"><?php include("includes/sidebar.php"); ?></div>
    <div class="col-md-8">
      <div class="p-4 rounded" style="background-color: #e6f4c3;">
        <div class="d-flex justify-content-between mb-4">
            <h4 class="fw-bold mb-0 text-center">Quản lý lịch phỏng vấn</h4>
            <a href="tao-lich-phongvan.php" class="btn btn-primary btn-sm">Tạo lịch mới</a>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered text-center align-middle bg-white">
            <thead class="table-success">
              <tr>
                <th>Ngày</th>
                <th>Ứng viên</th>
                <th>Bài đăng</th>
                <th>Hoàn thành</th>
                <th>Hủy</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($lichphongvans as $lich): ?>
              <tr>
                <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($lich['NGAYPHONGVAN']))); ?></td>
                <td><?php echo htmlspecialchars($lich['TENUV']); ?></td>
                <td><?php echo htmlspecialchars($lich['TENCV']); ?></td>
                <td>
                    <input type="checkbox" <?php if ($lich['HOANTHANH']) echo "checked disabled"; ?> 
                        onclick="window.location.href='quan-ly-lich.php?hoanthanh=<?php echo $lich['MALICH']; ?>'">
                </td>
                <td>
                    <input type="checkbox" <?php if ($lich['HUYPHONGVAN']) echo "checked disabled"; ?> 
                        onclick="window.location.href='quan-ly-lich.php?huy=<?php echo $lich['MALICH']; ?>'">
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>
