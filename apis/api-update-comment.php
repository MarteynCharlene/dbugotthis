<?php 
session_start();
if( !isset($_SESSION['iUserId'] ) ){
  header('Location: login.php');
}

$iUserId = $_SESSION['iUserId'];

$iMessageId = $_POST['iMessageId'];
$iSubjectId = $_POST['iSubjectId'];

require_once __DIR__ . '/../connect.php';


if(isset($_POST['txtSubjectEdited'], $_POST['txtSubjectMessageEdited'])){
    if(!empty($_POST['txtSubjectMessageEdited'])){
        $sEditedMessage = htmlspecialchars($_POST['txtSubjectMessageEdited']);

        $stmt = $db->prepare('UPDATE forum_subject_messages 
        SET message_timestamp = CURRENT_TIMESTAMP(), message_content = :sEditedText
        WHERE message_id = :iMessageId');
        $stmt->bindValue(':sEditedText', $sEditedMessage);
        $stmt->bindValue(':iMessageId', $iMessageId);
        $stmt->execute();
        header('Location: subject.php?subject='.$getSubjectId);
    } 
}