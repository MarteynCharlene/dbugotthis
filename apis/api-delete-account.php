<?php 
session_start();
if( !isset($_SESSION['iUserId'] ) ){
  header('Location: login.php');
}

$iUserId = $_SESSION['iUserId'];

require_once __DIR__ . '/../connect.php';

$stmt = $db->prepare('DELETE FROM users WHERE users.user_id = :iUserId');
$stmt->bindValue(':iUserId', $iUserId); 
$stmt->execute();

header('Location: ../login.php');