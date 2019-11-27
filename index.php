<?php

/* session_start();
if( !isset($_SESSION['sUserId'] ) ){
  header('Location: home.php');
}

$sUserId = $_SESSION['sUserId'];

$sInjectUserProfileName = 'Charlene Marteyn'; */
$sInjectCss = '<link rel="stylesheet" href="css/index.css">';

require_once __DIR__.'/connect.php';
require_once __DIR__.'/top.php'; 
?>

  <main>
    <div class="row">
        <div class="column">
            <div class="card">
            <h3>Card 1</h3>
            <p>Some text</p>
            <p>Some text</p>
            </div>
        </div>

        <div class="column">
            <div class="card">
            <h3>Card 2</h3>
            <p>Some text</p>
            <p>Sonn
            me text</p>
            </div>
        </div> 
        
    </div>

  </main>

<?php
require_once __DIR__.'/bottom.php'; 