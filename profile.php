
<?php
ob_start(); 
require_once 'init.php';
$avatar=$currentUser['picture'];
$covers=$currentUser['cover'];
if(!$currentUser){
    header('Location: index.php');
  
}
$userId=$_GET['id'];
$profile=findUserByID($userId);
$usersinfo=findInfoUserByID($userId);
$postsprofile=getNewfeedsinprofile($userId);
$isFollowing =getFriendship($currentUser['id'],$userId);
$isFollower =getFriendship($userId,$currentUser['id']);
?>

<?php
    include 'header.php';
?>
<?php 
$userprofile=$profile['displayName'];
$des=$usersinfo['user_describe'];
$status=$usersinfo['Relationship_Status'];
$Live=$usersinfo['Lives_In'];
$numberPhone=$profile['numberPhone'];
$Gender=$usersinfo['Gender'];
$birthday=$profile['birthday'];
$date=date_create($birthday);
$dateformat=  date_format($date,"d/m/y"); 
?>
<?php if(isset($_POST['uploadclick'])||isset($_POST['save_pic'])||isset($_POST['upstatus_profile'])||isset($_POST['save_info'])):?>
<?php 
  if(isset($_FILES['cover'])) {
    $FILES =$_FILES['cover'];
    $fileName = $FILES['name'];
    $fileSize = $FILES['size'];
    $fileTemp = $FILES['tmp_name'];
      $newImage1 = resizeImage($fileTemp, 250, 250);
      ob_start();
      imagejpeg($newImage1);
      $covers=ob_get_contents();
      ob_end_clean();
      updateCover($currentUser['id'],$covers);
      $success=true;
  }
  if(isset($_FILES['avatar'])) {
    $FILES =$_FILES['avatar'];
    $fileName = $FILES['name'];
    $fileSize = $FILES['size'];
    $fileTemp = $FILES['tmp_name'];
      $newImage = resizeImage($fileTemp, 250, 250);
      ob_start();
      imagejpeg($newImage);
      $avatar=ob_get_contents();
      ob_end_clean();
      updateAvatar($currentUser['id'],$avatar);
      $success=true;
  }
  if(isset($_POST['upstatus_profile'])){
  $content=$_POST['content'];
  upstatus($currentUser['id'],$content);
  $success=true;
  }
