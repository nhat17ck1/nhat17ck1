<?php
    ob_start();
    require_once 'init.php';
    $postsprofile=getNewfeedsinprofile($_SESSION['userId']);
?>
<?php include 'header.php';?>
<?php
if(!$currentUser){
   echo"<script>window.open('index.php','_self')</script>";
}
?>
<?php if(isset($_POST['uploadclick'])||isset($_POST['save_pic'])):?>
<?php 
if(isset($_FILES['cover'])) {
    $fileName = $_FILES['cover']['name'];
    $fileSize = $_FILES['cover']['size'];
    $fileTemp = $_FILES['cover']['tmp_name'];
    $fileSave = 'cover/' . $currentUser['id'] . '.jpg';
    // userid.jpg
    $result = move_uploaded_file($fileTemp, $fileSave);
    if (!$result) {
      $success = false;
    } else {
      $newImage = resizeImage($fileSave, 250, 250);
      imagejpeg($newImage, $fileSave);
      $currentUser['cover'] = 1;
      updatecover($currentUser);
      $success=true;
    }
  }
  if(isset($_FILES['avatar_1'])) {
    $fileName = $_FILES['avatar_1']['name'];
    $fileSize = $_FILES['avatar_1']['size'];
    $fileTemp = $_FILES['avatar_1']['tmp_name'];
    $fileSave = 'avatars/' . $currentUser['id'] . '.jpg';
    // userid.jpg
    $result = move_uploaded_file($fileTemp, $fileSave);
    if (!$result) {
      $success = false;
    } else {
      $newImage = resizeImage($fileSave, 250, 250);
      imagejpeg($newImage, $fileSave);
      $currentUser['avatar'] = 1;
      updateUser($currentUser);
      $success=true;
    }
  }

?>
<?php if ( $success): ?>
<?php echo"<script>window.open('myprofile.php','_self')</script>";?>
<?php else : ?>
<div class ="alert alert-danger" role="alert">cập nhật thông tin thất bại</div>
<?php endif ?>
<?php else: ?>

    <div class="cover">
      <?php if($currentUser['cover']): ?>
        <img src="cover/<?php echo $currentUser['id'];?>.jpg" >
      <?php else: ?>
        <img src="cover/default_cover.jpg" >       
      <?php endif ?>
    </div>
    <?php if($currentUser['picture']):?> 
            <img src="avatars/<?php echo $currentUser['id'];?>.jpg" alt="Avatar" class="img-raised rounded-circle img-fluid">
            <?php else: ?>
            <img src="avatars/no-avatar.jpg" alt="Avatar" class="img-raised rounded-circle img-fluid">
            <?php endif ?>

          <!-- <div class="btn-group " style="position: absolute; left: 170px;top: 300px;opacity: 0.5;filter: alpha(opacity=50);width: 50px;hight: 50px">
              <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="icon/camera.png" alt="avatar" style="width: 100%;hight: 50px">
              </button>
          </div>
            <div class="dropdown-menu">
              <a class="dropdown-item">
              <form method = "POST" enctype="multipart/form-data"action="myprofile.php" >
                <div class="form-group">
                <input type="file" class="form-control-file" id="avatar_1"name="avatar_1">
              </div>
                <p><button type = "submit" name="save_pic" class = "btn btn-primary">Cập Update</button> </p>
              </form>
              </a>
            </div> -->
<div class="btn-group"style="position: absolute; left: 50px;top: 70px;opacity: 0.5;filter: alpha(opacity=50);">
        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        cập nhật ảnh bìa
        </button>
    <div class="dropdown-menu">
        <a class="dropdown-item">
            <form method = "POST" enctype="multipart/form-data"action="myprofile.php"  >
        <div class="form-group">
            <input type="file" class="form-control-file" id="cover"name="cover">
        </div>
            <p><button type = "submit" name="uploadclick" value="Upload" class = "btn btn-primary">Update</button> </p>
        </form>
        </a>
    </div>
</div>
<div class="row">
		<div class="col-sm-12">
			<div class="well">
				<center><h1 ><strong>Bambo social</strong></h1></center>
			</div>
		</div>
  </div>
<div class="info">
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-8">
    </div>
</div>
<div class="container">
<div class="row">
  <div class="col-xs-6 .col-md-4">
          <div class="card"style="width:350px;height :600px;right:15%">
            <div class="card-body">
            </div>
          </div>
  </div>
  <div class="col-xs-6 .col-md-4" >
          <div class="card"style="width:790px;height :auto; left:auto">
            <div class="card-body">
            <div class="target">TimeLine <span></span><br />
                <?php foreach ($postsprofile as $post):?>
                  <div class="col-sm-12">
                      <span class="card" >
                          <div class="card-body">
                            <h5 class="card-title">
                              <?php if($post['picture']):?> 
                              <img style="width: 100px" class="card-img-top" src="avatars/<?php echo $post['userId'];?>.jpg"> 
                              <?php else: ?>
                              <img src="avatars/no-avatar.jpg" style="width: 100px" class="card-img-top">
                              <?php endif ?>
                              <?php echo $post['displayName'];?>
                              </h5>
                              <p class="card-text"> Đăng lúc: 
                              <?php echo $post['createAt'];?>
                              </p>
                              <p class="card-text">
                              <?php echo $post['content'];?>
                              </p>
                              </div>
                      </span>
                      <br>
                  </div>
                  <?php endforeach ?>
                  </div>
            </div>
          </div>
  </div>
</div>
      </div>
      </div>
<?php endif; ?>
<br>
<?php include 'footer.php';?>
