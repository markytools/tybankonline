<?php
  include("bank-control.php");
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
  <link rel="stylesheet" type="text/css" href="styles/home.css">
  <link rel="stylesheet" type="text/css" href="styles/footer-default.css">
  <link rel="shortcut icon" type="image/png" href="images/favicon.png">
</head>

<body>

  <header>
    <div class="container topheader">
      <a href="#"><img class="logo" src="images/tybanklogo.png"/></a>
      <button type="button" class="logout btn btn-default" id="logoutB"><div class="logoutLink">Log Out</div></button>
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="#">TyBank</a>
          </div>
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">About</a></li>
          </ul>
        </div>
      </nav>
    </div>
  </header>

  <div class="container-fluid contentContainer">
    <div class="row mainRow1">
      <div class="col-xs-3 col-sm-3 col-lg-3"></div>
      <div class="col-xs-9 col-sm-9 col-lg-9">
        <div class="well currentTitle">
          My Accounts
        </div>
      </div>
    </div>
    <div class="row mainRow2">
      <div class="col-xs-3 col-sm-3 col-lg-3">
        <div class="navigation">
          <div class="well" id="navigationwell">
            <div class="navigationText"><strong></strong>Navigate</div>
            <button type="button" class="btn btn-default btn-block" id="myAccountsB">My Accounts</button>
            <button type="button" class="btn btn-default btn-block" id="viewTransactionsB">View Transactions</button>
            <button type="button" class="btn btn-default btn-block" id="billsPaymentB">Bills Payment</button>
            <button type="button" class="btn btn-default btn-block" id="sendMoneyB">Send Money</button>
          </div>
        </div>
      </div>
      <div class="col-xs-9 col-sm-9 col-lg-9">
        <div class="well maintable">
          <div id="message">
            <?php
              $query = "SELECT firstname, lastname FROM personal_info WHERE idpersonal_info=".$_SESSION['id'];
            	$result = mysqli_query($link, $query);
              if ($result) {
            		$row = mysqli_fetch_array($result);
            		if ($row){
                  $firstname = $row[0];
                  $lastname = $row[1];
                  if ($_SESSION['last_login']) {
                    $lastlogin = "Your last login was ".$_SESSION['last_login'].".";
                  }
                  else $lastlogin = "This is your first login.";

                  echo 'Hello, '.$firstname.' '.$lastname.'!<br /> '.$lastlogin.'<br />';
                }
              }
             ?>
            <!-- Hello, Mark Vincent Ty!<br /> Your last login was July 20, 2017, 06:01:06 GMT+8.<br /> -->
            <br />
          </div>
          <table class="table table-bordered table-responsive">
            <thead>
              <tr>
                <th>Currency</th>
                <th>Account Type</th>
                <th>Account No.</th>
                <th>Username</th>
                <th>Balance</th>
              </tr>
            </thead>
            <tbody>

              <?php
                $bankacctQuery = "SELECT account_no FROM user_account WHERE personal_info_id=".$_SESSION['id'];
                $bankacctResult = mysqli_query($link, $bankacctQuery);
                if ($bankacctResult) {
                  while($row = $bankacctResult->fetch_assoc()){
                      $account_no = $row['account_no'];

                      $balance = 0;
                      $query = "SELECT currency, amount FROM amount WHERE accountno IN (SELECT account_no FROM user_account WHERE
                        account_no='$account_no' AND personal_info_id=".$_SESSION['id'].")";
                      $result = mysqli_query($link, $query);
                      if ($result) {
                          $row = mysqli_fetch_array($result);
                          echo '<tr>'.
                            '<td>'.$row[0].'</td>';
                          $balance = $row[1];
                      }

                      $query = "SELECT account_type FROM acct_type WHERE idacct_type IN (SELECT account_type_id FROM user_account WHERE
                        account_no='$account_no' AND personal_info_id=".$_SESSION['id'].")";
                      $result = mysqli_query($link, $query);
                      if ($result) {
                          $row = mysqli_fetch_array($result);
                          echo '<td>'.$row[0].'</td>';
                      }

                      echo '<td>'.$account_no.'</td>';

                      $query = "SELECT username FROM online_acct WHERE personal_info_id=".$_SESSION['id'];
                      $result = mysqli_query($link, $query);
                      if ($result) {
                          $row = mysqli_fetch_array($result);
                          echo '<td>'.$row[0].'</td>';
                      }

                      $balanceText = number_format($balance, 2);
                      echo '<td>PHP '.$balanceText.'</td>';
                      echo '<tr>';
                  }
                }
              ?>

            </tbody>
          </table>
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
  <script src="bankaccount-default.js"></script>
</body>

</html>
