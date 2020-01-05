<?php 
session_start();
if( !isset($_SESSION['iUserId'] ) ){
  header('Location: login.php');
}

$iUserId = $_SESSION['iUserId'];

require_once __DIR__.'/../connect.php';

$sUserName = $_POST['txtUsername'] ?? ''; 
if (empty($sUserName)){sendResponse(0, __LINE__);}
if (strlen($sUserName) < 2 ){sendResponse (0, __LINE__);} 
if (strlen($sUserName) > 20){sendResponse (0, __LINE__);}

$sNewEmail = $_POST['txtUserEmail'] ?? '';
if (empty($sNewEmail)){sendResponse(0, __LINE__);}
if( !filter_var( $sNewEmail, FILTER_VALIDATE_EMAIL ) ){ sendResponse(0, __LINE__);}


try{
    $stmt = $db->prepare('UPDATE users SET username=:sNewUsername, email=:sNewEmail WHERE users.user_id = :iUserId');
    $stmt->bindValue(':sNewUsername', $sUserName);
    $stmt->bindValue(':sNewEmail', $sNewEmail);
    $stmt->bindValue(':iUserId', $iUserId); 
    $stmt->execute();
    
    header("Location: ../profile.php");
     
}
  catch(PDOException $ex){
    echo "FATAL ERROR";
    echo $ex;
    //Fatal error if you try to break the uniqueness in the table
    $db->rollBack();
} 