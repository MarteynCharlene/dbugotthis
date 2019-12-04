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
        <p><span>username </span>blblblalalalala</p>
    </div>

    <div>
        <img src="img/test.png">
        <p><span>username </span>Ice cream cupcake cotton candy icing lollipop apple pie cupcake gummies bear claw. Chocolate cake chocolate jelly-o ice cream tootsie roll topping cake. Marshmallow fruitcake caramels tart pie croissant jelly beans. Soufflé brownie gummies caramels cake. Croissant dessert halvah. Chocolate tiramisu jelly-o tootsie roll. Cotton candy fruitcake pudding candy canes powder donut icing cake. Bonbon marshmallow liquorice chocolate bar donut pudding jelly beans. Cotton candy dragée bear claw chocolate bar soufflé toffee. Muffin powder wafer soufflé biscuit dragée.</p>
    </div>

    <div class="mt20">
        <img src="img/test.png">
        <form id="frmForumReply"action="">
        <textarea name="message" rows="10" cols="30"></textarea>
            <input type="submit" value="Comment">
        </form>
    </div>

</main>

















<?php
require_once __DIR__.'/bottom.php'; 