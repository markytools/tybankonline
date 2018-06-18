<?php

function addTransaction($link, $credit, $debit, $account_no, $trans_post_id, $datetime_post, $recipient_num, $trans_balance) {
    $query = "INSERT INTO transaction (credit, debit, account_no, trans_post_id, datetime_post, recipient_num, trans_balance)
      VALUES ($credit, $debit, '$account_no', $trans_post_id, '$datetime_post', '$recipient_num', $trans_balance)";
    $result = mysqli_query($link, $query);
    if ($result) {

    }
}

function updateAmount($link, $acctno, $amount) {
  $query = "UPDATE amount SET amount=".$amount." WHERE accountno=".$acctno;
  $result = mysqli_query($link, $query);
  if ($result) {

  }
}

 ?>
