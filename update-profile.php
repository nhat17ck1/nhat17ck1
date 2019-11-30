<?php
require_once 'init.php';
if(!$currentUser){
    header('Location: index.php');
}
//require 'functions.php';
?>

<?php
    include 'header.php';
?>
<h1>Thông tin cá nhân</h1>
<?php if(isset($_POST['displayName'])):?>
<?php 
$displayName = $_POST['displayName'];
$numberPhone=$_POST['numberPhone'];
$success = false;
if(isset($_FILES['avatar'])) {
    $fileName = $_FILES['avatar']['name'];
    $fileSize = $_FILES['avatar']['size'];
    $fileTemp = $_FILES['avatar']['tmp_name'];
    $fileSave = 'avatars/' . $currentUser['id'] . '.jpg';
    // userid.jpg
    $result = move_uploaded_file($fileTemp, $fileSave);
    if (!$result) {
      $success = false;
    } else {
      $newImage = resizeImage($fileSave, 250, 250);
      imagejpeg($newImage, $fileSave);
      $currentUser['picture'] = 1;
      updateUser($currentUser);
    }
  }
if($displayName != '')
{
    updateUserProfile($currentUser['id'],$displayName,$numberPhone);
    $success =true;
}
?>
<?php if ( $success): ?>
<?php echo"<script>window.open('index.php','_self')</script>";?>
<?php else : ?>
<div class ="alert alert-danger" role="alert">cập nhật thông tin thất bại</div>
<?php endif ?>
<?php else: ?>
<div class="card" >
<div class="card-body">
<form method = "POST" enctype="multipart/form-data"action="update-profile.php" >
    <div class = "form-group">
    <label for="displayName"><strong>Họ tên</strong></label> 
    <input type="text" class = "form-control" id = "displayName" name = "displayName" placeholder = "Họ tên"value="<?php echo $currentUser['displayName'];?>">
    </div>
    <div class = "form-group">
    <label for="numberPhone"><strong>Số điện thoại</strong></label> 
    <input type="text" class = "form-control" id = "numberPhone" name = "numberPhone" placeholder = "Số điện thoại"value="<?php echo $currentUser['numberPhone'];?>">
     </div>
    <div class="form-group">
    <label for="avatar"><strong>Ảnh đại diện</strong></label>
    <input type="file" class="form-control-file" id="avatar"name="avatar">
  </div>
    <p><button type = "submit" name="save_pic" class = "btn btn-primary">Cập nhật thông tin cá nhân</button> </p>
</form>
</div>
</div>
<?php endif; ?>
<br>
<?php include 'footer.php';?>