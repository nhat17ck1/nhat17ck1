<?php
ob_start();
require 'init.php';
if(!$currentUser){
    header('Location: index.php');
    ob_start();
}
//require 'functions.php';
?>

<?php
    include 'header.php';
?>
<h1>Đổi mật khẩu</h1>
<?php if(isset($_POST['currentPassword']) && isset($_POST['password'])): ?>
<?php 
$password = $_POST['password'];
$currentPassword = $_POST['currentPassword'];

$success = false;


if(password_verify($currentPassword,$currentUser['password']) && ($password != $currentPassword))
{
    UpdateUserPassword($currentUser['id'],$password);
    $success =true;
}

?>
<?php if ($success): ?>
<?php header('Location: index.php');?>
<!-- <?php echo"<script>window.open('index.php','_self')</script>";?> -->
<?php else : ?>
<div class ="alert alert-danger" role="alert">Đổi mật khẩu thất bại</div>
<?php endif; ?>
<?php else : ?>
<div class="card" >
<div class="card-body">
<form action="change_password.php" method = "POST">
    <div class = "form-group">
    <label for="currentPassword"><strong>Mật Khẩu hiện tại</strong></label> 
    <input type="password" class = "form-control" id = "currentPassword" name = "currentPassword" placeholder = "Mật Khẩu hiện tại">
    </div>
    <div class = "form-group">
    <label for="password"><strong>Mật Khẩu mới</strong></label> 
    <input type="password" class = "form-control" id = "password" name = "password" placeholder = "Mật khẩu mới ">
    </div>
   
    <p><button type = "submit" class = "btn btn-primary">Đổi mật khẩu</button> </p>

    </form>
</div>
</div>
<?php endif; ?>
<br>
<?php include 'footer.php'; ?>
