<?php 
// ==========================================
// FILE: ajax/profile.php
// MỤC ĐÍCH: Quản lý thông tin cá nhân người dùng
// BAO GỒM: Cập nhật thông tin, đổi ảnh đại diện, đổi mật khẩu
// ==========================================

  require('../admin/inc/db_config.php');
  require('../admin/inc/essentials.php');

  session_start();

  // Kiểm tra người dùng đã đăng nhập chưa
  if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
    echo 'not_logged_in';
    exit;
  }

  // ==========================================
  // CHỨC NĂNG: CẬP NHẬT THÔNG TIN CÁ NHÂN
  // Cập nhật tên, địa chỉ, số điện thoại, mã bưu điện, ngày sinh
  // ==========================================
  if(isset($_POST['info_form']))
  {
    // Lọc dữ liệu đầu vào
    $frm_data = filteration($_POST);

    // Kiểm tra số điện thoại đã được người khác sử dụng chưa
    $u_exist = select("SELECT * FROM `user_cred` WHERE `phonenum`=? AND `id`!=? LIMIT 1",
      [$frm_data['phonenum'],$_SESSION['uId']],"si");

    if(mysqli_num_rows($u_exist)!=0){
      echo 'phone_already'; // Số điện thoại đã tồn tại
      exit;
    }

    // Cập nhật thông tin người dùng trong database
    $query = "UPDATE `user_cred` SET `name`=?, `address`=?, `phonenum`=?,
      `pincode`=?, `dob`=? WHERE `id`=? LIMIT 1";
    
    $values = [$frm_data['name'],$frm_data['address'],$frm_data['phonenum'],
      $frm_data['pincode'],$frm_data['dob'],$_SESSION['uId']];

    if(update($query,$values,'sssssi')){
      // Cập nhật tên trong session để hiển thị trên giao diện
      $_SESSION['uName'] = $frm_data['name'];
      echo 1; // Cập nhật thành công
    }
    else{
      echo 0; // Cập nhật thất bại
    }
  }

  // ==========================================
  // CHỨC NĂNG: ĐỔI ẢNH ĐẠI DIỆN
  // Upload ảnh mới và xóa ảnh cũ (trừ default.jpg)
  // ==========================================
  if(isset($_POST['profile_form']))
  {
    // Upload ảnh mới với định dạng chuẩn hóa (JPEG 250x250px)
    $img = uploadUserImage($_FILES['profile']);
    
    if($img == 'inv_img'){
      echo 'inv_img'; // Định dạng ảnh không hợp lệ
      exit;
    }
    else if($img == 'upd_failed'){
      echo 'upd_failed'; // Upload thất bại
      exit;
    }

    // Lấy ảnh cũ từ database và xóa nếu không phải default.jpg
    $u_exist = select("SELECT `profile` FROM `user_cred` WHERE `id`=? LIMIT 1",[$_SESSION['uId']],"i");
    $u_fetch = mysqli_fetch_assoc($u_exist);

    if($u_fetch['profile'] != 'default.jpg') {
      deleteImage($u_fetch['profile'],USERS_FOLDER); // Xóa ảnh cũ
    }

    // Cập nhật ảnh mới trong database
    $query = "UPDATE `user_cred` SET `profile`=? WHERE `id`=? LIMIT 1";
    $values = [$img,$_SESSION['uId']];

    if(update($query,$values,'si')){
      // Cập nhật ảnh trong session để hiển thị ngay
      $_SESSION['uPic'] = $img;
      echo 1; // Thành công
    }
    else{
      echo 0; // Thất bại
    }
  }

  // ==========================================
  // CHỨC NĂNG: ĐỔI MẬT KHẨU
  // Thay đổi mật khẩu với xác nhận mật khẩu mới
  // ==========================================
  if(isset($_POST['pass_form']))
  {
    // Lọc dữ liệu đầu vào
    $frm_data = filteration($_POST);

    // Kiểm tra mật khẩu mới và xác nhận mật khẩu khớp nhau
    if($frm_data['new_pass']!=$frm_data['confirm_pass']){
      echo 'mismatch'; // Mật khẩu không khớp
      exit;
    }

    // Mã hóa mật khẩu mới bằng bcrypt
    $enc_pass = password_hash($frm_data['new_pass'],PASSWORD_DEFAULT);

    // Cập nhật mật khẩu mới vào database
    $query = "UPDATE `user_cred` SET `password`=? WHERE `id`=? LIMIT 1";
    $values = [$enc_pass,$_SESSION['uId']];

    if(update($query,$values,'si')){
      echo 1; // Đổi mật khẩu thành công
    }
    else{
      echo 0; // Đổi mật khẩu thất bại
    }
  }
?>