<?php 
require_once('./vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function detectPage(){
    $uri=$_SERVER['REQUEST_URI'];
    $parts=explode('/',$uri);
    $fileName=$parts[2];
    $parts=explode('.',$fileName);
    $page =$parts[0];
    return $page;
}
function findUserByEmail($email)
{
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE email =?");
    $stmt->execute(array($email));
    return  $stmt->fetch(PDO::FETCH_ASSOC);
}
function findUserByID($id)
{
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE id =?");
    $stmt->execute(array($id));
    return  $stmt->fetch(PDO::FETCH_ASSOC);
}
function findInfoUserByID($id)
{
    global $db;
    $stmt = $db->prepare("SELECT * FROM users_info WHERE id =?");
    $stmt->execute(array($id));
    return  $stmt->fetch(PDO::FETCH_ASSOC);
}
function UpdateUserPassword($id, $password){
    global $db;
    $hashPassword = password_hash($password,PASSWORD_DEFAULT);
    $stmt=$db->prepare("UPDATE users SET password= ? WHERE id= ?");
    return $stmt->execute(array($hashPassword,$id));
}
function updateUserProfile($id, $displayName,$numberPhone,$birthday){
    global $db;
    $stmt=$db->prepare("UPDATE users SET displayName= ?,numberPhone=? ,birthday=? WHERE id= ?");
    return $stmt->execute(array($displayName,$numberPhone,$birthday,$id));
}
function updateUserMyProfile($id,$user_describe,$Relationship_Status,$Lives_In,$Gender){
  global $db;
  $stmt=$db->prepare("UPDATE users_info SET user_describe=?,Relationship_Status=?,Lives_In=?,Gender=? WHERE id= ?");
  return $stmt->execute(array($user_describe,$Relationship_Status,$Lives_In,$Gender,$id));
}
function updateAvatar($id, $picture) {
  global $db;
  $stmt = $db->prepare("UPDATE users SET picture = ? WHERE id = ?");
  $stmt->execute(array( $picture, $id));
}
function updateCover($id, $cover) {
  global $db;
  $stmt = $db->prepare("UPDATE users SET cover = ? WHERE id = ?");
  $stmt->execute(array( $cover, $id));
}
function deletepost($post) {
  global $db;
  $stmt = $db->prepare("DELETE  FROM posts  WHERE id=?  ");
  $stmt->execute(array($post));
  return $post;
}
function insert_info_profile($ID,$user_describe,$Relationship_Status,$Lives_In,$Gender){
  global $db;
  $stmt=$db->prepare("INSERT INTO users_info (id,user_describe,Relationship_Status,Lives_In,Gender) VALUES (?,? , ?,?,?)");
  $stmt->execute(array($ID,$user_describe,$Relationship_Status,$Lives_In,$Gender));
 return $db->lastInsertId();
}
function getNewfeeds(){
  global $db;
  $stmt=$db->query("SELECT p.id,p.userId,u.picture,u.displayName as Fullname,p.content,p.createAt FROM users AS u JOIN posts as p WHERE u.id= p.userId ORDER BY p.createAt DESC");
  $stmt->execute();
  $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $posts;
}
function getNewfeedsinprofile($id){
  global $db;
  $stmt=$db->prepare("SELECT p.*,u.displayName as Fullname,u.picture FROM users AS u JOIN posts as p WHERE u.id= p.userId and u.id = ? ORDER BY p.createAt DESC");
  $stmt->execute(array($id));
  $posts= $stmt -> fetchAll(PDO::FETCH_ASSOC);
  return $posts;
}
function upstatus($userId,$content){
    global $db;
    $stmt=$db->prepare("INSERT INTO posts (content,userId) VALUES (? , ?)");
    $stmt->execute(array($content,$userId));
   return $db->lastInsertId();
}
function createUser($displayName, $email, $password,$numberPhone,$birthday) {
    global $db, $BASE_URL;
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $code = generateRandomString(16);
    $stmt = $db->prepare("INSERT INTO users (displayName, email, password, numberPhone,birthday, status, code) VALUES (?, ?, ?, ?,?, ?, ?)");
    $stmt->execute(array($displayName, $email, $hashPassword,$numberPhone,$birthday, 0, $code));
    $id = $db->lastInsertId();
    sendEmail($email, $displayName, 'Kích hoạt tài khoản', "Mã kích hoạt tài khoản của bạn là <a href=\"$BASE_URL/activate.php?code=$code\">$BASE_URL/activate.php?code=$code</a>");
    
    return $id;
  }
  function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
    function sendEmail($to, $name, $subject, $content) {
      global $EMAIL_FROM, $EMAIL_NAME, $EMAIL_PASSWORD;
    
      // Instantiation and passing `true` enables exceptions
      $mail = new PHPMailer(true);
    
      //Server settings
      $mail->isSMTP();                                            // Send using SMTP
      $mail->CharSet    = 'UTF-8';
      $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
      $mail->Username   = $EMAIL_FROM;                     // SMTP username
      $mail->Password   = $EMAIL_PASSWORD;                               // SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
      $mail->Port       = 587;                                    // TCP port to connect to
    
      //Recipients
      $mail->setFrom($EMAIL_FROM, $EMAIL_NAME);
      $mail->addAddress($to, $name);     // Add a recipient
    
      // Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = $subject;
      $mail->Body    = $content;
      // $mail->AltBody = $content;
    
      $mail->send();
    }
    
    function activateUser($code) {
      global $db;
      $stmt = $db->prepare("SELECT * FROM users WHERE code = ? AND status = ?");
      $stmt->execute(array($code, 0));
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($user && $user['code'] == $code) {
        $stmt = $db->prepare("UPDATE users SET code = ?, status = ? WHERE id = ?");
        $stmt->execute(array('', 1, $user['id']));
        return true;
      }
      return false;
    }
    function ForgetPassword($id, $displayName, $email, $password)
    {
        global $db, $BASE_URL;
        $code = generateRandomString(8);
        $hassCode = password_hash($code, PASSWORD_DEFAULT);
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");               
        sendEmail($email, $displayName, 'Lấy mật khẩu mới', "Mật khẩu mới là $code.
        Vui lòng vào đường link này để đăng nhập <a href =\"$BASE_URL/login.php\">$BASE_URL/login.php</a>");
        return $stmt->execute(array($hassCode, $id));
    }
    function resizeImage($filename, $max_width, $max_height)
    {
      list($orig_width, $orig_height) = getimagesize($filename);

      $width = $orig_width;
      $height = $orig_height;

      # taller
      if ($height > $max_height) {
        $width = ($max_height / $height) * $width;
        $height = $max_height;
      }

      # wider
      if ($width > $max_width) {
        $height = ($max_width / $width) * $height;
        $width = $max_width;
      }

      $image_p = imagecreatetruecolor($width, $height);

      $image = imagecreatefromjpeg($filename);

      imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);

      return $image_p;
    }
    function sendFriendRequest($userId1,$userId2){
      global $db;
      $stmt = $db->prepare("INSERT INTO friendship(userId1,userId2) value (?,?)");
      $stmt->execute(array($userId1, $userId2));
    }
    function getFriendship($userId1,$userId2){
      global $db;
      $stmt = $db->prepare("SELECT * FROM friendship WHERE userId1 = ? AND userId2 = ?");
      $stmt->execute(array($userId1, $userId2));
      return $stmt -> fetch(PDO::FETCH_ASSOC);
    }
    function removeFriendRequest($userId1,$userId2){
      global $db;
      $stmt = $db->prepare("DELETE from friendship where (userId1 = ? AND userId2 = ?) OR ( userId2 = ? AND userId1 = ?)");
      $stmt->execute(array($userId1, $userId2,$userId1, $userId2));
    }