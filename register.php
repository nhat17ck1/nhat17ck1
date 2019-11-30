<?php
    ob_start();
    require_once 'init.php';
//require 'functions.php';
?>

<?php
    include 'header.php';
?>
<section class="container-fluid" style=" padding :120px">
    <section class="row justify-content-center ">
        <section>
<h1><center>Đăng ký</center></h1>
<?php 
    // echo $_POST['displayName'];
    // echo $_POST['email'];
    // echo $_POST['password'];
    // echo $_POST['numberPhone'];
?>
<?php if(isset($_POST['displayName']) && isset($_POST['email']) && isset($_POST['password'])&&isset($_POST['numberPhone'])): ?>
<?php 
$displayName= $_POST['displayName'];
$email = $_POST['email'];
$password = $_POST['password'];
$numberPhone=$_POST['numberPhone'];
$hashPassword = password_hash($password,PASSWORD_DEFAULT);

$success = false;
$user =findUserByEmail($email);

    if(!$user)
    {
        $newUserId=createUser($displayName, $email, $password, $numberPhone);
        $_SESSION['userId'] =$newUserId;
        $success =true;
    }
?>
<?php if ($success): ?>
    <div class="alert alert-success" role="alert">
  Vui lòng kiểm tra email để kích hoạt tài khoản
    </div>
<?php else : ?>
<div class ="alert alert-danger" role="alert">Đăng Ký Thất Bại</div>
<?php endif; ?>
<?php else : ?>
<div class="card"style="width:350px">
  <div class="card-body">
<form action="register.php" method = "POST">
    <div class = "form-group">
     <label for="displayName"  ><strong>Họ tên</strong></label>
    <input type="text" class = "form-control" id = "displayName" name = "displayName" placeholder = "Họ tên" >
    </div>
    <div class = "form-group">
      <label for="email"  ><strong>Email</strong></label> 
    <input type="email" class = "form-control" id = "email" name = "email" placeholder = "Email" >
    </div>

    <div class = "form-group">
     <label for="password"><strong>Mật Khẩu</strong></label> 
    <input type="password" class = "form-control" id = "password" name = "password" placeholder = "Mật Khẩu">
    </div>
    <div class = "form-group">
     <label for="numberPhone"><strong>Số điện thoại</strong></label> 
    <input type="numberPhone" class = "form-control" id = "numberPhone" name = "numberPhone" placeholder = "Số điện thoại">
    </div>

    
    <p><button type = "submit"  class = "btn btn-primary">Đăng Ký</button> </p>

    </form>
</div>
</div>
        </section>
    </section>
</section>
<?php endif; ?>
<?php include 'footer.php'; ?>