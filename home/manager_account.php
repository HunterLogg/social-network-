<?php 
    require_once("../DBController.php");
    $db_handle = new DBController(); 
    $email = $_SESSION['email'];
    $query = "SELECT * FROM users WHERE email ='$email'";
    $sql = $db_handle->runQuery($query);
    $name = $sql[0]['firstname']. " " . $sql[0]['lastname'];
    $days = explode("-",$sql[0]['dob']);
?>


<div class="modal fade position-pixed" id="manager_account" role="dialog">
        <div class="modal-dialog btn-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><label id="title">Manage Account</label></h4>
                </div>
                <br>
                <div class="col-lg-12">
                    <form action="" id="manage_account">
                    <div id="msg"></div>
                    <div class="row">
                    <span class="form-message text-danger"></span>
                        <div class="form-group col-md-6 ">
                            <input type="text" class="form-control" id="firstname" rules="required" placeholder="First name" name='firstname' value="<?php echo $sql[0]['firstname']?>">
                            
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" id='lastname' rules="required" placeholder="Last name" name='lastname' value="<?php echo $sql[0]['lastname']?>">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <input type="email" class="form-control" id='email' rules="required|email" placeholder="Email" name='email' value="<?php echo $sql[0]['email']?>" readonly>
                            <span id="checkemail" class="form-message text-danger"></span>
                        </div>
                    </div>
                    <div class="row">
						<div class="form-group col-md-12">
							<input type="password" class="form-control" placeholder="New Password" name='password'>
                            <small><i>Password phải hơn 6 kí tự chứa chữ in hoa và chữ thường và số.</i></small>
							
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							<input type="password" class="form-control" placeholder="Confirm Password" name='cpass'>
							<small id="pass_match" data-status=''></small>
						</div>
					</div>
                    <b><small class="text-muted"><b>Birthday</b></small></b>
                    <div class="row">
                    <div class="form-group col-md-4">
                            <select name="day" id="day" class="form-select custom-select">
                                <?php
                                    for($i = 1 ; $i <= 31;$i++):
                                ?>
                                <option <?php if($i == $days[0]){echo "selected";}?> value="<?php echo $i ?>" <?php $i == abs(date("d")) ? "selected" : '' ?>><?php echo $i ?></option>
                            <?php endfor; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <select name="month" id="month" class="form-select custom-select">
                                <?php
                                    $month = array("","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sept","Oct","Nov","Dec");
                                    for($i = 1 ; $i <= 12;$i++):
                                ?>
                                <option <?php if($i == $days[1]){echo "selected";}?> value="<?php echo $i ?>" <?php $i == abs(date("m")) ? "selected" : '' ?>><?php echo ucwords($month[$i]) ?></option>
                            <?php endfor; ?>
                            </select>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <select name="year" id="year" class="form-select custom-select">
                                <?php
                                    for($i = abs(date('Y')) ; $i >= abs(date('Y')) - 100;$i--):
                                ?>
                                <option <?php if($i == $days[2]){echo "selected";}?> value="<?php echo $i ?>" <?php $i == abs(date("Y")) ? "selected" : '' ?>><?php echo $i ?></option>
                            <?php endfor; ?>
                            </select>
                        </div>
                        
                    </div>
                    <b><small class="text-muted"><b>Gender</b></small></b>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <div class="d-flex w-100 justify-content-between border rounded align-items center">
                                <label class="btn" for="gmale">Male</label>
                                <div class="form-check d-flex w-100 justify-content-end mt-2">
                                     <input class="form-check-input" type="radio" id="gmale" name="gender" value="Male"  <?php if($sql[0]['gender'] == 'Male') echo " checked=''" ?> >
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="d-flex justify-content-between border rounded align-items center">
                                <label class="btn" for="gfemale">Female</label>
                                <div class="form-check d-flex w-100 justify-content-end mt-2">
                                     <input class="form-check-input" type="radio" id="gfemale" name="gender" value="Female" <?php if($sql[0]['gender'] == 'Female') echo " checked=''" ?>>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <small><i>Rời khỏi đây nếu bạn không muốn thay đổi thông tin.</i></small><br>
                    <div class="modal-footer">
                        <button type="button" id="btnSave" class="btn btn-primary" >Save</button>
                        <button type="button" id="btnClose" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script src="../js/edit_account.js"></script>