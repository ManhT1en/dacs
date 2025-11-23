<?php 

  require('../inc/db_config.php');
  require('../inc/essentials.php');
  adminLogin();

  if(isset($_POST['get_users']))
  {
    $res = selectAll('user_cred');    
    $i=1;
    $path = USERS_IMG_PATH;

    $data = "";

    while($row = mysqli_fetch_assoc($res))
    {
      $del_btn = "<button type='button' onclick='remove_user($row[id])' class='btn btn-danger shadow-none btn-sm'>
        <i class='bi bi-trash'></i> 
      </button>";

      $verified = "<span class='badge bg-warning'><i class='bi bi-x-lg'></i></span>";
      $verify_btn = "<button type='button' onclick='verify_user($row[id])' class='btn btn-success shadow-none btn-sm me-1'>
        <i class='bi bi-check-circle'></i> Xác thực
      </button>";

      if($row['is_verified']){
        $verified = "<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
        $del_btn = ""; 
        $verify_btn = "";
      }

      $status = "<button onclick='toggle_status($row[id],0)' class='btn btn-dark btn-sm shadow-none'>
        active
      </button>";

      if(!$row['status']){
        $status = "<button onclick='toggle_status($row[id],1)' class='btn btn-danger btn-sm shadow-none'>
          inactive
        </button>";
      }

      $date = date("d-m-Y",strtotime($row['datentime']));

      $data.="
        <tr>
          <td>$i</td>
          <td>
            <img src='$path$row[profile]' width='55px'>
            <br>
            $row[name]
          </td>
          <td>$row[email]</td>
          <td>$row[phonenum]</td>
          <td>$row[address] | $row[pincode]</td>
          <td>$row[dob]</td>
          <td>$verified</td>
          <td>$status</td>
          <td>$date</td>
          <td>$verify_btn $del_btn</td>
        </tr>
      ";
      $i++;
    }

    echo $data;
  }

  if(isset($_POST['toggle_status']))
  {
    $frm_data = filteration($_POST);

    $q = "UPDATE `user_cred` SET `status`=? WHERE `id`=?";
    $v = [$frm_data['value'],$frm_data['toggle_status']];

    if(update($q,$v,'ii')){
      echo 1;
    }
    else{
      echo 0;
    }
  }

  if(isset($_POST['verify_user']))
  {
    $frm_data = filteration($_POST);

    $q = "UPDATE `user_cred` SET `is_verified`=1 WHERE `id`=?";
    $v = [$frm_data['user_id']];

    if(update($q,$v,'i')){
      echo 1;
    }
    else{
      echo 0;
    }
  }

  if(isset($_POST['remove_user']))
  {
    $frm_data = filteration($_POST);
    $user_id = $frm_data['user_id'];

    // Kiểm tra user có được xác thực chưa
    $user_check = select("SELECT * FROM `user_cred` WHERE `id`=? AND `is_verified`=?", [$user_id, 0], 'ii');
    
    if(mysqli_num_rows($user_check) == 0){
      echo 'verified_user'; // User đã xác thực hoặc không tồn tại
      exit;
    }

    // Bắt đầu xóa tất cả dữ liệu liên quan
    $con = $GLOBALS['con'];
    mysqli_begin_transaction($con);

    try {
      // 1. Lấy tất cả booking_id của user này
      $booking_ids = [];
      $bookings = select("SELECT `booking_id` FROM `booking_order` WHERE `user_id`=?", [$user_id], 'i');
      while($row = mysqli_fetch_assoc($bookings)){
        $booking_ids[] = $row['booking_id'];
      }

      // 2. Xóa dữ liệu liên quan nếu có bookings
      if(count($booking_ids) > 0){
        $ids_str = implode(',', $booking_ids);
        
        // Xóa booking_services
        mysqli_query($con, "DELETE FROM `booking_services` WHERE `booking_id` IN ($ids_str)");
        
        // Xóa booking_details
        mysqli_query($con, "DELETE FROM `booking_details` WHERE `booking_id` IN ($ids_str)");
        
        // Xóa rating_review
        mysqli_query($con, "DELETE FROM `rating_review` WHERE `booking_id` IN ($ids_str)");
      }

      // 3. Xóa tất cả bookings của user
      delete("DELETE FROM `booking_order` WHERE `user_id`=?", [$user_id], 'i');

      // 4. Xóa reviews trực tiếp từ user (nếu có)
      delete("DELETE FROM `rating_review` WHERE `user_id`=?", [$user_id], 'i');

      // 5. Cuối cùng xóa user
      $res = delete("DELETE FROM `user_cred` WHERE `id`=?", [$user_id], 'i');

      if($res){
        mysqli_commit($con);
        echo 1;
      } else {
        mysqli_rollback($con);
        echo 0;
      }

    } catch (Exception $e) {
      mysqli_rollback($con);
      echo 'error: ' . $e->getMessage();
    }

  }

  if(isset($_POST['search_user']))
  {
    $frm_data = filteration($_POST);

    $query = "SELECT * FROM `user_cred` WHERE `name` LIKE ?";

    $res = select($query,["%$frm_data[name]%"],'s');    
    $i=1;
    $path = USERS_IMG_PATH;

    $data = "";

    while($row = mysqli_fetch_assoc($res))
    {
      $del_btn = "<button type='button' onclick='remove_user($row[id])' class='btn btn-danger shadow-none btn-sm'>
        <i class='bi bi-trash'></i> 
      </button>";

      $verified = "<span class='badge bg-warning'><i class='bi bi-x-lg'></i></span>";
      $verify_btn = "<button type='button' onclick='verify_user($row[id])' class='btn btn-success shadow-none btn-sm me-1'>
        <i class='bi bi-check-circle'></i> Xác thực
      </button>";

      if($row['is_verified']){
        $verified = "<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
        $del_btn = ""; 
        $verify_btn = "";
      }

      $status = "<button onclick='toggle_status($row[id],0)' class='btn btn-dark btn-sm shadow-none'>
        active
      </button>";

      if(!$row['status']){
        $status = "<button onclick='toggle_status($row[id],1)' class='btn btn-danger btn-sm shadow-none'>
          inactive
        </button>";
      }

      $date = date("d-m-Y",strtotime($row['datentime']));

      $data.="
        <tr>
          <td>$i</td>
          <td>
            <img src='$path$row[profile]' width='55px'>
            <br>
            $row[name]
          </td>
          <td>$row[email]</td>
          <td>$row[phonenum]</td>
          <td>$row[address] | $row[pincode]</td>
          <td>$row[dob]</td>
          <td>$verified</td>
          <td>$status</td>
          <td>$date</td>
          <td>$verify_btn $del_btn</td>
        </tr>
      ";
      $i++;
    }

    echo $data;
  }

?>