<?php
  require('../inc/essentials.php');
  require('../inc/db_config.php');
  adminLogin();

  if(isset($_POST['get_bookings']))
  {
    $frm_data = filteration($_POST);

    $query = "SELECT bo.*, bd.* FROM `booking_order` bo
      INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
      WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?) 
      AND ((bo.booking_status=?) OR (bo.booking_status=? AND bo.arrival=?))
      ORDER BY bo.booking_id ASC";
    
    $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%",'pending','booked',0],'sssssi');
    $i=1;
    $table_data = "";

    if(mysqli_num_rows($res)==0){
      echo"<tr><td colspan='6' class='text-center'>No Data Found!</td></tr>";
      exit;
    }

    while($data = mysqli_fetch_assoc($res))
    {
      $date = date("d-m-Y",strtotime($data['datentime']));
      $checkin = date("d-m-Y",strtotime($data['check_in']));
      $checkout = date("d-m-Y",strtotime($data['check_out']));

      if($data['booking_status'] == 'pending') {
        $status_bg = 'bg-warning';
      } else {
        $status_bg = 'bg-success';
      }

      $services_q = mysqli_query($con, "SELECT s.name, bs.quantity FROM `booking_services` bs INNER JOIN `services` s ON bs.service_id = s.id WHERE bs.booking_id = {$data['booking_id']}");
      $services_data = "";
      if(mysqli_num_rows($services_q) > 0){
        while($s_row = mysqli_fetch_assoc($services_q)){
          $services_data .= "$s_row[name] (x$s_row[quantity])<br>";
        }
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
            <b>Price:</b> ".number_format($data['price'])." VND
          </td>
          <td>
            <b>Check-in:</b> $checkin
            <br>
            <b>Check-out:</b> $checkout
            <br>
            <b>Paid:</b> ".number_format($data['total_pay'])." VND
            <br>
            <b>Date:</b> $date
            <br>
            <b>Status:</b> <span class='badge $status_bg'>$data[booking_status]</span>
          </td>
          <td>$services_data</td>
          <td>
            <button type='button' onclick='assign_room($data[booking_id])' class='btn btn-sm btn-primary shadow-none' data-bs-toggle='modal' data-bs-target='#assign-room'>
              <i class='bi bi-check2-square'></i> Assign Room
            </button>
            <br>
            <button type='button' onclick='add_service_to_booking($data[booking_id])' class='btn btn-sm btn-info shadow-none mt-2' data-bs-toggle='modal' data-bs-target='#add-service-booking-modal'>
              <i class='bi bi-plus-square'></i> Add Service
            </button>
            <br>
            <button type='button' onclick='cancel_booking($data[booking_id])' class='btn btn-sm btn-danger shadow-none mt-2'>
              <i class='bi bi-trash'></i> Cancel Booking
            </button>
          </td>
        </tr>
      ";
      $i++;
    }
    echo $table_data;
  }

  if(isset($_POST['get_all_services']))
  {
    $res = select("SELECT * FROM `services` WHERE `status`=? AND `removed`=?", [1,0], 'ii');
    $data = "";

    if(mysqli_num_rows($res) == 0){
        echo "<div class='col-12 text-center'>Không tìm thấy dịch vụ nào đang hoạt động.</div>";
        exit;
    }

    $path = SERVICES_IMG_PATH;
    while($row = mysqli_fetch_assoc($res)){
      $data.="
        <div class='col-md-4 mb-3'>
            <div class='card h-100'>
                <img src='$path$row[image]' class='card-img-top' style='height: 150px; object-fit: cover;'>
                <div class='card-body'>
                    <div class='d-flex justify-content-between align-items-center mb-2'>
                        <h6 class='card-title mb-0'>$row[name]</h6>
                        <div class='form-check'>
                            <input class='form-check-input' type='checkbox' name='services' value='$row[id]' id='service-$row[id]'>
                        </div>
                    </div>
                    <p class='card-text mb-2'>".number_format($row['price'])." VND</p>
                    <div class='input-group input-group-sm'>
                        <span class='input-group-text'>Số lượng</span>
                        <input type='number' name='quantity_".$row['id']."' class='form-control shadow-none' value='1' min='1'>
                    </div>
                </div>
            </div>
        </div>
      ";
    }
    echo $data;
  }
  
  if(isset($_POST['add_service_to_booking_form']))
  {
    // Filter all data except services
    $frm_data = filteration($_POST);
    unset($frm_data['services']);

    // Manually handle services JSON string
    $services_json = $_POST['services'];
    $booking_id = $frm_data['booking_id'];
    $services = json_decode($services_json, true);

    // Check if JSON decoding was successful
    if (json_last_error() !== JSON_ERROR_NONE) {
        // Handle JSON error, maybe log it and send back an error response
        echo 0;
        exit;
    }
    
    $total_service_cost = 0;

    if (is_array($services) && count($services) > 0) {
        mysqli_begin_transaction($con);
        try {
            foreach($services as $service){
                // Sanitize each part of the service array
                $service_id = filter_var($service['id'], FILTER_VALIDATE_INT);
                $quantity = filter_var($service['quantity'], FILTER_VALIDATE_INT);

                if($service_id === false || $quantity === false || $quantity < 1) {
                    throw new Exception("Invalid service data provided.");
                }

                $s_res = select("SELECT `price` FROM `services` WHERE `id`=?", [$service_id], 'i');
                if(mysqli_num_rows($s_res) == 0){
                    throw new Exception("Service ID $service_id not found!");
                }
                $s_row = mysqli_fetch_assoc($s_res);
                $price = $s_row['price'];
                
                $total_service_cost += $price * $quantity;

                $q = "INSERT INTO `booking_services`(`booking_id`, `service_id`, `price`, `quantity`) VALUES (?,?,?,?)";
                $stmt = mysqli_prepare($con, $q);
                mysqli_stmt_bind_param($stmt, 'iiii', $booking_id, $service_id, $price, $quantity);
                if(!mysqli_stmt_execute($stmt)){
                    throw new Exception("Insert failed! Error: " . mysqli_stmt_error($stmt));
                }
            }

            if ($total_service_cost > 0) {
                $q_update = "UPDATE `booking_details` SET `total_pay` = `total_pay` + ? WHERE `booking_id` = ?";
                $stmt_update = mysqli_prepare($con, $q_update);
                mysqli_stmt_bind_param($stmt_update, 'di', $total_service_cost, $booking_id);
                if(!mysqli_stmt_execute($stmt_update)){
                    throw new Exception("Update total_pay failed! Error: " . mysqli_stmt_error($stmt_update));
                }
            }
            
            mysqli_commit($con);
            echo 1;

        } catch (Exception $e) {
            mysqli_rollback($con);
            echo 0;
        }

    } else {
        // This case handles empty services array, which is not an error.
        echo 1;
    }
  }

  if(isset($_POST['assign_room']))
  {
    $frm_data = filteration($_POST);

    $query = "UPDATE `booking_order` bo
      INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
      SET bo.booking_status = ?, bo.arrival = ?, bo.rate_review = ?, bd.room_no = ?
      WHERE bo.booking_id = ?";
      
    $values = ['booked', 1, 0, $frm_data['room_no'], $frm_data['booking_id']];
    $res = update($query, $values, 'siisi');
    
    echo ($res > 0) ? 1 : 0;
  }

  if(isset($_POST['cancel_booking']))
  {
    $frm_data = filteration($_POST);
    $query = "UPDATE `booking_order` SET `booking_status`=?, `refund`=? WHERE `booking_id`=?";
    $values = ['cancelled',0,$frm_data['booking_id']];
    $res = update($query, $values, 'sii');
    echo $res;
  }
?>