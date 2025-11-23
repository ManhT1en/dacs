-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3307
-- Thời gian đã tạo: Th7 25, 2025 lúc 07:14 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `vietchill`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin_cred`
--

CREATE TABLE `admin_cred` (
  `sr_no` int(11) NOT NULL,
  `admin_name` varchar(150) NOT NULL,
  `admin_pass` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin_cred`
--

INSERT INTO `admin_cred` (`sr_no`, `admin_name`, `admin_pass`) VALUES
(1, 'holden', '12345');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_details`
--

CREATE TABLE `booking_details` (
  `sr_no` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `total_pay` int(11) NOT NULL,
  `room_no` varchar(100) DEFAULT NULL,
  `user_name` varchar(100) NOT NULL,
  `phonenum` varchar(100) NOT NULL,
  `address` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_details`
--

INSERT INTO `booking_details` (`sr_no`, `booking_id`, `room_name`, `price`, `total_pay`, `room_no`, `user_name`, `phonenum`, `address`) VALUES
(1, 1, 'Phòng Cơ Bản 3', 1200000, 2400000, '001', 'Hung', '123', 'ad'),
(2, 2, 'Phòng Cao Cấp', 2000000, 4000000, 'a2', 'amey', '123', 'ad'),
(3, 3, 'Phòng Tổng Thống', 10000000, 10000000, NULL, 'amey', '123', 'ad'),
(21, 21, 'Phòng Cơ Bản 3', 1200000, 7200000, NULL, 'Hùng', '12345', 'qweqweqweqwe'),
(22, 22, 'Phòng Cao Cấp', 2000000, 4000000, '1', 'Hùng', '12345', 'qweqweqweqwe'),
(23, 23, 'Phòng Cơ Bản 3', 1200000, 1640000, '1', 'test', '1231231455555', '123123'),
(24, 24, 'Phòng Tổng Thống', 10000000, 20320000, '1', 'Nguyen Nghia', '0905123123', 'Da Nang'),
(25, 25, 'Phòng Cơ Bản 3', 1200000, 2400000, '2', 'Nguyen Nghia', '0905123123', 'Da Nang'),
(26, 26, 'Phòng Cơ Bản 3', 1200000, 1200000, NULL, 'Bui Thanh', '0327786217', 'Quận 8'),
(27, 27, 'Phòng Tổng Thống', 10000000, 10000000, '2', 'Bui Thanh', '0327786217', 'Quận 8'),
(28, 28, 'Phòng Cơ Bản 3', 1200000, 1200000, '2', 'Bui Thanh', '0327786217', 'Quận 8'),
(29, 29, 'Phòng Sang Trọng', 3500000, 7000000, '2', 'Phạm Quang Huy', '0352640446', 'Hà Nội'),
(30, 30, 'Homestay Mây Bay', 1300000, 1520000, '1', 'Phạm Quang Huy', '0352640446', 'Hà Nội'),
(31, 31, 'Homestay Nắng Mai', 1200000, 2400000, '2', 'Phạm Quang Huy', '0352640446', 'Hà Nội'),
(32, 32, 'Homestay Mây Bay', 1300000, 1300000, '111', 'Phạm Quang Huy', '0352640446', 'Hà Nội'),
(33, 33, 'Homestay Mây Bay', 1300000, 4080000, '2', 'Quang Huy', '0364106604', 'Hà Nội'),
(34, 34, 'Homestay Đồi Thông', 3500000, 7400000, NULL, 'Phạm Quang Huy', '0352702404', 'Hà Nội'),
(35, 35, 'Homestay Mây Bay', 1300000, 2600000, '1', 'Phạm Quang Huy', '0352702404', 'Hà Nội'),
(36, 36, 'Homestay Lá', 700000, 1080000, '3', 'Phạm Quang Huy', '0352702404', 'Hà Nội'),
(37, 37, 'Homestay Gió', 1000000, 1000000, NULL, 'Phạm Quang Huy', '0352702404', 'Hà Nội');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_order`
--

CREATE TABLE `booking_order` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `arrival` int(11) NOT NULL DEFAULT 0,
  `refund` int(11) DEFAULT NULL,
  `booking_status` varchar(100) NOT NULL DEFAULT 'pending',
  `order_id` varchar(150) NOT NULL,
  `trans_id` varchar(200) DEFAULT NULL,
  `trans_amt` int(11) DEFAULT NULL,
  `trans_status` varchar(100) NOT NULL DEFAULT 'pending',
  `trans_resp_msg` varchar(200) DEFAULT NULL,
  `rate_review` int(11) DEFAULT NULL,
  `datentime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_order`
--

INSERT INTO `booking_order` (`booking_id`, `user_id`, `room_id`, `check_in`, `check_out`, `arrival`, `refund`, `booking_status`, `order_id`, `trans_id`, `trans_amt`, `trans_status`, `trans_resp_msg`, `rate_review`, `datentime`) VALUES
(1, 2, 3, '2024-12-12', '2024-12-14', 1, NULL, 'booked', 'ORD_21055700', NULL, 0, 'pending', NULL, 0, '2025-06-11 01:50:12'),
(2, 2, 3, '2024-12-03', '2024-12-04', 1, NULL, 'booked', 'ORD_24215693', '20220720111212800110168128204225279', 600, 'TXN_SUCCESS', 'Txn Success', NULL, '2025-06-12 02:14:44'),
(3, 2, 3, '2024-12-13', '2024-12-17', 0, 1, 'cancelled', 'ORD_26312547', '20220720111212800110168165603901976', 1800, 'TXN_SUCCESS', 'Txn Success', NULL, '2025-06-13 02:19:00'),
(21, 7, 3, '2024-12-01', '2024-12-07', 0, 0, 'cancelled', 'ORD_74731476', NULL, NULL, 'TXN_SUCCESS', NULL, NULL, '2025-06-14 11:25:29'),
(22, 7, 4, '2024-12-29', '2024-12-31', 1, NULL, 'booked', 'ORD_72382450', NULL, NULL, 'TXN_SUCCESS', NULL, 0, '2025-06-14 11:32:34'),
(23, 11, 3, '2025-06-20', '2025-06-21', 1, NULL, 'booked', 'ORD_111924376', NULL, NULL, 'pending', NULL, 0, '2025-06-19 14:49:33'),
(24, 12, 6, '2025-06-26', '2025-06-28', 1, NULL, 'booked', 'ORD_126695204', NULL, NULL, 'pending', NULL, 0, '2025-06-19 15:19:53'),
(25, 12, 3, '2025-06-23', '2025-06-25', 1, NULL, 'booked', 'ORD_128630355', NULL, NULL, 'pending', NULL, 0, '2025-06-19 15:23:07'),
(26, 13, 3, '2025-06-19', '2025-06-20', 1, NULL, 'booked', 'ORD_134521689', NULL, NULL, 'pending', NULL, 0, '2025-06-19 22:30:35'),
(27, 13, 6, '2025-06-21', '2025-06-22', 1, NULL, 'booked', 'ORD_132557287', NULL, NULL, 'pending', NULL, 0, '2025-06-21 12:48:42'),
(28, 13, 3, '2025-06-21', '2025-06-22', 1, NULL, 'booked', 'ORD_139835049', NULL, NULL, 'pending', NULL, 0, '2025-06-21 12:51:28'),
(29, 14, 5, '2025-06-27', '2025-06-29', 1, NULL, 'booked', 'ORD_142446667', NULL, NULL, 'pending', NULL, 0, '2025-06-25 10:04:13'),
(30, 14, 9, '2025-07-15', '2025-07-16', 1, NULL, 'booked', 'ORD_146128013', NULL, NULL, 'pending', NULL, 0, '2025-07-14 16:36:48'),
(31, 14, 10, '2025-07-22', '2025-07-24', 1, NULL, 'booked', 'ORD_147591936', NULL, NULL, 'pending', NULL, 0, '2025-07-21 21:03:26'),
(32, 14, 9, '2025-07-22', '2025-07-23', 1, NULL, 'booked', 'ORD_14798817', NULL, NULL, 'pending', NULL, 0, '2025-07-22 13:07:29'),
(33, 15, 9, '2025-07-24', '2025-07-27', 1, NULL, 'booked', 'ORD_153585894', NULL, NULL, 'pending', NULL, 0, '2025-07-23 09:51:13'),
(34, 16, 5, '2025-07-24', '2025-07-26', 0, 0, 'cancelled', 'ORD_165049203', NULL, NULL, 'pending', NULL, NULL, '2025-07-23 10:41:49'),
(35, 16, 9, '2025-07-24', '2025-07-26', 1, NULL, 'booked', 'ORD_167074946', NULL, NULL, 'pending', NULL, 1, '2025-07-23 10:44:30'),
(36, 16, 3, '2025-07-24', '2025-07-25', 1, NULL, 'booked', 'ORD_163196570', NULL, NULL, 'pending', NULL, 0, '2025-07-23 10:47:30'),
(37, 16, 4, '2025-07-25', '2025-07-26', 0, NULL, 'pending', 'ORD_163836503', NULL, NULL, 'pending', NULL, NULL, '2025-07-23 10:49:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_services`
--

