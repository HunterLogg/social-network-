<div class="container-fluid">
	<form action="" id="signup" method="POST">
		<div class="col-lg-12">
			<div id="msg"></div>
			<div class="row">
				<div class="form-group col-md-6 ">
					<input type="text" class="form-control" id="firstname" rules="required" placeholder="First name" name='firstname'>
					<span class="form-message text-danger"></span>
				</div>
				<div class="form-group col-md-6">
					<input type="text" class="form-control" id='lastname' rules="required" placeholder="Last name" name='lastname'>
					<span class="form-message text-danger"></span>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12">
					<input type="email" class="form-control" id='email' rules="required|email" placeholder="Email" name='email'>
					<span id="checkemail" class="form-message text-danger"></span>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12">
					<input type="password" class="form-control" id="password" rules="required" placeholder="Password" name='password'>
					<span class="form-message text-danger"></span>
				</div>
			</div>
			<b><small class="text-muted"><b>Birthday</b></small></b>
			<div class="row">
			<div class="form-group col-md-4">
					<select name="day" id="day" class="custom-select">
						<?php
							for($i = 1 ; $i <= 31;$i++):
						?>
						<option value="<?php echo $i ?>" <?php $i == abs(date("d")) ? "selected" : '' ?>><?php echo $i ?></option>
					<?php endfor; ?>
					</select>
				</div>
				<div class="form-group col-md-4">
					<select name="month" id="month" class="custom-select">
						<?php
							$month = array("","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sept","Oct","Nov","Dec");
							for($i = 1 ; $i <= 12;$i++):
						?>
						<option value="<?php echo $i ?>" <?php $i == abs(date("m")) ? "selected" : '' ?>><?php echo ucwords($month[$i]) ?></option>
					<?php endfor; ?>
					</select>
				</div>
				
				<div class="form-group col-md-4">
					<select name="year" id="year" class="custom-select">
						<?php
							for($i = abs(date('Y')) ; $i >= abs(date('Y')) - 100;$i--):
						?>
						<option value="<?php echo $i ?>" <?php $i == abs(date("Y")) ? "selected" : '' ?>><?php echo $i ?></option>
					<?php endfor; ?>
					</select>
				</div>
				<span class="form-message text-danger"></span>
			</div>
			<b><small class="text-muted"><b>Gender</b></small></b>
			<div class="row">
	            <div class="form-group col-md-4">
					<div class="d-flex w-100 justify-content-between border rounded align-items center">
						<label class="btn" for="gmale">Male</label>
						<div class="form-check d-flex w-100 justify-content-end mt-2">
			             	<input class="form-check-input" type="radio" id="gmale" name="gender" value="Male" checked="" >
			            </div>
					</div>
	            </div>
				<div class="form-group col-md-4">
					<div class="d-flex justify-content-between border rounded align-items center">
						<label class="btn" for="gfemale">Female</label>
						<div class="form-check d-flex w-100 justify-content-end mt-2">
			             	<input class="form-check-input" type="radio" id="gfemale" name="gender" value="Female">
			            </div>
					</div>
	            </div>
				<span class="form-message text-danger"></span>
			</div>
			<div class="row">
				<p>Bằng cách nhấp vào Đăng ký, bạn đồng ý với <a href="">Điều khoản</a>, <a href="">Chính sách dữ liệu</a> và 
				<a href="">Chính sách cookie </a>của chúng tôi. Bạn có thể nhận được thông báo của chúng tôi qua SMS và hủy nhận bất kỳ lúc nào.</p>
			</div>
			<div class="row justify-content-center">
				<button class="btn btn-block btn-success col-sm-5 align-self-center"><b>Đăng kí</b></button>
			</div>
			
		</div>
	</form>
</div>
<style>
	#uni_modal .modal-footer{
		display:none 
	}
</style>


<script src="js/register/register.js"></script>
<script>
        Validator({
            form: '#signup',
            rules: [
                Validator.isRequired('#firstname','fn'),
				Validator.isRequired('#lastname','ln'),
				Validator.isRequired('#password','pw'),
                Validator.minLength('#firstname',3),
                Validator.minLength('#lastname',3),
				Validator.minLength('#password',6),
				Validator.isPassword('#password'),
                Validator.isEmail('#email'),
            ],
			onSubmit : function(data){
				//console.log(data);
			}
			
        });
		
    </script>