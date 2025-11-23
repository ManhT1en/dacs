<?php 
// ==========================================
// FILE: admin/ajax/refund_bookings.php
// MỤC ĐÍCH: Quản lý hoàn tiền cho bookings đã hủy
// ==========================================

  require('../inc/db_config.php');
  require('../inc/essentials.php');
  adminLogin();

  // ==========================================
  // CHỨC NĂNG: LẤY DANH SÁCH BOOKINGS CHờHOÀN TIỀN
  // Hiển thị các bookings đã hủy nhưng chưa refund
  // ==========================================
  if(isset($_POST['get_bookings']))
  {
    $frm_data = filteration($_POST);

    // Truy vấn bookings cancelled và refund=0 (chưa hoàn tiền)
    $query = "SELECT bo.*, bd.* FROM `booking_order` bo
      INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
      WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?) 
      AND (bo.booking_status=? AND bo.refund=?) ORDER BY bo.booking_id ASC";

    $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%","cancelled",0],'sssss');
    
    $i=1;
    $table_data = "";

    if(mysqli_num_rows($res)==0){
      echo"<b>No Data Found!</b>";
      exit;
    }

    while($data = mysqli_fetch_assoc($res))
    {
      $date = date("d-m-Y",strtotime($data['datentime']));
      $checkin = date("d-m-Y",strtotime($data['check_in']));
      $checkout = date("d-m-Y",strtotime($data['check_out']));

      $table_data .="
        <tr>
          <td>$i</td>
          <td>
            <span class='badge bg-primary'>
              Order ID: $data[order_id]
            </span>
            <br>
            <b>Name:</b> $data[user_name]
            <br>
            <b>Phone No:</b> $data[phonenum]
          </td>
          <td>
            <b>Room:</b> $data[room_name]
          </td>
          <td>
            <b>$data[total_pay] VND</b> 
          </td>
          <td>
            <button type='button' onclick='refund_booking($data[booking_id])' class='btn btn-success btn-sm fw-bold shadow-none'>
              <i class='bi bi-cash-stack'></i> Refund
            </button>
          </td>
        </tr>
      ";

      $i++;
    }

    echo $table_data;
  }

  // ==========================================
  // CHỨC NĂNG: XẬC NHẬN HOÀN TIỀN
  // Cập nhật refund=1 cho booking đã hủy
  // ==========================================
  if(isset($_POST['refund_booking']))
  {
    $frm_data = filteration($_POST);

    // Cập nhật refund=1 (đã hoàn tiền)
    $query = "UPDATE `booking_order` SET `refund`=? WHERE `booking_id`=?";
    $values = [1,$frm_data['booking_id']];
    $res = update($query,$values,'ii');

    echo $res; // Trả về 1 nếu thành công
  }

?>