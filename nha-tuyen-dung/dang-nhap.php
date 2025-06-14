<?php $page_name = "Đăng ký" ?>
<?php include("../includes/dbconnection.php"); ?>
<?php include("includes/header.php") ?>
<?php if (!empty($_POST)) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$sql = "select * from TAIKHOAN where USERNAME = ? and PASSWORD = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$username, $password]);
	$result = $stmt->fetchAll();
	if (count($result) > 0) {
		foreach ($result as $row)
        $_SESSION['username'] = $row['USERNAME'];
        $_SESSION['hoten'] = $row['HOTEN'];
        $_SESSION['vaitro'] = "nhatuyendung";
        $_SESSION['matk'] = $row['MATK'];
		header("Location: trang-chu.php");
		exit();
	} else {
		header("Location: dang-nhap.php?message=fail");
		exit();
	}
}?>
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="p-5 bg-light rounded" style="background-color: #e6f4d4 !important;">
        <h4 class="text-center mb-4 fw-bold">Đăng nhập</h4>

        <form action="#" method="post">
          <div class="mb-3">
            <label for="username" class="form-label fw-semibold">Tên đăng nhập</label>
            <input type="text" class="form-control" name="username" placeholder="Tên đăng nhập" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Mật khẩu</label>
            <input type="password" class="form-control" name="password" placeholder="Mật khẩu" required>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-3">
            <div></div>
            <a href="#" class="text-decoration-none fw-semibold" style="font-size: 0.9rem;">Quên mật khẩu?</a>
          </div>

          <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary fw-bold">Đăng nhập</button>
          </div>
<?php if (isset($_GET['message'])) {
			if ($_GET['message'] == "fail") {
				echo "<div class=\"text-danger\">Sai tên đăng nhập và mật khẩu</div>";
			}
		}?>
          <p class="text-center">
            Bạn chưa có tài khoản. <a href="dang-ky.php" class="fw-bold">Đăng kí</a><br>
            <a href="trang-chu.php" class="fw-semibold">Quay về trang chủ</a>
          </p>

          <p class="text-center fst-italic mt-3" style="font-size: 0.85rem;">
            Chính sách bảo mật và Điều khoản dịch vụ
          </p>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include("includes/footer.php") ?>