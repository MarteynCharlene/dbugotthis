<?php 
session_start();
if( !isset($_SESSION['iUserId'] ) ){
  header('Location: login.php');
}

$iUserId = $_SESSION['iUserId'];

$getMessageId = $_GET['replyid'];

$getSubjectId = $_GET['subject'];

require_once __DIR__ . '/../connect.php';

$stmt = $db->prepare('DELETE FROM forum_subject_messages WHERE message_id = :iMessageId 
AND user_fk = :iUserId AND subject_fk = :iSubjectId');
$stmt->bindValue(':iUserId', $iUserId); 
$stmt->bindValue(':iMessageId', $getMessageId);
$stmt->bindValue(':iSubjectId', $getSubjectId);
$stmt->execute();

header('Location: ../subject.php?subject='.$getSubjectId);
