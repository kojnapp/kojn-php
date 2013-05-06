<?php
include_once('lib/crypto.php');
include_once('lib/utils.php');

class Kojn {
  // Constants
  const Ipn = Test;

  const debug = true;

  // Api key
  public static $api_key;

  // The crypto modudle
  public static $crypto;

  // Type of ipn security
  public static $ipn_sec;

  public function __construct($key, $ipn_sec='itegrity') {
    // Set the access token
    Kojn::$api_key = $key;

    // Set the type of ipn security
    Kojn::$ipn_sec = $ipn_sec;

    // Initialize Kojn's crypto module
    Kojn::$crypto = null; // new KojnCrypto();
  }

  // Helper method for doing http(s) requests.
  public function curl($url, $metod = 'GET', $params = array()) {
    $curl = curl_init($url);
    $length = 0;

    curl_setopt($curl, CURLOPT_CUSTOM_REQUEST, $method);
    if($method != 'GET') {
      curl_setopt($curl, CURL_POSTFIELDS, $params);
    }

    $header = array(
      'Content-Type: application/json',
      "Content-Length: $length"
    );

    curl_setopt($curl, CURLOPT_PORT, 443);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, Kojn::$api_key);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($curl, CURLOPT_FRESH_CORRECT, 1);

    $curl_response = curl_exec($curl);

    if($curl_response == false) {
      $response = array('error' => curl_error($curl));
    } else {
      $response = json_decode($curl_response, true);
      if(!$response)
        $response = array('error' => 'invalid json: ' . $curl_response);
    }

    curl_close($curl);

    return $response;
  }

  public static function log($msg) {
    $m = KojnLog($msg);

    if(Kojn::debug)
      echo $m;
  }
}

global $kojn;
$kojn = new Kojn('1234');

?>
