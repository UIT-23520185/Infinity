<?php
include 'includes/header.php';
include 'includes/dbconnection.php';


$username = $_SESSION['username'] ?? '';
$row = null;

if ($username) {
    // Lấy dữ liệu ứng viên theo TENUV
    $sql = "SELECT * FROM UNGVIEN WHERE TENUV = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Lấy dữ liệu từ form
    $tenuv = $_POST['tenuv'] ?? '';
    $gioitinh = $_POST['gioitinh'] ?? '';
    $chuyenmon = $_POST['chuyenmon'] ?? '';
    $cvht = $_POST['cvht'] ?? '';
    $sonamkn = $_POST['sonamkn'] ?? null;
    $ngaysinh = $_POST['ngaysinh'] ?? '';

    // Validate đơn giản
    $errors = [];
    if (!$tenuv) $errors[] = "Tên ứng viên không được để trống.";
    if (!in_array($gioitinh, ['Nam', 'Nữ', 'Khác'])) $errors[] = "Giới tính không hợp lệ.";
    if (!$ngaysinh) $errors[] = "Ngày sinh không được để trống.";
    if ($sonamkn !== null && (!is_numeric($sonamkn) || $sonamkn < 0)) $errors[] = "Số năm kinh nghiệm phải là số không âm.";

    if (empty($errors)) {
        if ($row) {
            // Cập nhật
            $update_sql = "UPDATE UNGVIEN SET TENUV = ?, GIOITINH = ?, CHUYENMON = ?, CVHT = ?, SONAMKN = ?, NGAYSINH = ? WHERE TENUV = ?";
            $stmt = $conn->prepare($update_sql);
            $ok = $stmt->execute([$tenuv, $gioitinh, $chuyenmon, $cvht, $sonamkn, $ngaysinh, $username]);
            if ($ok) {
                echo "<script>alert('Cập nhật thành công!'); window.location.reload();</script>";
                $_SESSION['username'] = $tenuv;
            } else {
                echo "<script>alert('Cập nhật thất bại!');</script>";
            }
        } else {
            // Thêm mới
            $insert_sql = "INSERT INTO UNGVIEN (TENUV, GIOITINH, CHUYENMON, CVHT, SONAMKN, NGAYSINH, NGDKTK) VALUES (?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($insert_sql);
            $ok = $stmt->execute([$tenuv, $gioitinh, $chuyenmon, $cvht, $sonamkn, $ngaysinh]);
            if ($ok) {
                echo "<script>alert('Thêm thông tin thành công!'); window.location.reload();</script>";
                $_SESSION['username'] = $tenuv;
            } else {
                echo "<script>alert('Thêm thông tin thất bại!');</script>";
            }
        }
    } else {
        $error_msg = implode("\\n", $errors);
        echo "<script>alert('$error_msg');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Thông tin ứng viên</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f9fbe7;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 700px;
            margin: 50px auto;
            padding: 25px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
        }
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
    </style>
</head>
<body>
<div class="container">
    <h2>Thông tin ứng viên</h2>
    <form method="POST" action="">
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

        <label for="cvht">Cố vấn học tập (CVHT):</label>
        <input type="text" id="cvht" name="cvht" value="<?php echo htmlspecialchars($row['CVHT'] ?? ''); ?>" />

        <label for="sonamkn">Số năm kinh nghiệm:</label>
        <input type="number" id="sonamkn" name="sonamkn" min="0" value="<?php echo htmlspecialchars($row['SONAMKN'] ?? ''); ?>" />

        <label for="ngaysinh">Ngày sinh:</label>
        <input type="date" id="ngaysinh" name="ngaysinh" value="<?php echo htmlspecialchars($row['NGAYSINH'] ?? ''); ?>" required />

        <label for="ngaydk">Ngày đăng ký:</label>
        <input type="text" id="ngaydk" value="<?php echo htmlspecialchars($row['NGDKTK'] ?? ''); ?>" disabled />

        <button type="submit">Lưu thông tin</button>
    </form>
</div>

<?php include 'includes/footer.html'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
