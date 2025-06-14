<?php $page_name = "Đăng ký" ?>
<?php include("includes/header.php") ?>
<div class="container my-5">
  <div class="row">
    <div class="col-md-4 mb-4">
      <?php include("includes/sidebar.php"); ?>
    </div>
    <div class="col-md-8">
            <div class="p-4 rounded" style="background-color: #e5f0b5;">
                <h4 class="mb-4 text-center">Tải lên bài test</h4>

                <form>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Tên bài test:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Tên bài test">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Upload file Word:</label>
                        <div class="col-sm-9">
                            <button type="button" class="btn btn-outline-primary">Tải lên</button>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Link Google Form:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Link Google Form">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Link bài test khác:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Link bài test khác">
                        </div>
                    </div>

                    <div class="mb-4 row">
                        <label class="col-sm-3 col-form-label">Ghi chú:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="4" placeholder="Mô tả công việc"></textarea>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="button" class="btn btn-danger me-3">Xóa</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>

            </div>
    </div>
  </div>
</div>
<?php include("includes/footer.php") ?>
