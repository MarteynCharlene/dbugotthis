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
$stmt = $db->prepare('SELECT subject_id FROM forumsubjects');
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
            $stmt = $db->prepare('INSERT INTO forumsubjects VALUES (null, :iCreatorId, :sSubject, :sContent, NOW(), :sEmailNotification)');
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
      <form id="addSubjectForm" method="POST">
         <span class="close">&times;</span>
         <h2>Add a new subject</h2>
         <label style="padding-top:20px;" for="txtNewSubject">Title</label>
         <input type="text" id="txtNewSubject" name="txtNewSubject" size="100" maxlength="100" placeholder="Your subject...">
         <label for="txtNewContent">Subject</label>
         <textarea id="txtNewContent" name="txtNewContent" placeholder="Write something.." style="height:200px"></textarea>
         <label for="notification" class="checkboxLabel">
            <input id="notification" type="checkbox" name="cbEmailNotif"> Notify me by email when someone replies
         </label>
         <input type="submit" name="BtnSubmitNewSubject" value="Submit">
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
      $stmt = $db->prepare('select fs.subject_id, fs.subject, fs.content, IFNULL(c, 0) as totalMessages, users.username as authorOfTheSubject, IFNULL(u.username, users.username) as usernameOfLastReply from forumsubjects as fs left join (select count(*) as c, forum_subject_messages.subject_fk as subjectID from forum_subject_messages group by forum_subject_messages.subject_fk) as fsm on fsm.subjectID = fs.subject_id left join (select * from forum_subject_messages where message_id in (SELECT max(message_id) FROM forum_subject_messages group by subject_fk)) as fsmml on fsmml.subject_fk = fs.subject_id left join users as u on u.user_id = fsmml.user_fk left join users on users.user_id = fs.user_fk LIMIT '.$start.','.$SubjectsPerPage);      
      $stmt->execute();
      $aRows = $stmt->fetchAll();
      foreach( $aRows as $jRow ){
            echo '
            <tr>
               <td class="main">
                  <h3><a href="subject.php?subject='.$jRow->subject_id.'">'.$jRow->subject.'</a></h3>
                  <p>'.$jRow->content.'</p>
               </td>
               <td class="sub-info username">'.$jRow->authorOfTheSubject.'</td>
               <td class="sub-info">'.$jRow->totalMessages.'</td>
               <td class="sub-info">25.12.2015 at 18h07<br />by <span class="username">'.$jRow->usernameOfLastReply.'</span></td>
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

<?php

$sLinkToScript = '<script src="js/forum.js"></script>';
require_once __DIR__.'/bottom.php'; 