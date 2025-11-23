<?php

  // ========================================
  // HẰNG SỐ ĐƯỜNG DẪN
  // ========================================
  
  // Đường dẫn URL frontend - dùng để hiển thị hình ảnh trên website
  define('SITE_URL', 'http://localhost/vietchill/');
  define('ABOUT_IMG_PATH',SITE_URL.'images/about/');
  define('CAROUSEL_IMG_PATH',SITE_URL.'images/carousel/');
  define('FACILITIES_IMG_PATH',SITE_URL.'images/facilities/');
  define('ROOMS_IMG_PATH',SITE_URL.'images/rooms/');
  define('USERS_IMG_PATH',SITE_URL.'images/users/');
  define('SERVICES_IMG_PATH',SITE_URL.'images/services/');

  // Đường dẫn server backend - dùng cho thao tác upload file
  define('UPLOAD_IMAGE_PATH',$_SERVER['DOCUMENT_ROOT'].'/vietchill/images/');
  define('ABOUT_FOLDER','about/');
  define('CAROUSEL_FOLDER','carousel/');
  define('FACILITIES_FOLDER','facilities/');
  define('ROOMS_FOLDER','rooms/');
  define('USERS_FOLDER','users/');
  define('SERVICES_FOLDER','services/');

  // ========================================
  // HÀM XÁC THỰC & ĐIỀU HƯỚNG
  // ========================================

  /**
   * Kiểm tra admin đã đăng nhập, chuyển hướng về trang đăng nhập nếu chưa
   * Hàm này nên được gọi ở đầu mọi trang admin được bảo vệ
   */
  /**
   * Kiểm tra admin đã đăng nhập, chuyển hướng về trang đăng nhập nếu chưa
   * Hàm này nên được gọi ở đầu mọi trang admin được bảo vệ
   */
	function adminLogin() {
		session_start();
		if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)){
			echo"<script>window.location.href='index.php'</script>";
			exit;
		}
	}

  /**
   * Chuyển hướng người dùng đến URL được chỉ định bằng JavaScript
   * @param string $url - URL đích để chuyển hướng đến
   */
	function redirect($url) {
		echo "<script>window.location.href='$url'</script>";
		exit;
	}

  /**
   * Hiển thị thông báo Bootstrap alert
   * @param string $type - Loại thông báo: 'success' hoặc 'danger'
   * @param string $msg - Nội dung thông báo cần hiển thị
   */
	function alert($type, $msg) {
		$bs_class = ($type == 'success') ? 'alert-success' : 'alert-danger';
		echo <<<alert
			<div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
				<strong class="me-3">$msg</strong>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		alert;
	}

  // ========================================
  // HÀM UPLOAD HÌNH ẢNH
  // ========================================

  /**
   * Upload và xác thực các file hình ảnh chuẩn (JPEG, PNG, WebP)
   * Kiểm tra loại file và kích thước (tối đa 2MB), tạo tên file ngẫu nhiên
   * @param array $image - Phần tử mảng $_FILES chứa file được upload
   * @param string $folder - Hằng số thư mục đích (ví dụ: ROOMS_FOLDER)
   * @return string - Tên file được tạo nếu thành công, thông báo lỗi nếu thất bại
   */
  function uploadImage($image, $folder) {
    $valid_mime = ['image/jpeg', 'image/png', 'image/webp'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_mime)) {
      return 'Không hỗ trợ định dạng này!';
    } else if (($image['size'] / (1024 * 1024)) > 2) {
      return 'Vui lòng chọn hình ảnh dưới 2MB!';
    } else {
      $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
      $rname = 'IMG_'.random_int(11111,99999).".$ext";
      
      $img_path = UPLOAD_IMAGE_PATH . $folder . $rname;
      
      // Tạo thư mục nếu chưa tồn tại
      $dir = UPLOAD_IMAGE_PATH . $folder;
      if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
      }
      
      if (move_uploaded_file($image['tmp_name'], $img_path)) {
        return $rname;
      } else {
        return 'Tải lên hình ảnh thất bại!';
      }
    }
  }

  /**
   * Xóa file hình ảnh khỏi thư mục được chỉ định
   * Bảo vệ file default.jpg khỏi bị xóa
   * @param string $image - Tên file hình ảnh cần xóa
   * @param string $folder - Hằng số thư mục chứa hình ảnh
   * @return bool - True nếu xóa thành công hoặc là ảnh mặc định, false nếu thất bại
   */
  function deleteImage($image, $folder) {
    if($image == 'default.jpg') {
      return true; // Không xóa ảnh mặc định
    }
    
    $img_path = UPLOAD_IMAGE_PATH.$folder.$image;
    if(file_exists($img_path) && unlink($img_path)){
      return true;
    } else {
      return false;
    }
  }

  /**
   * Upload và xác thực file hình ảnh SVG (dùng cho icon tiện ích)
   * Kiểm tra loại file SVG và kích thước (tối đa 1MB)
   * @param array $image - Phần tử mảng $_FILES chứa file SVG được upload
   * @param string $folder - Hằng số thư mục đích
   * @return string - Tên file được tạo nếu thành công, thông báo lỗi nếu thất bại
   */
  function uploadSVGImage($image,$folder) {
    $valid_mime = ['image/svg+xml'];
    $img_mime = $image['type'];

    if(!in_array($img_mime,$valid_mime)){
      return 'Không hỗ trợ định dạng này!';
    }
    else if(($image['size']/(1024*1024))>1){
      return 'Vui lòng chọn hình ảnh dưới 1MB!';
    }
    else{
      $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
      $rname = 'IMG_'.random_int(11111,99999).".$ext";

      $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
      
      // Tạo thư mục nếu chưa tồn tại
      $dir = UPLOAD_IMAGE_PATH.$folder;
      if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
      }
      
      if(move_uploaded_file($image['tmp_name'],$img_path)){
        return $rname;
      }
      else{
        return 'Tải lên hình ảnh thất bại!';
      }
    }
  }

  /**
   * Upload ảnh đại diện người dùng và chuyển đổi sang định dạng JPEG chuẩn
   * Chấp nhận PNG, WebP và JPEG, chuyển đổi tất cả sang JPEG với chất lượng 75%
   * Kiểm tra loại file và kích thước (tối đa 2MB)
   * @param array $image - Phần tử mảng $_FILES chứa hình ảnh được upload
   * @return string - Tên file được tạo nếu thành công, mã lỗi nếu thất bại
   *                  Mã lỗi: 'inv_img' (loại không hợp lệ), 'inv_size' (quá lớn), 'upd_failed' (upload thất bại)
   */
	function uploadUserImage($image) {
    $valid_mime = ['image/jpeg','image/png','image/webp'];
    $img_mime = $image['type'];

    if(!in_array($img_mime,$valid_mime)){
      return 'inv_img'; // định dạng hình ảnh không hợp lệ
    }
    else if(($image['size']/(1024*1024)) > 2) {
      return 'inv_size'; // hình ảnh quá lớn
    }
    else {
      $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
      $rname = 'IMG_'.random_int(11111,99999).".jpeg";

      $img_path = UPLOAD_IMAGE_PATH.USERS_FOLDER.$rname;

      // Tạo thư mục users nếu chưa tồn tại
      $users_dir = UPLOAD_IMAGE_PATH.USERS_FOLDER;
      if (!is_dir($users_dir)) {
        if (!mkdir($users_dir, 0777, true)) {
          return 'upd_failed';
        }
      }

      // Tạo tài nguyên hình ảnh dựa trên loại file
      $img = false;
      if($ext == 'png' || $ext == 'PNG') {
        $img = imagecreatefrompng($image['tmp_name']);
      }
      else if($ext == 'webp' || $ext == 'WEBP') {
        $img = imagecreatefromwebp($image['tmp_name']);
      }
      else if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'JPG' || $ext == 'JPEG') {
        $img = imagecreatefromjpeg($image['tmp_name']);
      }

      if($img === false) {
        return 'upd_failed';
      }

      // Chuyển đổi sang JPEG và lưu
      if(imagejpeg($img, $img_path, 75)){
        imagedestroy($img); // Giải phóng bộ nhớ
        return $rname;
      }
      else{
        if($img) imagedestroy($img);
        return 'upd_failed';
      }
    }
  }

  /**
   * Tạo ảnh đại diện người dùng mặc định nếu chưa tồn tại
   * Tạo hình placeholder màu xám 100x100 với chữ "USER" ở định dạng JPEG
   * Được gọi tự động khi file này được include
   */
  function createDefaultUserImage() {
    $default_path = UPLOAD_IMAGE_PATH.USERS_FOLDER.'default.jpg';
    
    if (!file_exists($default_path)) {
      // Tạo thư mục users nếu chưa tồn tại
      $users_dir = UPLOAD_IMAGE_PATH.USERS_FOLDER;
      if (!is_dir($users_dir)) {
        mkdir($users_dir, 0777, true);
      }
      
      // Tạo hình ảnh mặc định đơn giản (hình vuông xám 100x100)
      $img = imagecreate(100, 100);
      $bg = imagecolorallocate($img, 200, 200, 200);
      $text_color = imagecolorallocate($img, 100, 100, 100);
      
      // Thêm chữ
      imagestring($img, 3, 25, 40, 'USER', $text_color);
      
      // Lưu dưới dạng JPEG
      imagejpeg($img, $default_path, 75);
      imagedestroy($img);
    }
  }

  // Gọi hàm này để đảm bảo ảnh mặc định tồn tại
  createDefaultUserImage();
?>