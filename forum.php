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

$SubjectsPerPage = 10;
$stmt = $db->prepare('SELECT subject_id FROM forum_subjects');
$stmt->execute();
$TotalSubjects = $stmt->rowCount();

$TotalPages = ceil($TotalSubjects/$SubjectsPerPage);
if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $TotalPages) {
   $_GET['page'] = intval($_GET['page']);
   $currentPage = $_GET['page'];
} else {
   $currentPage = 1;
}
$start = ($currentPage-1)*$SubjectsPerPage;

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

?>



<main>
   <h1>Forum</h1>
   
   <div id="addTopicBtn">Add a new subject</div>

   <div id="btnShowAddSubject">
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
               

   <table class="forum">
      <tr class="header">
         <th class="main" style="width:40%; text-align:left;">Subjects</th>
         <th class="sub-info" style="width:20%">Author</th>
         <th class="sub-info">number of replies</th>
         <th class="sub-info" style="width:20%">Latest message</th>
      </tr>

   <?php
      $stmt = $db->prepare('select fs.subject_id, fs.subject, fs.content, IFNULL(c, 0) as totalMessages, users.username as authorOfTheSubject, IFNULL(u.username, users.username) as usernameOfLastReply from forum_subjects as fs left join (select count(*) as c, forum_subject_messages.subject_fk as subjectID from forum_subject_messages group by forum_subject_messages.subject_fk) as fsm on fsm.subjectID = fs.subject_id left join (select * from forum_subject_messages where message_id in (SELECT max(message_id) FROM forum_subject_messages group by subject_fk)) as fsmml on fsmml.subject_fk = fs.subject_id left join users as u on u.user_id = fsmml.user_fk left join users on users.user_id = fs.user_fk LIMIT '.$start.','.$SubjectsPerPage);      
      $stmt->execute();
      $aRows = $stmt->fetchAll();
      foreach( $aRows as $jRow ){
            echo '
            <tr>
               <td class="main">
                  <h4><a href="subject.php?subject='.$jRow->subject_id.'">'.$jRow->subject.'</a></h4>
                  <p>'.$jRow->content.'</p>
               </td>
               <td class="sub-info">'.$jRow->authorOfTheSubject.'</td>
               <td class="sub-info">'.$jRow->totalMessages.'</td>
               <td class="sub-info">25.12.2015 at 18h07<br />by '.$jRow->usernameOfLastReply.'</td>
            </tr>
            '; 
            
         }

         ?>


   </table>

   <div id="pagination">
<?php
      for($i=1;$i<=$TotalPages;$i++) {
         if($i == $currentPage) {
            echo '<a href="forum.php?page='.$i.'"><button class="btn active">'.$i.'</button></a>';
         } else {
            echo '
            <a href="forum.php?page='.$i.'"><button class="btn">'.$i.'</button></a>';
         }
      }
?>
</div>

</main>
<!--

<form method="POST">
   <table>
      <tr>
         <th colspan="2">Nouveau Topic</th>
      </tr>
      <tr>
         <td>Sujet</td>
         <td><input type="text" name="tsujet" size="70" maxlength="70" /></td>
      </tr>
      <tr>
         <td>Message</td>
         <td><textarea name="tcontenu"></textarea></td>
      </tr>
      <tr>
         <td>Me notifier des réponses par mail</td>
         <td><input type="checkbox" name="tmail" /></td>
      </tr>
      <tr>
         <td colspan="2"><input type="submit" name="tsubmit" value="Poster le Topic" /></td>
      </tr>
      <?php if(isset($terror)) { ?>
      <tr>
         <td colspan="2">test</td> 
          <td colspan="2"><?= $terror ?></td> 
      </tr>
      <?php } ?> 
   </table>
</form> -->

<?php
require_once __DIR__.'/bottom.php'; 