<?php

session_start();
if( !isset($_SESSION['iUserId'] ) ){
  header('Location: login.php');
}

$iUserId = $_SESSION['iUserId'];

$sInjectCss = '<link rel="stylesheet" href="css/subject.css">';

$getSubjectId = $_GET['subject'];

require_once __DIR__.'/connect.php';
require_once __DIR__.'/top.php'; 

if(isset($_POST['txtSubjectAnswerSubmit'], $_POST['txtSubjectMessage'])){
    if(!empty($_POST['txtSubjectMessage'])){
        $sAnswer = htmlspecialchars($_POST['txtSubjectMessage']);

        $stmt = $db->prepare('INSERT INTO forum_subject_messages VALUES (null, :iSubjectId, :iUserId, NOW(), :sAnswer)');
        $stmt->bindValue(':iSubjectId', $getSubjectId);
        $stmt->bindValue(':iUserId', $iUserId);
        $stmt->bindValue(':sAnswer', $sAnswer);
        $stmt->execute();
        header('Location: subject.php');
    } 
}

?>

<main>
    <?php 
    
    $stmt2 = $db->prepare('SELECT forum_subjects.subject_id, forum_subjects.subject, forum_subjects.content, users.username FROM `forum_subjects` 
    LEFT JOIN users on users.user_id = forum_subjects.user_fk
    WHERE subject_id = :sGetSubjectId');
    $stmt2->bindValue(':sGetSubjectId', $getSubjectId);
    $stmt2->execute();
    $aRows = $stmt2->fetch();
    echo '
        <h1>'.$aRows->subject.'</h1>
        <div>
            <img src="img/6.jpg">
            <p><span>'.$aRows->username.'</span>'.$aRows->content.'</p>
        </div>
    ';

    $stmt = $db->prepare('SELECT forum_subject_messages.message_content, users.username FROM `forum_subject_messages` 
    LEFT JOIN users ON users.user_id = forum_subject_messages.user_fk
    WHERE subject_fk = :sGetSubjectId');
    $stmt->bindValue(':sGetSubjectId', $getSubjectId);
    $stmt->execute();
    $aRows = $stmt->fetchAll();
    foreach( $aRows as $jRow ){
        echo '
            <div>
                <img src="img/test.png">
                <p><span>'.$jRow->username.'</span>'.$jRow->message_content.'</p>
            </div>
        ';  
    }
    ?>

    <div class="mt20">
        <img src="img/test.png">
        <form id="frmForumReply" name="frmForumReply" method="POST">
            <textarea name="txtSubjectMessage" rows="10" cols="30"></textarea>
            <input type="submit" name="txtSubjectAnswerSubmit" value="Comment">
        </form>
    </div>

</main>

 <?php
require_once __DIR__.'/bottom.php'; 