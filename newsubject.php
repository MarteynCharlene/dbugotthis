<?php

session_start();
if( !isset($_SESSION['iUserId'] ) ){
  header('Location: login.php');
}

$iUserId = $_SESSION['iUserId'];

$sInjectCss = '<link rel="stylesheet" href="css/forum.css">';

require_once __DIR__.'/connect.php';
require_once __DIR__.'/top.php'; 

/* ----------------------------------- ADD A NEW TOPIC IN THE FORUM ---------------------------------- */

if(isset($_POST['BtnSubmitNewSubject'])) {
   if(isset($_POST['txtNewSubject'],$_POST['txtNewContent'])) {
      $sSubject = htmlspecialchars($_POST['txtNewSubject']);
      $sContent = htmlspecialchars($_POST['txtNewContent']);
      if(!empty($sSubject) AND !empty($sContent)) {
         if(strlen($sSubject) <= 100) {
            if(isset($_POST['cbEmailNotif'])) {
               $email_notif = 1;
            } else {
               $email_notif = 0;
            }
            $stmt = $db->prepare('INSERT INTO forum_subjects VALUES (null, :iCreatorId, :sSubject, :sContent, NOW(), :sEmailNotification)');
            $stmt->bindValue(':iCreatorId', $iUserId);
            $stmt->bindValue(':sSubject', $sSubject);
            $stmt->bindValue(':sContent', $sContent);
            $stmt->bindValue(':sEmailNotification', $email_notif);
            $stmt->execute();
         } else {
            $error = "Your subject cannot be longer than 100 characters";
         }
      } else {
         $error = "Please complete all required fields.";
      }
   }
}

/* ----------------------------------- ADD A NEW TOPIC IN THE FORUM ---------------------------------- */

?>



<main>
   <h1>Add a new subject</h1>
   <div id="addTopicBtn"><a href="forum.php">Cancel</a></div>
   <div>
      <form method="POST">
         <table>
            <tr>
               <td>Subject</td>
               <td><input type="text" name="txtNewSubject" size="100" maxlength="100" placeholder="Your subject..."></td>
            </tr>
            <tr>
               <td>Message</td>
               <td><textarea name="txtNewContent" maxlength="500" placeholder="Describe your issue..."></textarea></td>
            </tr>
            <tr>
               <td>Me notifier des réponses par mail</td>
               <td><input type="checkbox" name="cbEmailNotif" /></td>
            </tr>
            <tr>
               <td colspan="2"><input type="submit" name="BtnSubmitNewSubject" value="Submit"></td>
            </tr>
            <?php if(isset($error)) { ?>
            <tr>
               <td colspan="2"><?= $error ?></td>
            </tr>
            <?php } ?>
         </table>
      </form>
    </div>
</main>


<?php
require_once __DIR__.'/bottom.php'; 