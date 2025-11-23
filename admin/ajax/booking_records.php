<?php 
// ==========================================
// FILE: admin/ajax/booking_records.php
// MỤC ĐÍCH: Quản lý lịch sử đặt phòng đã hoàn tất
// BAO GỒM: Bookings đã checkin, đã hủy + hoàn tiền, thanh toán thất bại
// ==========================================

  require('../inc/db_config.php');
  require('../inc/essentials.php');
  date_default_timezone_set("Asia/Kolkata");
  adminLogin();

  // ==========================================
  // CHỨC NĂNG: LẤY LỊCH SỬ ĐẶT PHÒNG
  // Hiển thị bookings đã hoàn tất với phân trang
  // ==========================================
  if(isset($_POST['get_bookings']))
  {
    // Lọc dữ liệu đầu vào
    $frm_data = filteration($_POST);

    // Cài đặt phân trang (2 records mỗi trang)
    $limit = 2;
    $page = $frm_data['page'];
    $start = ($page-1) * $limit;

    // Truy vấn bookings đã hoàn tất:
    // - booked + arrival=1 (đã checkin)
    // - cancelled + refund=1 (đã hủy và hoàn tiền)
    // - payment failed (thanh toán thất bại)
    $query = "SELECT bo.*, bd.* FROM `booking_order` bo
      INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
      WHERE ((bo.booking_status='booked' AND bo.arrival=1) 
      OR (bo.booking_status='cancelled' AND bo.refund=1)
      OR (bo.booking_status='payment failed')) 
      AND (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?) 
      ORDER BY bo.booking_id DESC";

    // Đếm tổng số records để tính phân trang
    $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%"],'sss');
    
    // Lấy records cho trang hiện tại
    $limit_query = $query ." LIMIT $start,$limit";
    $limit_res = select($limit_query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%"],'sss');

    $total_rows = mysqli_num_rows($res);

    if($total_rows==0){
      $output = json_encode(["table_data"=>"<b>No Data Found!</b>", "pagination"=>'']);
      echo $output;
      exit;
    }

    $i=$start+1;
    $table_data = "";

    // Duyệt qua từng booking và tạo HTML table row
    while($data = mysqli_fetch_assoc($limit_res))
    {
      // Format ngày tháng
      $date = date("d-m-Y",strtotime($data['datentime']));
      $checkin = date("d-m-Y",strtotime($data['check_in']));
      $checkout = date("d-m-Y",strtotime($data['check_out']));

      // Xác định màu badge theo trạng thái
      if($data['booking_status']=='booked'){
        $status_bg = 'bg-success'; // Xanh lá: Đang ở
      }
      else if($data['booking_status']=='cancelled'){
        $status_bg = 'bg-danger'; // Đỏ: Đã hủy
      }
      else{
        $status_bg = 'bg-warning text-dark'; // Vàng: Thanh toán thất bại
      }
      
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
            <br>
            <b>Price:</b> $data[price] VND
          </td>
          <td>
            <b>Check-in:</b> $checkin
            <br>
            <b>Check-out:</b> $checkout
            <br>
            <b>Amount:</b> $data[total_pay] VND
          </td>
          <td>
            <span class='badge $status_bg'>$data[booking_status]</span>
          </td>
          <td>
            <button type='button' class='btn btn-outline-success btn-sm fw-bold shadow-none'>
              <i class='bi bi-file-earmark-arrow-down-fill'></i>
            </button>
          </td>
        </tr>
      ";

      $i++;
    }

    $pagination = "";

    if($total_rows>$limit)
    {
      $total_pages = ceil($total_rows/$limit); 

      if($page!=1){
        $pagination .="<li class='page-item'>
          <button onclick='change_page(1)' class='page-link shadow-none'>First</button>
        </li>";
      }

      $disabled = ($page==1) ? "disabled" : "";
      $prev= $page-1;
      $pagination .="<li class='page-item $disabled'>
        <button onclick='change_page($prev)' class='page-link shadow-none'>Prev</button>
      </li>";


      $disabled = ($page==$total_pages) ? "disabled" : "";
      $next = $page+1;
      $pagination .="<li class='page-item $disabled'>
        <button onclick='change_page($next)' class='page-link shadow-none'>Next</button>
      </li>";

      if($page!=$total_pages){
        $pagination .="<li class='page-item'>
          <button onclick='change_page($total_pages)' class='page-link shadow-none'>Last</button>
        </li>";
      }

    }

    $output = json_encode(["table_data"=>$table_data,"pagination"=>$pagination]);

    echo $output;
  }

?>