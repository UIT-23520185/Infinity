<?php
include 'includes/header.php';
include 'includes/dbconnection.php';

// Kiểm tra nếu chưa đăng nhập thì redirect về trang đăng nhập
if (!isset($_SESSION['username'])) {
    header('Location: dang-nhap.php');
    exit;
}

$matk = $_SESSION['matk']; // Lấy mã tài khoản từ session
$message = '';

// Lấy tab đang chọn (mặc định là Thông tin cá nhân)
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'thong-tin-ca-nhan';

// Nếu tab là thong-tin-ca-nhan và form được submit
if ($tab === 'thong-tin-ca-nhan' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $tenuv = $_POST['tenuv'];
    $gioitinh = $_POST['gioitinh'] ?? null;
    $chuyenmon = $_POST['chuyenmon'] ?? null;
    $cvht = $_POST['cvht'] ?? null;
    $sonamkn = $_POST['sonamkn'] ?? null;
    $ngaysinh = $_POST['ngaysinh'];

    // Kiểm tra xem ứng viên đã có trong DB chưa
    $stmt = $conn->prepare("SELECT * FROM UNGVIEN WHERE MATK = ?");
    $stmt->execute([$matk]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Cập nhật
        $stmt = $conn->prepare("UPDATE UNGVIEN SET TENUV=?, GIOITINH=?, CHUYENMON=?, CVHT=?, SONAMKN=?, NGAYSINH=? WHERE MATK=?");
        $stmt->execute([$tenuv, $gioitinh, $chuyenmon, $cvht, $sonamkn, $ngaysinh, $matk]);
    } else {
        // Chèn mới
        $ngaydk = date('Y-m-d');
        $stmt = $conn->prepare("INSERT INTO UNGVIEN (TENUV, GIOITINH, CHUYENMON, CVHT, SONAMKN, NGAYSINH, NGDKTK, MATK)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$tenuv, $gioitinh, $chuyenmon, $cvht, $sonamkn, $ngaysinh, $ngaydk, $matk]);
    }

    // Cập nhật họ tên vào bảng TAIKHOAN
    $stmt = $conn->prepare("UPDATE TAIKHOAN SET HOTEN = ? WHERE MATK = ?");
    $stmt->execute([$tenuv, $matk]);

    $message = "Cập nhật thông tin thành công!";
}

// Lấy thông tin ứng viên (để hiển thị form)
$stmt = $conn->prepare("SELECT * FROM UNGVIEN WHERE MATK = ?");
$stmt->execute([$matk]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
// ho so
if ($tab === 'ho-so' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['anhcv']) && $_FILES['anhcv']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['anhcv']['tmp_name'];
        $fileName = $_FILES['anhcv']['name'];
        $fileSize = $_FILES['anhcv']['size'];
        $fileType = $_FILES['anhcv']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Các định dạng được phép
        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];

        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Đặt tên file mới để tránh trùng lặp
            $newFileName = $matk . '_cv.' . $fileExtension;

            // Thư mục upload (bạn tạo thư mục uploads trong dự án)
            $uploadFileDir = './uploads/';
            $dest_path = $uploadFileDir . $newFileName;

            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                // Cập nhật tên file vào DB
                $stmt = $conn->prepare("UPDATE UNGVIEN SET CV_IMAGE = ? WHERE MATK = ?");
                $stmt->execute([$newFileName, $matk]);
                $message = "Ảnh CV đã được cập nhật thành công!";
            } else {
                $error = "Có lỗi xảy ra khi tải lên file.";
            }
        } else {
            $error = "Chỉ cho phép tải lên file: " . implode(", ", $allowedfileExtensions);
        }
    } else {
        $error = "Vui lòng chọn file để tải lên.";
    }
}

// Lấy thông tin ứng viên để hiển thị form và ảnh CV (cập nhật sau khi có thể upload)
$stmt = $conn->prepare("SELECT * FROM UNGVIEN WHERE MATK = ?");
$stmt->execute([$matk]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
//cai dat bao mat
if ($tab === 'cai-dat-bao-mat' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $matkhaucu = trim($_POST['matkhaucu'] ?? '');
    $matkhaumoi = trim($_POST['matkhaumoi'] ?? '');
    $nhaplaimatkhaumoi = trim($_POST['nhaplaimatkhaumoi'] ?? '');

    // Lấy mật khẩu cũ từ DB
    $stmt = $conn->prepare("SELECT PASSWORD FROM TAIKHOAN WHERE MATK = ?");
    $stmt->execute([$matk]);
    $taikhoan = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$taikhoan || $matkhaucu !== $taikhoan['PASSWORD']) {
        $error = "❌ Mật khẩu cũ không đúng.";
    } elseif ($matkhaumoi !== $nhaplaimatkhaumoi) {
        $error = "❌ Mật khẩu mới không khớp.";
    } else {
        $stmt = $conn->prepare("UPDATE TAIKHOAN SET PASSWORD = ? WHERE MATK = ?");
        $stmt->execute([$matkhaumoi, $matk]);
        $message = "✅ Đổi mật khẩu thành công!";
    }
}

