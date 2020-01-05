<?php 

session_start();
if( !isset($_SESSION['iUserId'] ) ){
    header('Location: login.php');
}

$iUserId = $_SESSION['iUserId'];

require_once __DIR__.'/../connect.php';

$sOldPassword = $_POST['txtLoginPassword'] ?? '';
if( empty($sOldPassword) ){ sendResponse(0, __LINE__);  }
if( strlen($sOldPassword) < 2 ){ sendResponse(0, __LINE__); }
if( strlen($sOldPassword) > 50 ){ sendResponse(0, __LINE__); }

// validate password
$sNewPassword = $_POST['txtLoginNewPassword'] ?? '';
if( empty($sNewPassword) ){ sendResponse(0, __LINE__);  }
if( strlen($sNewPassword) < 2 ){ sendResponse(0, __LINE__); }
if( strlen($sNewPassword) > 50 ){ sendResponse(0, __LINE__); }

// validate confirm password
$sConfirmNewPassword = $_POST['txtLoginConfirmNewPassword'] ?? '';
if( empty($sConfirmNewPassword) ){ sendResponse(0, __LINE__);  }
if( $sNewPassword != $sConfirmNewPassword ){ sendResponse(0, __LINE__);  }
// $jClient->password = password_hash($sNewPassword, PASSWORD_DEFAULT); 

try {
    $stmt = $db->prepare("UPDATE users 
                          SET password= :sNewPassword 
                          WHERE users.user_id = :iUserId AND password= :sOldPassword");
    $stmt->bindValue(':sNewPassword', $sNewPassword);
    $stmt->bindValue(':iUserId', $iUserId);
    $stmt->bindValue(':sOldPassword', $sOldPassword);
    $stmt->execute();
    
    header("Location: ../profile.php");

}catch(PDOException $ex){
    echo $ex;
}

/* --------------------------------------------------------------------------- */

 function sendResponse($iStatus, $iLineNumber){
    echo '{"status":'.$iStatus.', "code":'.$iLineNumber.'}';
    exit;
  }