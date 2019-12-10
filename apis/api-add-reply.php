<?php 
echo "jhghj";
require_once __DIR__.'/../connect.php';

session_start();

if(isset($_POST['iuserId'])){
    $iUserId = $_POST['iuserId'];
}

if(isset($_POST['iSubjectId'])){
    $iSubjectId = $_POST['iSubjectId'];
}

$sComment = $_POST['sSubjectMessage'] ?? '';

print_r($_POST);

echo $sComment;
if (strlen($sComment) < 1 ){sendResponse (0, __LINE__);} 
if (strlen($sComment) > 530){sendResponse (0, __LINE__);}

try{
    echo $iSubjectId;
    $stmt = $db->prepare('INSERT INTO forum_subject_messages VALUES (NULL, :iSubjectId, :iUserId, NOW(), :sComment');
    $stmt->bindValue(':iSubjectId', $iSubjectId);
    $stmt->bindValue(':iUserId', $iUserId);
    $stmt->bindValue(':sComment', $sComment);
    $stmt->execute();

} catch (PDOEXception $ex){
    echo $ex;
} 

// **************************************************

function sendResponse( $bStatus, $iLineNumber ){
    echo '{"status":'.$bStatus.', "code":'.$iLineNumber.'}';
    exit;
}






/* 
if(isset($_POST['BtnSubmitComment'])) {
    if(isset($_POST['sSubjectMessage'])) {
       $iSubjectId = htmlspecialchars($_POST['iSubjectId']);
       $sComment = htmlspecialchars($_POST['sSubjectMessage']);
       if(!empty($sComment)) {
          if(strlen($sComment) <= 530) {
            $stmt = $db->prepare('INSERT INTO forum_subject_messages VALUES (NULL, :iSubjectId, :iUserId, NOW(), :sComment');
            $stmt->bindValue(':iSubjectId', $iSubjectId);
            $stmt->bindValue(':iUserId', $iUserId);
            $stmt->bindValue(':sComment', $sComment);
            $stmt->execute();

          } else {
             $error = "Your subject cannot be longer than 530 characters";
          }
       } else {
          $error = "Please complete all required fields.";
       }
    }
 } */