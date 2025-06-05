<?php
include 'includes/dbconnection.php';
include 'includes/header.php';

// Lấy ID công việc từ URL
$id = $_GET['id'] ?? 0;

if (!$id || !is_numeric($id)) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>ID công việc không hợp lệ.</div></div>";
    include 'includes/footer.html';
    exit;
}

// Truy vấn chi tiết công việc
$sql = "
    SELECT B.*, NTD.TENNTD, NTD.EMAIL, NTD.DIACHI AS DIACHINTD
    FROM BAIDANG B
    JOIN NHATUYENDUNG NTD ON B.MANTD = NTD.MANTD
    WHERE B.MABD = ?
";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$job = $stmt->fetch();

if (!$job) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>Không tìm thấy công việc.</div></div>";
    include 'includes/footer.html';
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= htmlspecialchars($job['TENCV']) ?> - Chi tiết công việc</title>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"/>
</head>
<body>

<section class="job-detail py-5">
    <?php if (!empty($_GET['msg'])): ?>
<div class="container mt-4">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_GET['msg']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
    </div>
</div>
<?php endif; ?>
    <div class="container">
        <div class="bg-white p-4 rounded shadow-sm">
            <h2 class="mb-3"><?= htmlspecialchars($job['TENCV']) ?></h2>
            <p class="text-muted"><strong>Ngành nghề:</strong> <?= htmlspecialchars($job['TENNGANH']) ?></p>
            <p><strong>Hình thức làm việc:</strong> <?= htmlspecialchars($job['HTLV']) ?></p>
            <p><strong>Lương:</strong> <?= htmlspecialchars($job['LUONG']) ?></p>
            <p><strong>Kinh nghiệm:</strong> <?= htmlspecialchars($job['KINHNGHIEM']) ?></p>
            <p><strong>Cấp bậc:</strong> <?= htmlspecialchars($job['CAPBAC']) ?></p>
            <p><strong>Địa chỉ làm việc:</strong> <?= htmlspecialchars($job['DIACHI']) ?></p>
            <p><strong>Thời gian làm việc:</strong> <?= htmlspecialchars($job['THOIGIANLV']) ?></p>

            <?php if (!empty($job['HINHANH'])): ?>
                <img src="uploads/<?= htmlspecialchars($job['HINHANH']) ?>" alt="Hình ảnh công việc" class="img-fluid my-3 rounded" style="max-height: 300px;">
            <?php endif; ?>

            <hr>

            <h5>Phúc lợi</h5>
            <p><?= nl2br(htmlspecialchars($job['PHUCLOI'])) ?></p>

            <h5>Mô tả công việc</h5>
            <p><?= nl2br(htmlspecialchars($job['MOTACV'])) ?></p>

            <h5>Yêu cầu công việc</h5>
            <p><?= nl2br(htmlspecialchars($job['YEUCAUCV'])) ?></p>

            <h5>Thông tin khác</h5>
            <p><?= nl2br(htmlspecialchars($job['TTKHAC'])) ?></p>

            <hr>

            <h5>Thông tin nhà tuyển dụng</h5>
            <p><strong>Tên công ty:</strong> <?= htmlspecialchars($job['TENNTD']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($job['EMAIL']) ?></p>
            <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($job['DIACHINTD']) ?></p>

            <a href="ung-tuyen.php?job_id=<?= $job['MABD'] ?>" class="btn btn-success mt-3">Ứng tuyển ngay</a>
            <a href="luu-tin.php?job_id=<?= $job['MABD'] ?>" class="btn btn-outline-primary mt-3">Lưu tin</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.html'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>