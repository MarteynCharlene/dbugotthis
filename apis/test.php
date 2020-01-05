<?php 
require_once __DIR__.'/../connect.php';

session_start();
if( !isset($_SESSION['iUserId']) ){
  header('Location: login.php');
}

$iUserId = $_SESSION['iUserId'];

try {
    $db->beginTransaction();
    $iAmountOfCorrectAnswers = 0;
    foreach ($_POST as $question_id => $questionAnswer) {
        $correctAnswer = $stmt2 = $db->prepare('SELECT is_correct_answer from question_choices where question_fk = :questionId and choice_id = :choiceId');
        $stmt2->bindValue(':questionId', $question_id);
        $stmt2->bindValue(':choiceId', $questionAnswer);
        $stmt2->execute();
        $isCorrectAnswer = $stmt2->fetch()->is_correct_answer;
        if ($isCorrectAnswer == 1) {
            $iAmountOfCorrectAnswers = $iAmountOfCorrectAnswers + 1;
        }
        $stmt2 = $db->prepare('INSERT into users_answers values(Null, :iUserId, :question_id, :choice_id, :answered_correctly, CURRENT_TIME())');
        $stmt2->bindValue(':iUserId', $iUserId);
        $stmt2->bindValue(':question_id', $question_id);
        $stmt2->bindValue(':choice_id', $questionAnswer);
        $stmt2->bindValue(':answered_correctly', $isCorrectAnswer);
        if(!$stmt2->execute()) {
            throw new Exception("An error occured saving the data", 1);
        }
    }
    $db->commit();
    echo 'You have ' . $iAmountOfCorrectAnswers . ' correct answers';
} catch (Exception $exception) {
    $db->rollback();
    echo $exception;
}

?>

