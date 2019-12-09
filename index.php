<?php
ob_start();
 require_once 'init.php';
 $newfeeds=getNewfeeds();
?>
<?php include 'header.php'; ?>
<br>
<?php if ($currentUser): ?>
<div class="container">
    <p>Chào mừng "<?php echo $currentUser['displayName'];?>" đã quay trở lại</p>
    <div class="card"style="" >
            <div class="card-body">
            <form action="upstatus.php" method="POST">
                <div class="form-group">
                    <label for="content"><strong>Nội dung</strong></label>
                    <textarea class="form-control" name="content" id="content" rows="3"placeholder="Bạn đang nghĩ gì?"></textarea>		
                </div>
                <button type="submit" class="btn btn-primary">Đăng</button>
            </form>	
            </div>
    </div>
    <br>
<div class="row">
    <?php foreach ($newfeeds  as $posts):?>
        <div class="col-sm-12">
            <form  method="POST">
                <div class="card" >
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php if($posts['picture']):?> 
                            <img style="width: 100px;height: 110px" class="card-img-top" src="avatar.php?id=<?php echo $posts['userId']?>">  
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
                            <div class="col"style="text-align: right;position: absolute; left:8px;top:8px ">    <button type="submit" name="delete" value = <?php echo $posts['id'] ?>  class="btn btn-danger" >Xóa</button>   </div>
                        
                            <?php 
                            if(isset($_POST['delete']))
                            {
                                $value = $_POST['delete'];
                                deletepost($value);
                                header("Location: index.php");
                                }
                            ?>
                        <?php else:?>
                        <?php endif;?>
                    </div>
                </div><br>
            </form>
        </div>
    <?php endforeach ?>
</div>
<?php else:?>
    <div class="container">
        <div class="row">
            <div class="col-sm-8" >
                <h2> <strong>See what's happening <br> in the world right now</strong></h2><br>
            <div class="social">
                <img style="width: 380px;" src="https://cdn.pixabay.com/photo/2017/02/25/23/52/connections-2099068_1280.png">
            </div >
        </div>
            <div class="col-sm-4">
                <div class="register_index">
                <h1 style="font-family: inherit;font-size:36px ">Đăng ký</h1>
                <h3 style="font-family: inherit;font-size: 19px">Nhanh chóng dễ dàng</h3>
                <div class="card"style="width:350px">
                    <div class="card-body">
                    <form action="register.php" method = "POST">
                        <div class = "form-group">
                            <label for="displayName"  ><strong>Họ tên</strong></label>
                            <input type="text" class = "form-control" id = "displayName" name = "displayName" placeholder = "Họ tên"required >
                        </div>
                        <div class = "form-group">
                            <label for="email"  ><strong>Email</strong></label> 
                            <input type="email" class = "form-control" id = "email" name = "email" placeholder = "Email" required>
                        </div>
                        <div class = "form-group">
                            <label for="password"><strong>Mật Khẩu</strong></label> 
                            <input type="password" class = "form-control" id = "password" name = "password" placeholder = "Mật Khẩu"required>
                        </div>
                        <div class = "form-group">
                            <label for="numberPhone"><strong>Số điện thoại</strong></label> 
                            <input type="tel" pattern="^\+?(?:[0-9]??).{5,14}[0-9]$" class = "form-control" id = "numberPhone" name = "numberPhone" placeholder="+8400000000" required>
                        </div>
                        <div class="form-group>">
                            <label for="birthday"><strong>Ngày sinh</strong></label> 
                            <input type="date" name="birthday"id = "birthday" class="form-control input-md" required>
                        </div><br>
                        <a style="text-decoration:none;float: right; color:#187FAB;" data-toggle="tooltip" title="login" href="login.php">Already have an account?</a>
                        <p><button type = "submit" class = "btn btn-primary">Đăng Ký</button> </p>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif?>
<?php include 'footer.php'; ?>

