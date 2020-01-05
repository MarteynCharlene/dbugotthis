<?php

session_start();
if( !isset($_SESSION['iUserId'] ) ){
  header('Location: login.php');
}

$iUserId = $_SESSION['iUserId'];

$sInjectCss = '<link rel="stylesheet" href="css/profile.css">';

require_once __DIR__.'/connect.php';
require_once __DIR__.'/top.php'; 


$stmt = $db->prepare('SELECT users.email, users.user_id, users.username, IFNULL(user_profile_picture.url, "default-picture.jpg") as userProfilePicture FROM users
LEFT JOIN user_profile_picture ON user_profile_picture.user_fk = users.user_id
WHERE users.user_id = :iUserId');
$stmt->bindValue(':iUserId', $iUserId);
$stmt->execute();
$aRows = $stmt->fetch();          
?>

<main>

<h1>Change your profile picture</h1>
   <div class="container">
      <form class="tabcontentContainer" action="apis/api-update-profilepic.php" method="post" enctype="multipart/form-data">
         <table>
            <tr>
               <td style="width:50%">Your current profile picture</td>
               <td style="width:25%"><img id="profilePicture" class="profilePicture" src="img/<?= $aRows->userProfilePicture ?>"></td>
               <td>
                  <label style="cursor:pointer" onclick="document.getElementById('fileToUpload').click()">Select a Picture</label>
                  <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*" style="display:none" onchange="previewImage()">
               </td>
            </tr>
            <tr>
               <td><input type="submit" name="BtnSubmitNewSubject" value="Submit"></td>
            </tr>
         </table>
      </form>
   </div>

<h1>Change your parameters</h1>
<div class="container">
   <form action="apis/api-update-profile-param.php" method="post">
      <table>
         <tr>
            <td>Username</td>
            <td><input type="text" name="txtUsername" value="<?= $aRows->username ?>"></td>
         </tr>
         <tr>
            <td>Email</td>
            <td><input type="email" name="txtUserEmail" value="<?= $aRows->email ?>"></td>
         </tr>
         <tr>
            <td><input type="submit" name="BtnSubmitNewSubject" value="Submit"></td>
         </tr>
      </table>
   </form>
</div>

<h1>Change your password</h1>
<div class="container">
   <form action="apis/api-update-password.php" method="POST">
      <table>
         <tr>
            <td>Current password</td>
            <td><input type="password" name="txtLoginPassword" id="txtLoginPassword" placeholder="your password..."></td>
         </tr>
         <tr>
            <td>New password</td>
            <td><input type="password" name="txtLoginNewPassword" id="txtLoginNewPassword" placeholder="your new password..."></td>
         </tr>
         <tr>
            <td>Confirm New password</td>
            <td><input type="password" name="txtLoginConfirmNewPassword" id="txtLoginConfirmNewPassword" placeholder="confirm your new password"></td>
         </tr>
         <tr>
            <td><input type="submit" name="BtnSubmitChangePwd" value="Submit"></td>
         </tr>
      </table>
   </form>
</div>

<h1>Delete your account</h1>
<div class="container">
   <form action="apis/api-delete-account.php" method="POST">
      <table>
         <tr>
            <td>Delete account</td>
            <td><input style="background-color:red;"type="submit" name="BtnSubmitDeleteAcc" value="Delete"></td></td>
         </tr>
      </table>
   </form>
</div>
</main>

<script>


function previewImage(){
let preview = document.getElementById('profilePicture')
let file = document.querySelector('input[type=file]').files[0]
console.log(file);
let reader = new FileReader()
   reader.onloadend = function(){
      preview.src = reader.result
   }
reader.readAsDataURL(file)
}



</script>
<?php

require_once __DIR__.'/bottom.php'; 