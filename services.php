<?php
// These includes are already in links.php, so they are removed to prevent redeclaration errors.
// require('admin/inc/db_config.php');
// require('admin/inc/essentials.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VietChill - Dịch vụ</title>
    <?php require('inc/links.php'); ?>
    <style>
        .pop:hover {
            border-top-color: var(--teal) !important;
            transform: scale(1.03);
            transition: all 0.3s;
        }
    </style>
</head>
<body class="bg-light">

    <?php require('inc/header.php'); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">CÁC DỊCH VỤ CỦA CHÚNG TÔI</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">
            Khám phá các dịch vụ đa dạng của chúng tôi, được thiết kế để mang lại cho bạn sự thoải mái và tiện lợi nhất.
        </p>
    </div>

    <div class="container">
        <div class="row">
            <?php
            $res = select("SELECT * FROM `services` WHERE `status`=? AND `removed`=?", [1, 0], 'ii');
            $path = SERVICES_IMG_PATH;

            if(mysqli_num_rows($res) > 0){
                while ($row = mysqli_fetch_assoc($res)) {
                    $price_formatted = number_format($row['price']);
                    echo <<<data
                        <div class="col-lg-4 col-md-6 mb-5 px-4">
                            <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="$path$row[image]" width="80px">
                                    <h5 class="m-0 ms-3">$row[name]</h5>
                                </div>
                                <p>$row[description]</p>
                                <p class="mb-0">Giá: <strong>$price_formatted VND</strong></p>
                            </div>
                        </div>
                    data;
                }
            } else {
                echo '<div class="col-12 text-center"><h4>Hiện tại chưa có dịch vụ nào.</h4></div>';
            }
            ?>
        </div>
    </div>


    <?php require('inc/footer.php'); ?>

</body>
</html> 