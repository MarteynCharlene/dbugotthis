<?php

session_start();
if( !isset($_SESSION['iUserId'] ) ){
  header('Location: login.php');
}

$iUserId = $_SESSION['iUserId'];

$sInjectCss = '<link rel="stylesheet" href="css/fullsubject.css">';

require_once __DIR__.'/connect.php';
require_once __DIR__.'/top.php'; 

?>

<main>
    <div>
        <img src="img/6.jpg">
        <p>blblblalalalala</p>
    </div>

    <div>
        <img src="img/test.png">
        <p>blalala</p>
    </div>


</main>

















<?php
require_once __DIR__.'/bottom.php'; 