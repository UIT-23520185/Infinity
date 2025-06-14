<?php $page_name = "Đăng ký" ?>
<?php include("includes/header.php") ?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="p-5 rounded" style="background-color: #e6f4d4;">
        <h4 class="text-center fw-bold mb-4">Đăng ký</h4>
        <form action="hoan-tat-dang-ky.php" method="post">
          <div class="mb-3">
            <label for="fullname" class="form-label">Họ tên</label>
            <input type="text" class="form-control" name="fullname" placeholder="Nhập họ tên của bạn" required>
          </div>
          <div class="mb-3">
            <label for="username" class="form-label">Tên đăng nhập</label>
            <input type="text" class="form-control" name="username" placeholder="Tên đăng nhập" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" name="password" placeholder="Mật khẩu" required>
          </div>
          <div class="mb-4">
            <label for="confirmPassword" class="form-label">Nhập lại mật khẩu</label>
            <input type="password" class="form-control" name="confirmPassword" placeholder="Nhập lại mật khẩu" required>
          </div>
          <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary">Đăng kí</button>
          </div>
		  <?php if (isset($_GET['message'])) {
			if ($_GET['message'] == "fail_username") {
				echo "<div class=\"text-danger\">Tên đăng nhập đã tồn tại</div>";
			} else {
				echo "<div class=\"text-danger\">Mật khẩu không khớp</div>";
			}
		}?>
          <p class="text-center mb-1">
            Bạn đã có tài khoản. <a href="dang-nhap.php" class="fw-bold text-dark text-decoration-none">Đăng nhập</a><br>
            <a href="trang-chu.php" class="text-decoration-none">Quay về trang chủ</a>
          </p>
          <p class="text-center fst-italic mt-2 mb-0">
            Chính sách bảo mật và Điều khoản dịch vụ
          </p>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include("includes/footer.php") ?>