CREATE TABLE `booking_services` (
  `sr_no` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_services`
--

INSERT INTO `booking_services` (`sr_no`, `booking_id`, `service_id`, `price`, `quantity`) VALUES
(1, 23, 1, 120000, 1),
(2, 23, 1, 120000, 1),
(3, 23, 2, 200000, 1),
(4, 24, 1, 120000, 1),
(5, 24, 2, 200000, 1),
(6, 30, 10, 120000, 1),
(7, 30, 1, 100000, 1),
(8, 34, 1, 100000, 2),
(9, 34, 2, 200000, 1),
(10, 33, 3, 100000, 1),
(11, 33, 8, 80000, 1),
(12, 36, 1, 100000, 1),
(13, 36, 2, 200000, 1),
(14, 36, 8, 80000, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carousel`
--

CREATE TABLE `carousel` (
  `sr_no` int(11) NOT NULL,
  `image` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `carousel`
--

INSERT INTO `carousel` (`sr_no`, `image`) VALUES
(14, 'IMG_91370.jpg'),
(15, 'IMG_76404.jpg'),
(16, 'IMG_38884.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_details`
--

CREATE TABLE `contact_details` (
  `sr_no` int(11) NOT NULL,
  `address` varchar(50) NOT NULL,
  `gmap` varchar(100) NOT NULL,
  `pn1` bigint(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fb` varchar(100) NOT NULL,
  `insta` varchar(100) NOT NULL,
  `tw` varchar(100) NOT NULL,
  `iframe` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `contact_details`
--

INSERT INTO `contact_details` (`sr_no`, `address`, `gmap`, `pn1`, `email`, `fb`, `insta`, `tw`, `iframe`) VALUES
(1, 'Hà Nội', 'https://www.google.com/maps?q=%C4%90%C3%A0+N%E1%BA%B5ng', 84352640446, 'pqhuy@gmail.com', 'https://www.facebook.com/', '', '', 'https://www.google.com/maps?q=%C4%90%C3%A0+N%E1%BA%B5ng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `facilities`
--

CREATE TABLE `facilities` (
  `id` int(11) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `facilities`
--

INSERT INTO `facilities` (`id`, `icon`, `name`, `description`) VALUES
(13, 'IMG_43553.svg', 'Wi-Fi', 'Kết nối Internet tốc độ cao, miễn phí trong toàn bộ khách sạn, giúp bạn dễ dàng làm việc hoặc giải trí trực tuyến.'),
(14, 'IMG_49949.svg', 'Máy Lạnh', 'Hệ thống điều hòa không khí hiện đại, mang lại không gian thoải mái và dễ chịu, phù hợp với mọi điều kiện thời tiết.'),
(15, 'IMG_41622.svg', 'Truyền Hình', 'TV màn hình phẳng với đa dạng kênh giải trí trong nước và quốc tế, đáp ứng nhu cầu thư giãn của khách hàng.'),
(17, 'IMG_47816.svg', 'Spa', 'Dịch vụ spa chuyên nghiệp với liệu trình thư giãn, chăm sóc cơ thể, và phục hồi sức khỏe.'),
(18, 'IMG_96423.svg', 'Máy Sưởi', 'Hệ thống sưởi ấm chất lượng cao, giữ không gian ấm áp, đặc biệt phù hợp vào những ngày lạnh giá.'),
(19, 'IMG_27079.svg', 'Máy Nước Nóng', 'Máy nước nóng tiện lợi, cung cấp nước nóng tức thì, đảm bảo sự thoải mái khi sử dụng phòng tắm.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `features`
--

INSERT INTO `features` (`id`, `name`) VALUES
(13, 'Phòng Ngủ'),
(14, 'Ban Công'),
(15, 'Nhà Bếp'),
(17, 'Ghế Sofa');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rating_review`
--

CREATE TABLE `rating_review` (
  `sr_no` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` varchar(200) NOT NULL,
  `seen` int(11) NOT NULL DEFAULT 0,
  `datentime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rating_review`
--

INSERT INTO `rating_review` (`sr_no`, `booking_id`, `room_id`, `user_id`, `rating`, `review`, `seen`, `datentime`) VALUES
(4, 21, 5, 2, 5, 'Dịch vụ tuyệt vời, không gian đẳng cấp và được trang bị đầy đủ tiện nghi hiện đại. Rất phù hợp cho những dịp đặc biệt hoặc nghỉ dưỡng cao cấp.', 1, '2025-06-20 00:22:25'),
(5, 22, 4, 5, 3, 'Chất lượng dịch vụ xuất sắc, phòng rộng rãi, đầy đủ tiện nghi. Không gian sang trọng và thoải mái, rất đáng giá cho kỳ nghỉ.', 1, '2025-06-20 00:22:30'),
(6, 1, 3, 6, 4, 'Tương tự như “Phòng Cơ bản”, nhưng một số chi tiết như ánh sáng hoặc nội thất cần được cải thiện để mang lại trải nghiệm tốt hơn.', 1, '2025-06-21 00:22:34'),
(8, 21, 5, 7, 5, 'Nhân viên phục vụ rất chuyên nghiệp, mang lại cảm giác thoải mái và đáng nhớ cho kỳ nghỉ.', 1, '2025-06-22 00:22:25'),
(9, 22, 3, 8, 4, 'Dịch vụ ổn định, phòng sạch sẽ và gọn gàng. Tuy nhiên, tiện nghi chỉ ở mức cơ bản, phù hợp cho những ai cần chỗ ở ngắn hạn.', 1, '2025-06-24 00:22:34'),
(10, 1, 6, 2, 5, 'Phòng đẳng cấp, dịch vụ chu đáo, không gian sang trọng. Tuy nhiên, giá thành hơi cao so với những gì nhận được.', 1, '2025-06-24 00:22:34'),
(12, 1, 3, 7, 5, 'Rất tốt, đỉnh nóc kịch trần, bay phấp pha phấp phới.\r\nHãy gửi voucher discount về cho tôi vì đã để lại bình luận tốt!', 0, '2025-06-24 11:33:41'),
(13, 35, 9, 16, 5, 'Good', 0, '2025-07-23 10:44:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `area` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `adult` int(11) NOT NULL,
  `children` int(11) NOT NULL,
  `description` varchar(350) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `removed` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `area`, `price`, `quantity`, `adult`, `children`, `description`, `status`, `removed`) VALUES
(1, 'Phòng Cơ Bản 1', 34, 800000, 56, 2, 1, 'Phòng đơn giản, phù hợp với những khách hàng cần chỗ nghỉ ngắn hạn. Được trang bị các tiện nghi cơ bản như giường thoải mái, bàn làm việc nhỏ, và Wi-Fi miễn phí.', 1, 1),
(2, 'Phòng Cơ Bản 2', 40, 1000000, 30, 2, 1, 'Nâng cấp nhẹ so với Phòng Cơ Bản 1, mang đến không gian rộng rãi hơn và thêm các tiện ích như TV màn hình phẳng và minibar.', 1, 1),
(3, 'Homestay Lá', 30, 700000, 20, 2, 1, 'Phòng cao cấp hơn với thiết kế hiện đại, ban công nhỏ hoặc cửa sổ lớn có view thành phố, tạo cảm giác thoáng đãng và thư giãn.', 1, 0),
(4, 'Homestay Gió', 50, 1000000, 15, 4, 2, 'Không gian rộng rãi với thiết kế sang trọng, phù hợp cho các kỳ nghỉ dài ngày. Được trang bị nội thất cao cấp, phòng tắm riêng với bồn tắm, và các tiện ích như máy pha cà phê và két an toàn.', 1, 0),
(5, 'Homestay Đồi Thông', 120, 3500000, 15, 6, 3, 'Thiết kế đẳng cấp với nội thất tinh tế và các tiện nghi hiện đại. Phòng có không gian sống riêng biệt, ban công hoặc cửa sổ lớn với view đẹp, mang lại trải nghiệm thư giãn hoàn hảo.', 1, 0),
(6, 'Hoemstay Suối Nhỏ', 40, 10000000, 5, 3, 1, 'Hạng phòng cao cấp nhất, mang đến sự xa hoa với không gian rộng lớn, nội thất tinh xảo và dịch vụ đặc biệt. Bao gồm phòng khách riêng, phòng ngủ lớn, phòng tắm xa hoa và nhiều tiện nghi VIP như quản gia riêng.', 1, 0),
(7, 'Homestay Sương Sớm', 60, 1500000, 15, 5, 2, 'Ẩn mình giữa thiên nhiên tĩnh lặng, Homestay Sương Sớm mang đến cho bạn một không gian nghỉ dưỡng trong lành và an yên. Mỗi buổi sáng thức dậy, bạn sẽ được đón chào bởi làn sương mờ giăng, ánh nắng dịu nhẹ len lỏi qua khung cửa sổ và tiếng chim hót giữa núi rừng – tất cả tạo nên một trải nghiệm thật chậm, thật riêng.', 1, 0),
(8, 'Homestay Mộc Trà', 45, 900000, 10, 3, 1, 'Ẩn mình sau hàng tre xanh và vườn cúc dại, Homestay Mộc Trà như một nốt trầm giữa bản nhạc của núi rừng. Không gian được chăm chút bởi chất liệu tự nhiên: gỗ thô, tre, và ánh sáng vàng ấm – tất cả tạo nên một nơi chốn thiền tĩnh và an yên, nơi mà chỉ cần bước vào là thấy nhẹ lòng.', 1, 0),
(9, 'Homestay Mây Bay', 60, 1300000, 15, 4, 2, 'Nằm ở vị trí cao nhất của Homestay, Homestay Mây Bay là lựa chọn tuyệt vời cho những ai muốn &quot;thức dậy giữa tầng mây&quot;. Sáng sớm, mây lững lờ trôi ngang qua khung cửa kính; chiều về, nắng nhạt vàng phủ khắp không gian. Một nơi nhẹ tênh, trong trẻo, như chính cái tên của nó.', 1, 0),
(10, 'Homestay Nắng Mai', 45, 1200000, 20, 3, 1, 'Homestay Nắng Mai là không gian lý tưởng cho những ai yêu buổi sáng dịu dàng và thích cảm giác tỉnh dậy trong ánh nắng ấm. Mỗi sớm mai, căn phòng như được bao phủ bởi một lớp nắng vàng nhẹ, len qua từng khe rèm, soi rọi vào từng ngóc ngách – đem lại cảm giác tươi mới, tích cực và tràn đầy sức sống.', 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room_facilities`
--

CREATE TABLE `room_facilities` (
  `sr_no` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `facilities_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `room_facilities`
--

INSERT INTO `room_facilities` (`sr_no`, `room_id`, `facilities_id`) VALUES
(66, 3, 13),
(67, 3, 14),
(68, 3, 19),
(85, 5, 13),
(86, 5, 14),
(87, 5, 18),
(88, 4, 13),
(89, 4, 14),
(90, 4, 17),
(91, 4, 19),
(96, 6, 13),
(97, 6, 14),
(98, 6, 18),
(99, 6, 19),
(100, 7, 13),
(101, 7, 14),
(102, 7, 15),
(103, 7, 19),
(104, 8, 13),
(105, 8, 14),
(106, 8, 19),
(107, 9, 13),
(108, 9, 14),
(109, 9, 15),
(110, 9, 19),
(111, 10, 13),
(112, 10, 14),
(113, 10, 19);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room_features`
--

CREATE TABLE `room_features` (
  `sr_no` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `features_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `room_features`
--

INSERT INTO `room_features` (`sr_no`, `room_id`, `features_id`) VALUES
(49, 3, 13),
(50, 3, 14),
(51, 3, 17),
(61, 5, 13),
(62, 5, 14),
(63, 5, 15),
(64, 4, 13),
(65, 4, 14),
(66, 4, 15),
(70, 6, 13),
(71, 6, 14),
(72, 6, 15),
(73, 7, 13),
(74, 7, 14),
(75, 7, 15),
(76, 8, 13),
(77, 8, 14),
(78, 8, 15),
(79, 9, 13),
(80, 9, 14),
(81, 10, 13),
(82, 10, 14);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room_images`
--

CREATE TABLE `room_images` (
  `sr_no` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `image` varchar(150) NOT NULL,
  `thumb` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `room_images`
--

INSERT INTO `room_images` (`sr_no`, `room_id`, `image`, `thumb`) VALUES
(17, 4, 'IMG_44867.png', 0),
(18, 4, 'IMG_78809.png', 0),
(19, 4, 'IMG_11892.png', 0),
(21, 5, 'IMG_17474.png', 0),
(22, 5, 'IMG_42663.png', 0),
(23, 5, 'IMG_70583.png', 0),
(24, 6, 'IMG_67761.png', 0),
(25, 6, 'IMG_69824.png', 0),
(27, 4, 'IMG_56943.jpg', 1),
(28, 5, 'IMG_76095.jpg', 1),
(33, 3, 'IMG_49720.jpg', 0),
(34, 3, 'IMG_43812.jpg', 0),
(41, 6, 'IMG_23684.jpg', 1),
(42, 3, 'IMG_85865.jpg', 1),
(43, 7, 'IMG_99975.jpg', 0),
(44, 7, 'IMG_40566.jpg', 1),
(45, 7, 'IMG_25765.jpg', 0),
(46, 8, 'IMG_19448.jpg', 1),
(47, 8, 'IMG_59793.jpg', 0),
(48, 8, 'IMG_40559.jpg', 0),
(50, 9, 'IMG_80060.jpg', 0),
(51, 9, 'IMG_35726.jpg', 0),
(52, 9, 'IMG_14326.jpg', 1),
(53, 10, 'IMG_31478.jpg', 1),
(54, 10, 'IMG_36445.jpg', 0),
(55, 10, 'IMG_24087.jpg', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(150) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `removed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `services`
--

INSERT INTO `services` (`id`, `name`, `price`, `description`, `image`, `status`, `removed`) VALUES
(1, 'Xe đạp địa hình', 100000, 'Loại xe được thiết kế để di chuyển trên nhiều loại địa hình khác nhau, từ đường bằng phẳng đến đường gồ ghề, đồi núi.', 'IMG_94414.jpg', 1, 0),
(2, 'Lều cắm trại', 200000, 'Lều di động, được thiết kế để bảo vệ người sử dụng khỏi các yếu tố thời tiết như nắng, mưa, gió, và côn trùng.', 'IMG_65604.jpg', 1, 0),
(3, 'Combo đồ nướng', 100000, 'Là thiết bị dùng để nấu chín thực phẩm bằng nhiệt, thường ở nhiệt độ cao, với nhiều chức năng và kiểu dáng đa dạng.', 'IMG_92951.jpg', 1, 0),
(4, 'a', 22, '', 'IMG_30163.jpg', 1, 1),
(5, 'xe đạp', 100000, '', 'IMG_88988.jpg', 1, 1),
(6, 'Xe máy (Xe số)', 200000, 'Là loại xe máy có hộp số cơ khí, yêu cầu người lái phải tự thao tác sang số bằng chân đạp cần số', 'IMG_65464.png', 1, 0),
(7, 'Xe máy (Xe tay ga)', 300000, 'Có đặc điểm nổi bật là phần để chân cho người lái, hệ thống truyền động vô cấp  giúp vận hành êm ái và dễ điều khiển', 'IMG_82697.jpg', 1, 0),
(8, 'Dịch vụ dọn dẹp', 80000, 'Bao gồm dọn dẹp phòng ở, nhà vệ sinh, làm sạch các khu vực chung, thay ga giường, vỏ gối, và đảm bảo các tiện nghi trong phòng hoạt động tốt', 'IMG_87099.jpg', 1, 0),
(9, 'Dịch vụ giặt ủi', 60000, 'Bao gồm việc giặt, làm khô và là quần áo, khăn, ga trải giường, v.v. của khách. Dịch vụ này giúp khách giữ quần áo sạch sẽ và gọn gàng trong suốt thời gian lưu trú', 'IMG_18954.jpg', 1, 0),
(10, 'Dịch vụ massage', 120000, 'Dịch vụ này mang đến sự tiện lợi và trải nghiệm thư giãn độc đáo, hòa mình vào không gian sống và văn hóa địa phương.', 'IMG_62245.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `settings`
--

CREATE TABLE `settings` (
  `sr_no` int(11) NOT NULL,
  `site_title` varchar(50) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `site_about` varchar(250) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `shutdown` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `settings`
--

INSERT INTO `settings` (`sr_no`, `site_title`, `site_about`, `shutdown`) VALUES
(1, 'VietChill', 'Trải nghiệm dịch vụ đặt phòng Homestay trực tuyến nhanh chóng, tiện lợi với đa dạng lựa chọn tại các điểm đến du lịch nổi tiếng trên khắp Việt Nam. Hãy để hành trình của bạn bắt đầu chỉ với vài cú nhấp chuột!', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `team_details`
--

CREATE TABLE `team_details` (
  `sr_no` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `picture` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `team_details`
--

INSERT INTO `team_details` (`sr_no`, `name`, `picture`) VALUES
(16, 'Quân', 'chill-guy1.png'),
(17, 'Huy', 'chill-guy2.png'),
(18, 'Trường', 'chill-guy3.png'),
(19, 'Dũng', 'chill-guy4.png'),
(20, 'Đăng', 'chill-guy5.png'),
(21, 'Đạt', 'chill-guy6.png'),
(22, 'Hưng', 'chill-guy7.png'),
(23, 'Hiếu', 'chill-guy8.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_cred`
--

CREATE TABLE `user_cred` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `address` varchar(120) NOT NULL,
  `phonenum` varchar(100) NOT NULL,
  `pincode` int(11) NOT NULL,
  `dob` date NOT NULL,
  `profile` varchar(100) NOT NULL DEFAULT 'chill-guy.png',
  `password` varchar(200) NOT NULL,
  `is_verified` int(11) NOT NULL DEFAULT 0,
  `token` varchar(200) DEFAULT NULL,
  `t_expire` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `datentime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_cred`
--

INSERT INTO `user_cred` (`id`, `name`, `email`, `address`, `phonenum`, `pincode`, `dob`, `profile`, `password`, `is_verified`, `token`, `t_expire`, `status`, `datentime`) VALUES
(2, 'Trung', 'trung@gmail.com', 'ad', '123', 123324, '2022-06-12', 'chill-guy2.png', '12345', 1, NULL, NULL, 1, '2025-06-22 16:05:59'),
(5, 'Huy', 'huy@gmail.com', 'asd', '1234', 123, '2005-12-30', 'chill-guy3.png', '12345', 1, '24ffd287a4c2eda5f2b424be2824f997', NULL, 1, '2025-06-23 02:37:19'),
(6, 'Hiếu', 'hieu@gmail.com', 'asd', '1123', 123, '2005-12-22', 'chill-guy6.png', '12345', 1, 'ef6dc7ba39cf4bf844244d3ef927a3e7', NULL, 1, '2025-06-23 02:40:42'),
(7, 'Hùng', 'hung@gmail.com', 'qweqweqweqwe', '12345', 123, '1995-12-28', 'chill-guy1.png', '12345', 0, '5c9f04397ff3e693f7cbfccea1044483', NULL, 1, '2025-06-23 02:42:37'),
(8, 'Đạt', 'dat@gmail.com', 'a', '12', 1, '2005-12-01', 'chill-guy5.png', '12345', 0, '250dd45640f7d810313b27e758a267af', NULL, 1, '2025-06-23 02:55:39'),
(9, 'trung', '123123@asdasdasd', '1123123123', '1231111111111', 123, '2222-02-12', 'chill-guy.png', '123', 0, NULL, NULL, 1, '2025-06-24 11:56:05'),
(11, 'test', 'test@gmail.com', '123123', '1231231455555', 123123, '1111-11-11', 'chill-guy.png', '12345', 0, NULL, NULL, 1, '2025-06-24 13:05:25'),
(12, 'Nguyen Nghia', 'nghia@gmail.com', 'Da Nang', '0905123123', 123123, '2002-03-19', 'IMG_78307.jpeg', '$2y$10$Ni7GZPADcuGdZMmJ.0WR1uAiE2C/OAkVGhm.k15//FM1tk8oXZieu', 0, NULL, NULL, 1, '2025-06-24 15:18:33'),
(13, 'Bui Thanh', 'hau69710@gmail.com', 'Quận 8', '0327786217', 84, '2003-04-10', 'IMG_68658.jpeg', '$2y$10$O.c8RHDqyryx.qBPnI49b.2YabjvIAwP5SlQknqez1lMGZYRI4RN2', 0, NULL, NULL, 1, '2025-06-24 22:30:05'),
(14, 'Phạm Quang Huy', 'pqhuy@gmail.com', 'Hà Nội', '0352640446', 1204034299, '2004-08-25', 'IMG_49614.jpeg', '$2y$10$OnsfuBREGbXC.oEjWjnnA.Of0CPsGb1QxFnFWaDF18JP2RYhoriSu', 0, NULL, NULL, 1, '2025-06-24 22:06:13'),
(15, 'Quang Huy', 'pqhuy2508@gmail.com', 'Hà Nội', '0364106604', 1204034299, '2004-08-25', 'IMG_29236.jpeg', '$2y$10$Y0bLko9VUmXD.Sndvy4TyuZ0.RngNPhQVuVCP//rx3Tt.8X54z37W', 0, NULL, NULL, 1, '2025-07-23 09:33:09'),
(16, 'Phạm Quang Huy', 'pqhuyy2508@gmail.com', 'Hà Nội', '0352702404', 142, '2004-08-25', 'IMG_95762.jpeg', '$2y$10$pZVhy/h7wNWvvhVvhQCojOV.Zq5G.rc77gHQSA07noxp5d8G4Wav.', 0, NULL, NULL, 1, '2025-07-23 10:39:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_queries`
--

CREATE TABLE `user_queries` (
  `sr_no` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` varchar(500) NOT NULL,
  `datentime` datetime NOT NULL DEFAULT current_timestamp(),
  `seen` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_queries`
--

INSERT INTO `user_queries` (`sr_no`, `name`, `email`, `subject`, `message`, `datentime`, `seen`) VALUES
(11, 'Hung', 'hung@gmail.com', 'Tôi muốn đặt phòng', 'Cần hỗ trợ đặt phòng Tổng Thống.', '2025-06-19 00:00:00', 1),
(13, 'Trung', 'trung@gmail.com', 'Yêu cầu hoàn tiền', 'Cần hỗ trợ hoàn tiền do huỷ đột xuất.', '2025-06-12 10:10:48', 1),
(14, 'Bui Thanh', 'hau69710@gmail.com', 'test', 'test', '2025-06-21 12:50:32', 0),
(15, 'Phạm Quang Huy', 'pqhuy2508@gmail.com', 'Đặt phòng', 'Tôi muốn đặt phòng', '2025-07-23 10:45:45', 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin_cred`
--
ALTER TABLE `admin_cred`
  ADD PRIMARY KEY (`sr_no`);

--
-- Chỉ mục cho bảng `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Chỉ mục cho bảng `booking_order`
--
ALTER TABLE `booking_order`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Chỉ mục cho bảng `booking_services`
--
ALTER TABLE `booking_services`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Chỉ mục cho bảng `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`sr_no`);

--
-- Chỉ mục cho bảng `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`sr_no`);

--
-- Chỉ mục cho bảng `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `rating_review`
--
ALTER TABLE `rating_review`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `facilities id` (`facilities_id`),
  ADD KEY `room id` (`room_id`);

--
-- Chỉ mục cho bảng `room_features`
--
ALTER TABLE `room_features`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `features id` (`features_id`),
  ADD KEY `rm id` (`room_id`);

--
-- Chỉ mục cho bảng `room_images`
--
ALTER TABLE `room_images`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `room_id` (`room_id`);

--
-- Chỉ mục cho bảng `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`sr_no`);

--
-- Chỉ mục cho bảng `team_details`
--
ALTER TABLE `team_details`
  ADD PRIMARY KEY (`sr_no`);

--
-- Chỉ mục cho bảng `user_cred`
--
ALTER TABLE `user_cred`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_phonenum` (`phonenum`),
  ADD KEY `idx_token` (`token`);

--
-- Chỉ mục cho bảng `user_queries`
--
ALTER TABLE `user_queries`
  ADD PRIMARY KEY (`sr_no`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin_cred`
--
ALTER TABLE `admin_cred`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `booking_order`
--
ALTER TABLE `booking_order`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `booking_services`
--
ALTER TABLE `booking_services`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `carousel`
--
ALTER TABLE `carousel`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `rating_review`
--
ALTER TABLE `rating_review`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `room_facilities`
--
ALTER TABLE `room_facilities`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT cho bảng `room_features`
--
ALTER TABLE `room_features`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT cho bảng `room_images`
--
ALTER TABLE `room_images`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT cho bảng `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `settings`
--
ALTER TABLE `settings`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `team_details`
--
ALTER TABLE `team_details`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `user_cred`
--
ALTER TABLE `user_cred`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `user_queries`
--
ALTER TABLE `user_queries`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `booking_details`
--
ALTER TABLE `booking_details`
  ADD CONSTRAINT `booking_details_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`);

--
-- Các ràng buộc cho bảng `booking_order`
--
ALTER TABLE `booking_order`
  ADD CONSTRAINT `booking_order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_cred` (`id`),
  ADD CONSTRAINT `booking_order_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Các ràng buộc cho bảng `booking_services`
--
ALTER TABLE `booking_services`
  ADD CONSTRAINT `booking_services_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`),
  ADD CONSTRAINT `booking_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);

--
-- Các ràng buộc cho bảng `rating_review`
--
ALTER TABLE `rating_review`
  ADD CONSTRAINT `rating_review_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`),
  ADD CONSTRAINT `rating_review_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `rating_review_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user_cred` (`id`);

--
-- Các ràng buộc cho bảng `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD CONSTRAINT `facilities id` FOREIGN KEY (`facilities_id`) REFERENCES `facilities` (`id`),
  ADD CONSTRAINT `room id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Các ràng buộc cho bảng `room_features`
--
ALTER TABLE `room_features`
  ADD CONSTRAINT `features id` FOREIGN KEY (`features_id`) REFERENCES `features` (`id`),
  ADD CONSTRAINT `rm id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Các ràng buộc cho bảng `room_images`
--
ALTER TABLE `room_images`
  ADD CONSTRAINT `room_images_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
