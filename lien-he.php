<!DOCTYPE html>
<html>
<head>
    <title>Liên hệ</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>
   <?php include 'includes/header.php'; ?>

    <div class="container mt-5">
        <h2>Liên hệ với chúng tôi</h2>
        <form>
            <div class="mb-3">
                <label for="name" class="form-label">Họ tên</label>
                <input type="text" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Nội dung</label>
                <textarea class="form-control" id="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Gửi liên hệ</button>
        </form>
    </div>

<?php include 'includes/footer.html'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


