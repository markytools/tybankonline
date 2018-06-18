<?php
  include("bank-control.php");
  include("tools/bills-payment-control.php");

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
  <link rel="stylesheet" type="text/css" href="styles/bills-payment.css">
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
          Bills Payment
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
          <div class="row">
            <br />
          </div>
          <div class="row">
            <div class="col-xs-1 col-sm-1 col-lg-1"></div>
            <div class="col-xs-6 col-sm-6 col-lg-6">You can pay your utility bills online in TyBank here.</div>
            <div class="col-xs-5 col-sm-5 col-lg-5"></div>
          </div>
          <div class="row">
            <br />
          </div>
            <div class="row formRow">
                <div class="col-xs-1 col-sm-1 col-lg-1"></div>
                <div class="col-xs-3 col-sm-3 col-lg-3 detailLabel">
                  <label>Utility Service</label>
                </div>
                <div class="col-xs-1 col-sm-1 col-lg-1">
                  <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="utilityId" data-toggle="dropdown"><span id="selectUtilityId">Select a utility service...</span><span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                      <li role="presentation"><a role="menuitem" tabindex="-1" id="globeId"></a></li>
                      <li role="presentation"><a role="menuitem" tabindex="-1" id="smartId"></a></li>
                      <li role="presentation"><a role="menuitem" tabindex="-1" id="norecoId"></a></li>
                    </ul>
                  </div>
                </div>
                <div class="col-xs-7 col-sm-7 col-lg-7"></div>
            </div>
            <div class="row formRow">
                <div class="col-xs-1 col-sm-1 col-lg-1"></div>
                <div class="col-xs-3 col-sm-3 col-lg-3 detailLabel">
                  <label>Account Number</label>
                </div>
                <div class="col-xs-1 col-sm-1 col-lg-1">
                  <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span id="acctnoId">Select your account number...</span><span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                      <?php
                        $query = "SELECT accountno, amount, currency, idamount FROM amount WHERE accountno IN (SELECT account_no FROM user_account WHERE personal_info_id=".$_SESSION['id'].")";
                        $result = mysqli_query($link, $query);
                        if ($result) {
                          while($row = $result->fetch_assoc()) {
                              $acctno = $row['accountno'];
                              $amount = $row['amount'];
                              $currency = $row['currency'];
                              $idamount = $row['idamount'];
                              echo '<li role="presentation"><a role="menuitem" tabindex="-1" class="acctnoval" idamount="'.$idamount.'"
                                acctno="'.$acctno.'" currency="'.$currency.'" balance="'.$amount.'">'.$acctno.'</a></li>';
                          }
                        }
                       ?>
                    </ul>
                  </div>
                </div>
                <div class="col-xs-3 col-sm-3 col-lg-3">
                </div>
                <div class="col-xs-4 col-sm-4 col-lg-4 ">
                  <div class="acctbalance">

                  </div>
                </div>
            </div>
            <div class="row inputRow">
                <div class="col-xs-1 col-sm-1 col-lg-1"></div>
                <div class="col-xs-3 col-sm-3 col-lg-3 detailLabel2">
                  <label>Merchant Number</label>
                </div>
                <div class="col-xs-1 col-sm-1 col-lg-1">

                  <div class="col-xs-1 col-sm-1 col-lg-1 numInputCol">
                    <input type="text" id="merchantNumId" maxlength="12" onkeyup="this.value = this.value.replace(/[^0-9]/, '')" class="numInput"/>
                  </div>
                  <div class="col-xs-2 col-sm-2 col-lg-2"></div>
                  <div class="col-xs-1 col-sm-1 col-lg-1">
                  </div>

                </div>
                <div class="col-xs-7 col-sm-7 col-lg-7"></div>
            </div>
            <div class="row inputRow">
                <div class="col-xs-1 col-sm-1 col-lg-1"></div>
                <div class="col-xs-3 col-sm-3 col-lg-3 detailLabel2">
                  <label>Amount</label>
                </div>
                <div class="col-xs-1 col-sm-1 col-lg-1">

                  <div class="col-xs-1 col-sm-1 col-lg-1 numInputCol">
                    <input type="number" id="amountInputId" onkeyup="this.value = this.value.replace(/^[+]?([^0-9.^0-9])/, '')" class="numInput" min="0" max="9999999999999999999999999"/>
                  </div>
                  <div class="col-xs-2 col-sm-2 col-lg-2"></div>
                  <div class="col-xs-1 col-sm-1 col-lg-1"></div>

                </div>
                <div class="col-xs-7 col-sm-7 col-lg-7"></div>
            </div>
            <div class="row">
              <div>
                <div class="col-xs-4 col-sm-4 col-lg-4"></div>
                <div class="col-xs-4 col-sm-4 col-lg-4 errorMsg"></div>
                <div class="col-xs-4 col-sm-4 col-lg-4"></div>
              </div>
            </div>
            <div class="row payB">
                <div class="col-xs-5 col-sm-5 col-lg-5"></div>
                <div class="col-xs-3 col-sm-3 col-lg-3">
                  <!-- <button type="button" name="paybill" value="PayBills" id="defaultB" class="pay btn btn-default" data-toggle="modal" data-target="#paySuccessModal">Pay Bills</button> -->
                  <button type="button" name="paybill" value="PayBills" id="defaultB" class="btn btn-default pay" href="">Pay Bills</button>
                </div>
                <div class="col-xs-4 col-sm-4 col-lg-4"></div>
            </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="paySuccessModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Payment Successful</h4>
        </div>
        <div class="modal-body">
          <div class="alert alert-success">
            <strong>Transaction complete!</strong> You have successfully made a payment transaction.
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
  <script>
    var globe = 'GLOBE';
    var smart = 'SMART';
    var noreco = 'NORECO';

    $('#globeId').text(globe);
    $('#smartId').text(smart);
    $('#norecoId').text(noreco);

    $('#globeId').click(function() {
      $('#selectUtilityId').text(globe);
    });
    $('#smartId').click(function() {
      $('#selectUtilityId').text(smart);
    });
    $('#norecoId').click(function() {
      $('#selectUtilityId').text(noreco);
    });

    // $(".acctnoval").each(function(i) {
    //   console.log('value:', $(this).val());
    //   $(this).click(function() {
    //     $('#acctnoId').text($(this).val());
    //   });
    // });

    $('#defaultB').click(function() {
      var currentAcctNum = $('#acctnoId').html();
      var currentUtility = $('#selectUtilityId').html();
      var merchantAcctNo = $('#merchantNumId').val();
      if (currentUtility == "Select a utility service...") {
        $('.errorMsg').html("No utility selected");
      }
      else if (currentAcctNum == "Select your account number...") {
        $('.errorMsg').html("No account number selected");
      }
      else if ($('#merchantNumId').val() == "") {
        $('.errorMsg').html("Enter a merchant account");
      }
      else if ($('#amountInputId').val() == "") {
        $('.errorMsg').html("Enter an amount");
      }
      else {
        var acctnoElem = $('.acctnoval[acctno="' + $('#acctnoId').html() + '"]');
        var currentBalance = parseFloat(acctnoElem.attr("balance"));
        var amount = parseFloat($('#amountInputId').val());
        if (amount > currentBalance) {
          $('.errorMsg').html("Insufficent balance");
        }
        else {
          var idamount = parseInt(acctnoElem.attr("idamount"));
          var transPostId = 0;

          switch (currentUtility) {
            case "GLOBE": transPostId = 3; break;
            case "SMART": transPostId = 4; break;
            case "NORECO": transPostId = 5; break;
            default: break;
          }

          window.location.href = "bills-payment.php?transPostId=" + transPostId + "&idamount=" + idamount + "&amount=" + amount +
            "&merchant=" + merchantAcctNo;
        }
      }
    });

    $(document).ready(function() {
      $("a[class^='acctnoval']").each(function(i) {
        $(this).click(function() {
          $('#acctnoId').text($(this).html());
          $('.acctbalance').html($(this).attr("currency") + ' ' + $(this).attr("balance"));
        });
      });
    });
  </script>

  <?php
    if (!empty($_GET['billpaymentsuccess']) && $_GET['billpaymentsuccess'] == 1) {
      echo "<script type='text/javascript'>".
        "$(document).ready(function(){".
          "$('#paySuccessModal').modal('show');".
        "});".
      "</script>";
    }
   ?>

</body>

</html>
