<?php

require_once __DIR__.'/../connect.php';

$sUserName = $_POST['txtSignupUserName'] ?? ''; 
if (empty($sUserName)){sendResponse(0, __LINE__);}
if (strlen($sUserName) < 2 ){sendResponse (0, __LINE__);} 
if (strlen($sUserName) > 20){sendResponse (0, __LINE__);}

// Validate email
$sEmail = $_POST['txtSignupEmail'] ?? ''; 
if (empty($sEmail)){sendResponse(0, __LINE__);}
if( !filter_var( $sEmail, FILTER_VALIDATE_EMAIL ) ){ sendResponse(0, __LINE__);}

// Validate Password
$sPassword = $_POST['txtSignupPassword'] ?? '';
if (empty($sPassword)){sendResponse(0, __LINE__);}
if (strlen($sPassword) < 4){sendResponse(0, __LINE__);}
if (strlen($sPassword) > 20){sendResponse(0, __LINE__);}

// Validate confirm Password
$sConfirmPassword = $_POST['txtSignupConfirmPassword'] ?? '';
if (empty($sConfirmPassword)){sendResponse(0, __LINE__);}
if ($sPassword != $sConfirmPassword ){sendResponse(0, __LINE__);}

//$PasswordHash = password_hash($sPassword, PASSWORD_DEFAULT);

try{
    $stmt = $db->prepare('INSERT INTO users VALUES (null, :sUserName, :sEmail, :sPassword, CURRENT_TIMESTAMP)');
    $stmt->bindValue(':sUserName', $sUserName);
    $stmt->bindValue(':sEmail', $sEmail);
    $stmt->bindValue(':sPassword', $sPassword);
    $stmt->execute();
    $iUserId =$db->lastInsertId(); // get the id for the user

    header('Location: ../login.php');
} catch (PDOEXception $ex){
    echo $ex;
}



// **************************************************

function sendResponse( $bStatus, $iLineNumber ){
    echo '{"status":'.$bStatus.', "code":'.$iLineNumber.'}';
    exit;
}