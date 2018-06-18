<?php
	include("login-control.php");
	include("myphpmailer.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>TyBank</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="styles/default-styles.css">
  <link rel="stylesheet" type="text/css" href="styles/login.css">
  <link rel="stylesheet" type="text/css" href="styles/footer-default.css">
  <link rel="shortcut icon" type="image/png" href="images/favicon.png">
</head>

<body>

  <div class="container topheader">
    <img class="welcomeTitle" src="images/welcometybank.png" />
  </div>

  <?php
  	if (!empty($_GET['logout']) && $_GET['logout'] == 1) {
      echo '<div class="container">'.
        '<div class="row">'.
          '<div class="col-xs-2 col-sm-2 col-lg-2"></div>'.
          '<div class="col-xs-8 col-sm-8 col-lg-8">'.
            '<div class="logoutAlert alert alert-danger alert-dismissable fade in" id="alert-danger">'.
              '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.
              '<strong>Session Expired!</strong>'.
              '<br /> You have been logged out.'.
            '</div>'.
          '</div>'.
          '<div class="col-xs-2 col-sm-2 col-lg-2"></div>'.
        '</div>'.
      '</div>';
    }
  ?>

  <div class="container-fluid contentContainer">
    <div class="row loginRow">
      <div class="col-xs-1 col-sm-1 col-lg-1"></div>
      <div class="col-xs-5 col-sm-5 col-lg-5">
        <div class="loginWell well">
          <div class="logintext">Log In Your Account</div>
          <form class="loginform" method="POST">
            <div class="form-group">
              <label for="username">Username:</label>
              <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" value = "<?php if (!empty($_POST['username'])) echo addslashes($_POST['username']); ?>"/>
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" value = "<?php if (!empty($_POST['password'])) echo addslashes($_POST['password']); ?>"/>
            </div>
            <div class="loginError"><?php if ($loginerror) echo addslashes($loginerror); ?></div>
            <br />
            Don't have an account yet? Click <a href="register.php">here</a> to register!
            <div align="right"><button type="submit" name="submit" value="Submit" class="submit btn btn-default">Submit</button></div>
          </form>
        </div>
      </div>
      <div class="col-xs-5 col-sm-5 col-lg-5">
        <div class="tybanklogo">
          <img src="images/tybanklogo.png" />
        </div>
      </div>
      <div class="col-xs-1 col-sm-1 col-lg-1"></div>
    </div>
  </div>

  <footer class="footer">
    <div class="container-fluid socialmedia">
      <div class="row footerRow1">
        <div class="col-xs-1 col-sm-1 col-lg-1"></div>
        <div class="col-xs-5 col-sm-5 col-lg-5">
          <a href="#" class="fa fa-facebook"></a>
          <a href="#" class="fa fa-twitter"></a>
          <a href="#" class="fa fa-google"></a>
          <a href="#" class="fa fa-linkedin"></a>
        </div>
        <div class="col-xs-1 col-sm-1 col-lg-1"></div>
        <div class="col-xs-4 col-sm-4 col-lg-4">
          <div class="tybanktextpic">
            <img src="images/tybanktextpic.png" />
          </div>
        </div>
        <div class="col-xs-1 col-sm-1 col-lg-1"></div>
      </div>
      <div class="row footerRow2">
        <div class="col-xs-1 col-sm-1 col-lg-1"></div>
        <div class="col-xs-1 col-sm-1 col-lg-1" style="width: 9%"><a href="#">About</a></div>
        <div class="col-xs-1 col-sm-1 col-lg-1" style="width: 11%"><a href="#">Contact Us</a></div>
        <div class="col-xs-1 col-sm-1 col-lg-1" style="width: 12%"><a href="#">Privacy Policy</a></div>
        <div class="col-xs-1 col-sm-1 col-lg-1" style="width: 20%"><a href="#">Terms of Service</a></div>
        <div class="col-xs-1 col-sm-1 col-lg-1"></div>
        <div class="col-xs-4 col-sm-4 col-lg-4 copyrightCol">TyBank, Inc. © 2017. All Rights Reserved.</div>
      </div>
    </div>
  </footer>

  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script>
    $(".contentContainer").css("min-height", $(window).height());
	  $(".contentContainer").css("width", $(window).width());
	  $(".topheader").css("width", $(window).width());

    $("#alert-danger").fadeTo(2000, 500).slideUp(500, function() {
      $("#alert-danger").slideUp(500);
    });
  </script>
</body>

</html>
