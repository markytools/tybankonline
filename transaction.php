<?php
  include("bank-control.php");
  include("tools/transaction-control.php");
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
  <link rel="stylesheet" type="text/css" href="styles/transaction.css">
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
          My Transactions
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
          <div class="row transacRow1"><label class="transacLabel">Transaction Details:</label></div>
          <div class="row transacDetailRow">
            <div class="col-xs-3 col-sm-3 col-lg-3 transacDetailLabel">
              <label>Account</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-9">
              <div class="dropdown">
                <?php

                      // $_SESSION['current_acctno'] = '';
                      // $_SESSION['current_dates'] = '';
                      // $_SESSION['current_trans_type'] = '';
                      // $_SESSION['current_creditdebit'] = '';
                      // $_SESSION['current_amount_filt'] = '';
                  class AccountNoDetails {
                    public $acctno;
                    public $accttype;
                    public $user_acct_id;
                  }

                  $current_acctno = '';
                  $current_accttype = '';
                  $acct_details_arr = array();
                  $query = "SELECT iduser_account, account_no, account_type FROM user_account INNER JOIN acct_type ON
                    user_account.account_type_id=acct_type.idacct_type WHERE personal_info_id=".$_SESSION['id'];
                  $result = mysqli_query($link, $query);
                  if ($result) {
                    while($row = $result->fetch_assoc()) {
                        $user_acct_id = $row['iduser_account'];
                        $account_no = $row['account_no'];
                        $acct_type = $row['account_type'];

                        $acctdetails = new AccountNoDetails();
                        $acctdetails->acctno = $account_no;
                        $acctdetails->accttype = $acct_type;
                        $acctdetails->user_acct_id = $user_acct_id;

                        if ($_SESSION['current_user_acct_id'] == '') {
                          $_SESSION['current_user_acct_id'] = $user_acct_id;
                          $current_acctno = $account_no;
                          $current_accttype = $acct_type;
                        }
                        else {
                          if ($_SESSION['current_user_acct_id'] == $user_acct_id) {
                            $current_acctno = $account_no;
                            $current_accttype = $acct_type;
                          }
                        }

                        array_push($acct_details_arr, $acctdetails);
                    }
                  }
                 ?>

                <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><?php echo $current_acctno; ?> (<?php echo $current_accttype; ?>)<span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                  <?php
                    foreach ($acct_details_arr as $acct_details_data) {
                        echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="transaction.php?account='.$acct_details_data->user_acct_id.'">'.$acct_details_data->acctno.' ('.$acct_details_data->accttype.')</a></li>';
                    }
                   ?>
                </ul>
              </div>
            </div>
          </div>
          <div class="row transacDetailRow">
            <div class="col-xs-3 col-sm-3 col-lg-3 transacDetailLabel">
              <label>Dates</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-9">
              <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><?php if ($_SESSION['current_dates'] == '') $_SESSION['current_dates'] = "Current"; echo $_SESSION['current_dates'];  ?><span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="transaction.php?dates=1">Current</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="transaction.php?dates=2">Last 7 days</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="transaction.php?dates=3">Last 30 days</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="transaction.php?dates=4">Last 3 months</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="transaction.php?dates=5">Last 6 months</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="transaction.php?dates=6">Last 12 months</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="row transacDetailRow">
            <div class="col-xs-3 col-sm-3 col-lg-3 transacDetailLabel">
              <label>Transaction Type</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-9">
              <div class="dropdown">
                <?php

                  function getTransactionTypeText($id) {
                    switch ($id) {
                      case 0: return "All";
                      case 1: return "Money Transfer";
                      case 2: return "Bills Payment";
                      case 3: return "Mastercard";
                      case 4: return "Deposit";
                      default: break;
                    }
                  }

                 ?>
                <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><?php echo getTransactionTypeText($_SESSION['current_trans_type_id']); ?><span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="transaction.php?transtype=1">All</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="transaction.php?transtype=2">Money Transfer</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="transaction.php?transtype=3">Bills Payment</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="transaction.php?transtype=4">Mastercard</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="transaction.php?transtype=5">Deposit</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="row transacDetailRow">
            <div class="col-xs-3 col-sm-3 col-lg-3 transacDetailLabel">
              <label>Credit/Debit</label>
            </div>
            <div class="col-xs-9 col-sm-9 col-lg-9">
              <div class="dropdown">
                <?php

                  function getCreditDebitText($id) {
                    switch ($id) {
                      case 1: return "All";
                      case 2: return "Credit Only";
                      case 3: return "Debit Only";
                      default: break;
                    }
                  }

                 ?>
                <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><?php echo getCreditDebitText($_SESSION['current_creditdebit']); ?><span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="transaction.php?cred_deb=1">All</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="transaction.php?cred_deb=2">Credit Only</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="transaction.php?cred_deb=3">Debit Only</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="row transacDetailRow">
            <div class="col-xs-3 col-sm-3 col-lg-3 transacDetailLabel">
              <label>Amount</label>
            </div>
            <div class="col-xs-4 col-sm-4 col-lg-4">
              <div class="dropdown">
                <?php
                  function getAmountFilter($id) {
                    switch ($id) {
                      case 1: return "Any amount";
                      case 2: return "Greater than or equal to >=";
                      case 3: return "Less than or equal to <=";
                      case 4: return "Greater than >";
                      case 5: return "Less than <";
                      case 6: return "Equal to =";
                      default: break;
                    }
                  }

                 ?>
                <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><?php echo getAmountFilter($_SESSION['current_amount_filt']); ?><span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                  <li role="presentation"><a role="menuitem" tabindex="-1" id="option1" href="transaction.php?amountfilt=1">Any amount</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" id="option2" href="transaction.php?amountfilt=2">Greater than or equal to >=</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" id="option3" href="transaction.php?amountfilt=3">Less than or equal to <=</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" id="option4" href="transaction.php?amountfilt=4">Greater than ></a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" id="option5" href="transaction.php?amountfilt=5">Less than <</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" id="option6" href="transaction.php?amountfilt=6">Equal to =</a></li>
                </ul>
              </div>
            </div>
            <div class="col-xs-1 col-sm-1 col-lg-1">
              <input type="number" id="amountInputId" onkeyup="this.value = this.value.replace(/^[+]?([^0-9.^0-9])/, '')" class="amountInput" min="0" max="9999999999999999999999999" value="<?php echo $_SESSION['current_amount_val']; ?>"/>
            </div>
            <div class="col-xs-2 col-sm-2 col-lg-2"></div>
            <div class="col-xs-1 col-sm-1 col-lg-1">
              <button type="submit" name="submit" value="Submit" id="searchB" class="search btn btn-default">Search</button>
            </div>
            <div class="col-xs-1 col-sm-1 col-lg-1"></div>
          </div>

              <?php
                $days = 1;
                $months = 0;
                $creditdebit_comb = "AND";
                $credit_min = ' AND credit>=0';
                $debit_min = ' AND debit>=0';
                // $credit_limit = ' AND credit>=0';
                // $debit_limit = ' AND debit>=0';

                switch ($_SESSION['current_dates']) {
                  case 'Current': {
                    $days = 1;
                    $months = 0;
                  }; break;
                  case 'Last 7 days': {
                    $days = 7;
                    $months = 0;
                  }; break;
                  case 'Last 30 days': {
                    $days = 30;
                    $months = 0;
                  }; break;
                  case 'Last 3 months': {
                    $days = 0;
                    $months = 3;
                  }; break;
                  case 'Last 6 months': {
                    $days = 0;
                    $months = 6;
                  }; break;
                  case 'Last 12 months': {
                    $days = 0;
                    $months = 12;
                  }; break;
                  default: break;
                }

                switch ($_SESSION['current_amount_filt']) {
                  case 1: {
                    $creditdebit_comb = "OR";
                    $credit_min = ' AND (credit>=0 ';
                    $debit_min = ' debit>=0)';

                    switch ($_SESSION['current_creditdebit']) {
                      case 1: {
                        $creditdebit_comb = 'OR';
                      }; break;
                      case 2: {
                        $creditdebit_comb = 'AND';
                        $debit_min = ' debit=0)';
                      }; break;
                      case 3: {
                        $creditdebit_comb = 'AND';
                        $credit_min = ' AND (credit=0 ';
                      }; break;
                      default: break;
                    }
                  }; break;
                  case 2: {
                    $creditdebit_comb = "OR";
                    $credit_min = ' AND (credit>='.$_SESSION['current_amount_val'].' ';
                    $debit_min = ' debit>='.$_SESSION['current_amount_val'].')';

                    switch ($_SESSION['current_creditdebit']) {
                      case 1: {
                        $creditdebit_comb = 'OR';
                      }; break;
                      case 2: {
                        $creditdebit_comb = 'AND';
                        $debit_min = ' debit=0)';
                      }; break;
                      case 3: {
                        $creditdebit_comb = 'AND';
                        $credit_min = ' AND (credit=0 ';
                      }; break;
                      default: break;
                    }
                  }; break;
                  case 3: {
                    $creditdebit_comb = "OR";
                    $credit_min = ' AND (credit<='.$_SESSION['current_amount_val'].' ';
                    $debit_min = ' debit<='.$_SESSION['current_amount_val'].')';

                    switch ($_SESSION['current_creditdebit']) {
                      case 1: {
                        $creditdebit_comb = 'AND';
                      }; break;
                      case 2: {
                        $creditdebit_comb = 'AND';
                        $debit_min = ' debit=0)';
                      }; break;
                      case 3: {
                        $creditdebit_comb = 'AND';
                        $credit_min = ' AND (credit=0 ';
                      }; break;
                      default: break;
                    }
                  }; break;
                  case 4: {
                    $creditdebit_comb = "OR";
                    $credit_min = ' AND (credit>'.$_SESSION['current_amount_val'].' ';
                    $debit_min = ' debit>'.$_SESSION['current_amount_val'].')';

                    switch ($_SESSION['current_creditdebit']) {
                      case 1: {
                        $creditdebit_comb = 'OR';
                      }; break;
                      case 2: {
                        $creditdebit_comb = 'AND';
                        $debit_min = ' debit=0)';
                      }; break;
                      case 3: {
                        $creditdebit_comb = 'AND';
                        $credit_min = ' AND (credit=0 ';
                      }; break;
                      default: break;
                    }
                  }; break;
                  case 5: {
                    $creditdebit_comb = "OR";
                    $credit_min = ' AND (credit<'.$_SESSION['current_amount_val'].' ';
                    $debit_min = ' debit<'.$_SESSION['current_amount_val'].')';

                    switch ($_SESSION['current_creditdebit']) {
                      case 1: {
                        $creditdebit_comb = 'AND';
                      }; break;
                      case 2: {
                        $creditdebit_comb = 'AND';
                        $debit_min = ' debit=0)';
                      }; break;
                      case 3: {
                        $creditdebit_comb = 'AND';
                        $credit_min = ' AND (credit=0 ';
                      }; break;
                      default: break;
                    }
                  }; break;
                  case 6: {
                    $creditdebit_comb = "OR";
                    $credit_min = ' AND (credit='.$_SESSION['current_amount_val'].' ';
                    $debit_min = ' debit='.$_SESSION['current_amount_val'].')';

                    switch ($_SESSION['current_creditdebit']) {
                      case 1: {
                        $creditdebit_comb = 'AND';
                      }; break;
                      case 2: {
                        $creditdebit_comb = 'AND';
                        $debit_min = ' debit=0)';
                      }; break;
                      case 3: {
                        $creditdebit_comb = 'AND';
                        $credit_min = ' AND (credit=0 ';
                      }; break;
                      default: break;
                    }
                  }; break;
                  default: break;
                }

                $acct_no_query = " AND account_no='".$current_acctno."'";
                $date_query = "(transaction.datetime_post BETWEEN DATE_SUB((DATE_SUB(NOW(), INTERVAL ".$months." MONTH)), INTERVAL ".$days." DAY) AND NOW()) ";
                if ($_SESSION['current_trans_type_id'] == 0) $trans_type_query = "";
                else $trans_type_query = " AND trans_type.idtrans_type = ".$_SESSION['current_trans_type_id'];

                $query = "SELECT datetime_post, trans_type, trans_desc, post_data, recipient_num,
                credit, debit, trans_balance FROM trans_type INNER JOIN trans_post ON
                trans_type.idtrans_type=trans_post.trans_type_id INNER JOIN transaction ON trans_post.idtrans_post=transaction.trans_post_id
                WHERE ".$date_query.$trans_type_query.$credit_min.$creditdebit_comb.$debit_min.$acct_no_query." ORDER BY datetime_post DESC";

                $result = mysqli_query($link, $query);
                if ($result) {
                  if (mysqli_num_rows($result) != 0) {
                    echo '<hr class="divider pdfDivider">'.
                    '<div class="row exportPDFRow">'.
                      '<div class="col-xs-9 col-sm-9 col-lg-9"></div>'.
                      '<div class="col-xs-3 col-sm-3 col-lg-3">'.
                    '<span id="exportPDFText"><strong>Export to PDF&nbsp;&nbsp;</strong></span> <button id="exportPDFButton" type="button"><img id="pdfPic" src="images/pdflogo.png"/></button>'.
                    '</div>'.
                  '</div>';
               ?>
          <div class="row tableDiv">
            <div class="table-responsive double-scroll">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Transaction Type</th>
                    <th>Transaction Data</th>
                    <th>Credit</th>
                    <th>Debit</th>
                    <th>Balance</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                        $_SESSION['current_trans_details'] = array();

                        while ($row = $result->fetch_assoc()) {
                            $trans_date = $row['datetime_post'];
                            $trans_type = $row['trans_type'];
                            $trans_desc = $row['trans_desc'];
                            $post_data = $row['post_data'];
                            $recipient_num = $row['recipient_num'];
                            $credit = $row['credit'];
                            $debit = $row['debit'];
                            $trans_balance = $row['trans_balance'];

                            $recipient_num_text = "";
                            if ($recipient_num == NULL || $recipient_num == 0) $recipient_num_text = "";
                            else $recipient_num_text = "_".$recipient_num;

                            $trans_data = $post_data.$recipient_num_text;
                            $credit_str = 'PHP '.number_format($credit, 2);
                            $debit_str = 'PHP '.number_format($debit, 2);
                            $trans_balance_str = 'PHP '.number_format($trans_balance, 2);
                            $trans_details = new PHPTransactionDetails($trans_date, $trans_type, $trans_data, $credit_str, $debit_str,
                              $trans_balance_str);
                            array_push($_SESSION['current_trans_details'], serialize($trans_details));

                            echo '<tr>'.
                              '<td>'.$trans_date.'</td>'.
                              '<td><div title="'.$trans_desc.'">'.$trans_type.'</div></td>'.
                              '<td>'.$trans_data.'</td>'.
                              '<td>'.$credit_str.'</td>'.
                              '<td>'.$debit_str.'</td>'.
                              '<td>'.$trans_balance_str.'</td>'.
                             '</tr>';
                        }
                      }
                    }

                   ?>
                  <!-- <tr>
                    <td>July 20, 2017, 06:01:06</td>
                    <td><div title="money transfer desc">MONEY_TRANSFER</div></td>
                    <td>MASTERCARD_PAY_525257142524</td>
                    <td>PHP 9,999,999</td>
                    <td>PHP 9,999,999</td>
                    <td>PHP 9,999,999</td>
                  </tr> -->
                </tbody>
              </table>
            </div>
          </div>
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
  <script src="jquery.doubleScroll.js"></script>
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
      $(document).ready(function() {
        $('#amountInputId').change(function() {
          var amountToFilter = $('#amountInputId').val();
          $('#option1').attr('href', ('../transaction.php?amountfilt=0&amountval=' + amountToFilter));
          $('#option2').attr('href', ('../transaction.php?amountfilt=1&amountval=' + amountToFilter));
          $('#option3').attr('href', ('../transaction.php?amountfilt=2&amountval=' + amountToFilter));
          $('#option4').attr('href', ('../transaction.php?amountfilt=3&amountval=' + amountToFilter));
          $('#option5').attr('href', ('../transaction.php?amountfilt=4&amountval=' + amountToFilter));
          $('#option6').attr('href', ('../transaction.php?amountfilt=5&amountval=' + amountToFilter));
        });
      });

      $('#searchB').click(function() {
        var amountToFilter = $('#amountInputId').val();
        window.location.href = "transaction.php?amountval=" + amountToFilter;
      });

      $('#exportPDFButton').click(function() {
        window.location.href = "transaction-pdf-export.php";
      });
  </script>
  <script>
      $(document).ready(function() {
        $('.double-scroll').doubleScroll();
      });
  </script>
</body>

</html>
