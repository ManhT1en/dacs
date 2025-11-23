// Hàm lấy và hiển thị danh sách tất cả người dùng
function get_users() {
  // Tạo đối tượng XMLHttpRequest để gửi yêu cầu AJAX
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/users.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  // Xử lý khi nhận được phản hồi từ server
  xhr.onload = function () {
    // Cập nhật nội dung HTML của bảng với dữ liệu người dùng
    document.getElementById('users-data').innerHTML = this.responseText;
  }

  // Gửi yêu cầu lấy danh sách người dùng
  xhr.send('get_users');
}


// Hàm bật/tắt trạng thái hoạt động của người dùng (active/inactive)
function toggle_status(id, val) {
  // Tạo đối tượng XMLHttpRequest
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/users.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  // Xử lý phản hồi từ server
  xhr.onload = function () {
    if (this.responseText == 1) {
      alert('success', 'Status toggled!');
      get_users(); // Tải lại danh sách người dùng
    }
    else {
      alert('success', 'Server Down!');
    }
  }

  // Gửi yêu cầu thay đổi trạng thái với ID và giá trị mới
  xhr.send('toggle_status=' + id + '&value=' + val);
}

// Hàm xác thực người dùng (đánh dấu is_verified = 1)
function verify_user(user_id) {
  // Hiển thị hộp thoại xác nhận trước khi xác thực
  if (confirm("Bạn có chắc muốn xác thực user này không?")) {
    // Tạo FormData để gửi dữ liệu
    let data = new FormData();
    data.append('user_id', user_id);
    data.append('verify_user', '');

    // Tạo đối tượng XMLHttpRequest
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users.php", true);

    // Xử lý phản hồi từ server
    xhr.onload = function () {
      console.log("Verify response:", this.responseText); // Log debug để kiểm tra
      if (this.responseText == 1) {
        // Xác thực thành công
        alert('success', 'Đã xác thực user thành công!');
        get_users(); // Tải lại danh sách để cập nhật trạng thái
      }
      else {
        // Xác thực thất bại
        alert('error', 'Xác thực user thất bại! Response: ' + this.responseText);
      }
    }
    // Gửi yêu cầu xác thực
    xhr.send(data);
  }
}

// Hàm xóa người dùng và tất cả dữ liệu liên quan (cascade delete)
function remove_user(user_id) {
  // Hiển thị cảnh báo trước khi xóa
  if (confirm("Bạn có chắc muốn xóa user này không? Tất cả dữ liệu liên quan (bookings, reviews) cũng sẽ bị xóa!")) {
    // Tạo FormData để gửi dữ liệu
    let data = new FormData();
    data.append('user_id', user_id);
    data.append('remove_user', '');

    // Tạo đối tượng XMLHttpRequest
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users.php", true);

    // Xử lý phản hồi từ server
    xhr.onload = function () {
      console.log("Server response:", this.responseText); // Log debug
      if (this.responseText == 1) {
        // Xóa thành công
        alert('success', 'Đã xóa user thành công!');
        get_users(); // Tải lại danh sách
      }
      else if (this.responseText == 'verified_user') {
        // User đã xác thực không thể xóa
        alert('error', 'Không thể xóa! User này đã xác thực email.');
      }
      else if (this.responseText.startsWith('error:')) {
        // Hiển thị lỗi cụ thể từ server
        alert('error', 'Lỗi: ' + this.responseText);
      }
      else {
        // Lỗi không xác định
        alert('error', 'Xóa user thất bại! Vui lòng thử lại.');
      }
    }
    // Gửi yêu cầu xóa
    xhr.send(data);
  }
}

// Hàm tìm kiếm người dùng theo tên
function search_user(username) {
  // Tạo đối tượng XMLHttpRequest
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/users.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  // Xử lý phản hồi từ server
  xhr.onload = function () {
    // Cập nhật bảng với kết quả tìm kiếm
    document.getElementById('users-data').innerHTML = this.responseText;
  }

  // Gửi yêu cầu tìm kiếm với từ khóa
  xhr.send('search_user&name=' + username);
}

// Tự động tải danh sách người dùng khi trang được load
window.onload = function () {
  get_users();
}