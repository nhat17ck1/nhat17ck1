<?php
require_once 'init.php';
if(!$currentUser){
    header('Location: index.php');
    exit();
}

$content=$_POST['content'];
upstatus($currentUser['id'],$content);



// redirect to homepage
 header('Location: index.php'); ?>