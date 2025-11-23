<?php 

  // QUẢN LÝ HÌNH ẢNH CAROUSEL
  // Xử lý upload, hiển thị và xóa hình ảnh carousel trang chủ


  require('../inc/db_config.php');
  require('../inc/essentials.php');
  adminLogin();

 
  // THÊM HÌNH ẢNH CAROUSEL
  // Upload hình ảnh mới vào thư mục carousel và lưu vào cơ sở dữ liệu
  // Trả về: 1 nếu thành công, mã lỗi nếu thất bại

  if(isset($_POST['add_image']))
  {
    $img_r = uploadImage($_FILES['picture'],CAROUSEL_FOLDER);

    if($img_r == 'inv_img'){
      echo $img_r;  // Định dạng hình ảnh không hợp lệ
    }
    else if($img_r == 'inv_size'){
      echo $img_r;  // Hình ảnh quá lớn
    }
    else if($img_r == 'upd_failed'){
      echo $img_r;  // Upload thất bại
    }
    else{
      $q = "INSERT INTO `carousel`(`image`) VALUES (?)";
      $values = [$img_r];
      $res = insert($q,$values,'s');
      echo $res;
    }
  }

  // ----------------------------------------
  // LẤY TẤT CẢ HÌNH ẢNH CAROUSEL
  // Truy xuất và hiển thị tất cả hình ảnh carousel với nút xóa
  // ----------------------------------------
  if(isset($_POST['get_carousel']))
  {
    $res = selectAll('carousel');

    while($row = mysqli_fetch_assoc($res))
    {
      $path = CAROUSEL_IMG_PATH;
      echo <<<data
        <div class="col-md-4 mb-3">
          <div class="card bg-dark text-white">
            <img src="$path$row[image]" class="card-img">
            <div class="card-img-overlay text-end">
              <button type="button" onclick="rem_image($row[sr_no])" class="btn btn-danger btn-sm shadow-none">
                <i class="bi bi-trash"></i> Xoá
              </button>
            </div>
          </div>
        </div>
      data;
    }
  }

  // ----------------------------------------
  // XÓA HÌNH ẢNH CAROUSEL
  // Xóa file hình ảnh khỏi server và xóa bản ghi trong cơ sở dữ liệu
  // Trả về: 1 nếu thành công, 0 nếu thất bại
  // ----------------------------------------
  if(isset($_POST['rem_image']))
  {
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_image']];

    $pre_q = "SELECT * FROM `carousel` WHERE `sr_no`=?";
    $res = select($pre_q,$values,'i');
    $img = mysqli_fetch_assoc($res);

    if(deleteImage($img['image'],CAROUSEL_FOLDER)){
      $q = "DELETE FROM `carousel` WHERE `sr_no`=?";
      $res = delete($q,$values,'i');
      echo $res;
    }
    else{
      echo 0;
    }

  }

?>