<?php 

require_once __DIR__.'/../connect.php';

setlocale(LC_TIME, 'dk');

$stmt = $db->prepare('SELECT message_datetime FROM forum_subject_messages ORDER BY message_datetime DESC');
$stmt->execute();
$aRow = $stmt->fetch()['message_datetime'];
var_dump($aRow);

$var = ucfirst(strftime('%A, le %d ',strtotime($stmt)));
$var .= ucfirst(strftime('%B %Y',strtotime($stmt)));
var_dump($var);

?>