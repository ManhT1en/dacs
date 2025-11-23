<?php
  require('inc/essentials.php');
  require('inc/db_config.php');
  adminLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trang quản lý - Dịch vụ</title>
  <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">

  <?php require('inc/header.php'); ?>

  <div class="container-fluid" id="main-content">
    <div class="row">
      <div class="col-lg-10 ms-auto p-4 overflow-hidden">
        <h3 class="mb-4">Dịch vụ</h3>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Danh sách dịch vụ</h5>
              <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-service-modal">
                <i class="bi bi-plus-square"></i> Thêm
              </button>
            </div>

            <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;">
              <table class="table table-hover border">
                <thead>
                  <tr class="bg-dark text-light">
                    <th scope="col">#</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Ảnh</th>
                    <th scope="col">Giá</th>
                    <th scope="col">Mô tả</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Hành động</th>
                  </tr>
                </thead>
                <tbody id="services-data">
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Service Modal -->
  <div class="modal fade" id="add-service-modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="add_service_form">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Thêm dịch vụ</h5>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold">Tên</label>
              <input type="text" name="name" class="form-control shadow-none" required>
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Giá</label>
              <input type="number" min="1" name="price" class="form-control shadow-none" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Mô tả</label>
              <textarea name="desc" class="form-control shadow-none" rows="3"></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Ảnh</label>
              <input type="file" name="image" accept="image/jpeg, image/png, image/webp, image/svg+xml" class="form-control shadow-none" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">HỦY</button>
            <button type="submit" class="btn custom-bg text-white shadow-none">LƯU</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Service Modal -->
  <div class="modal fade" id="edit-service-modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="edit_service_form">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Sửa dịch vụ</h5>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold">Tên</label>
              <input type="text" name="name" class="form-control shadow-none" required>
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Giá</label>
              <input type="number" min="1" name="price" class="form-control shadow-none" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Mô tả</label>
              <textarea name="desc" class="form-control shadow-none" rows="3"></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Ảnh</label>
              <input type="file" name="image" accept="image/jpeg, image/png, image/webp, image/svg+xml" class="form-control shadow-none">
            </div>
            <input type="hidden" name="service_id">
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">HỦY</button>
            <button type="submit" class="btn custom-bg text-white shadow-none">LƯU</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php require('inc/scripts.php'); ?>
  <script src="scripts/services.js"></script>
</body>
</html> 