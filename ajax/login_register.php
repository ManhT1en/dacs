<?php 
// ==========================================
// FILE: ajax/login_register.php
// MỤC ĐÍCH: Xử lý đăng ký, đăng nhập và khôi phục mật khẩu cho người dùng
// ==========================================

require('../admin/inc/db_config.php');
require('../admin/inc/essentials.php');

// Bật báo cáo lỗi để debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Đặt kiểu nội dung
header('Content-Type: text/plain');

// Ghi log tất cả dữ liệu POST để debug
error_log("POST data received: " . print_r($_POST, true));
if(isset($_FILES['profile'])) {
    error_log("File data received: " . print_r($_FILES['profile'], true));
}

// ==========================================
// CHỨC NĂNG: ĐĂNG KÝ TÀI KHOẢN MỚI
// Xử lý việc đăng ký người dùng mới với thông tin cá nhân và ảnh đại diện
// ==========================================
if(isset($_POST['register'])) {
    try {
        error_log("Registration process started");
        
        // Lọc và làm sạch dữ liệu đầu vào
        $data = filteration($_POST);

        // Kiểm tra tất cả các trường bắt buộc
        if(empty($data['name']) || empty($data['email']) || empty($data['phonenum']) || 
           empty($data['address']) || empty($data['pincode']) || empty($data['dob']) || 
           empty($data['pass']) || empty($data['cpass'])) {
            error_log("Missing required fields");
            echo 'missing_fields';
            exit;
        }

        // Kiểm tra mật khẩu và xác nhận mật khẩu có khớp không
        if($data['pass'] != $data['cpass']) {
            error_log("Password mismatch");
            echo 'pass_mismatch';
            exit;
        }

        // Kiểm tra độ mạnh mật khẩu (tối thiểu 6 ký tự)
        if(strlen($data['pass']) < 6) {
            error_log("Password too short");
            echo 'pass_too_short';
            exit;
        }

        // Kiểm tra định dạng email hợp lệ
        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            error_log("Invalid email format");
            echo 'invalid_email';
            exit;
        }

        // Kiểm tra định dạng số điện thoại (10-15 chữ số)
        if(!preg_match('/^[0-9]{10,15}$/', $data['phonenum'])) {
            error_log("Invalid phone number format");
            echo 'invalid_phone';
            exit;
        }

        // Kiểm tra email hoặc số điện thoại đã tồn tại chưa
        $u_exist = select("SELECT * FROM `user_cred` WHERE `email` = ? OR `phonenum` = ? LIMIT 1", 
                         [$data['email'], $data['phonenum']], "ss");
        
        if(mysqli_num_rows($u_exist) != 0) {
            $u_exist_fetch = mysqli_fetch_assoc($u_exist);
            if($u_exist_fetch['email'] == $data['email']) {
                error_log("Email already exists: " . $data['email']);
                echo 'email_already';
            } else {
                error_log("Phone already exists: " . $data['phonenum']);
                echo 'phone_already';
            }
            exit;
        }

        // Xử lý upload ảnh đại diện
        $profile_image = 'default.jpg'; // Ảnh mặc định nếu không upload
        
        if(isset($_FILES['profile']) && $_FILES['profile']['error'] == 0) {
            error_log("Processing profile image upload");
            
            // Upload ảnh người dùng với định dạng chuẩn JPEG
            $img = uploadUserImage($_FILES['profile']);
            
            if($img == 'inv_img'){
                error_log("Invalid image format");
                echo 'inv_img';
                exit;
            }
            else if($img == 'inv_size'){
                error_log("Image size too large");
                echo 'inv_size';
                exit;
            }
            else if($img == 'upd_failed'){
                error_log("Image upload failed");
                echo 'upd_failed';
                exit;
            }
            else {
                $profile_image = $img;
                error_log("Image uploaded successfully: " . $profile_image);
            }
        } else {
            error_log("No profile image uploaded or upload error");
        }

        // Mã hóa mật khẩu để bảo mật (sử dụng bcrypt)
        $hashed_password = password_hash($data['pass'], PASSWORD_DEFAULT);
        error_log("Password hashed successfully");

        // Thêm thông tin người dùng vào database
        // Lưu ý: is_verified mặc định = 0 (chưa xác thực)
        $query = "INSERT INTO `user_cred` (`name`, `email`, `phonenum`, `address`, `pincode`, `dob`, `password`, `profile`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $values = [$data['name'], $data['email'], $data['phonenum'], $data['address'], $data['pincode'], $data['dob'], $hashed_password, $profile_image];
        
        error_log("Attempting database insert");
        $result = insert($query, $values, 'ssssssss');
        
        if($result) {
            error_log("Registration successful for email: " . $data['email']);
            echo 'registration_success'; // Thành công
        } else {
            error_log("Database insert failed");
            // Nếu insert thất bại, xóa ảnh đã upload để tránh rác
            if($profile_image != 'default.jpg') {
                deleteImage($profile_image, USERS_FOLDER);
                error_log("Cleaned up uploaded image due to database failure");
            }
            echo 'registration_failed'; // Thất bại
        }
        
    } catch (Exception $e) {
        error_log("Registration error: " . $e->getMessage());
        echo 'registration_failed';
    }
    exit;
}

