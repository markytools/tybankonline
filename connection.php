<?php
$dbhost = 'db4free.net';
$dbuser = 'mvty_markytools';
$dbpass = '12345678';
$dbname = 'mvty_tybank';
$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

$query = "SET time_zone = '+00:00'";
$result = mysqli_query($link, $query);
if ($result) {
  // echo "connected";
}
// if(! $conn )
// {
// die('Could not connect: ' . mysql_error());
// }
// echo 'Connected successfully';

// mysqli_close($link);
?>