?>
<?php if ($success): ?>
<?php echo "<script>window.open('profile.php?id=$userId','_self')</script>"; ?>
<?php else : ?>
<div class ="alert alert-danger" role="alert">cập nhật thông tin thất bại</div>
<?php endif ?>
<?php else: ?>
<div class="container">
    <div class="cover">
        <div class="row">
	        	<div class="col-sm-12">
                      <div class="well">
                            <?php if($profile['cover']): ?>
                              <img src="cover.php?id=<?php echo $profile['id']?>" style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                                      <?php if($isFollowing && $isFollower): ?>
                                          <div class="alert alert-primary" role="alert"style="position: absolute; right:150px;bottom:-10px">
                                             Bạn bè
                                          </div>
                                          <form method="POST" action="remove-friend.php">
                                              <input type="hidden" name="id" value="<?php echo $_GET['id'] ; ?>">
                                          <button type="submit" class="btn btn-primary"style="position: absolute; right:20px;bottom:10px"> Hủy bạn bè </button>
                                          </form>
                                      <?php else: ?>
                                      <?php if ($isFollowing && !$isFollower):?>
                                          <form method="POST" action="remove-friend.php">
                                              <input type="hidden" name="id" value="<?php echo $_GET['id'] ; ?>">
                                          <button type="submit" class="btn btn-primary"style="position: absolute; right:20px;bottom:10px"> Xóa yêu cầu kết bạn </button>
                                          </form>
                                      <?php endif ?>
                                      <?php if (!$isFollowing && $isFollower):?>
                                          <form method="POST" action="remove-friend.php">
                                              <input type="hidden" name="id" value="<?php echo $_GET['id'] ; ?>">
                                          <button type="submit" class="btn btn-primary"style="position: absolute; right:20px;bottom:10px"> Hủy yêu cầu kết bạn </button>
                                          </form>
                                          <form method="POST" action="add-friend.php">
                                              <input type="hidden" name="id" value="<?php echo $_GET['id'] ; ?>">
                                          <button type="submit" class="btn btn-primary"style="position: absolute; right:200px;bottom:10px">Đồng ý yêu cầu kết bạn </button>
                                          </form>
                                      <?php endif ?>
                                      <?php if (!$isFollower && !$isFollowing):?>
                                          <?php if($profile['id']==$currentUser['id']):?>
                                          <?php else: ?>
                                          <form method="POST" action="add-friend.php">
                                              <input type="hidden" name="id" value="<?php echo $_GET['id'] ; ?>">
                                          <button type="submit" class="btn btn-primary"style="position: absolute; right:20px;bottom:10px">Gửi yêu cầu kết bạn</button>
                                          </form>
                                          <?php endif ?>
                                      <?php endif ?>
                                  <?php endif ?>
                            <?php else: ?>
                              <img src="cover/default_cover.jpg" style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                            <?php endif ?>
                        </div>
                  
                    <?php if($profile['picture']):?> 
                    <img src="avatar.php?id=<?php echo $profile['id']?>" alt="Avatar" class="img-raised rounded-circle img-fluid"style="height: 174px; width: 170px;">
                    <?php else: ?>
                    <img src="avatars/no-avatar.jpg" alt="Avatar" class="img-raised rounded-circle img-fluid"style="height: 174px; width: 170px";>
                    <?php endif ?>
                    <?php if ($currentUser['id']!=$profile['id']) :?>
                    <?php else:?>
                    <form action="updateinfo.php" method="post" enctype="multipart/form-data">
                      <ul class="nav pull-left" style="position: absolute;top: 10px;left: 50px;">
                          <li class="dropdown"style="opacity: 0.5;filter: alpha(opacity=50);">
                              <button class="dropdown-toggle btn btn-secondary" data-toggle="dropdown">Change Cover</button> 
                              <div class="dropdown-menu"style="width:300px;height: 150px">
                                <center>
                                <p><strong>Select Cover</strong> and then click the <br> <strong>Update Cover
                                <label class='btn btn-info'style="width:300px;">
                                <input type='file' name='cover' size='60' />
                                </label>
                                <button name='uploadclick' class='btn btn-info'>Update</button>
                                </strong></p>
                                  
                                  </center>
                                </div>
                            </li>
                        </ul>
                    </form>
                    <?php endif?>
                  </div>
                </div>
            </div>
    <div class="row">
        <div class="col-sm-12">
          <div class="well">
            <center><h1 style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"><strong>Bambo social</strong></h1></center>
          </div>
        </div>
      </div>
      <div class="row">
            <div class="col-sm-4" style="border-radius: 5px;">
                      
                <div class="card"style="height :882px" >
                    <div class="card-body">
                    <?php if ($currentUser['id']!=$profile['id']) :?>
                    <?php else:?>
                      <div class="btn-group">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" >
                                <img src="icon/camera.png" alt="avatar" style="width: 25px;height: 25px">
                                </button>
                              <div class="dropdown-menu">
                                <a class="dropdown-item">
                                <form method = "POST" enctype="multipart/form-data"action="profile.php"  >
                                <div class="form-group">
                                    <input type="file" class="form-control-file" id="avatar"name="avatar">
                                </div>
                                    <p><button name="save_pic" class = "btn btn-primary">Update</button> </p>
                                </form>
                                </a>
                              </div>
                      </div>
                      <?php endif?>
                
                        <!-- asfasdfasdfasdfasdf -->
                        <?php if ($currentUser['id']!=$profile['id']) :?>
                        <?php else:?>
                        <?php if(!$userinfo['id']):?>
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                Sửa
                              </button>
                              <!-- Modal -->
                              <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLongTitle">Thông tin cá nhân</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <div aria-hidden="true">&times;</div>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method = "POST" enctype="multipart/form-data"action="updateinfo.php"  >
                                          <div class="card-body";>
                                              <div class="row">
                                                <div class="col-md-6"style="left:auto;right:auto" >
                                        
                                              <div class = "form-group">
                                                  <label for="describe_insert"  ><strong>Describe </strong></label> 
                                                  <input type="text" class = "form-control" id = "describe_insert" name = "describe_insert" placeholder="describe" >
                                              </div>

                                              <div class = "form-group">
                                                  <label for="Relationship_status_insert"  ><strong>Relationship status</strong></label> 
                                                  <input type="text" class = "form-control" id = "Relationship_status_insert" name = "Relationship_status_insert"placeholder="Relationship status"  >
                                              </div>
                                              <p><button name="insertinfo" class = "btn btn-primary">insert</button> </p>   
                                              </div>
                                             
                                              <div class="col-md-6"style="left:auto;right:auto">
                                              <div class = "form-group">
                                                  <label for="Lives_insert"><strong>Lives In</strong></label> 
                                                  <select class="form-control" name="Lives_insert" >
                                                    <option disabled>Select a Country</option>
                                                    <option>Vietnam</option>
                                                    <option>United States of America</option>
                                                    <option>India</option>
                                                    <option>Japan</option>
                                                    <option>UK</option>
                                                    <option>France</option>
                                                    <option>Korea</option>
                                                    <option>China</option>
                                                  </select>
                                              </div>
                                        
                                              <div class = "form-group">
                                                  <label for="Gender_"><strong>Gender</strong></label> 
                                                  <select class="form-control input-md" name="Gender_" >
                                                    <option disabled="disabled">Select a Gender</option>
                                                    <option>Male</option>
                                                    <option>Female</option>
                                                    <option>Others</option>
                                                  </select>
                                              </div>                                      
                                             </div>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                                                      
                          <!-- dfjhasdfhjkgasdjkfh -->
                          <?php endif?>
                          <?php endif?>
                          <?php if ($currentUser['id']!=$profile['id']) :?>
                        <?php else:?>
                        <?php if($userinfo['id']):?>
                          <!-- Button trigger modal -->
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                Sửa
                              </button>

                              <!-- Modal -->
                              <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLongTitle">Thông tin cá nhân</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <div aria-hidden="true">&times;</div>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                    <form method = "POST" enctype="multipart/form-data"action="updateinfo.php"  >
                                      <div class="card-body">
                                      <div class="row">
                                        <div class="col-md-6"style="left:auto;right:auto" >
                                      <div class = "form-group">
                                            <label for="displayName"  ><strong>Fullname</strong></label>
                                            <input type="text" class = "form-control" id = "displayName" name = "displayName" value="<?php echo $currentUser['displayName'];?>" >
                                      </div>

                                      <div class = "form-group">
                                          <label for="describe"  ><strong>Describe </strong></label> 
                                          <input type="text" class = "form-control" id = "describe" name = "describe" value="<?php echo $userinfo['user_describe'];?>" >
                                      </div>

                                      <div class = "form-group">
                                          <label for="Relationship_status"  ><strong>Relationship status</strong></label> 
                                          <input type="text" class = "form-control" id = "Relationship_status" name = "Relationship_status" value="<?php echo $userinfo['Relationship_Status'];?>" >
                                      </div>
                                      <div class = "form-group">
                                          <label for="Lives"><strong>Lives In</strong></label> 
                                          <select class="form-control" name="Lives" >
                                            <option disabled>Select a Country</option>
                                            <option>Vietnam</option>
                                            <option>United States of America</option>
                                            <option>India</option>
                                            <option>Japan</option>
                                            <option>UK</option>
                                            <option>France</option>
                                            <option>Korea</option>
                                            <option>China</option>
                                          </select>
                                      </div>
                                      </div>
                                            <div class="col-md-6"style="left:auto;right:auto">
                                      <div class = "form-group">
                                          <label for="numberPhone"  ><strong>numberPhone</strong></label> 
                                          <input type="text" class = "form-control" id = "numberPhone" name = "numberPhone" value="<?php echo $currentUser['numberPhone'];?>" >
                                      </div>
                                      <div class = "form-group">
                                          <label for="Gender_"><strong>Gender</strong></label> 
                                          <select class="form-control input-md" name="Gender_">
                                            <option disabled="disabled">Select a Gender</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                            <option>Others</option>
                                          </select>
                                      </div>
                                      <div class="form-group>">
                                            <label for="birthday"><strong>Ngày sinh</strong></label> 
                                          <input type="date" name="birthday"id = "birthday" class="form-control input-md"value="<?php echo $currentUser['birthday'];?>"> <br>
                                      </div>
                            
                                      <p><button name="save_info" class = "btn btn-primary">Save changes</button> </p>
                                      </div>
                                    </div>
                                    </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                      </div>
                      <?php endif?>
                      <?php endif?>
              <?php
              echo"
                  <center><h2><strong>About</strong></h2></center><br>
                  <center><h4><strong>$userprofile</strong></h4></center>
                  <p><strong><i style='color:grey;'>______________________________________________</i></strong></p><br>
                  <p><strong><i style='color:grey;'><center>$des</center></i></strong></p><br>
                  <p><strong>Relationship Status: </strong> $status</p><br>
                  <p><strong>Lives In: </strong> $Live</p><br>
                  <p><strong>NumberPhone: </strong> $numberPhone</p><br>
                  <p><strong>Gender: </strong>$Gender  </p><br>
                  <p><strong>Date Of Birth: </strong>$dateformat  </p><br>
                  ";
                  ?>
                   </div>
                  </div>
                  <br>
            </div>
            <div class=" col-sm-8">
            <div class="card"style="left:auto;right:auto;top:auto;bottom:auto;width:auto;" >
            <div class="card-body">
                  <form action="profile.php" method="POST">
                      <div class="form-group">
                          <label for="content"><strong>Nội dung</strong></label>
                          <textarea class="form-control" name="content" id="content" rows="3"placeholder="Bạn đang nghĩ gì?"></textarea>		
                      </div>
                      <button type="submit" name="upstatus_profile" class="btn btn-primary">Đăng</button>
                  </form>
            </div>
        </div>
        	<br>
            <div class="card"style="left:auto;right:auto;top:auto;bottom:auto;width:auto;">
            <div class="card-body">
            <div class="target" ><center><strong>
            </strong></center> <span></span><br />
                <?php foreach ($postsprofile as $posts):?>
                  <div class="col-sm-12">
                  <form  method="POST">
                      <span class="card" >
                          <div class="card-body"style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                            <h5 class="card-title">
                              <?php if($posts['picture']):?> 
                              <img style="width: 100px" class="card-img-top" src="avatar.php?id=<?php echo $posts['userId']?>"> 
                              <?php else: ?>
                              <img src="avatars/no-avatar.jpg" style="width: 100px" class="card-img-top">
                              <?php endif ?>
                              <?php echo $posts['Fullname'];?>
                              </h5>
                              <p class="card-text"> Đăng lúc: 
                              <?php echo $posts['createAt'];?>
                              </p>
                              <p class="card-text">
                              <?php echo $posts['content'];?>
                              </p>
                              <?php if($posts['Fullname'] == $currentUser['displayName']):?>
                                <div class="col"style="text-align: right;position: absolute; left:8px;top:8px "><button type="submit" name="delete_post_profile" value = <?php echo $posts['id'] ?>  class="btn btn-danger" >Xóa</button></div>
                                  <?php 
                                  if(isset($_POST['delete_post_profile']))
                                  {
                                      $value = $_POST['delete_post_profile'];
                                      deletepost($value);
                                      header("Location: profile.php");
                                      }
                                  ?>
                              <?php else:?>
                              <?php endif;?>
                              </div>
                      </span>
                      <br>
                      </form>
                  </div>
                  <?php endforeach ?>
                  </div>
            </div>
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