<?php 
$page_name = "Chi tiết bài đăng";
include("../includes/dbconnection.php");
include("includes/header.php");; 

if (!isset($_SESSION['matk'])) {
    echo "<div class='alert alert-danger'>Vui lòng đăng nhập</div>";
    exit();
}

$mantd = $_SESSION['matk'];

// Lấy id bài đăng từ URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>Không tìm thấy bài đăng!</div>";
    exit();
}

$mabd = intval($_GET['id']);

// Truy vấn thông tin bài đăng
$sql = "SELECT * FROM baidang WHERE MABD = :mabd AND MANTD = :mantd";
$stmt = $conn->prepare($sql);
$stmt->execute([':mabd' => $mabd, ':mantd' => $mantd]);
$baidang = $stmt->fetch();

if (!$baidang) {
    echo "<div class='alert alert-danger'>Bài đăng không tồn tại hoặc không thuộc quyền quản lý của bạn!</div>";
    exit();
}

// Truy vấn danh sách ứng viên đã ứng tuyển vào bài đăng
$sql_uv = "SELECT uv.MAUV, uv.TENUV, uv.GIOITINH, uv.CHUYENMON, uv.SONAMKN, ct.NGAYUNGTUYEN
           FROM chitiet_ungtuyen ct
           JOIN ungvien uv ON ct.MAUV = uv.MAUV
           WHERE ct.MABD = :mabd";

$stmt_uv = $conn->prepare($sql_uv);
$stmt_uv->execute([':mabd' => $mabd]);
$ungviens = $stmt_uv->fetchAll();
?>

<div class="container my-5">
  <div class="row">
    <div class="col-md-4 mb-4">
      <?php include("includes/sidebar.php"); ?>
    </div>
    <div class="col-md-8">
      <div class="p-4 rounded" style="background-color: #e6f4c3;">
        <h4 class="fw-bold mb-4 text-center">Chi tiết bài đăng</h4>

        <div class="mb-3"><strong>Tên công việc:</strong> <?php echo htmlspecialchars($baidang['TENCV']); ?></div>
        <div class="mb-3"><strong>Ngành nghề:</strong> <?php echo htmlspecialchars($baidang['TENNGANH']); ?></div>
        <div class="mb-3"><strong>Hình thức làm việc:</strong> <?php echo htmlspecialchars($baidang['HTLV']); ?></div>
        <div class="mb-3"><strong>Lương:</strong> <?php echo htmlspecialchars($baidang['LUONG']); ?></div>
        <div class="mb-3"><strong>Kinh nghiệm:</strong> <?php echo htmlspecialchars($baidang['KINHNGHIEM']); ?></div>
        <div class="mb-3"><strong>Cấp bậc:</strong> <?php echo htmlspecialchars($baidang['CAPBAC']); ?></div>
        <div class="mb-3"><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($baidang['DIACHI']); ?></div>
        <div class="mb-3"><strong>Phúc lợi:</strong> <?php echo nl2br(htmlspecialchars($baidang['PHUCLOI'])); ?></div>
        <div class="mb-3"><strong>Mô tả công việc:</strong> <?php echo nl2br(htmlspecialchars($baidang['MOTACV'])); ?></div>
        <div class="mb-3"><strong>Yêu cầu công việc:</strong> <?php echo nl2br(htmlspecialchars($baidang['YEUCAUCV'])); ?></div>
        <div class="mb-3"><strong>Thời gian làm việc:</strong> <?php echo htmlspecialchars($baidang['THOIGIANLV']); ?></div>
        <div class="mb-3"><strong>Thông tin khác:</strong> <?php echo nl2br(htmlspecialchars($baidang['TTKHAC'])); ?></div>

        <?php if (!empty($baidang['HINHANH'])): ?>
        <div class="mb-3">
          <strong>Hình ảnh minh họa:</strong><br>
          <img src="../uploads/<?php echo htmlspecialchars($baidang['HINHANH']); ?>" class="img-fluid rounded" style="max-width:300px;">
        </div>
        <?php endif; ?>

        <hr>

        <h5 class="fw-bold">Danh sách ứng viên đã ứng tuyển</h5>
<?php if (count($ungviens) == 0): ?>
    <div class='alert alert-warning'>Chưa có ứng viên ứng tuyển vào tin này!</div>
<?php else: ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên ứng viên</th>
                <th>Giới tính</th>
                <th>Chuyên môn</th>
                <th>Kinh nghiệm</th>
                <th>Ngày ứng tuyển</th>
                <th>Chi tiết</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($ungviens as $uv): ?>
            <tr>
                <td><?php echo htmlspecialchars($uv['TENUV']); ?></td>
                <td><?php echo htmlspecialchars($uv['GIOITINH']); ?></td>
                <td><?php echo htmlspecialchars($uv['CHUYENMON']); ?></td>
                <td><?php echo htmlspecialchars($uv['SONAMKN']); ?> năm</td>
                <td><?php echo htmlspecialchars($uv['NGAYUNGTUYEN']); ?></td>
                <td>
                  <a href="chi-tiet-ung-vien.php?id=<?php echo $uv['MAUV']; ?>" class="btn btn-primary btn-sm">Xem</a>

                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>


      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>
