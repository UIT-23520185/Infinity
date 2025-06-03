<?php
session_unset(); // Xóa tất cả biến trong $_SESSION
session_destroy(); // Hủy session

// Xóa cả cookie nếu có
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

header("Location: dang-nhap.php"); // Chuyển về trang đăng nhập
exit();