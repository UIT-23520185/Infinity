<?php
$host = "localhost";
$dbname = "qltuyendung";       // ← sửa lại tên CSDL của bạn
$username = "root";      // ← sửa lại tài khoản CSDL của bạn
$password = "Chinh2504@";       // ← sửa lại mật khẩu CSDL

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}
?>