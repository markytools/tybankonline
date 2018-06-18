<?php

if (!empty($_GET['account'])) {
  $user_acct_id = $_GET['account'];
  $_SESSION['current_user_acct_id'] = $user_acct_id;
}

if (!empty($_GET['dates'])) {
  switch ($_GET['dates']) {
    case 1: $_SESSION['current_dates'] = "Current"; break;
    case 2: $_SESSION['current_dates'] = "Last 7 days"; break;
    case 3: $_SESSION['current_dates'] = "Last 30 days"; break;
    case 4: $_SESSION['current_dates'] = "Last 3 months"; break;
    case 5: $_SESSION['current_dates'] = "Last 6 months"; break;
    case 6: $_SESSION['current_dates'] = "Last 12 months"; break;
    default: break;
  }
}

if (!empty($_GET['transtype'])) {
  switch ($_GET['transtype']) {
    case 1: $_SESSION['current_trans_type_id'] = 0; break;
    case 2: $_SESSION['current_trans_type_id'] = 1; break;
    case 3: $_SESSION['current_trans_type_id'] = 2; break;
    case 4: $_SESSION['current_trans_type_id'] = 3; break;
    case 5: $_SESSION['current_trans_type_id'] = 4; break;
    default: break;
  }
}

if (!empty($_GET['cred_deb'])) {
  $_SESSION['current_creditdebit'] = $_GET['cred_deb'];
}

if (!empty($_GET['amountfilt'])) {
  $_SESSION['current_amount_filt'] = $_GET['amountfilt'];
}

if (!empty($_GET['amountval'])) {
  $_SESSION['current_amount_val'] = $_GET['amountval'];
}

class PHPTransactionDetails {
  public $date;
  public $type;
  public $data;
  public $credit;
  public $debit;
  public $balance;

  public function __construct($date, $type, $data, $credit, $debit, $balance) {
    $this->date = $date;
    $this->type = $type;
    $this->data = $data;
    $this->credit = $credit;
    $this->debit = $debit;
    $this->balance = $balance;
  }
}
 ?>
