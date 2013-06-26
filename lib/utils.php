<?php

function Kojn_log($msg) {
  date_default_timezone_set("Europe/Berlin");

  $file = dirname(__FILE__) . '/kojn.log';
  $contents = date('d-m H:i:s').": ";

  if (is_array($msg)) {
    $contents = $contents . var_export($msg, true);
  } else if (is_object($msg)) {
    $contents = $contents . json_encode($msg);
  } else {
    $contents = $contents . $msg;
  }

  $contents = $contents."\n";

  file_put_contents($file, $contents, FILE_APPEND);

  return $contents;
}

function arrayToObject($d) {
  if (is_array($d)) {
    /*
     * Return array converted to object
     * Using __FUNCTION__ (Magic constant)
     * for recursive call
     */
    return (object) array_map(__FUNCTION__, $d);
  }
  else {
    // Return object
    return $d;
  }
}

function Kojn_json() {
  return json_decode(file_get_contents('php://input'));
}

?>

