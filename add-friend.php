<?php
require_once 'init.php';
if(!$currentUser){
    header('Location: index.php');
   exit();
    
}
$userId=$_POST['id'];
$profile=findUserByID($userId);
if(isset($_POST['btnclickSend'])){
    sendFriendRequest($currentUser['id'],$profile['id'],0);
}
else if(isset($_POST['btnclickAccpet'])){
    updateFriendRequest($profile['id'],$currentUser['id'],1);
    sendFriendRequest($currentUser['id'],$profile['id'],1);
}
header('Location: profile.php?id='.$_POST['id']);
