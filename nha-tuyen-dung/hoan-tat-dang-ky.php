<?php 
$page_name = "Đăng ký";
include("../includes/dbconnection.php"); 

if (!empty($_POST) || !empty($_GET)) {
	if (!empty($_POST)) {
		if (!isset($_POST['tenNTD'])) {
			$fullname = $_POST['fullname'];
			$username = $_POST['username'];

			$stmt = $conn->prepare("select * from taikhoan where USERNAME = :username");
			$stmt->bindParam(':username', $username);
			$stmt->execute();
			$result = $stmt->fetchAll();

			if (count($result) > 0) {
				header("Location: dang-ky.php?message=fail_username");
				exit();
			}

			$password = $_POST['password'];
			$confirmPassword = $_POST['confirmPassword'];
			if ($password != $confirmPassword) {
				header("Location: dang-ky.php?message=fail_password");
				exit();
			}
		} else {
			// Lấy dữ liệu từ form
			$fullname = $_POST['fullname'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			$tenNTD = $_POST['tenNTD'];
			$email = $_POST['email'];
			$diachi = $_POST['diachi'];
			$mavttk = 1;

			// Thêm vào bảng tài khoản
			$sql = "INSERT INTO TAIKHOAN (USERNAME, PASSWORD, HOTEN, MAVTTK, NGDKTK) VALUES (?, ?, ?, ?, CURDATE())";
			$stmt = $conn->prepare($sql);
			$success_taikhoan = $stmt->execute([$username, $password, $fullname, $mavttk]);

			// Lấy mã tài khoản vừa tạo
			$id = 0;
			$sql = "SELECT MATK FROM TAIKHOAN WHERE USERNAME = ?";
			$stmt = $conn->prepare($sql);
			$stmt->execute([$username]);
			$result = $stmt->fetchAll();
			foreach ($result as $row) {
				$id = $row['MATK'];
			}

			// Thêm vào bảng nhà tuyển dụng
			$sql = "INSERT INTO nhatuyendung VALUES (?, ?, ?, ?)";
			$stmt = $conn->prepare($sql);
			$success_ntd = $stmt->execute([$id, $tenNTD, $email, $diachi]);

			// Gửi thư hệ thống nếu tạo thành công
			if ($success_taikhoan && $success_ntd) {
				$sql_mail = "INSERT INTO hop_thu (MANGUOIGUI, MANGUOINHAN, USERNAME_NGUOIGUI, TEN_NGUOIGUI, USERNAME_NGUOINHAN, TIEUDE, THONGDIEP)
							 VALUES (:manguoigui, :manguoinhan, :username_nguoigui, :ten_nguoigui, :username_nguoinhan, :tieude, :thongdiep)";
				$stmt_mail = $conn->prepare($sql_mail);
				$stmt_mail->execute([
					':manguoigui' => 1,
					':manguoinhan' => $id,
					':username_nguoigui' => 'system',
					':ten_nguoigui' => 'Hệ thống',
					':username_nguoinhan' => $username,
					':tieude' => 'Chào mừng',
					':thongdiep' => 'Chúc mừng bạn đã đăng ký thành công tài khoản nhà tuyển dụng'
				]);

				header("Location: hoan-tat-dang-ky.php?message=success");
				exit();
			}
		}
	}
?>
<?php include("includes/header.php") ?>
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="p-5 rounded" style="background-color: #e6f4d4;">
        <h4 class="text-center fw-bold mb-4">Hoàn tất đăng ký doanh nghiệp</h4>
        <form action="#" method="post">
          <div class="mb-3">
            <label for="tenNTD" class="form-label">Tên nhà tuyển dụng</label>
            <input type="hidden" name="fullname" value="<?php if (isset($_POST['fullname'])) echo $_POST['fullname']; ?>">
            <input type="hidden" name="username" value="<?php if (isset($_POST['fullname'])) echo $_POST['username']; ?>">
            <input type="hidden" name="password" value="<?php if (isset($_POST['fullname'])) echo $_POST['password']; ?>">
            <input type="text" class="form-control" name="tenNTD" placeholder="Tên nhà tuyển dụng" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Email" required>
          </div>
          <div class="mb-4">
            <label for="diachi" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" name="diachi" placeholder="Địa chỉ" required>
          </div>
          <div class="d-grid mb-2">
            <button type="submit" class="btn btn-primary">Hoàn tất đăng ký nhà tuyển dụng</button>
          </div>
		  <?php if (isset($_GET['message']) && $_GET['message'] == "success"): ?>
				<div class="text-success">Đăng ký tài khoản thành công.</div>
		  <?php endif; ?>
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
<?php } ?>
