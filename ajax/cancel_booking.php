<?php 
// ==========================================
// FILE: ajax/cancel_booking.php
// MỤC ĐÍCH: Hủy đặt phòng của người dùng
// ==========================================

  require('../admin/inc/db_config.php');
  require('../admin/inc/essentials.php');

  
  session_start();


  // Kiểm tra người dùng đã đăng nhập chưa
  if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
    redirect('index.php');
  }

  // ==========================================
  // CHỨC NĂNG: HỦY ĐẶT PHÒNG
  // Cập nhật trạng thái booking thành 'cancelled'
  // ==========================================
  if(isset($_POST['cancel_booking']))
  {
    // Lọc dữ liệu đầu vào
    $frm_data = filteration($_POST);

    // Cập nhật trạng thái booking và đặt refund = 0 (chưa hoàn tiền)
    $query = "UPDATE `booking_order` SET `booking_status`=?, `refund`=? 
      WHERE `booking_id`=? AND `user_id`=?";

    $values = ['cancelled',0,$frm_data['id'],$_SESSION['uId']];

    $result = update($query,$values,'siii');

    echo $result; // Trả về 1 nếu thành công, 0 nếu thất bại
  }

?>