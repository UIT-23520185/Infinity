<?php
$page_name = "Tạo lịch phỏng vấn";
include("../includes/dbconnection.php");
include("includes/header.php");

// Kiểm tra đăng nhập
if (!isset($_SESSION['matk'])) {
    echo "<div class='alert alert-danger'>Vui lòng đăng nhập</div>";
    exit();
}

// Lấy mã nhà tuyển dụng
$mantd = $_SESSION['matk'];
$matk = $_SESSION['matk'];

// Xử lý form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username_uv = trim($_POST['username_uv']);
    $mabd = intval($_POST['mabd']);
    $ngaypv = $_POST['ngaypv'];

    // Tìm mã ứng viên dựa trên username nhập vào
    $sql_uv = "SELECT uv.MAUV, uv.TENUV, tk.MATK, tk.USERNAME FROM ungvien uv 
               JOIN taikhoan tk ON uv.MATK = tk.MATK 
               WHERE tk.USERNAME = :username";
    $stmt_uv = $conn->prepare($sql_uv);
    $stmt_uv->execute([':username' => $username_uv]);
    $uv = $stmt_uv->fetch();

    if (!$uv) {
        echo "<script>alert('Không tìm thấy ứng viên với username này!');</script>";
    } else {
        // Thêm lịch phỏng vấn
        $stmt = $conn->prepare("INSERT INTO lich_phongvan (MANTD, MAUV, MABD, NGAYPHONGVAN) VALUES (:mantd, :mauv, :mabd, :ngaypv)");
        $stmt->execute([':mantd' => $mantd, ':mauv' => $uv['MAUV'], ':mabd' => $mabd, ':ngaypv' => $ngaypv]);

        // Gửi thư thông báo
        $sql_mail = "INSERT INTO hop_thu (MANGUOIGUI, MANGUOINHAN, USERNAME_NGUOIGUI, TEN_NGUOIGUI, USERNAME_NGUOINHAN, TIEUDE, THONGDIEP)
                     VALUES (:manguoigui, :manguoinhan, :username_nguoigui, :ten_nguoigui, :username_nguoinhan, :tieude, :thongdiep)";
        $stmt_mail = $conn->prepare($sql_mail);
        $stmt_mail->execute([
            ':manguoigui' => $matk,
            ':manguoinhan' => $uv['MATK'],
            ':username_nguoigui' => 'NhaTuyenDung',
            ':ten_nguoigui' => 'Nhà tuyển dụng',
            ':username_nguoinhan' => $uv['USERNAME'],
            ':tieude' => 'Thông báo lịch phỏng vấn',
            ':thongdiep' => "Bạn đã có lịch phỏng vấn vào ngày $ngaypv"
        ]);

        echo "<script>alert('Đã tạo lịch phỏng vấn và gửi thư thành công!'); window.location.href='tao-lich-phongvan.php';</script>";
        exit();
    }
}

// Lấy danh sách bài đăng của nhà tuyển dụng
$bds = $conn->query("SELECT * FROM baidang WHERE MANTD = $mantd")->fetchAll();
?>

<div class="container my-5">
  <div class="row">
    <div class="col-md-4 mb-4"><?php include("includes/sidebar.php"); ?></div>
    <div class="col-md-8">
      <div class="p-4 rounded" style="background-color: #e6f4c3;">
        <h4 class="fw-bold mb-4 text-center">Tạo lịch phỏng vấn</h4>

        <form method="post">
          <div class="mb-3">
            <label>Username ứng viên:</label>
            <input type="text" name="username_uv" class="form-control" required placeholder="Nhập username của ứng viên">
          </div>

          <div class="mb-3">
            <label>Bài đăng:</label>
            <select name="mabd" class="form-select" required>
              <?php foreach ($bds as $bd): ?>
                <option value="<?php echo $bd['MABD']; ?>"><?php echo $bd['TENCV']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label>Ngày phỏng vấn:</label>
            <input type="date" name="ngaypv" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-primary">Tạo lịch</button>
        </form>

      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>
