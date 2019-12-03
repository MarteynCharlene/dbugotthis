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
   <h1>Forum</h1>
   <div id="addTopicBtn"><a href="newsubject.php">Add a new subject</a></div>
               

   <table class="forum">
      <tr class="header">
         <th class="main" style="width:40%; text-align:left;">Topic</th>
         <th class="sub-info" style="width:25%">Author</th>
         <th class="sub-info">number of messages</th>
         <th class="sub-info" style="width:25%">Last reply</th>
      </tr>

      <tr>
         <td class="main">
            <h4><a href="#">this is a test</a></h4>
            <p>Caramels soufflé gingerbread. Macaroon cookie ice cream. Sweet biscuit powder dessert. Fruitcake powder candy.</p>
         </td>
         <td class="sub-info">charlene</td>
         <td class="sub-info">21</td>
         <td class="sub-info">25.12.2015 at 18h07<br />by charlene</td>
      </tr>

      <tr>
         <td class="main">
            <h4><a href="#">this is a test</a></h4>
         </td>
         <td class="sub-info">4083495</td>
         <td class="sub-info">25.12.2015 à 18h07<br />de PrimFX</td>
         <td class="sub-info">25.12.2015 à 18h07<br />par charlene</td>
      </tr>

      <tr>
         <td class="main">
            <h4><a href="#">this is a test</a></h4>
         </td>
         <td class="sub-info">4083495</td>
         <td class="sub-info">25.12.2015 à 18h07<br />de PrimFX</td>
         <td class="sub-info">25.12.2015 à 18h07<br />par charlene</td>
      </tr>

      <tr>
         <td class="main">
            <h4><a href="#">this is a test</a></h4>
         </td>
         <td class="sub-info">4083495</td>
         <td class="sub-info">25.12.2015 à 18h07<br />de PrimFX</td>
         <td class="sub-info">25.12.2015 à 18h07<br />par charlene</td>
      </tr>

      <tr>
         <td class="main">
            <h4><a href="#">this is a test</a></h4>
         </td>
         <td class="sub-info">4083495</td>
         <td class="sub-info">25.12.2015 à 18h07<br />de PrimFX</td>
         <td class="sub-info">25.12.2015 à 18h07<br />par charlene</td>
      </tr>

      <tr>
         <td class="main">
            <h4><a href="#">this is a test</a></h4>
         </td>
         <td class="sub-info">4083495</td>
         <td class="sub-info">25.12.2015 à 18h07<br />de PrimFX</td>
         <td class="sub-info">25.12.2015 à 18h07<br />par charlene</td>
      </tr>

      <tr>
         <td class="main">
            <h4><a href="#">this is a test</a></h4>
         </td>
         <td class="sub-info">4083495</td>
         <td class="sub-info">25.12.2015 à 18h07<br />de PrimFX</td>
         <td class="sub-info">25.12.2015 à 18h07<br />par charlene</td>
      </tr>

      <tr>
         <td class="main">
            <h4><a href="#">this is a test</a></h4>
         </td>
         <td class="sub-info">4083495</td>
         <td class="sub-info">25.12.2015 à 18h07<br />de PrimFX</td>
         <td class="sub-info">25.12.2015 à 18h07<br />par charlene</td>
      </tr>

      <tr>
         <td class="main">
            <h4><a href="#">this is a test</a></h4>
         </td>
         <td class="sub-info">4083495</td>
         <td class="sub-info">25.12.2015 à 18h07<br />de PrimFX</td>
         <td class="sub-info">25.12.2015 à 18h07<br />par charlene</td>
      </tr>

      <tr>
         <td class="main">
            <h4><a href="#">this is a test</a></h4>
         </td>
         <td class="sub-info">4083495</td>
         <td class="sub-info">25.12.2015 à 18h07<br />de PrimFX</td>
         <td class="sub-info">25.12.2015 à 18h07<br />par charlene</td>
      </tr>


   </table>

    <div id="pagination">
        <button class="btn">1</button>
        <button class="btn active">2</button>
        <button class="btn">3</button>
        <button class="btn">4</button>
        <button class="btn">5</button>
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