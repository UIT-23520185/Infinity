<?php  
$page_name = "Đăng tin"; 
include("../includes/dbconnection.php");
include("includes/header.php"); 


// Giả sử nhà tuyển dụng đăng nhập đã lưu MANTD trong session
// Ví dụ: $_SESSION['MANTD'] = 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tencv = $_POST['tencv'];
    $tennganh = $_POST['tennganh'];
    $htlv = $_POST['htlv'];
    $luong = $_POST['luong'];
    $kinhnghiem = $_POST['kinhnghiem'];
    $capbac = $_POST['capbac'];
    $diachi = $_POST['diachi'];
    $phucloi = $_POST['phucloi'];
    $motacv = $_POST['motacv'];
    $yeucaucv = $_POST['yeucaucv'];
    $thoigianlv = $_POST['thoigianlv'];
    $ttkhac = $_POST['ttkhac'];

    // Xử lý ảnh
    $hinhanh = null;
    if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] == 0) {
        $target_dir = "uploads/";
        $file_name = time() . '_' . basename($_FILES['hinhanh']['name']);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES['hinhanh']['tmp_name'], "../$target_file")) {
            $hinhanh = $file_name;
        }
    }

    $mantd = $_SESSION['matk']; // Lấy từ session login

    $sql = "INSERT INTO baidang (TENCV, TENNGANH, HTLV, LUONG, KINHNGHIEM, CAPBAC, DIACHI, PHUCLOI, MOTACV, YEUCAUCV, THOIGIANLV, TTKHAC, HINHANH, MANTD)
            VALUES (:tencv, :tennganh, :htlv, :luong, :kinhnghiem, :capbac, :diachi, :phucloi, :motacv, :yeucaucv, :thoigianlv, :ttkhac, :hinhanh, :mantd)";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':tencv' => $tencv,
        ':tennganh' => $tennganh,
        ':htlv' => $htlv,
        ':luong' => $luong,
        ':kinhnghiem' => $kinhnghiem,
        ':capbac' => $capbac,
        ':diachi' => $diachi,
        ':phucloi' => $phucloi,
        ':motacv' => $motacv,
        ':yeucaucv' => $yeucaucv,
        ':thoigianlv' => $thoigianlv,
        ':ttkhac' => $ttkhac,
        ':hinhanh' => $hinhanh,
        ':mantd' => $mantd
    ]);

    echo "<div class='alert alert-success'>Đăng tin thành công!</div>";
}
?>

<div class="container my-5">
  <div class="row">
    <div class="col-md-4 mb-4">
      <?php include("includes/sidebar.php"); ?>
    </div>
    <div class="col-md-8">
      <div class="p-5 rounded" style="background-color: #e6f4c3;">
        <h4 class="mb-4 fw-bold">Đăng tin</h4>
        <form method="post" enctype="multipart/form-data">

          <div class="mb-3">
            <label class="form-label fw-semibold">Tên công việc:</label>
            <input type="text" name="tencv" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Ngành nghề:</label>
            <input type="text" name="tennganh" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Hình thức làm việc:</label>
            <input type="text" name="htlv" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Lương:</label>
            <input type="text" name="luong" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Kinh nghiệm:</label>
            <input type="text" name="kinhnghiem" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Cấp bậc:</label>
            <input type="text" name="capbac" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Địa chỉ:</label>
            <input type="text" name="diachi" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Phúc lợi:</label>
            <textarea name="phucloi" class="form-control"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Mô tả công việc:</label>
            <textarea name="motacv" class="form-control"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Yêu cầu công việc:</label>
            <textarea name="yeucaucv" class="form-control"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Thời gian làm việc:</label>
            <input type="text" name="thoigianlv" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Thông tin khác:</label>
            <textarea name="ttkhac" class="form-control"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Hình ảnh minh họa:</label>
            <input type="file" name="hinhanh" class="form-control">
          </div>

          <div class="mt-4 d-flex justify-content-center gap-3">
            <button type="reset" class="btn btn-danger px-4">Xóa</button>
            <button type="submit" class="btn btn-primary px-4">Đăng</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>
