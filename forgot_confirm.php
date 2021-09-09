<?php include("src/header.php") ?>
<body class="bg-light">
    <div class="navbar" style="background-color: #fff;">
        <a class="btn text-primary  float-left " style="font-size: 2rem" href="index.php"><b>facebook</b></a>
        <form action="" method="post" id="login-form" class=" float-right row nav-item ">
            <input type="text" name="email" id="email" class="form-control col mx-1" placeholder="Email">
            <input type="password" name="password" id="password" class="form-control col mx-1" placeholder="Password">
            <input type="submit" value="Đăng Nhập" id="login" class="col btn btn-primary mx-1">
            <span class="form-message text-danger"></span>
        </form>
        </div>
    </div>
    <div class="content bg-light">
        <div class="position-absolute top-50 start-50 translate-middle border shadow" style="width: 45%; padding: 20px; background-color: #fff;">
            <form action="" method="POST" class="confirm-code">
                <h3>Xác thực mã</h3>
                <hr>
                <h4>Vui lòng nhập mã được gửi qua email của bạn.</h4>
                <input type="text" name="code" id="code" class="form-control">
                <span class="error-forgot text-danger"></span>
                <hr>
                <div class="float-right">
                <button class="btn btn-primary btn-confirm">Xác thực</button>
                </div>
            </form>
        </div>
    </div>
    <div class="position-absolute bottom-0 start-0 w-100">
        <?php include_once("src/footer.php");?>
    </div>
    <script src="js/singup.js"></script>
    <script>
        // forgot password
    const forgot = document.querySelector(".confirm-code");
    forgot.onsubmit = (e) => {
        e.preventDefault();
    }
    $(".btn-confirm").click(function (e){
        let xhr = new XMLHttpRequest();// tạo sml object
                xhr.open("POST","forgotpass/ajax_forgot.php?action=confirm",true),
                xhr.onload = () => {
                    if(xhr.readyState === XMLHttpRequest.DONE){
                        if(xhr.status === 200){
                            let data = xhr.response;
                            console.log(data);  
                            if(data == "success"){
                                location.href = "change_pass.php";
                            }
                            else {
                                $(".error-forgot").text(data);
                                $("#code").addClass("is-invalid");
                            }
                        }
                    }
                }
        let formData = new FormData(forgot);
        xhr.send(formData);
    });
    </script>
</body>
</html>