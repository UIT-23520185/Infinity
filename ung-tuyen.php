<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'includes/dbconnection.php';

if (!isset($_SESSION['matk'])) {
    header('Location: login.php?msg=Vui lòng đăng nhập trước khi ứng tuyển!');
    exit;
}

$matk = $_SESSION['matk'];
$job_id = $_GET['job_id'] ?? 0;

// Kiểm tra ID hợp lệ
if (!$job_id || !is_numeric($job_id)) {
    header('Location: index.php?msg=ID công việc không hợp lệ.');
    exit;
}

// Lấy MAUV từ bảng UNGVIEN theo MATK
$sql = "SELECT MAUV FROM UNGVIEN WHERE MATK = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$matk]);
$ungvien = $stmt->fetch();

if (!$ungvien) {
    header('Location: index.php?msg=Không tìm thấy hồ sơ ứng viên.');
    exit;
}

$mauv = $ungvien['MAUV'];

// Kiểm tra đã ứng tuyển chưa
$sql_check = "SELECT * FROM CHITIET_UNGTUYEN WHERE MAUV = ? AND MABD = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->execute([$mauv, $job_id]);

if ($stmt_check->rowCount() > 0) {
    header("Location: chi-tiet-cong-viec.php?id=$job_id&msg=Bạn đã ứng tuyển công việc này trước đó!");
    exit;
}

// Tiến hành lưu ứng tuyển
$sql_insert = "INSERT INTO CHITIET_UNGTUYEN (MAUV, MABD, NGAYUNGTUYEN) VALUES (?, ?, CURDATE())";
$stmt_insert = $conn->prepare($sql_insert);
if ($stmt_insert->execute([$mauv, $job_id])) {
    header("Location: chi-tiet-cong-viec.php?id=$job_id&msg=Ứng tuyển thành công!");
} else {
    header("Location: chi-tiet-cong-viec.php?id=$job_id&msg=Ứng tuyển thất bại, vui lòng thử lại.");
}
?>