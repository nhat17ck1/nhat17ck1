<?php
//start session
session_start();
//load core function
require_once('functions.php');
require_once('./vendor/autoload.php');
require_once('config.php');
//alway display error
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
//detect page
$page=detectPage();
//connection
$db = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8", $DB_USER, $DB_PASSWORD);
//detect login
$currentUser=null;
if (isset($_SESSION['userId'])){
   $currentUser=findUserByID($_SESSION['userId']);
}
//