<?php 
// ==========================================
// FILE: ajax/review_room.php
// MỤC ĐÍCH: Gửi đánh giá và nhận xét cho phòng đã đặt
// ==========================================

  require('../admin/inc/db_config.php');
  require('../admin/inc/essentials.php');

  
  session_start();


  // Kiểm tra người dùng đã đăng nhập chưa
  if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
    redirect('index.php');
  }

  // ==========================================
  // CHỨC NĂNG: GỮI ĐÁNH GIÁ & NHẬN XÉT
  // Lưu rating và review cho phòng sau khi lưu trú
  // ==========================================
  if(isset($_POST['review_form']))
  {
    // Lọc dữ liệu đầu vào
    $frm_data = filteration($_POST);

    // Đánh dấu booking đã được review (rate_review = 1)
    $upd_query = "UPDATE `booking_order` SET `rate_review`=? WHERE `booking_id`=? AND `user_id`=?";
    $upd_values = [1,$frm_data['booking_id'],$_SESSION['uId']];
    $upd_result = update($upd_query,$upd_values,'iii');

    // Thêm đánh giá vào bảng rating_review
    $ins_query = "INSERT INTO `rating_review`(`booking_id`, `room_id`, `user_id`, `rating`, `review`)
      VALUES (?,?,?,?,?)";

    $ins_values = [$frm_data['booking_id'],$frm_data['room_id'],$_SESSION['uId'],
      $frm_data['rating'],$frm_data['review']];

    $ins_result = insert($ins_query,$ins_values,'iiiis');

    echo $ins_result; // Trả về 1 nếu thành công, 0 nếu thất bại
  }

?>