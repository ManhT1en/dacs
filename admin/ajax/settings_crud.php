<?php

  // ========================================
  // CÁC THAO TÁC CRUD CHO CÀI ĐẶT
  // Xử lý tất cả quản lý cài đặt admin (thông tin chung, chế độ tắt trang)
  // ========================================

  require('../inc/db_config.php');
  require('../inc/essentials.php');
  adminLogin();

  // ----------------------------------------
  // LẤY CÀI ĐẶT CHUNG
  // Truy xuất tiêu đề trang web và thông tin giới thiệu
  // ----------------------------------------
  if(isset($_POST['get_general'])) {
    $q = "SELECT * FROM `settings` WHERE `sr_no` = ?";
    $values = [1];
    $res = select($q,$values,"i");
    $data = mysqli_fetch_assoc($res);
    $json_data = json_encode($data);
    echo $json_data;
  }

  // ----------------------------------------
  // CẬP NHẬT CÀI ĐẶT CHUNG
  // Cập nhật tiêu đề trang web và mô tả giới thiệu
  // ----------------------------------------
  if(isset($_POST['upd_general'])) {
    $frm_data = filteration($_POST);

    $q = "UPDATE `settings` SET `site_title` = ?, `site_about` = ? WHERE `sr_no` = ?";
    $values = [$frm_data['site_title'],$frm_data['site_about'],1];
    $res = update($q,$values,'ssi');
    echo $res;
  }

  // ----------------------------------------
  // CẬP NHẬT CHỂ ĐỘ TẮT TRANG
  // Bật/tắt chế độ tắt trang web (chế độ bảo trì)
  // ----------------------------------------
  if(isset($_POST['upd_shutdown'])) {
    $frm_data = $_POST['upd_shutdown'];

    $q = "UPDATE `settings` SET `shutdown` = ? WHERE `sr_no` = ?";
    $values = [$frm_data,1];
    $res = update($q,$values,'ii');
    echo $res;
  }

?>