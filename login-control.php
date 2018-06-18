<?php
session_start();
require 'connection.php';

if (!empty($_GET['logout'])) {
  if ($_GET['logout'] == 1 && (!empty($_SESSION["id"]) && $_SESSION["id"])) {
  	session_destroy();	//destroys all session variables
    header("Location: index.php");
  }
}

$loginerror = "";
if (!empty($_POST['username']) && !empty($_POST['password'])) {
  $username = mysqli_real_escape_string($link, $_POST["username"]);
	$password = $_POST['password'];
	$password = md5(md5($username.$password));

  $query = "SELECT personal_info.idpersonal_info, online_acct.last_login FROM personal_info INNER JOIN online_acct ON
    personal_info.idpersonal_info=online_acct.personal_info_id WHERE personal_info.idpersonal_info IN (SELECT personal_info_id FROM online_acct
    WHERE username='$username' AND password='$password')";
// $query = "SELECT acct_no, firstname, lastname FROM user_account WHERE username = '$username' AND password = '$password' LIMIT 1";

	$result = mysqli_query($link, $query);
  if ($result) {
		$row = mysqli_fetch_array($result);
		if ($row){
      $_SESSION['id'] = $row[0];
      $_SESSION['last_login'] = $row[1];

      $_SESSION['current_user_acct_id'] = '';
      $_SESSION['current_dates'] = '';
      $_SESSION['current_trans_type_id'] = 0;
      $_SESSION['current_creditdebit'] = 1;
      $_SESSION['current_amount_filt'] = 1;
      $_SESSION['current_amount_val'] = 0;
      $_SESSION['bills'] = "0";

			$timezone = date_default_timezone_get();
			date_default_timezone_set($timezone);
			$date = new DateTime();
			$datestring = $date->format('Y-m-d H:i:s');
			// echo $date->format('Y-m-d H:i:s');

			$query = "UPDATE online_acct SET last_login = '$datestring' WHERE personal_info_id = ".$_SESSION['id'];

			$result = mysqli_query($link, $query);
			if ($result) {
				header("Location: home.php");
			}
			else {
				$loginerror = "Internal Error";
			}
    }
    else {
        $loginerror = "User does not exists!";
    }
  }
  else {
    $loginerror = "User does not exists!";
  }
}

?>