function isActive($currentTab, $tabName) {
    return $currentTab === $tabName ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Hồ sơ của tôi - TalentHub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .content-wrapper {
      flex: 1 0 auto;
      display: flex;
      padding: 20px;
      background: #f8f9fa;
    }
    .sidebar {
      width: 250px;
      background-color: #343a40;
      min-height: 500px;
      border-radius: 8px;
    }
    .sidebar .nav-link {
      color: #adb5bd;
      padding: 15px 20px;
      font-weight: 500;
    }
    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
      background-color: #495057;
      color: #fff;
      border-radius: 0 8px 8px 0;
    }
    .profile-content {
      flex-grow: 1;
      margin-left: 20px;
      background-color: #fff;
      border-radius: 8px;
      padding: 30px;
      box-shadow: 0 0 10px rgb(0 0 0 / 0.1);
    }

    /* Style form giống tai-khoan.php */
    label {
      font-weight: bold;
      margin-top: 12px;
      display: block;
    }
    input, select, button {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    button {
      background-color: #4caf50;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 16px;
    }
    button:hover {
      background-color: #45a049;
    }
    .gender-options {
      display: flex;
      gap: 20px;
      margin-top: 5px;
      margin-bottom: 15px;
    }
    .gender-options label {
      font-weight: normal;
    }
    .gender-options input {
      width: auto;
    }
    .alert-success {
      background-color: #d4edda;
      color: #155724;
      padding: 12px;
      border-radius: 5px;
      margin-bottom: 20px;
      border: 1px solid #c3e6cb;
      text-align: center;
    }
  </style>
</head>
<body>

<!-- Nội dung chính -->
<div class="content-wrapper container-fluid">
  <!-- Sidebar -->
  <nav class="sidebar nav flex-column nav-pills">
    <a class="nav-link <?php echo isActive($tab, 'thong-tin-ca-nhan'); ?>" aria-current="page" href="ho-so.php?tab=thong-tin-ca-nhan">Thông tin cá nhân</a>
    <a class="nav-link <?php echo isActive($tab, 'ho-so'); ?>" href="ho-so.php?tab=ho-so">Hồ sơ</a>
    <a class="nav-link <?php echo isActive($tab, 'tin-da-luu'); ?>" href="ho-so.php?tab=tin-da-luu">Tin đã lưu</a>
    <a class="nav-link <?php echo isActive($tab, 'tin-da-ung-tuyen'); ?>" href="ho-so.php?tab=tin-da-ung-tuyen">Tin đã ứng tuyển</a>
    <a class="nav-link <?php echo isActive($tab, 'cai-dat-bao-mat'); ?>" href="ho-so.php?tab=cai-dat-bao-mat">Cài đặt bảo mật</a>
    <a class="nav-link text-danger" href="logout.php">Đăng xuất</a>
  </nav>

<!-- Phần nội dung bên phải -->
<div class="profile-content">
  <?php
    if ($tab === 'thong-tin-ca-nhan') {
  ?>
    <h3>Thông tin ứng viên</h3>
    <?php if (!empty($message)) : ?>
      <div class="alert-success"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" action="ho-so.php?tab=thong-tin-ca-nhan">
        <!-- Các trường nhập -->
        <label for="tenuv">Tên ứng viên:</label>
        <input type="text" id="tenuv" name="tenuv" value="<?php echo htmlspecialchars($row['TENUV'] ?? ''); ?>" required />

        <label>Giới tính:</label>
        <div class="gender-options">
            <input type="radio" id="nam" name="gioitinh" value="Nam" <?php echo (isset($row['GIOITINH']) && $row['GIOITINH'] === 'Nam') ? 'checked' : ''; ?> />
            <label for="nam">Nam</label>

            <input type="radio" id="nu" name="gioitinh" value="Nữ" <?php echo (isset($row['GIOITINH']) && $row['GIOITINH'] === 'Nữ') ? 'checked' : ''; ?> />
            <label for="nu">Nữ</label>

            <input type="radio" id="khac" name="gioitinh" value="Khác" <?php echo (isset($row['GIOITINH']) && $row['GIOITINH'] === 'Khác') ? 'checked' : ''; ?> />
            <label for="khac">Khác</label>
        </div>

        <label for="chuyenmon">Chuyên môn:</label>
        <input type="text" id="chuyenmon" name="chuyenmon" value="<?php echo htmlspecialchars($row['CHUYENMON'] ?? ''); ?>" />

        <label for="cvht">Công việc hiện tại:</label>
        <input type="text" id="cvht" name="cvht" value="<?php echo htmlspecialchars($row['CVHT'] ?? ''); ?>" />

        <label for="sonamkn">Số năm kinh nghiệm:</label>
        <input type="number" id="sonamkn" name="sonamkn" min="0" value="<?php echo htmlspecialchars($row['SONAMKN'] ?? ''); ?>" />

        <label for="ngaysinh">Ngày sinh:</label>
        <input type="date" id="ngaysinh" name="ngaysinh" value="<?php echo htmlspecialchars($row['NGAYSINH'] ?? ''); ?>" required />

        <button type="submit">Cập nhật</button>
    </form>

  <?php
    } elseif ($tab === 'ho-so') {
  ?>
    <h3>Hồ sơ ứng viên</h3>

    <?php if (!empty($message)) : ?>
      <div class="alert-success"><?php echo $message; ?></div>
    <?php elseif (!empty($error)) : ?>
      <div class="alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if (!empty($row['CV_IMAGE'])): ?>
      <p>File CV hiện tại:</p>
      
      <?php
        $cvFile = $row['CV_IMAGE'];
        $cvExtension = strtolower(pathinfo($cvFile, PATHINFO_EXTENSION));
      ?>

      <?php if (in_array($cvExtension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
        <img src="uploads/<?php echo htmlspecialchars($cvFile); ?>" 
             alt="Ảnh CV" 
             style="max-width: 300px; height: auto; border: 1px solid #ccc; padding: 5px;">
      <?php elseif ($cvExtension === 'pdf'): ?>
        <a href="uploads/<?php echo htmlspecialchars($cvFile); ?>" target="_blank">
          <?php echo htmlspecialchars($cvFile); ?>
        </a>
      <?php else: ?>
        <p>Định dạng file không hỗ trợ hiển thị trước.</p>
      <?php endif; ?>
    <?php else: ?>
      <p>Chưa có CV được tải lên.</p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" action="ho-so.php?tab=ho-so">
        <label for="anhcv">Tải lên ảnh CV (PDF, JPG, PNG):</label>
        <input type="file" id="anhcv" name="anhcv" accept=".pdf,.jpg,.jpeg,.png" required />
        <button type="submit">Cập nhật CV</button>
    </form>

  <?php
    } elseif ($tab === 'tin-da-luu') {
      echo "<h3>Danh sách tin đã lưu - đang phát triển</h3>";
    } elseif ($tab === 'tin-da-ung-tuyen') {
      echo "<h3>Danh sách tin đã ứng tuyển - đang phát triển</h3>";
    } elseif ($tab === 'cai-dat-bao-mat') {
  ?>
      <h3>Đổi mật khẩu</h3>
<?php if (!empty($message)) : ?>
    <div class="alert-success" style="color: green; border: 1px solid green; padding: 8px;">
        <?php echo $message; ?>
    </div>
<?php elseif (!empty($error)) : ?>
    <div class="alert-danger" style="color: red; border: 1px solid red; padding: 8px;">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

      <form method="POST" action="ho-so.php?tab=cai-dat-bao-mat">
          <label for="matkhaucu">Mật khẩu hiện tại:</label>
          <input type="password" id="matkhaucu" name="matkhaucu" required>

          <label for="matkhaumoi">Mật khẩu mới:</label>
          <input type="password" id="matkhaumoi" name="matkhaumoi" required>

          <label for="nhaplaimatkhaumoi">Nhập lại mật khẩu mới:</label>
          <input type="password" id="nhaplaimatkhaumoi" name="nhaplaimatkhaumoi" required>

          <button type="submit">Cập nhật mật khẩu</button>
      </form>
  <?php
    } else {
      echo "<h3>Chọn tab ở bên trái để xem thông tin</h3>";
    }
  ?>
</div>
  
</body>
</html>