<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-latest.js"></script>
      <style>
      div.target {
          height:600px;
          overflow:scroll;
      }
      span {
          color:red;
          display:none;
      }
      </style>
      <script>
      $(function(){
          $('.target').scroll(function(){
              $("span").css("display", "inline").fadeOut("slow");
          });
      });
      </script>
    <style>
		 button:hover {
  			box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
		}
    .main-navigation {
    box-shadow: 0 2px 2px -2px rgba(0,0,0,.2);
    }
    footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   text-align: center;
   background-color: #343A40;
   color: #FFFFFF;
  }
  div.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
.well{
		background-color: #FFFFFF;
    width:90%;
  margin-left: 40px;
    color:black;
	}
.info{
  width:90%;
  margin-left: 40px;
}
.icon{
  width:50px;height:50px
}
.img-raised.rounded-circle.img-fluid {
    position: absolute;
    left: 75px;
    top: 126px;
    width:230px;height:230px
}
.cover{
  width:90%;
  margin-left: 40px;
  
}
.avatar{
  position: absolute;
  left: 75px;
  top: 126px;
}
.cover img{
  width: 100%;
  height: 300px;
}
.navbar-nav .form{
   float:right;
   margin-right: 100px;;
   letter-spacing: 1px;
   font:-size:17px;
}
/* .btn-group {
  position: absolute;
  left: 50px;
  top: 70px;
  opacity: 0.5;
  filter: alpha(opacity=50); 
} */
.navbar-nav .input[type=email],.input[type=password],.input[type=submit]{
   padding: 5px;
   font:-size:15px;
   font-family:inherit;
   border:none;
   margin:1px;
}

	</style>
  </head>
<body style="background-color: #e3f2fd ">
  <nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark ; position: fixed;">
    <a class="navbar-brand " href="index.php"><strong>Bamboo social</strong></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <?php if (isset($currentUser)):?>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      <?php endif;?>
    </ul>
      <?php if (!$currentUser):?>
      <div class="navbar-nav mr-end">
        <!-- <li class="nav-item <?php echo $page =='forgetpass' ? 'active':''?>">
          <a class="nav-link" href="forgetpass.php">Quên mật khẩu </a>
        </li>
        <li class="nav-item <?php echo $page =='login' ? 'active':''?>">
          <a class="nav-link" href="login.php">Đăng nhập </a>
        </li>
	      <li class="nav-item <?php echo $page =='register' ? 'active':''?>">
          <a class="nav-link" href="register.php">Đăng Ký </a>
        </li>  -->
          <form action="login.php" method="POST">
            <table>
              <tr>
                <th style="color: #e3f2fd" >Username</th>
                <th style="color: #e3f2fd" >Password</th>
              </tr>
              <tr>
                <td><input type="email" class="form-control" id="email" name="email" placeholder="Tên đăng nhập" ></td>
                <td><input type="password" class="form-control" id="password" name="password" placeholder="mật khẩu">	</td>
                <td><button type="submit" class="btn btn-primary"min=-100 max=100>Đăng nhập</button></td>
              </tr>
              <tr>
                <td>
                </td>
                <td>
                <div style="text-align: right" >
                  <a href ="forgetpass.php">Quên mật khẩu?</a>
                </div>
               </td>
              </tr>
      </table>
          </form>	
      </div>
  </div>
  </nav>
      <?php else:?>
        
      <ul class="navbar-nav mr-auto">
        <li class="nav-item <?php echo $page =='myprofile' ? 'active':''?>">
        <a class="nav-link" href="myprofile.php">
          <?php if($currentUser['picture']):?> 
            <img style="width: 30px;hight: 50px" class="card-img-top" src="avatars/<?php echo $currentUser['id'];?>.jpg"?>
            <?php else: ?>
            <img src="avatars/no-avatar.jpg" style="width: 30px;hight: 50px" class="card-img-top">
            <?php endif ?>
   
          <?php echo $currentUser ? ''. $currentUser['displayName'].'':''?>
        </a>
        </li>
        <li class="nav-item <?php echo $page =='index' ? 'active':''?>">
        <a class="nav-link" href="index.php">Trang chủ </a>
      </li>
        <!-- <li class="nav-item <?php echo $page =='change_password' ? 'active':''?>">
          <a class="nav-link" href="change_password.php">Đổi mật khẩu </a>
        </li>
        <li class="nav-item <?php echo $page =='logout' ? 'active':''?>">
          <a class="nav-link" href="logout.php">Đăng xuất<?php echo $currentUser ? ' ('. $currentUser['displayName'].')':''?></a> -->
        <!-- <echo $currentUser ? '('. $currentUser['username'].')':''?> -->
        <!-- </li> -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Cài đặt
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item <?php echo $page =='update-profile' ? 'active':''?>" href="update-profile.php">Thông tin cá nhân</a>
            <a class="dropdown-item <?php echo $page =='change_password' ? 'active':''?>" href="change_password.php">Đổi mật khẩu </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item <?php echo $page =='logout' ? 'active':''?>" href="logout.php">Đăng xuất<?php echo $currentUser ? ' ('. $currentUser['displayName'].')':''?></a>
          </div>
        </li>
      </ul>
      <?php endif;?>
  </div>
</nav>