<?php

require 'transaction-util.php';
require 'myphpmailer.php';

if (!empty($_GET['transPostId'])) {
  if ($_GET['transPostId'] == 2) {
    $query = "SELECT amount, accountno, email, firstname, lastname FROM amount INNER JOIN user_account ON amount.accountno=user_account.account_no INNER JOIN
      online_acct ON user_account.personal_info_id=online_acct.personal_info_id INNER JOIN personal_info ON online_acct.personal_info_id=personal_info.idpersonal_info WHERE idamount=".$_GET['idamount'];
  	$result = mysqli_query($link, $query);
    if ($result) {
  		$row = mysqli_fetch_array($result);
  		if ($row){
        $myBalance = $row['amount'];
        $myAcctNo = $row['accountno'];
        $myNewBalance = $myBalance - $_GET['amount'];
        $myEmail = $row['email'];
        $myFirstname = $row['firstname'];
        $myLastname = $row['lastname'];

        $query = "SELECT amount FROM amount WHERE accountno='".$_GET['targetacct']."'";
        $result = mysqli_query($link, $query);
        if ($result) {
          $row = mysqli_fetch_array($result);
          if ($row){
            $targetBalance = $row['amount'];
            $targetAcctNo = $_GET['targetacct'];
            $newTargetBalance = $targetBalance + $_GET['amount'];

      			// $timezone = date_default_timezone_get();
      			// date_default_timezone_set($timezone);
      			$date = new DateTime();
      			$datestring = $date->format('Y-m-d H:i:s');

            addTransaction($link, 0, $_GET['amount'], $myAcctNo, 2, $datestring, $targetAcctNo, $myNewBalance);
            addTransaction($link, $_GET['amount'], 0, $targetAcctNo, 1, $datestring, $myAcctNo, $newTargetBalance);
            updateAmount($link, $myAcctNo, $myNewBalance);
            updateAmount($link, $targetAcctNo, $newTargetBalance);

            sendEmailMessage($myEmail, "TyBank Account Money Transfer Notification", "Hello, ".$myFirstname." ".$myLastname."! \nThis is to notify you that you have successfully sent PHP ".$_GET['amount']."\nfrom account number ********".substr($myAcctNo, -4)." to ********".substr($targetAcctNo, -4).".");

            header("Location: send-money.php?sendmoneysuccess=1");
          }
          else {
              header("Location: send-money.php?sendmoneysuccess=2");
          }
        }
        else {
            header("Location: send-money.php?sendmoneysuccess=2");
        }
      }
    }
  }
  else if ($_GET['transPostId'] != 0) {
    $query = "SELECT accountno, amount FROM amount WHERE idamount=".$_GET['idamount'];
  	$result = mysqli_query($link, $query);
    if ($result) {
  		$row = mysqli_fetch_array($result);
  		if ($row){
        $acctno = $row['accountno'];
        $balance = $row['amount'];

  			// $timezone = date_default_timezone_get();
  			// date_default_timezone_set($timezone);
  			$date = new DateTime();
  			$datestring = $date->format('Y-m-d H:i:s');

        $newBalance = $balance - $_GET['amount'];

        addTransaction($link, 0, $_GET['amount'], $acctno, $_GET['transPostId'], $datestring, $_GET['merchant'], $newBalance);
        updateAmount($link, $acctno, $newBalance);

        header("Location: bills-payment.php?billpaymentsuccess=1");
      }
    }
  }
}

 ?>
