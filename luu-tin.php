<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'includes/dbconnection.php';
// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['matk'])) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>Bạn cần đăng nhập để lưu tin.</div></div>";
    include 'includes/footer.html';
    exit;
}

$matk = $_SESSION['matk'];

// Lấy MAUV ứng viên tương ứng MATK
$sql = "SELECT MAUV FROM UNGVIEN WHERE MATK = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$matk]);
$result = $stmt->fetch();
if (!$result) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Tài khoản này không phải ứng viên hoặc chưa được cập nhật thông tin ứng viên.</div></div>";
    include 'includes/footer.html';
    exit;
}

$mauv = $result['MAUV']; // <- Tên biến đúng là $mauv

// Lấy ID tin tuyển dụng từ URL
$job_id = $_GET['job_id'] ?? 0;
if (!$job_id || !is_numeric($job_id)) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>ID công việc không hợp lệ.</div></div>";
    include 'includes/footer.html';
    exit;
}

// Kiểm tra xem tin đã được lưu chưa
$checkSql = "SELECT * FROM LUUTIN WHERE MAUV = ? AND MABD = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->execute([$mauv, $job_id]); // <- sửa lại dùng $mauv

if ($checkStmt->rowCount() > 0) {
    header("Location: chi-tiet-cong-viec.php?id=$job_id&msg=Đã lưu tin này trước đó");
    exit;
}

// Lưu tin mới
$insertSql = "INSERT INTO LUUTIN (MAUV, MABD) VALUES (?, ?)";
$insertStmt = $conn->prepare($insertSql);

try {
    $insertStmt->execute([$mauv, $job_id]); // <- sửa lại dùng $mauv
    header("Location: chi-tiet-cong-viec.php?id=$job_id&msg=Lưu tin thành công");
} catch (PDOException $e) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Lỗi khi lưu tin: " . $e->getMessage() . "</div></div>";
}
?>