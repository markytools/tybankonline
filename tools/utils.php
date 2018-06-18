<?php

//$assert should be true, else it should terminate
function assertRegisterData(&$registererror, $assert, $message){
  if ($assert) {
    return true;
  }
  else {
    $registererror = $message;
    return false;
  }
}

function getEncodedUrl() {
  
}
?>
