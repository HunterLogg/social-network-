<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>facebook</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/fonts/themify-icons/themify-icons.css">
    <link type="text/css" rel="stylesheet" href="../css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="../css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css.map">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
</head>

<?php
session_start();
require_once("../DBController.php");
?>
<?php
$db_handle = new DBController(); 
$email = $_SESSION['email'];
$query = "SELECT * FROM users WHERE email ='$email'";
$sql = $db_handle->runQuery($query);

$name = $sql[0]['firstname']. " " . $sql[0]['lastname'];
$imgPath = $sql[0]['img_user'];
$user_id = $sql[0]['id'];
//$unique_id = $sql[0]['unique_id'];
if(!isset($_SESSION['email'])){
    header("location: http://localhost/facebookapp/index.php");
}
?>

<body>

    <div class="header">
    <div class="d-flex flex-row justify-content-between p-1 w-100" style="background-color: #fff" >
        <div class="d-flex flex-row">
        <a href="home.php" class="d-flex"><img src="../img/facebooklogo.png" alt="facebooklogo" class=" img" style="margin-top: 9px;"></a>
        <div class="d-flex input-search">
            <input type="text" placeholder="Search Facebook" class="form-control" id="search_user" style="width:calc(80%);border-radius: 50px !important;"/>
            <button type="button" class="btn btn-light" id="btn-search" style="width:calc(20%);border-radius: 50px !important; margin-bottom: 8px;"><i class="ti-search p-2 m-1 "></i></button>
        </div>
        </div>
        <div class="d-flex">
            <a href="home.php" class="p-2 btn btn-light btnhome" ><i class="ti-home"></i></a>
        </div>
        <div class="d-flex">
            <a href="user_profile.php?id=<?php echo $user_id; ?>" class="btn text-dark ">
                <img src="../img/avartar/<?php echo $imgPath;?>" alt="img" class="img rounded-circle mr-1" style="max-width: calc(100%); height" >
                <span id="Name" style="padding-top: 2px;"><?php echo $name; ?></span>
            </a>
            <ul class="dropdown">
                <a class="dropdown-toggle btn btn-light" style="margin-top: 10px;" data-toggle="dropdown" href="#">
                </a>
            <ul class= "dropdown-menu dropdown-user" style="left: -100px;">
                <li>
                    <a href="user_profile.php?id=<?php echo $user_id; ?>"><i class="ti-user"></i> User Profile</a>
                </li>
                <li>
                    <a href="#" type="button" data-toggle="modal" data-target="#manager_account" ><i class="ti-settings"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="../index.php?logout=logout&id=<?php echo $user_id; ?>"><i class="ti-power-off"></i> Logout</a>
                </li>
            </ul>
            </ul>
        </div>
    </div>
    </div>
    
    <div class="manager">
        <?php include "manager_account.php"; ?>
    </div>