// ==========================================
// CHỨC NĂNG: ĐĂNG NHẬP
// Xác thực người dùng bằng email/số điện thoại và mật khẩu
// ==========================================
if(isset($_POST['login'])) {
    try {
        error_log("Login process started");
        
        // Lọc dữ liệu đầu vào
        $data = filteration($_POST);

        // Kiểm tra các trường bắt buộc
        if(empty($data['email_mob']) || empty($data['pass'])) {
            error_log("Login: Missing required fields");
            echo 'missing_fields';
            exit;
        }

        // Tìm người dùng theo email HOẶC số điện thoại
        $query = "SELECT * FROM `user_cred` WHERE `email` = ? OR `phonenum` = ? LIMIT 1";
        $values = [$data['email_mob'], $data['email_mob']];
        $res = select($query, $values, "ss");

        if(mysqli_num_rows($res) == 1) {
            $row = mysqli_fetch_assoc($res);
            error_log("User found: " . $row['email']);
            
            // Xác thực mật khẩu (hỗ trợ cả mật khẩu đã mã hóa và plain text cũ)
            $password_valid = false;
            if(password_verify($data['pass'], $row['password'])) {
                // Mật khẩu đã được hash đúng cách
                $password_valid = true;
                error_log("Password verified with hash");
            } else if($data['pass'] == $row['password']) {
                // Hỗ trợ mật khẩu plain text cũ (backward compatibility)
                $password_valid = true;
                error_log("Password verified with plain text (legacy)");
                
                // Tự động cập nhật sang mật khẩu đã hash
                $hashed_password = password_hash($data['pass'], PASSWORD_DEFAULT);
                $update_query = "UPDATE `user_cred` SET `password` = ? WHERE `id` = ?";
                update($update_query, [$hashed_password, $row['id']], 'si');
                error_log("Updated plain text password to hash");
            }
            
            if($password_valid) {
                // Tạo session để lưu thông tin đăng nhập
                session_start();
                $_SESSION['login'] = true;              // Đánh dấu đã đăng nhập
                $_SESSION['uId'] = $row['id'];          // ID người dùng
                $_SESSION['uName'] = $row['name'];      // Tên người dùng
                $_SESSION['uPic'] = $row['profile'];    // Ảnh đại diện
                
                error_log("Login successful for user ID: " . $row['id']);
                echo 'login_success'; // Đăng nhập thành công
            } else {
                error_log("Invalid password for user: " . $data['email_mob']);
                echo 'invalid_password'; // Sai mật khẩu
            }
        } else {
            error_log("User not found: " . $data['email_mob']);
            echo 'invalid_email_mob'; // Không tìm thấy tài khoản
        }
        
    } catch (Exception $e) {
        error_log("Login error: " . $e->getMessage());
        echo 'login_failed';
    }
    exit;
}

// ==========================================
// CHỨC NĂNG: KHÔI PHỤC MẬT KHẨU
// Reset mật khẩu bằng token được gửi qua email
// ==========================================
if(isset($_POST['recover_user'])) {
    try {
        error_log("Password recovery process started");
        
        // Lọc dữ liệu đầu vào
        $data = filteration($_POST);
        
        // Kiểm tra token khôi phục có hợp lệ và chưa hết hạn không
        $query = "SELECT * FROM `user_cred` WHERE `email`=? AND `token`=? AND `t_expire`=? LIMIT 1";
        $values = [$data['email'], $data['token'], date("Y-m-d")];
        $res = select($query, $values, 'sss');
        
        if(mysqli_num_rows($res) == 1) {
            // Token hợp lệ, mã hóa mật khẩu mới
            $hashed_password = password_hash($data['pass'], PASSWORD_DEFAULT);
            
            // Cập nhật mật khẩu mới và xóa token
            $update_query = "UPDATE `user_cred` SET `password`=?, `token`=?, `t_expire`=? WHERE `email`=? LIMIT 1";
            $update_values = [$hashed_password, null, null, $data['email']];
            
            if(update($update_query, $update_values, 'ssss')) {
                error_log("Password recovery successful for: " . $data['email']);
                echo 'success'; // Khôi phục thành công
            } else {
                error_log("Password recovery database update failed");
                echo 'failed'; // Cập nhật database thất bại
            }
        } else {
            error_log("Invalid recovery token or expired");
            echo 'failed'; // Token không hợp lệ hoặc đã hết hạn
        }
        
    } catch (Exception $e) {
        error_log("Password recovery error: " . $e->getMessage());
        echo 'failed';
    }
    exit;
}

// If no valid action is found
error_log("No valid action found in POST data");
echo 'invalid_action';
?>