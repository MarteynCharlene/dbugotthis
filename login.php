<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/login.css">
    <title>db&#8594;UGotThis</title>
</head>
<body>
  <nav>
    <div id="logoContainer"><a href="#"> db&#8594;UGotThis</a></div>
  </nav>


  <main>
    <div class="text-part">
      <img src="img/test.png">
      <p>Gain database knowledge in a fun way!</p>
    </div>

    <div class="login-part">

      <div class="form">
        <form class="register-form" method="POST" action="apis/api-signup.php">
          <h1>CREATE ACCOUNT</h1>
          <input name="txtSignupUserName" type="text" placeholder="USERNAME"/>
          <input name="txtSignupEmail" type="text" placeholder="EMAIL ADDRESS"/>
          <input name="txtSignupPassword" type="password" placeholder="PASSWORD"/>
          <input name="txtSignupConfirmPassword" type="password" placeholder="REPEAT PASSWORD"/>
          <button>create</button>
          <p class="message">Already registered? <a href="#">Sign In</a></p>
        </form>

        <form class="login-form" method="POST" action="apis/api-login.php">
          <h1>ACCOUNT LOGIN</h1>
          <input name="txtLoginEmail" type="text" placeholder="EMAIL ADDRESS" autocomplete="off" required/>
          <input name="txtLoginPassword" type="password" placeholder="PASSWORD" autocomplete="off" required/>
          <button>log in</button>
          <p class="message">Not registered? <a href="#">Create an account</a></p>
        </form>
      </div>

    </div>
  </main>

  <footer>© Charlene Marteyn || KEA PROJECT 2019 </footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 

<script>

$('.message a').click(function(){
   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});

</script>
</body>
</html>