<?php 

require_once __DIR__.'/../connect.php';

session_start();
if( !isset($_SESSION['iUserId'] ) ){
  header('Location: login.php');
}

$iUserId = $_SESSION['iUserId'];


if(isset($_POST['txtSubjectAnswerSubmit'], $_POST['txtSubjectmessage'], $_POST['iSubjectId'])){
    if(!empty($_POST['txtSubjectmessage'])){
        $sAnswer = htmlspecialchars($_POST['txtSubjectmessage']);
        $iSubjectId = htmlspecialchars($_POST['iSubjectId']);

        $stmt = $db->prepare('INSERT INTO forum_subject_messages VALUES (null, :iSubjectId, :iUserId, NOW(), :sAnswer)');
        $stmt->bindValue(':iSubjectId', $iSubjectId);
        $stmt->bindValue(':iUserId', $iUserId);
        $stmt->bindValue(':sAnswer', $sAnswer);
        $stmt->execute();

    } 
}