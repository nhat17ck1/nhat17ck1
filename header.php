<!doctype html>
<html lang="en">
  <head >
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
    <script src="https://code.jquery.com/jquery-latest.js"></script>
    <link rel="stylesheet" href="style/style.css" media="all"/>
      <script>
      $(function(){
          $('.target').scroll(function(){
              $("span").css("display", "inline").fadeOut("slow");
          });
      });
      </script>
  </head>
<body style="background-color: #E9EBEE ">
  <nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark ; position: fixed;"style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
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
          <form action="login.php" method="POST">
            <table>
              <tr>
                <th style="color: #e3f2fd" >Username</th>
               
                <th style="color: #e3f2fd" >Password</th>
              </tr>
              <tr>
                <td><input type="email" class="form-control" id="email" name="email" placeholder="Tên đăng nhập"required ></td>
                <td  ><input type="password" class="form-control" id="password" name="password" placeholder="mật khẩu" required> </td>
                <td><button type="submit" class="btn btn-primary"min=-100 max=100 >Đăng nhập</button></td>
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
        <a class="nav-link" href="profile.php?id=<?php echo $currentUser['id']?>">
          <?php if($currentUser['picture']):?> 
            <img style="width: 30px;height: 30px" class="card-img-top" src="avatar.php?id=<?php echo $currentUser['id']?>">
            <?php else: ?>
            <img src="avatars/no-avatar.jpg" style="width: 30px;height: 30px" class="card-img-top">
            <?php endif ?>
   
          <?php echo $currentUser ? ''. $currentUser['displayName'].'':''?>
        </a>
        </li>
        <li class="nav-item <?php echo $page =='index' ? 'active':''?>">
        <a class="nav-link" href="index.php">Trang chủ </a>
      </li>
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