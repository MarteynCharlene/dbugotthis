<?php

/* session_start();
if( !isset($_SESSION['sUserId'] ) ){
  header('Location: home.php');
}

$sUserId = $_SESSION['sUserId'];

$sInjectUserProfileName = 'Charlene Marteyn'; */
$sInjectCss = '<link rel="stylesheet" href="css/forum.css">';

require_once __DIR__.'/connect.php';
require_once __DIR__.'/top.php'; 
?>


<main>

<table class="forum">
   <tr class="header">
      <th class="main">Sujet</th>
      <th class="sub-info w10">Messages</th>
      <th class="sub-info w20">Dernier message</th>
      <th class="sub-info w20">Création</th>
   </tr>

   <tr>
      <td class="main">
         <h4><a href="">this is a test</a></h4>
      </td>
      <td class="sub-info">4083495</td>
      <td class="sub-info">25.12.2015 à 18h07<br />de PrimFX</td>
      <td class="sub-info">25.12.2015 à 18h07<br />par charlene</td>
   </tr>

   <tr>
      <td class="main">
         <h4><a href="">this is a test</a></h4>
      </td>
      <td class="sub-info">4083495</td>
      <td class="sub-info">25.12.2015 à 18h07<br />de PrimFX</td>
      <td class="sub-info">25.12.2015 à 18h07<br />par charlene</td>
   </tr>

   <tr>
      <td class="main">
         <h4><a href="">this is a test</a></h4>
      </td>
      <td class="sub-info">4083495</td>
      <td class="sub-info">25.12.2015 à 18h07<br />de PrimFX</td>
      <td class="sub-info">25.12.2015 à 18h07<br />par charlene</td>
   </tr>

   <tr>
      <td class="main">
         <h4><a href="">this is a test</a></h4>
      </td>
      <td class="sub-info">4083495</td>
      <td class="sub-info">25.12.2015 à 18h07<br />de PrimFX</td>
      <td class="sub-info">25.12.2015 à 18h07<br />par charlene</td>
   </tr>

   <tr>
      <td class="main">
         <h4><a href="">this is a test</a></h4>
      </td>
      <td class="sub-info">4083495</td>
      <td class="sub-info">25.12.2015 à 18h07<br />de PrimFX</td>
      <td class="sub-info">25.12.2015 à 18h07<br />par charlene</td>
   </tr>

   <tr>
      <td class="main">
         <h4><a href="">this is a test</a></h4>
      </td>
      <td class="sub-info">4083495</td>
      <td class="sub-info">25.12.2015 à 18h07<br />de PrimFX</td>
      <td class="sub-info">25.12.2015 à 18h07<br />par charlene</td>
   </tr>

   <tr>
      <td class="main">
         <h4><a href="">this is a test</a></h4>
      </td>
      <td class="sub-info">4083495</td>
      <td class="sub-info">25.12.2015 à 18h07<br />de PrimFX</td>
      <td class="sub-info">25.12.2015 à 18h07<br />par charlene</td>
   </tr>

   <tr>
      <td class="main">
         <h4><a href="">this is a test</a></h4>
      </td>
      <td class="sub-info">4083495</td>
      <td class="sub-info">25.12.2015 à 18h07<br />de PrimFX</td>
      <td class="sub-info">25.12.2015 à 18h07<br />par charlene</td>
   </tr>

   <tr>
      <td class="main">
         <h4><a href="">this is a test</a></h4>
      </td>
      <td class="sub-info">4083495</td>
      <td class="sub-info">25.12.2015 à 18h07<br />de PrimFX</td>
      <td class="sub-info">25.12.2015 à 18h07<br />par charlene</td>
   </tr>

   <tr>
      <td class="main">
         <h4><a href="">this is a test</a></h4>
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