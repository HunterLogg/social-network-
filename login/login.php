<?php
    include('src/header.php');
    session_start();
?>
<body class="bg-light">
    <main id="main">
        <div class="col-md-5 offset-md-1">
            <div class="d-flex justify-content-center align-items-center w-100 h-100">
                <span  class="m-4 p-2">
                <h1 class="text-primary" style="font-size: 4rem"><b>facebook</b></h1>
                <h3>Connect with friends and the world around you on Facebook.</h3>
                <br>
                <br>
                <br>
                <br>
                </span>
            </div>
        </div>
        <div class="col-md-6 d-flex justify-content-center">
            <div id="login-center" class="row justify-content-center align-self-center w-100 h-50">
                <div class="card col-sm-7 shadow p-3 mb-5 bg-body rounded ">
                    <div class="card-body">
                        <form id="login-form" method="POST" >
                            <div class="form-group">
                                <input type="text" id="email" name="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                            </div>
				            <span class="form-message text-danger"></span>
                            <center><button class="btn btn-block btn-wave btn-primary" id = "login">Đăng nhập</button></center> <br>
                            <center><a href="forgot.php">Quên mật khẩu?</a></center>
                            <hr class="my-4">
                            <center><button class="btn btn-block btn-wave btn-success bg-gradient-success" type="button" id="new_account">Tạo tài khoản mới</button></center>
                        </form>
                    </div>
                </div>
                <center><div class="alert col-md-6"><p><a href="" class="alert-link text-dark">Tạo Trang</a> dành cho người nổi tiếng, nhãn hiệu hoặc doanh nghiệp.</p></div></center>
            </div>
        </div>
    </main>
    <div class="modal fade" id="uni_modal" role='dialog'>
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title"></h5>
             <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><b>&times;</b></span>
            </button>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          </div>
          </div>
        </div>
    </div>
    <script src="js/singup.js"></script>
    <script>
        function escape($s) {  
            return strip_tags($s);
        }

    </script>
    <?php
        include_once("src/footer.php");
    ?>
</body>
</html>
