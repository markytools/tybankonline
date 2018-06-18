<?php
session_start();
require 'connection.php';


if (!empty($_GET['logout'])) {
  if ($_GET['logout'] == 1 && $_SESSION["id"]) {
  	session_destroy();	//destroys all session variables
    header("Location: index.php?logout=1");
  }
}
else {
  if (!$_SESSION["id"]) {
  	session_destroy();	//destroys all session variables
    header("Location: index.php?logout=1");
  }
}

abstract class TransactionDates {
  const Current = 0;
  const Last7Days = 1;
  const Last30Days = 2;
  const Last3Months = 3;
  const Last6Months = 4;
  const Last12Months = 5;
}

// values are the ids of the trans_type table
abstract class TransactionType {
  const ALL = 0;
  const MONEY_TRANSFER = 0;
  const BILL_PAY = 1;
  const MASTERCARD = 2;
  const DEPOSIT = 3;
}

?>
