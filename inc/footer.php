<div class="container-fluid bg-white mt-5">
  <div class="row">
    <div class="col-lg-4 p-4">
      <h3 class="h-font fw-bold fs-3 mb-2"><?php echo $settings_r['site_title'] ?></h3>
      <p>
        <?php echo $settings_r['site_about'] ?>
      </p>
    </div>
    <div class="col-lg-4 p-4">
      <h5 class="mb-3">Liên kết</h5>
      <a href="index.php" class="d-inline-block mb-2 text-dark text-decoration-none">Trang chủ</a> <br>
      <a href="rooms.php" class="d-inline-block mb-2 text-dark text-decoration-none">Danh sách phòng</a> <br>
      <a href="facilities.php" class="d-inline-block mb-2 text-dark text-decoration-none">Tiện ích</a> <br>
      <a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none">Liên hệ</a> <br>
      <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">Về chúng tôi</a>
    </div>
    <div class="col-lg-4 p-4">
        <h5 class="mb-3">Theo dõi chúng tôi</h5>
        <?php 
          if($contact_r['tw']!=''){
            echo<<<data
              <a href="$contact_r[tw]" class="d-inline-block text-dark text-decoration-none mb-2">
                <i class="bi bi-twitter me-1"></i> Twitter
              </a><br>
            data;
          }
        ?>
        <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block text-dark text-decoration-none mb-2">
          <i class="bi bi-facebook me-1"></i> Facebook
        </a><br>
        <a href="<?php echo $contact_r['insta'] ?>" class="d-inline-block text-dark text-decoration-none">
          <i class="bi bi-instagram me-1"></i> Instagram
        </a><br>
    </div>
  </div>
</div>

