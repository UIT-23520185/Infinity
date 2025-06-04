<?php include 'includes/header.php';
include 'includes/dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $sql = "SELECT tk.*, vt.TENVT 
            FROM TAIKHOAN tk 
            JOIN VAITROTK vt ON tk.MAVTTK = vt.MAVT 
            WHERE tk.USERNAME = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && $password === $user['PASSWORD']) {
        $_SESSION['username'] = $user['USERNAME'];
        $_SESSION['hoten'] = $user['HOTEN'];
        $_SESSION['vaitro'] = $user['TENVT'];
        $_SESSION['matk'] = $user['MATK'];
        header("Location: trang-chu.php");
        exit();
    } else {
        $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
</head>
<body>


<div class="container mt-5" style="max-width: 500px;">
    <h2 class="mb-4 text-center">Đăng nhập</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Tên đăng nhập</label>
            <input type="text" class="form-control" id="username" name="username" required value="<?php echo htmlspecialchars($_POST['username'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Đăng nhập</button>
    </form>
</div>

<?php include 'includes/footer.html'; ?>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
