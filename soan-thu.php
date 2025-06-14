<?php
$page_name = "Soạn thư";
include("includes/dbconnection.php");
include("includes/header.php");

// Kiểm tra đăng nhập
if (!isset($_SESSION['matk'])) {
    echo "<div class='alert alert-danger'>Vui lòng đăng nhập</div>";
    exit();
}

$matk = $_SESSION['matk'];

// Lấy thông tin người gửi
$sql_nguoi_gui = "SELECT * FROM taikhoan WHERE MATK = :matk";
$stmt_ng = $conn->prepare($sql_nguoi_gui);
$stmt_ng->execute([':matk' => $matk]);
$nguoi_gui = $stmt_ng->fetch();

// Xử lý gửi thư
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nguoinhan_username = trim($_POST['nguoinhan']);
    $tieude = trim($_POST['tieude']);
    $thongdiep = trim($_POST['thongdiep']);

    // Lấy thông tin người nhận
    $sql_nr = "SELECT * FROM taikhoan WHERE USERNAME = :username";
    $stmt_nr = $conn->prepare($sql_nr);
    $stmt_nr->execute([':username' => $nguoinhan_username]);
    $nguoi_nhan = $stmt_nr->fetch();

    if (!$nguoi_nhan) {
        echo "<script>alert('Không tìm thấy người nhận');</script>";
    } else {
        $sql_insert = "INSERT INTO hop_thu (MANGUOIGUI, MANGUOINHAN, USERNAME_NGUOIGUI, TEN_NGUOIGUI, USERNAME_NGUOINHAN, TIEUDE, THONGDIEP)
                        VALUES (:manguoigui, :manguoinhan, :username_nguoigui, :ten_nguoigui, :username_nguoinhan, :tieude, :thongdiep)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->execute([
            ':manguoigui' => $matk,
            ':manguoinhan' => $nguoi_nhan['MATK'],
            ':username_nguoigui' => $nguoi_gui['USERNAME'],
            ':ten_nguoigui' => $nguoi_gui['HOTEN'],
            ':username_nguoinhan' => $nguoinhan_username,
            ':tieude' => $tieude,
            ':thongdiep' => $thongdiep
        ]);

        echo "<script>alert('Đã gửi thư thành công!'); window.location.href='hop-thu.php';</script>";
        exit();
    }
}
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
<div class="container my-5">
  <div class="row">
    <div class="col-md-12">
      <div class="p-4 rounded" style="background-color: #e6f4c3;">
        <h4 class="fw-bold mb-4 text-center">Soạn thư</h4>

        <form method="post">
          <div class="mb-3">
            <label>Gửi đến (username):</label>
            <input type="text" name="nguoinhan" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Tiêu đề:</label>
            <input type="text" name="tieude" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Nội dung:</label>
            <textarea name="thongdiep" class="form-control" rows="5" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Gửi thư</button>
        </form>

      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>
