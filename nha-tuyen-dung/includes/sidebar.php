<div class="card">
        <div class="card-body">
          <a href="quan-ly-lich.php"><button class="btn btn-light w-100 mb-2">Quản lý lịch</button></a>
          <a href="tao-bai-test.php"><button class="btn btn-light w-100 mb-2">Tạo bài test</button></a>
          <a href="danh-sach-bai-test.php"><button class="btn btn-light w-100 mb-2">Danh sách bài test</button></a>
          <a href="../cam-nang.php"><button class="btn btn-light w-100 mb-3">Cẩm nang nghề nghiệp</button></a>
          <?php if (empty($_SESSION)) { ?>
		  <p><strong>Đăng tin tuyển dụng, tìm kiếm ứng viên hiệu quả</strong></p>
		  <ul class="mb-3">
            <li>Đăng tin tuyển dụng miễn phí, đơn giản và nhanh chóng</li>
            <li>Nguồn ứng viên khổng lồ từ nhiều ngành nghề, lĩnh vực khác nhau</li>
          </ul>
          <a href="dang-tin.php"><button class="btn btn-primary w-100 mb-2">Đăng tin ngay</button></a>
          <a href="tim-ung-vien.php"><button class="btn btn-primary w-100">Tìm kiếm ứng viên</button></a>
		  <?php } ?>
        </div>
      </div>