<?php
require_once 'init.php';
if(!$currentUser){
    header('Location: index.php');
    exit();
}
$content=$_POST['content'];
$prioty=$_POST['priority'];

if(isset($_POST['index_post'])){
    $check = getimagesize($_FILES["picture_post_icon"]["tmp_name"]);
    if($check !== false) {
        $FILES =$_FILES['picture_post_icon'];
        $fileName = $FILES['name'];
        $fileSize = $FILES['size'];
        $fileTemp = $FILES['tmp_name'];
        $newImage = resizeImage($fileTemp, 350, 300);
        ob_start();
        imagejpeg($newImage);
        $postImage=ob_get_contents();
        ob_end_clean();
        upstatus($currentUser['id'],$content,$postImage,$prioty);
    }
    else {
        $postImage=null;
        upstatus($currentUser['id'],$content,$postImage,$prioty);
    } 
}


// redirect to homepage
 header('Location: index.php'); ?>