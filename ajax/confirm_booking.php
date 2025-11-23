<?php 
// ==========================================
// FILE: ajax/confirm_booking.php
// MỤC ĐÍCH: Kiểm tra tính trạng phòng và tính toán chi phí đặt phòng
// ==========================================

  require('../admin/inc/db_config.php');
  require('../admin/inc/essentials.php');

  

  // ==========================================
  // CHỨC NĂNG: KIỂM TRA PHÒNG CÓ SẴN
  // Validate ngày và kiểm tra phòng còn trống không
  // ==========================================
  if(isset($_POST['check_availability']))
  {
    // Lọc dữ liệu đầu vào
    $frm_data = filteration($_POST);
    $status = "";
    $result = "";

    // Validate ngày checkin và checkout

    
    $today_date = new DateTime(date("Y-m-d"));
    $checkin_date = new DateTime($frm_data['check_in']);
    $checkout_date = new DateTime($frm_data['check_out']);

    // Checkin và checkout không được trùng nhau
    if($checkin_date == $checkout_date){
      $status = 'check_in_out_equal';
      $result = json_encode(["status"=>$status]);
    }
    // Checkout phải sau checkin
    else if($checkout_date < $checkin_date){
      $status = 'check_out_earlier';
      $result = json_encode(["status"=>$status]);
    }
    // Checkin không được là ngày quá khứ
    else if($checkin_date < $today_date){
      $status = 'check_in_earlier';
      $result = json_encode(["status"=>$status]);
    }

    // Nếu có lỗi thì trả về lỗi, nếu không thì kiểm tra phòng trống
    if($status!=''){
      echo $result;
    }
    else{
      session_start();

      // Truy vấn kiểm tra số bookings trùng thời gian

      $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
        WHERE booking_status=? AND room_id=?
        AND check_out > ? AND check_in < ?";

      $values = ['booked',$_SESSION['room']['id'],$frm_data['check_in'],$frm_data['check_out']];
      $tb_fetch = mysqli_fetch_assoc(select($tb_query,$values,'siss'));
      
      // Lấy số lượng phòng tổng cộng
      $rq_result = select("SELECT `quantity` FROM `rooms` WHERE `id`=?",[$_SESSION['room']['id']],'i');
      $rq_fetch = mysqli_fetch_assoc($rq_result);

      // Nếu không còn phòng trống
      if(($rq_fetch['quantity']-$tb_fetch['total_bookings'])==0){
        $status = 'unavailable';
        $result = json_encode(['status'=>$status]);
        echo $result;
        exit;
      }

      // Tính số ngày lưu trú và tổng chi phí
      $count_days = date_diff($checkin_date,$checkout_date)->days;
      $payment = $_SESSION['room']['price'] * $count_days;

      // Lưu thông tin vào session
      $_SESSION['room']['payment'] = $payment;
      $_SESSION['room']['available'] = true;
      
      // Trả về kết quả có sẵn với số ngày và tổng tiền
      $result = json_encode(["status"=>'available', "days"=>$count_days, "payment"=> $payment]);
      echo $result;
    }

  }

?>