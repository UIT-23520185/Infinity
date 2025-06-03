<?php 
include 'includes/header.php'; 
include 'includes/dbconnection.php';

$errors = [];
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hoten = trim($_POST['hoten'] ?? '');
    $username = trim($_POST['tendangnhap'] ?? '');
    $password = $_POST['matkhau'] ?? '';
    $repassword = $_POST['nhaplaimatkhau'] ?? '';
    $maVaiTroUngVien = 2;

    // Kiểm tra mật khẩu khớp
    if ($password !== $repassword) {
        $errors[] = "Mật khẩu nhập lại không khớp.";
    }

    // Kiểm tra tên đăng nhập đã tồn tại chưa
    $stmt = $conn->prepare("SELECT * FROM TAIKHOAN WHERE USERNAME = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $errors[] = "Tên đăng nhập đã tồn tại.";
    }

 if (count($errors) === 0) {
    $sql = "INSERT INTO TAIKHOAN (USERNAME, PASSWORD, HOTEN, MAVTTK, NGDKTK) VALUES (?, ?, ?, ?, CURDATE())";
    $stmt = $conn->prepare($sql);
    $success = $stmt->execute([$username, $password, $hoten, $maVaiTroUngVien]);

        if ($success) {
            $successMessage = "Đăng ký thành công. Bạn có thể đăng nhập.";
            // Nếu muốn tự động chuyển trang sau khi đăng ký thành công, có thể dùng header ở đây
            // header("Location: dang-nhap.php");
            // exit();
        } else {
            $errors[] = "Đăng ký thất bại. Vui lòng thử lại.";
        }
    }
  }
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Đăng ký</title>
  <link href="css/bootstrap.min.css" rel="stylesheet" />
  <style>
    /* Giữ nguyên css của bạn */
    .form-container {
      background-color: #e5f5b7;
      padding: 30px;
      border-radius: 15px;
      max-width: 500px;
      margin: auto;
    }
  </style>
</head>
<body>
<div class="container my-5">
  <div class="form-container shadow">
    <h4 class="text-center mb-4"><strong>Đăng ký</strong></h4>

    <?php if (!empty($errors)) : ?>
      <div class="alert alert-danger">
        <?php echo implode('<br>', $errors); ?>
      </div>
    <?php endif; ?>

    <?php if ($successMessage) : ?>
      <div class="alert alert-success">
        <?php echo $successMessage; ?>
      </div>
    <?php endif; ?>

    <form action="" method="post">
      <div class="mb-3">
        <label for="hoten" class="form-label">Họ tên</label>
        <input type="text" class="form-control" id="hoten" name="hoten" value="<?php echo htmlspecialchars($_POST['hoten'] ?? ''); ?>" placeholder="Nhập họ tên của bạn" required />
      </div>
      <div class="mb-3">
        <label for="tendangnhap" class="form-label">Tên đăng nhập</label>
        <input type="text" class="form-control" id="tendangnhap" name="tendangnhap" value="<?php echo htmlspecialchars($_POST['tendangnhap'] ?? ''); ?>" placeholder="Tên đăng nhập" required />
      </div>
      <div class="mb-3">
        <label for="matkhau" class="form-label">Mật khẩu</label>
        <input type="password" class="form-control" id="matkhau" name="matkhau" placeholder="Mật khẩu" required />
      </div>
      <div class="mb-3">
        <label for="nhaplaimatkhau" class="form-label">Nhập lại mật khẩu</label>
        <input type="password" class="form-control" id="nhaplaimatkhau" name="nhaplaimatkhau" placeholder="Nhập lại mật khẩu" required />
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Đăng ký</button>
      </div>
    </form>

    <div class="text-center mt-3">
      <p>Bạn đã có tài khoản? <a href="dang-nhap.php"><strong>Đăng nhập</strong></a></p>
      <p><a href="trang-chu.php">Quay về trang chủ</a></p>
      <p class="fst-italic">Chính sách bảo mật và Điều khoản dịch vụ</p>
    </div>
  </div>
</div>

<?php include 'includes/footer.html'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
