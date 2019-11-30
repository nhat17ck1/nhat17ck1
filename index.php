<?php
 require_once 'init.php';
 //require_once 'functions.php';
 // Xử lý logic ở đây
 $posts=getNewfeeds();
?>
<?php include 'header.php'; ?>
<br>
<?php if ($currentUser): ?>
<div class="container">
    <p style="">Chào mừng "<?php echo $currentUser['displayName'];?>" đã quay trở lại</p>
            <form action="upstatus.php" method="POST">
                <div class="form-group">
                    <label for="content"><strong>Nội dung</strong></label>
                    <textarea class="form-control" name="content" id="content" rows="3"placeholder="<Bạn đang nghĩ gì?"></textarea>		
                </div>
                <button type="submit" class="btn btn-primary">Đăng</button>
            </form>	
            <br>
    <div class="row">
    <?php foreach ($posts as $post):?>
    <div class="col-sm-12">
        <div class="card" >
    <!-- <img class="card-img-top" src="avatars/<?php echo $post['userId'];?>.jpg" alt="<?php echo $post['displayName'];?>"> -->
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
        </div>
        <br>
    </div>
    <?php endforeach ?>
    </div>
    <?php else:?>
    <div class="row">
        <div class="col-md-8" style="left: 8%;">
        <h2> <strong>See what's happening <br> in the world right now</strong></h2><br>
        <img style="width: 380px;" src="https://cdn.pixabay.com/photo/2017/02/25/23/52/connections-2099068_1280.png">
        </div>
        <div class="col-md-4"style="right: 6%;">
            <h1 style="font-family: inherit;font-size:36px ">Đăng ký</h1>
            <h3 style="font-family: inherit;font-size: 19px">Nhanh chóng dễ dàng</h3>
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
                    <p><button type = "submit" class = "btn btn-primary">Đăng Ký</button> </p>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
<?php endif?>

<?php include 'footer.php'; ?>
