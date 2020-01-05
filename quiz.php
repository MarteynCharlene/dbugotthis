<?php

session_start();
if( !isset($_SESSION['iUserId']) ){
  header('Location: login.php');
}

$iUserId = $_SESSION['iUserId'];

$sInjectCss = '<link rel="stylesheet" href="css/quiz.css">';

$getCategoryId = $_GET['category'];

require_once __DIR__.'/connect.php';
require_once __DIR__.'/top.php'; 
?>

<main>

  <div class="mySlides">

    <?php
    $stmt = $db->prepare('SELECT choice_id, choice, question_id, question from question_choices join questionss on question_choices.question_fk = questionss.question_id where category_fk = :iCategoryId');
    $stmt->bindValue(':iCategoryId', $getCategoryId);
    $stmt->execute();
    $aRows = $stmt->fetchAll();
    echo '
    <h2 class="mt20" style="text-align:center"> MariaDB quiz</h2>
    <form action="apis/test.php" method="POST">';
    $creatingQuestionId = 0;
    foreach ($aRows as $rowKey => $row) {
        if ($creatingQuestionId != $row->question_id) {
            if($creatingQuestionId != 0){
                echo '<br/><br/>';
            }
            echo '
            <div>'.$row->question.'</div>';
            $creatingQuestionId = $row->question_id;
        }
            echo '<input type="radio" name="'.$row->question_id.'" value="'.$row->choice_id.'"> '.$row->choice.'<br>';
    }
     echo '<input type="submit" value="submit">
    </form> ';
    ?>
  </div>


</main>








<?php
require_once __DIR__.'/bottom.php'; 