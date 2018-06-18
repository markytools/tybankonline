<?php
	include("verifyaccount.php");

  // if (!empty($_GET['logout']) && $_GET['logout'] == 1 AND $_SESSION["id"]){
  // 	session_destroy();	//destroys all session variables
  //   header("Location:index.php");
  // }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Register</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="styles/default-styles.css">
  <link rel="stylesheet" type="text/css" href="styles/register.css">
  <link rel="stylesheet" type="text/css" href="styles/footer-default.css">
  <link rel="shortcut icon" type="image/png" href="images/favicon.png">
</head>

<body>

  <div class="container topheader">
    <img class="welcomeTitle" src="images/welcometybank.png" />
  </div>

  <div class="container-fluid contentContainer">
    <div class="row loginRow">
      <div class="col-xs-1 col-sm-1 col-lg-1"></div>
      <div class="col-xs-5 col-sm-5 col-lg-5">
        <div class="loginWell well">
          <div class="logintext">Create an Online TyBank Account</div>
          <form class="loginform" method="POST">
            <div class="form-group">
              <label for="firstname">First Name:</label>
              <input type="text" class="form-control" id="firstname" placeholder="Enter first name" name="firstname" value = "<?php if (!empty($_POST['firstname'])) echo addslashes($_POST['firstname']); ?>"/>
            </div>
            <div class="form-group">
              <label for="middlename">Middle Name:</label>
              <input type="text" class="form-control" id="middlename" placeholder="Enter middle name" name="middlename" value = "<?php if (!empty($_POST['middlename'])) echo addslashes($_POST['middlename']); ?>"/>
            </div>
            <div class="form-group">
              <label for="lastname">Last Name:</label>
              <input type="text" class="form-control" id="lastname" placeholder="Enter last name" name="lastname" value = "<?php if (!empty($_POST['lastname'])) echo addslashes($_POST['lastname']); ?>"/>
            </div>
            <div class="form-group">
              <label for="address">Address:</label>
              <input type="text" class="form-control" id="address" placeholder="Enter address" name="address" value = "<?php if (!empty($_POST['address'])) echo addslashes($_POST['address']); ?>"/>
            </div>
            <div class="form-group">
              <label for="acctno">Account No:</label>
              <input type="text" class="form-control" maxlength="12" onkeyup="this.value = this.value.replace(/[^0-9]/, '')" id="acctno" placeholder="Enter account number" name="acctno" value = "<?php if (!empty($_POST['acctno'])) echo addslashes($_POST['acctno']); ?>"/>
            </div>
            <div class="form-group">
              <label for="username">Username:</label>
              <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" value = "<?php if (!empty($_POST['username'])) echo addslashes($_POST['username']); ?>"/>
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value = "<?php if (!empty($_POST['email'])) echo addslashes($_POST['email']); ?>"/>
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" value = "<?php if (!empty($_POST['password'])) echo addslashes($_POST['password']); ?>"/>
            </div>
            <div class="form-group">
              <label for="password">Confirm Password:</label>
              <input type="password" class="form-control" id="confirmpass" placeholder="Enter password again" name="confirmpass" value = "<?php if (!empty($_POST['confirmpass'])) echo addslashes($_POST['confirmpass']); ?>"/>
            </div>
            <div class="loginError"><?php if ($registererror) echo addslashes($registererror); ?></div>
            <br />
              Already have an account? Click <a href="index.php">here</a> to login!
            <div align="right"><button type="submit" name="submit" value="Register" class="submit btn btn-default">Submit</button></div>
          </form>
        </div>
      </div>
      <div class="col-xs-6 col-sm-6 col-lg-6">
        <div class="tybanklogo">
          <img src="images/tybanklogo.png" />
        </div>
        <div class="tybankmottoimg">
          <img src="images/tybankmotto.png" />
        </div>
      </div>
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
