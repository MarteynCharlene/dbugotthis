<?php

session_start();
if( !isset($_SESSION['iUserId']) ){
  header('Location: login.php');
}

$iUserId = $_SESSION['iUserId'];

$sInjectCss = '<link rel="stylesheet" href="css/index.css">';

require_once __DIR__.'/connect.php';
require_once __DIR__.'/top.php'; 
?>

  <main>
    <h1>Database quizzes</h1>
    <div class="row">

    <?php
      $stmt = $db->prepare('SELECT * FROM categories');      
      $stmt->execute();
      $aRows = $stmt->fetchAll();
      foreach( $aRows as $jRow ){
        echo '
          <a href="quiz.php?category='.$jRow->category_id.'">
            <div class="column">
              <div class="card">
                <h3 class="username">'.$jRow->category_name.'</h3>
                <p>'.$jRow->category_description.'</p>
              </div>
            </div>
          </a>
            '; 
            
         }

         ?>
        
    </div>

  </main>

<?php
require_once __DIR__.'/bottom.php'; 