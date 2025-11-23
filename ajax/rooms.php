<?php 
// ==========================================
// FILE: ajax/rooms.php
// MỤC ĐÍCH: Hiển thị danh sách phòng với bộ lọc tìm kiếm
// BỘ LỌC: Ngày checkin/checkout, số lượng khách, tiện ích
// ==========================================

  require('../admin/inc/db_config.php');
  require('../admin/inc/essentials.php');
  

  session_start();

  // ==========================================
  // CHỨC NĂNG: LẤY DANH SÁCH PHÒNG VỚI BỘ LỌC
  // Xử lý tìm kiếm phòng theo ngày, số khách, tiện ích
  // ==========================================
  if(isset($_GET['fetch_rooms']))
  {
    // Giải mã dữ liệu kiểm tra tính trạng (check availability)
    $chk_avail = json_decode($_GET['chk_avail'],true);
    
    // Kiểm tra và validate ngày checkin và checkout
    if($chk_avail['checkin']!='' && $chk_avail['checkout']!='')
    {
      $today_date = new DateTime(date("Y-m-d"));
      $checkin_date = new DateTime($chk_avail['checkin']);
      $checkout_date = new DateTime($chk_avail['checkout']);
  
      // Checkin và checkout phải khác nhau
      if($checkin_date == $checkout_date){
        echo"<h3 class='text-center text-danger'>Invalid Dates Entered!</h3>";
        exit;
      }
      // Checkout phải sau checkin
      else if($checkout_date < $checkin_date){
        echo"<h3 class='text-center text-danger'>Invalid Dates Entered!</h3>";
        exit;
      }
      // Checkin không được là ngày quá khứ
      else if($checkin_date < $today_date){
        echo"<h3 class='text-center text-danger'>Invalid Dates Entered!</h3>";
        exit;
      }
    }

    // Giải mã dữ liệu số lượng khách
    $guests = json_decode($_GET['guests'],true);
    $adults = ($guests['adults']!='') ? $guests['adults'] : 0;
    $children = ($guests['children']!='') ? $guests['children'] : 0;

    // Giải mã danh sách tiện ích được chọn
    $facility_list = json_decode($_GET['facility_list'],true);

    // Biến đếm số phòng và chuỗi HTML xuất ra
    $count_rooms = 0;
    $output = "";


    // Lấy cài đặt hệ thống để kiểm tra website có đóng cửa không
    $settings_q = "SELECT * FROM `settings` WHERE `sr_no`=1";
    $settings_r = mysqli_fetch_assoc(mysqli_query($con,$settings_q));


    // Truy vấn phòng theo số lượng khách (người lớn và trẻ em)
    $room_res = select("SELECT * FROM `rooms` WHERE `adult`>=? AND `children`>=? AND `status`=? AND `removed`=?",[$adults,$children,1,0],'iiii');

    while($room_data = mysqli_fetch_assoc($room_res))
    {
      // Kiểm tra phòng có sẵn trong khoảng thời gian đã chọn
      if($chk_avail['checkin']!='' && $chk_avail['checkout']!='')
      {
        // Đếm số bookings trùng thời gian
        $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
          WHERE booking_status=? AND room_id=?
          AND check_out > ? AND check_in < ?";

        $values = ['booked',$room_data['id'],$chk_avail['checkin'],$chk_avail['checkout']];
        $tb_fetch = mysqli_fetch_assoc(select($tb_query,$values,'siss'));

        // Nếu không còn phòng trống, bỏ qua phòng này
        if(($room_data['quantity']-$tb_fetch['total_bookings'])==0){
          continue;
        }
      }

      // get facilities of room with filters
      $fac_count=0;

      $fac_q = mysqli_query($con,"SELECT f.name, f.id FROM `facilities` f 
        INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id 
        WHERE rfac.room_id = '$room_data[id]'");

      $facilities_data = "";
      while($fac_row = mysqli_fetch_assoc($fac_q))
      {
        if( in_array($fac_row['id'],$facility_list['facilities']) ){
          $fac_count++;
        }

        $facilities_data .="<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
          $fac_row[name]
        </span>";
      }

      if(count($facility_list['facilities'])!=$fac_count){
        continue;
      }


      // get features of room

      $fea_q = mysqli_query($con,"SELECT f.name FROM `features` f 
        INNER JOIN `room_features` rfea ON f.id = rfea.features_id 
        WHERE rfea.room_id = '$room_data[id]'");

      $features_data = "";
      while($fea_row = mysqli_fetch_assoc($fea_q)){
        $features_data .="<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
          $fea_row[name]
        </span>";
      }


      // get thumbnail of image

      $room_thumb = ROOMS_IMG_PATH."thumbnail.jpg";
      $thumb_q = mysqli_query($con,"SELECT * FROM `room_images` 
        WHERE `room_id`='$room_data[id]' 
        AND `thumb`='1'");

      if(mysqli_num_rows($thumb_q)>0){
        $thumb_res = mysqli_fetch_assoc($thumb_q);
        $room_thumb = ROOMS_IMG_PATH.$thumb_res['image'];
      }

      $book_btn = "";

      if(!$settings_r['shutdown']){
        $login=0;
        if(isset($_SESSION['login']) && $_SESSION['login']==true){
          $login=1;
        }

        $book_btn = "<button onclick='checkLoginToBook($login,$room_data[id])' class='btn btn-sm w-100 text-white custom-bg shadow-none mb-2'>Đặt ngay</button>";
      }

      // print room card

      $output.="
        <div class='card mb-4 border-0 shadow'>
          <div class='row g-0 p-3 align-items-center'>
            <div class='col-md-5 mb-lg-0 mb-md-0 mb-3'>
              <img src='$room_thumb' class='img-fluid rounded'>
            </div>
            <div class='col-md-5 px-lg-3 px-md-3 px-0'>
              <h5 class='mb-3'>$room_data[name]</h5>
              <div class='features mb-3'>
                <h6 class='mb-1'>Không gian</h6>
                $features_data
              </div>
              <div class='facilities mb-3'>
                <h6 class='mb-1'>Tiện ích</h6>
                $facilities_data
              </div>
              <div class='guests'>
                <h6 class='mb-1'>Số lượng khách</h6>
                <span class='badge rounded-pill bg-light text-dark text-wrap'>
                  $room_data[adult] Người lớn
                </span>
                <span class='badge rounded-pill bg-light text-dark text-wrap'>
                  $room_data[children] Trẻ em
                </span>
              </div>
            </div>
            <div class='col-md-2 mt-lg-0 mt-md-0 mt-4 text-center'>
              <h6 class='mb-4'>$room_data[price] VND / đêm</h6>
              $book_btn
              <a href='room_details.php?id=$room_data[id]' class='btn btn-sm w-100 btn-outline-dark shadow-none'>Chi tiết</a>
            </div>
          </div>
        </div>
      ";

      $count_rooms++;
    }

    if($count_rooms>0){
      echo $output;
    }
    else{
      echo"<h3 class='text-center text-danger'>No rooms to show!</h3>";
    }

  }


?>