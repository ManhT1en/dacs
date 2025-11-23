<?php
  require('../inc/db_config.php');
  require('../inc/essentials.php');
  adminLogin();

  if(isset($_POST['add_service']))
  {
    $frm_data = filteration($_POST);

    $img_r = uploadImage($_FILES['image'], SERVICES_FOLDER);

    if($img_r == 'inv_img'){
      echo $img_r;
    }
    else if($img_r == 'inv_size'){
      echo $img_r;
    }
    else if($img_r == 'upd_failed'){
      echo $img_r;
    }
    else{
      $q = "INSERT INTO `services`(`name`, `price`, `description`, `image`) VALUES (?,?,?,?)";
      $values = [$frm_data['name'], $frm_data['price'], $frm_data['desc'], $img_r];
      $res = insert($q, $values, 'siss');
      echo $res;
    }
  }

  if(isset($_POST['get_services']))
  {
    $res = select("SELECT * FROM `services` WHERE `removed`=?", [0], 'i');
    $i=1;
    $path = SERVICES_IMG_PATH;

    $data = "";

    while($row = mysqli_fetch_assoc($res))
    {
      $status = ($row['status'] == 1) 
        ? "<button onclick='toggle_status($row[id],0)' class='btn btn-success btn-sm shadow-none'>active</button>"
        : "<button onclick='toggle_status($row[id],1)' class='btn btn-warning btn-sm shadow-none'>inactive</button>";

      $data.="
        <tr class='align-middle'>
          <td>$i</td>
          <td>$row[name]</td>
          <td><img src='$path$row[image]' width='100px'></td>
          <td>$row[price] VND</td>
          <td>$row[description]</td>
          <td>$status</td>
          <td>
            <button type='button' onclick='get_service($row[id])' class='btn btn-primary shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#edit-service-modal'>
              <i class='bi bi-pencil-square'></i>
            </button>
            <button type='button' onclick='remove_service($row[id])' class='btn btn-danger shadow-none btn-sm'>
              <i class='bi bi-trash'></i>
            </button>
          </td>
        </tr>
      ";
      $i++;
    }
    echo $data;
  }

  if(isset($_POST['toggle_status']))
  {
    $frm_data = filteration($_POST);
    $q = "UPDATE `services` SET `status`=? WHERE `id`=?";
    $v = [$frm_data['value'], $frm_data['toggle_status']];
    if(update($q,$v,'ii')){
      echo 1;
    } else {
      echo 0;
    }
  }

  if(isset($_POST['get_service']))
  {
    $frm_data = filteration($_POST);
    $res = select("SELECT * FROM `services` WHERE `id`=?", [$frm_data['get_service']], 'i');
    $servicedata = mysqli_fetch_assoc($res);
    $data = ["servicedata" => $servicedata];
    $json_data = json_encode($data);
    echo $json_data;
  }

  if(isset($_POST['edit_service']))
  {
    $frm_data = filteration($_POST);
    $flag = 0;

    if(isset($_FILES['image'])){
      $img_r = uploadImage($_FILES['image'],SERVICES_FOLDER);
      if($img_r == 'inv_img' || $img_r == 'inv_size' || $img_r == 'upd_failed'){
        echo $img_r;
        exit;
      }
      $q = "UPDATE `services` SET `name`=?, `price`=?, `description`=?, `image`=? WHERE `id`=?";
      $values = [$frm_data['name'], $frm_data['price'], $frm_data['desc'], $img_r, $frm_data['service_id']];
      if(update($q, $values, 'sissi')){
        $flag = 1;
      }
    }
    else{
      $q = "UPDATE `services` SET `name`=?, `price`=?, `description`=? WHERE `id`=?";
      $values = [$frm_data['name'], $frm_data['price'], $frm_data['desc'], $frm_data['service_id']];
      if(update($q, $values, 'sisi')){
        $flag = 1;
      }
    }

    if($flag){
      // Also delete the old image if a new one was uploaded
      if(isset($_FILES['image'])){
        $res = select("SELECT `image` FROM `services` WHERE `id`=?", [$frm_data['service_id']], 'i');
        $img = mysqli_fetch_assoc($res)['image'];
        if($img != $img_r){
          deleteImage($img, SERVICES_FOLDER);
        }
      }
      echo 1;
    }
    else{
      echo 0;
    }
  }

  if(isset($_POST['remove_service']))
  {
    $frm_data = filteration($_POST);

    $res = select("SELECT `image` FROM `services` WHERE `id`=?", [$frm_data['remove_service']], 'i');
    $img = mysqli_fetch_assoc($res)['image'];
    
    if(deleteImage($img, SERVICES_FOLDER)){
      $q = "UPDATE `services` SET `removed`=? WHERE `id`=?";
      $v = [1, $frm_data['remove_service']];
      if(update($q,$v,'ii')){
        echo 1;
      } else {
        echo 0;
      }
    }
    else {
      echo 0;
    }
  }
?> 