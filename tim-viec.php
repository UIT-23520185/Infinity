
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tìm việc - TalentHub</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
</head>
<body>

<?php include 'includes/header.php'; ?>

<!-- Bộ lọc tìm việc -->
<section class="search-bar py-4 mt-5">
  <div class="container bg-light p-4 rounded shadow-sm">
    <h5 class="mb-3 fw-bold">Tìm việc</h5>
    <div class="row g-2">
      <div class="col-md-3">
        <input type="text" class="form-control" placeholder="Chức danh, công ty, từ khoá..." />
      </div>
      <div class="col-md-2">
        <select class="form-select">
          <option selected>Tất cả ngành nghề</option>
        </select>
      </div>
      <div class="col-md-2">
        <select class="form-select">
          <option selected>Tất cả địa điểm</option>
        </select>
      </div>
      <div class="col-md-2">
        <select class="form-select">
          <option>Mức lương</option>
        </select>
      </div>
      <div class="col-md-2">
        <select class="form-select">
          <option>Hình thức</option>
        </select>
      </div>
      <div class="col-md-1">
        <button class="btn btn-primary w-100">Tìm</button>
      </div>
    </div>
  </div>
</section>

<!-- Danh sách công việc -->
<section class="job-list py-5">
  <div class="container">
    <h5 class="fw-bold mb-4">Danh sách công việc mới nhất</h5>

    <div class="job-card p-4 mb-3 border rounded shadow-sm">
      <p class="text-muted">Chưa có dữ liệu công việc để hiển thị.</p>
    </div>
  </div>
</section>

<?php include 'includes/footer.html'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
