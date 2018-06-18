<?php
	session_start();
	include("connection.php");
	include("tools/utils.php");

  //Cannot be used with passwords
  function tableHasData(&$link, $tablename, $column_name, $column_value) {
    $valuetype = 0;
    if (is_string($column_value)) {
      $valuetype = 0;
      $column_value = mysqli_real_escape_string($link, $column_value);
    }
    else $valuetype = 1;

    $query = "";
    if ($valuetype == 0) $query = "SELECT * FROM $tablename WHERE $column_name = '$column_value' LIMIT 1";
    else $query = "SELECT * FROM $tablename WHERE $column_name = $column_value LIMIT 1";

  	$result = mysqli_query($link, $query);
    if ($result) {
  		$row = mysqli_fetch_array($result);
  		if ($row){
        return true;
      }
    }
    return false;
  }

  function validAccountData(&$link, $acctno, $firstname, $middlename, $lastname, $address) {
    $error = "";
    $query = "SELECT * FROM personal_info WHERE idpersonal_info IN (SELECT personal_info_id FROM user_account WHERE account_no='$acctno')";
    $result = mysqli_query($link, $query);
    if ($result) {
  		$row = mysqli_fetch_array($result);
  		if ($row){
        if (strtoupper($row['firstname']) != strtoupper($firstname)) $error = "Invalid account data";
        if (strtoupper($row['middlename']) != strtoupper($middlename)) $error = "Invalid account data";
        if (strtoupper($row['lastname']) != strtoupper($lastname)) $error = "Invalid account data";
        if (strtoupper($row['address']) != strtoupper($address)) $error = "Invalid account data";

        //SESSION
      }
      else $error = "Invalid account number";
    }
    else $error = "Invalid account number";
    return $error;
  }

  function registerOnlineAccount(&$link, $acctno, $email, $username, $password) {
    $email = mysqli_real_escape_string($link, $email);
    $username = mysqli_real_escape_string($link, $username);
    $password = md5(md5($username.$password));
    $last_login = "NONE";

		$query = "INSERT INTO online_acct (email, username, password, personal_info_id) VALUES ('$email', '$username', '$password', (SELECT personal_info_id FROM user_account WHERE account_no='$acctno'))";

    $result = mysqli_query($link, $query);
    if ($result) {

		  $query = "SELECT personal_info.idpersonal_info, online_acct.last_login FROM personal_info INNER JOIN online_acct ON
		    personal_info.idpersonal_info=online_acct.personal_info_id WHERE personal_info.idpersonal_info IN (SELECT personal_info_id FROM online_acct
		    WHERE username='$username' AND password='$password')";

			$result2 = mysqli_query($link, $query);
	    if ($result2) {
				$row = mysqli_fetch_array($result2);
				$_SESSION["id"] = $row[0];
				$_SESSION["last_login"] = $row[1];

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

				$loginQuery = "UPDATE online_acct SET last_login = '$datestring' WHERE personal_info_id = ".$_SESSION['id'];
				$loginResult = mysqli_query($link, $loginQuery);
				if ($loginResult) {
					return true;
				}
				else return false;
			}
			else return false;
    }
    else return false;
  }

  $registererror = "";
  if (!empty($_POST['submit']) && $_POST["submit"] == "Register"){
    $registererror = "";
    if (!assertRegisterData($registererror, !empty($_POST['username']), "Enter a Username")) return;
    if (!assertRegisterData($registererror, !tableHasData($link, "online_acct",
      "username", $_POST['username']), "Username already exists")) return;

    if (!assertRegisterData($registererror, !empty($_POST['email']), "Enter an Email")) return;
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $registererror = "Invalid emails";
      return;
    }
    if (!assertRegisterData($registererror, !tableHasData($link, "online_acct",
      "email", $email), "Email already exists")) return;

    if (!assertRegisterData($registererror, !empty($_POST['acctno']), "Enter an Account Number")) return;
    $registererror = validAccountData($link, $_POST['acctno'], $_POST['firstname'], $_POST['middlename'], $_POST['lastname'], $_POST['address']);
    if ($registererror) return;
    // if (!assertRegisterData($registererror, !tableHasData($link, "online_acct",
    //   "acct_no", $_POST['acctno']), "Account already registered")) return;

    if (!assertRegisterData($registererror, (strlen($_POST['password']) >= 8), "Password must be at least 8 characters")) return;
    if (!assertRegisterData($registererror, $_POST['password'] == $_POST['confirmpass'], "Passwords do not match")) return;

    $registerOnlineError = registerOnlineAccount($link, $_POST['acctno'], $_POST['email'], $_POST['username'], $_POST['password']);
    if (!$registerOnlineError) {
      $registererror = "An internal error has occured";
      return;
    }
    else {
      header("Location: home.php");
    }
  }
?>
