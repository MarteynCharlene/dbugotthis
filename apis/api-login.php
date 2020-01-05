<?php 

require_once __DIR__ . '/../connect.php';

$sEmail = $_POST['txtLoginEmail'] ?? '';
if( empty($sEmail) ){sendResponse(0, __LINE__, "email field is empty");}
if( !filter_var( $sEmail, FILTER_VALIDATE_EMAIL ) ){ sendResponse(0, __LINE__, "email field doesn't match with an email format");  }

$sPassword = $_POST['txtLoginPassword'] ?? '';
if( empty($sPassword) ){ sendResponse(0, __LINE__,"password field empty");  }
if( strlen($sPassword) < 4 ){ sendResponse(0, __LINE__, "password should be more than 4 characters"); }
if( strlen($sPassword) > 50 ){ sendResponse(0, __LINE__, "password should be less than 50 characters"); }

try{
    $stmt = $db->prepare('SELECT COUNT(*) as total, user_id FROM users 
    WHERE email=:sEmail AND password = :sPassword');
    $stmt->bindValue(':sEmail', $sEmail); 
    $stmt->bindValue(':sPassword', $sPassword);
    $stmt->execute();
    $aRows = $stmt->fetchAll();
    
    if($aRows[0]->total == 0){
        header("Location: ../login.php");
        exit;
    }

    session_start();
    $_SESSION['iUserId'] = $aRows[0]->user_id;
    header("Location: ../index.php");

} catch(PDOEXception $ex){
    echo $ex;
}

// **************************************************

function sendResponse( $bStatus, $iLineNumber ){
    echo '{"status":'.$bStatus.', "code":'.$iLineNumber.'}';
    exit;
}