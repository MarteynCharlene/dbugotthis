<?php 

setlocale(LC_TIME, 'dk');

$stmt = $db->prepare('SELECT * FROM heure ORDER BY datetimet DESC');
$stmt = $db->execute()['datetimet'];
var_dump($dtt);

$var = ucfirst(strftime('%A, le %d ',strtotime($dtt)));
$var .= ucfirst(strftime('%B %Y',strtotime($dtt)));
var_dump($var);

?>