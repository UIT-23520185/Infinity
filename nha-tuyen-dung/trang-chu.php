<?php $page_name = "Đăng ký" ?>
<?php include("includes/header.php") ?>
<div class="container my-5">
  <div class="row">
    <div class="col-md-4 mb-4">
      <?php include("includes/sidebar.php"); ?>
    </div>
    <div class="col-md-8">
      <div class="p-4 rounded" style="background-color: #e6f4d4;">
        <h5 class="text-center fw-bold mb-4">Bảng xếp hạng nghề nghiệp theo số đơn ứng tuyển</h5>
        <div class="table-responsive">
          <table class="table table-bordered bg-white">
            <thead class="text-center">
              <tr>
                <th scope="col">Top</th>
                <th scope="col">Nhóm nghề nghiệp</th>
                <th scope="col">Số đơn</th>
              </tr>
            </thead>
            <tbody class="text-center">
              <tr><td>1</td><td>Kinh doanh</td><td>1000</td></tr>
              <tr><td>2</td><td>Công nghệ thông tin</td><td>801</td></tr>
              <tr><td>3</td><td>Marketing</td><td>750</td></tr>
              <tr><td>4</td><td>Ngân hàng</td><td>700</td></tr>
              <tr><td>5</td><td>Giáo viên</td><td>681</td></tr>
              <tr><td>6</td><td>Y tế</td><td>640</td></tr>
              <tr><td>7</td><td>Điện lực</td><td>500</td></tr>
              <tr><td>8</td><td>Tài xế</td><td>300</td></tr>
              <tr><td>9</td><td>Luật</td><td>200</td></tr>
              <tr><td>10</td><td>Kế toán</td><td>100</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include("includes/footer.php") ?>