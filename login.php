<?php
    ob_start();
    require_once 'init.php';
?>
<?php include 'header.php';?>
<section class="container-fluid" style="background-color: #e3f2fd; padding :172px">
    <section class="row justify-content-center">
        <section>
<h1><center>Đăng nhập</center></h1>
<?php if (isset($_POST['email'])&& isset($_POST['password'])):?>
<?php 
    $email=$_POST['email'];
    $password=$_POST['password'];
    $success=false;

    $user = findUserByEmail($email);

    if ($user && $user['status'] == 1 &&password_verify($password, $user['password'])) {
        $success=true;
        $_SESSION['userId']= $user['id'];
    }
?>
<?php if($success):?>
<?php ob_start();?>
<?php header('Location: index.php'); ?>
<?php else: ?>
<div class="alert alert-danger"role="alert">
    Đăng nhập thất bại
<!-- <?php
    echo "<script>window.open('login.php','_self')</script>"; ?> -->
</div>
<?php endif; ?>
<?php else: ?>
<div class="card"style="width:350px">
  <div class="card-body">
    <form action="login.php" method="POST">
			<div class="form-group">
				<label for="email"><strong>Email</strong></label>
				<input type="email" class="form-control" id="email" name="email" placeholder="Tên đăng nhập" min=-100 max=1000>				
			</div>
			<div class="form-group">
				<label for="password"><strong>Mật khẩu</strong></label>
				<input type="password" class="form-control" id="password" name="password" placeholder="mật khẩu" min=-100 max=1000>	
			</div>
            
            <div class="form-group">
                <div style="text-align: right" >
                <a href ="forgetpass.php"><strong>Quên mật khẩu?</strong></a>
                </div>
            </div>
			<button type="submit" class="btn btn-primary"min=-100 max=100>Đăng nhập</button>
		</form>	
        </div>
</div>
        </section>
    </section>
</section>
<?php endif; ?>
<?php include 'footer.php';?>

