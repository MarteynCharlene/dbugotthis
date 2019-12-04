<?php 

require_once __DIR__.'/../connect.php';

session_start();
$iUserId = $_SESSION['iUserId'];

$getSubjectId = $_GET['subject'];

$stmt = $db->prepare('SELECT subject, content, username FROM `forum_subjects` 
LEFT JOIN users on users.user_id = forum_subjects.user_fk
WHERE subject_id = :sGetfollowedid');
$stmt->bindValue(':sGetSubjectId', $getSubjectId);
$stmt->execute();

header('Location:'.$_SERVER['HTTP_REFERER']);