<?php 

  // ========================================
  // QUẢN LÝ TÍNH NĂNG & TIỆN ÍCH
  // Tính năng: Thuộc tính phòng (WiFi, TV, v.v.)
  // Tiện ích: Tiện nghi khách sạn với icon SVG (Hồ bơi, Phòng gym, v.v.)
  // ========================================

  require('../inc/db_config.php');
  require('../inc/essentials.php');
  adminLogin();

  // ========================================
  // CÁC THAO TÁC VỚI TÍNH NĂNG
  // ========================================

  // ----------------------------------------
  // THÊM TÍNH NĂNG MỚI
  // Thêm tính năng phòng mới (ví dụ: "Điều hòa nhiệt độ")
  // ----------------------------------------
  if(isset($_POST['add_feature']))
  {
    $frm_data = filteration($_POST);

    $q = "INSERT INTO `features`(`name`) VALUES (?)";
    $values = [$frm_data['name']];
    $res = insert($q,$values,'s');
    echo $res;
  }

  // ----------------------------------------
  // LẤY TẤT CẢ TÍNH NĂNG
  // Truy xuất và hiển thị tất cả tính năng trong bảng
  // ----------------------------------------
  if(isset($_POST['get_features']))
  {
    $res = selectAll('features');
    $i=1;

    while($row = mysqli_fetch_assoc($res))
    {
      echo <<<data
        <tr>
          <td>$i</td>
          <td>$row[name]</td>
          <td>
            <button type="button" onclick="rem_feature($row[id])" class="btn btn-danger btn-sm shadow-none">
              <i class="bi bi-trash"></i> Xoá
            </button>
          </td>
        </tr>
      data;
      $i++;
    }
  }

  // ----------------------------------------
  // XÓA TÍNH NĂNG
  // Xóa tính năng nếu chưa được gán cho bất kỳ phòng nào
  // Trả về: 'room_added' nếu tính năng đang được sử dụng, số dòng bị ảnh hưởng nếu đã xóa
  // ----------------------------------------
  if(isset($_POST['rem_feature']))
  {
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_feature']];

    // Kiểm tra xem tính năng có được gán cho phòng nào không
    $check_q = select('SELECT * FROM `room_features` WHERE `features_id`=?',[$frm_data['rem_feature']],'i');

    if(mysqli_num_rows($check_q)==0){
      $q = "DELETE FROM `features` WHERE `id`=?";
      $res = delete($q,$values,'i');
      echo $res;
    }
    else{
      echo 'room_added';  // Tính năng đang được sử dụng, không thể xóa
    }

  }

  // ========================================
  // CÁC THAO TÁC VỚI TIỆN ÍCH
  // ========================================

  // ----------------------------------------
  // THÊM TIỆN ÍCH MỚI
  // Thêm tiện ích với icon SVG, tên và mô tả
  // ----------------------------------------
  if(isset($_POST['add_facility']))
  {
    $frm_data = filteration($_POST);

    $img_r = uploadSVGImage($_FILES['icon'],FACILITIES_FOLDER);

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
      $q = "INSERT INTO `facilities`(`icon`,`name`, `description`) VALUES (?,?,?)";
      $values = [$img_r,$frm_data['name'],$frm_data['desc']];
      $res = insert($q,$values,'sss');
      echo $res;
    }
  }

  // ----------------------------------------
  // LẤY TẤT CẢ TIỆN ÍCH
  // Truy xuất và hiển thị tất cả tiện ích với icon
  // ----------------------------------------
  if(isset($_POST['get_facilities']))
  {
    $res = selectAll('facilities');
    $i=1;
    $path = FACILITIES_IMG_PATH;

    while($row = mysqli_fetch_assoc($res))
    {
      echo <<<data
        <tr class='align-middle'>
          <td>$i</td>
          <td><img src="$path$row[icon]" width="100px"></td>
          <td>$row[name]</td>
          <td>$row[description]</td>
          <td>
            <button type="button" onclick="rem_facility($row[id])" class="btn btn-danger btn-sm shadow-none">
              <i class="bi bi-trash"></i> Xoá
            </button>
          </td>
        </tr>
      data;
      $i++;
    }
  }

  // ----------------------------------------
  // XÓA TIỆN ÍCH
  // Xóa tiện ích và icon của nó nếu chưa được gán cho bất kỳ phòng nào
  // Trả về: 'room_added' nếu tiện ích đang được sử dụng, 1 nếu đã xóa, 0 nếu thất bại
  // ----------------------------------------
  if(isset($_POST['rem_facility']))
  {
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_facility']];

    // Kiểm tra xem tiện ích có được gán cho phòng nào không
    $check_q = select('SELECT * FROM `room_facilities` WHERE `facilities_id`=?',[$frm_data['rem_facility']],'i');

    if(mysqli_num_rows($check_q)==0)
    {
      $pre_q = "SELECT * FROM `facilities` WHERE `id`=?";
      $res = select($pre_q,$values,'i');
      $img = mysqli_fetch_assoc($res);
  
      if(deleteImage($img['icon'],FACILITIES_FOLDER)){
        $q = "DELETE FROM `facilities` WHERE `id`=?";
        $res = delete($q,$values,'i');
        echo $res;      
      }
      else{
        echo 0;
      }
    }
    else{
      echo 'room_added';  // Tiện ích đang được sử dụng, không thể xóa
    }

  }

?>