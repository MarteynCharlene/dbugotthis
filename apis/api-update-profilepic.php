<?php

session_start();
if( !isset($_SESSION['iUserId'] ) ){
    header('Location: login.php');
}

$iUserId = $_SESSION['iUserId'];

$sUniqueName = uniqid();
$validUniqueName = $sUniqueName.".png";
$target_file = __DIR__."/../img/$sUniqueName.png"; // $target_dir . basename($_FILES["fileToUpload"]["name"]);
echo "<div>$target_file</div>";
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 99999999999 ) { 
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

if($imageFileType = "jpg"){
    
}

print_r($_FILES);

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        require_once __DIR__.'/../connect.php';

        $alreadyHaveImg = $db->prepare('SELECT * FROM user_profile_picture WHERE user_fk = :iUserId');
        $alreadyHaveImg->bindValue(':iUserId', $iUserId);
        $alreadyHaveImg->execute();
        $alreadyHaveImg = $alreadyHaveImg->rowCount();

        if($alreadyHaveImg == 0){
            $stmt = $db->prepare('INSERT INTO `user_profile_picture` VALUES (:iUserId, :filePath)');
        } elseif($alreadyHaveImg == 1) {
            $stmt = $db->prepare('UPDATE user_profile_picture SET url = :filePath WHERE user_fk = :iUserId');
        }
        $stmt->bindValue(':filePath', $validUniqueName);
        $stmt->bindValue(':iUserId', $iUserId);
        $stmt->execute();
        header("Location: ../profile.php");

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}