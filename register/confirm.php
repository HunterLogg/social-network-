<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook</title>
    <link type="text/css" rel="stylesheet" href="../css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
</head>
<?php session_start();?>

<body class="bg-light">
    <div class="navbar ml-2">
        <a class="btn text-primary float-left bg-light pb-2" style="font-size: 3rem" href="#"><b>facebook</b></a>
        
    </div>
    <div class="content">
        <div class="position-absolute top-50 start-50 translate-middle border shadow" style="width: 40%; padding: 20px; background-color: #fff;">
            <form action="" method="POST" id="confirm-form">
                <h3 class="text-primary">Hoàn tất đăng nhập</h3>
                <hr>
                <h4 class="text-primary">Vui lòng chọn ảnh và xác thực tài khoản.</h4>
                <form action="#" class="" id="img-from">
                    <span class="form-message text-danger"></span>
                    <div class="form-group">
                        <span>Vui lòng chọn ảnh đại diện.</span><br>
                        <input type="file" id="img_file" name="img_file" class="btn btn-info">
                        <center><img src="" alt="" id="img-review"></center>
                        <span class="error-message"></span>
                    </div>
                    <div class="form-group">
                        <span>Vui lòng nhập số điện thoại!</span>
                        <input type="text" class="form-control" name="contact" id="contact">
                    </div>


                    <div class="form-group">
                        <span>Vui lòng nhập mã đễ xác thực tài khoản.</span>
                        <input type="text" id="valdiation" name="valdiation" class="form-control" placeholder="Code">
                        <span class="verification">
                            <?php
                            if(!empty($_SESSION['valdiation_code'])){
                                echo $_SESSION['valdiation_code'];
                            }
                            ?>
                        </span>
                        <span class="error"></span>
                    </div>
                    <hr>
                    <input type="submit" value="Xác thực tài khoản" class="btn btn-success float-right mr-5" id="confirm">
                </form>
                </div>
            </form>
        </div>
    </div>
    <script src="../js/register/confirm.js"></script>
</body>
</html>