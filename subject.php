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




/* __________________________________ ADDING MESSAGES FROM USER ________________________ */

if(isset($_POST['txtSubjectAnswerSubmit'], $_POST['txtSubjectMessage'])){
    if(!empty($_POST['txtSubjectMessage'])){
        $sAnswer = htmlspecialchars($_POST['txtSubjectMessage']);
        $stmt = $db->prepare('INSERT INTO forum_subject_messages VALUES (null, :iSubjectId, :iUserId, NOW(), :sAnswer)');
        $stmt->bindValue(':iSubjectId', $getSubjectId);
        $stmt->bindValue(':iUserId', $iUserId);
        $stmt->bindValue(':sAnswer', $sAnswer);
        $stmt->execute();
        header('Location: subject.php?subject='.$getSubjectId);
    } 
}


/* __________________________________ UPDATING USER MESSAGES ________________________ */

if(isset($_POST['txtSubjectEdited'], $_POST['txtSubjectMessageEdited'])){
    if(!empty($_POST['txtSubjectMessageEdited'])){
        $sEditedMessage = htmlspecialchars($_POST['txtSubjectMessageEdited']);
        $iMessageId = htmlspecialchars($_POST['iMessageId']);
        $stmt = $db->prepare('UPDATE `forum_subject_messages` 
        SET `message_timestamp`= CURRENT_TIMESTAMP(),`message_content`= :sEditedText 
        WHERE message_id = :iMessageId');
        $stmt->bindValue(':sEditedText', $sEditedMessage);
        $stmt->bindValue(':iMessageId', $iMessageId);
        $stmt->execute();
        header('Location: subject.php?subject='.$getSubjectId);
    } 
}

/* --------------------------------------------------------------------------------------------------------- */

?>

<main>
    <a href="forum.php" class="previous">&#8249; Previous</a>

    <?php 
    
    $stmt2 = $db->prepare('SELECT forumsubjects.subject_id, forumsubjects.subject, forumsubjects.content, users.username, users.user_id, IFNULL(user_profile_picture.url, "default-picture.jpg") as userProfilePicture FROM `forumsubjects` 
    LEFT JOIN users on users.user_id = forumsubjects.user_fk
    LEFT JOIN user_profile_picture on user_profile_picture.user_fk = forumsubjects.user_fk
    WHERE subject_id = :sGetSubjectId');
    $stmt2->bindValue(':sGetSubjectId', $getSubjectId);
    $stmt2->execute();
    $aRows = $stmt2->fetch();
    if( $aRows->user_id == $iUserId){
        echo '
        <h1>'.$aRows->subject.'</h1>
        <div class="container">
            <img src="img/'.$aRows->userProfilePicture.'">
            <div class="test" style="background-color:#EDF2FC;">
                <p class="username">'.$aRows->username.'</p>
                <p>'.$aRows->content.'</p>
            </div>
        </div>
    ';} else{
        echo '
        <h1>'.$aRows->subject.'</h1>
        <div class="container">
            <img src="img/'.$aRows->userProfilePicture.'">
            <div class="test">
                <p class="username">'.$aRows->username.'</p>
                <p>'.$aRows->content.'</p>
            </div>
        </div>
    ';
    };
   

    $stmt = $db->prepare('SELECT forum_subject_messages.subject_fk, forum_subject_messages.message_id, forum_subject_messages.message_content, users.username, users.user_id, IFNULL(user_profile_picture.url, "default-picture.jpg") as userProfilePicture FROM `forum_subject_messages` 
    LEFT JOIN users ON users.user_id = forum_subject_messages.user_fk
    LEFT JOIN user_profile_picture ON user_profile_picture.user_fk = forum_subject_messages.user_fk
    WHERE subject_fk = :sGetSubjectId');
    $stmt->bindValue(':sGetSubjectId', $getSubjectId);
    $stmt->execute();
    $aRows = $stmt->fetchAll();
    foreach( $aRows as $jRow ){
        if( $jRow->user_id == $iUserId){
            echo '
            <div class="container">
                <img src="img/'.$jRow->userProfilePicture.'">
                <div class="test" style="background-color:#EDF2FC;">
                <span id="updateMessageBtn"><i class="fas fa-pen close" style="font-size: 16px; padding: 8px;"></i></span>
                <a href="apis/api-delete-own-reply.php?subject='.$jRow->subject_fk.'&replyid='.$jRow->message_id.'"><span class="close"><i style="font-size: 16px; padding: 8px" class="far">&#xf2ed;</i></span></a>
                    <p class="username">'.$jRow->username.'</p>
                    <p>'.$jRow->message_content.'</p>
                </div>
                        <img id="userUpdateFormImg" src="img/'.$jRow->userProfilePicture.'" style="display:none">
                        <form id="frmUpdateForm" method="POST" style="display:none">
                            <div class="test">
                                <input type="hidden" name="iMessageId" value="'.$jRow->message_id.'">
                                <textarea name="txtSubjectMessageEdited" style="width:100%" rows="10" cols="30">'.$jRow->message_content.'</textarea><br>
                                <input type="submit" name="txtSubjectEdited" value="update">
                            </div>
                        </form>
                
            </div>
            ';
        } else{
            echo '
            <div class="container">
                <img src="img/'.$jRow->userProfilePicture.'">
                <div class="test">
                    <p class="username">'.$jRow->username.'</p>
                    <p>'.$jRow->message_content.'</p>
                </div>
            </div>
        '; 
        }
         
    }
    ?>

    <div class="mt20 container">
        <?php 
        
        $stmt = $db->prepare('SELECT users.user_id, IFNULL(user_profile_picture.url, "default-picture.jpg") as userProfilePicture FROM users
        LEFT JOIN user_profile_picture ON user_profile_picture.user_fk = users.user_id
        WHERE users.user_id = :iUserId');
        $stmt->bindValue(':iUserId', $iUserId);
        $stmt->execute();
        $aRows = $stmt->fetch();   
        echo '<img src="img/'.$aRows->userProfilePicture.'">'
        ?>
       
        
        <form id="frmForumReply" name="frmForumReply" method="POST">
            <textarea name="txtSubjectMessage" rows="10" cols="30"></textarea>
            <input type="submit" name="txtSubjectAnswerSubmit" value="Comment">
        </form>
    </div>

</main>

 <?php

$sLinkToScript = '<script src="js/subject.js"></script>';
require_once __DIR__.'/bottom.php'; 