<h6 class="text-center bg-dark text-white p-3 m-0">Website Đặt phòng khách sạn và Homestay</h6>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>

  function alert(type,msg,position='body')
  {
    let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
    let element = document.createElement('div');
    element.innerHTML = `
      <div class="alert ${bs_class} alert-dismissible fade show" role="alert">
        <strong class="me-3">${msg}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    `;

    if(position=='body'){
      document.body.append(element);
      element.classList.add('custom-alert');
    }
    else{
      document.getElementById(position).appendChild(element);
    }
    setTimeout(remAlert, 3000);
  }

  function remAlert(){
    let alerts = document.getElementsByClassName('alert');
    if(alerts.length > 0) {
      alerts[0].remove();
    }
  }

  function setActive()
  {
    let navbar = document.getElementById('nav-bar');
    if(navbar) {
      let a_tags = navbar.getElementsByTagName('a');

      for(let i=0; i<a_tags.length; i++)
      {
        let file = a_tags[i].href.split('/').pop();
        let file_name = file.split('.')[0];

        if(document.location.href.indexOf(file_name) >= 0){
          a_tags[i].classList.add('active');
        }
      }
    }
  }

  // Registration form handler with improved error handling
  let register_form = document.getElementById('register-form');

  if(register_form) {
    register_form.addEventListener('submit', (e)=>{
      e.preventDefault();
      
      console.log('Registration form submitted');
      
      // Show loading state
      let submitBtn = register_form.querySelector('button[type="submit"]');
      let originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang xử lý...';
      submitBtn.disabled = true;

      // Validate form data before sending
      let name = register_form.elements['name'].value.trim();
      let email = register_form.elements['email'].value.trim();
      let phonenum = register_form.elements['phonenum'].value.trim();
      let address = register_form.elements['address'].value.trim();
      let pincode = register_form.elements['pincode'].value.trim();
      let dob = register_form.elements['dob'].value;
      let pass = register_form.elements['pass'].value;
      let cpass = register_form.elements['cpass'].value;

      // Client-side validation
      if(!name || !email || !phonenum || !address || !pincode || !dob || !pass || !cpass) {
        alert('error', 'Vui lòng điền đầy đủ thông tin!');
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        return;
      }

      if(pass !== cpass) {
        alert('error', 'Mật khẩu không trùng khớp!');
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        return;
      }

      if(pass.length < 6) {
        alert('error', 'Mật khẩu phải có ít nhất 6 ký tự!');
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        return;
      }

      // Create FormData
      let data = new FormData();
      data.append('name', name);
      data.append('email', email);
      data.append('phonenum', phonenum);
      data.append('address', address);
      data.append('pincode', pincode);
      data.append('dob', dob);
      data.append('pass', pass);
      data.append('cpass', cpass);
      
      // Only append profile if file is selected
      if(register_form.elements['profile'].files[0]) {
        data.append('profile', register_form.elements['profile'].files[0]);
        console.log('Profile image selected:', register_form.elements['profile'].files[0].name);
      } else {
        console.log('No profile image selected');
      }
      
      data.append('register', '');

      // Debug: Log form data
      console.log('Sending registration data:');
      for (let [key, value] of data.entries()) {
        if(key === 'profile' && value instanceof File) {
          console.log(key + ':', value.name, value.size + ' bytes');
        } else {
          console.log(key + ':', value);
        }
      }

      // Hide modal before making request
      var myModal = document.getElementById('registerModal');
      var modal = bootstrap.Modal.getInstance(myModal);
      if(modal) {
        modal.hide();
      }

      let xhr = new XMLHttpRequest();
      xhr.open("POST","ajax/login_register.php",true);

      xhr.onload = function(){
        // Reset button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        console.log('Server response:', this.responseText);
        
        if(this.responseText == 'pass_mismatch'){
          alert('error',"Mật khẩu không trùng khớp!");
        }
        else if(this.responseText == 'email_already'){
          alert('error',"Email đã được đăng ký!");
        }
        else if(this.responseText == 'phone_already'){
          alert('error',"Số điện thoại đã được đăng ký!");
        }
        else if(this.responseText == 'inv_img'){
          alert('error',"Chỉ hỗ trợ định dạng JPG, WEBP & PNG!");
        }
        else if(this.responseText == 'inv_size'){
          alert('error',"Hình ảnh phải nhỏ hơn 2MB!");
        }
        else if(this.responseText == 'upd_failed'){
          alert('error',"Tải lên hình ảnh thất bại!");
        }
        else if(this.responseText == 'mail_failed'){
          alert('error',"Hệ thống đang bảo trì, không thể gửi email xác nhận!");
        }
        else if(this.responseText == 'registration_failed' || this.responseText == 'ins_failed'){
          alert('error',"Đăng ký thất bại! Vui lòng thử lại!");
        }
        else if(this.responseText == 'registration_success'){
          alert('success',"Đăng ký thành công! Vui lòng đăng nhập!");
          register_form.reset();
          
          // Show login modal after successful registration
          setTimeout(function() {
            var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.show();
          }, 1000);
        }
        else {
          alert('error',"Có lỗi xảy ra: " + this.responseText);
        }
      }

      xhr.onerror = function() {
        // Reset button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        console.error('Network error during registration');
        alert('error',"Lỗi kết nối! Vui lòng kiểm tra internet và thử lại!");
      }

      xhr.ontimeout = function() {
        // Reset button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        console.error('Request timeout during registration');
        alert('error',"Timeout! Vui lòng thử lại!");
      }

      // Set timeout
      xhr.timeout = 30000; // 30 seconds

      xhr.send(data);
    });
  }

  // Login form handler with improved error handling
  let login_form = document.getElementById('login-form');

  if(login_form) {
    login_form.addEventListener('submit', function(e) {
      e.preventDefault();
      
      console.log('Login form submitted');
      
      // Show loading state
      let submitBtn = login_form.querySelector('button[type="submit"]');
      let originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang xử lý...';
      submitBtn.disabled = true;
      
      // Validate form data
      let email_mob = login_form.elements['email_mob'].value.trim();
      let pass = login_form.elements['pass'].value;

      if(!email_mob || !pass) {
        alert('error', 'Vui lòng điền đầy đủ thông tin!');
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        return;
      }
      
      let data = new FormData();
      data.append('email_mob', email_mob);
      data.append('pass', pass);
      data.append('login', '');

      console.log('Sending login data:', email_mob);

      let xhr = new XMLHttpRequest();
      xhr.open("POST","ajax/login_register.php",true);

      xhr.onload = function() {
        // Reset button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        console.log('Login response:', this.responseText);
        
        if(this.responseText === 'login_success') {
          alert('success', 'Đăng nhập thành công!');
          
          // Hide login modal
          var myModal = document.getElementById('loginModal');
          var modal = bootstrap.Modal.getInstance(myModal);
          if(modal) {
            modal.hide();
          }
          
          // Reload page after short delay
          setTimeout(function() {
            window.location.reload();
          }, 1000);
        } 
        else if(this.responseText === 'invalid_email_mob') {
          alert('error', 'Email hoặc số điện thoại không tồn tại!');
        } 
        else if(this.responseText === 'invalid_password') {
          alert('error', 'Mật khẩu không đúng!');
        } 
        else {
          alert('error', 'Đăng nhập thất bại: ' + this.responseText);
        }
      }

      xhr.onerror = function() {
        // Reset button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        console.error('Network error during login');
        alert('error', 'Lỗi kết nối! Vui lòng thử lại!');
      }

      xhr.ontimeout = function() {
        // Reset button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        console.error('Request timeout during login');
        alert('error', 'Timeout! Vui lòng thử lại!');
      }

      // Set timeout
      xhr.timeout = 15000; // 15 seconds

      xhr.send(data);
    });
  }

  // Forgot password form handler (commented out for now)
  /*
  let forgot_form = document.getElementById('forgot-form');

  if(forgot_form) {
    forgot_form.addEventListener('submit', (e)=>{
      e.preventDefault();

      let data = new FormData();
      data.append('email',forgot_form.elements['email'].value);
      data.append('forgot_pass','');

      var myModal = document.getElementById('forgotModal');
      var modal = bootstrap.Modal.getInstance(myModal);
      modal.hide();

      let xhr = new XMLHttpRequest();
      xhr.open("POST","ajax/login_register.php",true);

      xhr.onload = function(){
        if(this.responseText == 'inv_email'){
          alert('error',"Email không hợp lệ!");
        }
        else if(this.responseText == 'not_verified'){
          alert('error',"Email chưa được xác thực! Vui lòng liên hệ Admin");
        }
        else if(this.responseText == 'inactive'){
          alert('error',"Tài khoản bị khóa! Vui lòng liên hệ Admin.");
        }
        else if(this.responseText == 'mail_failed'){
          alert('error',"Không thể gửi email. Hệ thống lỗi!");
        }
        else if(this.responseText == 'upd_failed'){
          alert('error',"Khôi phục tài khoản thất bại. Hệ thống lỗi!");
        }
        else{
          alert('success',"Link khôi phục đã được gửi tới email!");
          forgot_form.reset();
        }
      }

      xhr.send(data);
    });
  }
  */

  function checkLoginToBook(status,room_id){
    if(status){
      window.location.href='confirm_booking.php?id='+room_id;
    }
    else{
      alert('error','Vui lòng đăng nhập để đặt phòng!');
    }
  }

  // Initialize functions when page loads
  document.addEventListener('DOMContentLoaded', function() {
    setActive();
    console.log('Page loaded, JavaScript initialized');
  });

  // Also call setActive for compatibility
  setActive();

</script>