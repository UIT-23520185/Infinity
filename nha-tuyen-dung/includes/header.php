<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $page_name ?></title>
		<meta charset="utf-8" />
		<meta name="view-port" content="width=device-width, scale=1.0" />
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="../css/style-ntd.css" />
		<script src="../js/jquery.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #6c3eb6;">
		  <div class="container-fluid">
			<a class="navbar-brand fw-bold" href="trang-chu.php">TalentHub</a>
			<div class="collapse navbar-collapse">
			  <ul class="navbar-nav me-auto">
				<li class="nav-item"><a class="dang-tin-menu nav-link" href="dang-tin.php">Đăng tin</a></li>
				<li class="nav-item"><a class="quan-ly-tin-menu nav-link" href="quan-ly-tin.php">Quản lý tin</a></li>
				<li class="nav-item"><a class="tim-ung-vien-menu nav-link" href="tim-ung-vien.php">Tìm ứng viên</a></li>
				<li class="nav-item"><a class="ql-ung-vien-menu nav-link" href="ung-vien-da-luu.php">Ứng viên đã lưu</a></li>
				<li class="nav-item"><a class="quy-trinh-menu nav-link" href="quy-trinh.php">Quy trình</a></li>
			  </ul>
			  <?php if (isset($_SESSION['vaitro'])) { if ($_SESSION['vaitro'] == "nhatuyendung") {?>
				 <a class="btn btn-primary me-2" href="hop-thu.php">Hộp thư</a>
				 <a class="btn btn-danger me-2" href="dang-xuat.php">Đăng xuất</a> 
			  <?php }} else { ?>
			  <a class="btn btn-outline-light me-2" href="dang-ky.php">Đăng kí</a>
			  <a class="btn btn-light me-2" href="dang-nhap.php">Đăng nhập</a>
			  <a class="btn btn-dark" href="../trang-chu.php">Dành cho người tìm việc</a>
			  <?php } ?>
			</div>
		  </div>
		</nav>