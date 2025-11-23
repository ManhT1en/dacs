# VIETCHILL - HOTEL BOOKING WEBSITE
<br>

### Table of Contents

- [Abstract](#abstract)
- [Software Requirements](#software-requirements)
- [Instructions](#instructions)
- [Screenshots](#screenshots)
- [Reference](#reference)

## ABSTRACT
<p align="justify">Các trang web đặt phòng khách sạn là một bài tập thực hành hữu ích dành cho sinh viên ngành CNTT muốn học và rèn luyện kỹ năng lập trình web. Đây là ứng dụng web cho phép người dùng tìm kiếm và đặt phòng khách sạn trực tuyến, với các chức năng phổ biến như tìm kiếm theo vị trí, giá cả, tiện nghi và đặt phòng trực tiếp qua giao diện website.</p>

<p align="justify">Thông qua việc xây dựng một trang web đặt phòng khách sạn, sinh viên có thể áp dụng các kiến thức về frontend, backend, và cơ sở dữ liệu. Ngoài ra, dự án này còn giúp rèn luyện kỹ năng triển khai các tính năng nâng cao như tích hợp đánh giá của khách hàng, bộ lọc tìm kiếm, và hệ thống xác nhận đặt phòng.</p>

<p align="justify">Bài tập này không chỉ giúp sinh viên hiểu rõ hơn về quy trình phát triển ứng dụng web thực tế mà còn nâng cao kỹ năng giải quyết vấn đề, tổ chức hệ thống và xây dựng giao diện thân thiện với người dùng. Đây là một cơ hội tuyệt vời để chuẩn bị cho các dự án thực tế trong tương lai.</p>

<br>

## SOFTWARE REQUIREMENTS
<ul type="square">
  <li> <b> Operating System : </b> Windows, MacOS (Chưa kiểm tra trên Linux nhưng chắc ok thôi.)</li>
   &emsp;
  <li> <b> Frontend : </b>
       <p align="left"> 
          <a href="https://www.w3.org/html/" target="_blank" > 
            <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/html5/html5-original-wordmark.svg" alt="html5" width="50" height="50"/> 
          </a>    
         &emsp;
          <a href="https://www.w3schools.com/css/" target="_blank">
            <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/css3/css3-original-wordmark.svg" alt="css3" width="50" height="50"/> 
          </a> 
         &emsp;
         <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript" target="_blank"> 
           <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/javascript/javascript-original.svg" alt="javascript" width="40" height="40"/>
         </a>
         &emsp;
          <a href="https://getbootstrap.com" target="_blank"> 
            <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/bootstrap/bootstrap-plain-wordmark.svg" alt="bootstrap" width="40" height="40"/> 
          </a>
        </p> 
  </li>
 <li> <b> Backend : </b>
     <p align = "left">
        <a href="https://www.php.net" target="_blank"> 
          <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-original.svg" alt="php" width="50" height="50"/> 
       </a>
     </p>
   </li>

  <li> <b> Database : </b>
     <p align="left"> 
       <a href="https://www.mysql.com/" target="_blank">
         <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/mysql/mysql-original-wordmark.svg" alt="mysql" width="50" height="50"/> 
       </a> 
</p>
   </li>
  </ul>
  
  <br>
  
## INSTRUCTIONS

1. Tải và cài đặt <a href="https://www.apachefriends.org/download.html">XAMPP</a>

2. Tải tệp gzip "vietchill" từ github repo này, giải nén và copy toàn bộ thư mục

4. Paste vào thư mục 'htdocs' trong thư mục gốc cài xampp. (Windows: C:\Program Files\xampp\htdocs hoặc MacOS: /Applications/XAMPP)

5. Mở PHPMyAdmin trong trình duyệt `http://localhost/phpmyadmin`

6. Tạo database "vietchill"

7. Import `vietchill.sql` file vào database vừa tạo

8. Paste URL này vào trình duyệt `http://localhost/vietchill/index.php`

9. Để truy cập trang quản lý, sử dụng link tài khoản sau:
    
   `http://localhost/vietchill/admin/index.php`

   `username:  holden`
   
   `password:  12345`
   
<br>

## Hình Minh Hoạ

<details>
<summary><b> Trang chủ: </b></summary>
<br>

![index](/images/screenshots/home.png)

![index](/images/screenshots/rooms.png)

![index](/images/screenshots/others.png)

![index](/images/screenshots/contact.png)

![index](/images/screenshots/rooms-details.png)

</details>

<br>

<details>
<summary><b> Đăng ký: </b></summary>
<br>

![register](/images/screenshots/register.png)

</details>

<br>

<details>
<summary><b> Đăng nhập: </b></summary>
<br>

![login](/images/screenshots/login.png)

</details>

<br>

<details>
<summary><b> Hồ sơ người dùng: </b></summary>
<br>

![profile](/images/screenshots/profile.png)

![booking](/images/screenshots/booking.png)

</details>

<br>

<details>
<summary><b> Admin Dashboard: </b></summary>
<br>

![admin](/images/screenshots/admin.png)

![admin](/images/screenshots/admin-dashboard.png)

![admin](/images/screenshots/admin-rooms.png)

![admin](/images/screenshots/new-bookings.png)

![admin](/images/screenshots/page-setting.png)

</details>

## References

<a id="reference" href="https://github.com/tj-webdev/Hotel-Booking-Website-Assets"> Hotel-Booking-Website-Assets </a>