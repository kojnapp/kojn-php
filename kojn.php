<?php
include_once('lib/crypto.php');
include_once('lib/utils.php');

class Kojn {
  // The singleton instance
  protected static $_instance;
  public function getInstance() { return self::$_instance; }

  // Constants
  const Ipn = Test;

  const debug = true;

  // host (for debug purposes)
  public static $host;
  // port (for debug purposes)
  public static $port;
  // ssl enabled (for debug purposes)
  public static $ssl = true;

  // Api key
  public static $api_key;

  // The crypto modudle
  public static $crypto;

  // Type of ipn security
  public static $ipn_sec;

  public function init_base() {
    // Set the type of ipn security
    self::$ipn_sec = $ipn_sec;

    // Initialize Kojn's crypto module
    self::$crypto = null; // new KojnCrypto();
  }

  public static function setup($func) {
    self::$_instance = new Kojn();
    $func(Kojn);

    Kojn::getInstance()->init_base();

    return Kojn::getInstance();
  }

  public function uri($path) {
    return Kojn::$host . ":" . strval(Kojn::$port) . "/api" . $path;
  }

  // Helper method for doing http(s) requests.
  public function curl($path, $method = 'GET', $params = array()) {
    $uri = $this->uri($path);
    Kojn::log("Retrieve data from `{$uri}'");

    $curl = curl_init($uri);
    $length = 0;

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    if($method !== 'GET') {
      $encoded_str = json_encode($params);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $encoded_str);
      $length = strlen($encoded_str);
    }

    $header = array(
      'Content-Type: application/json',
      "Content-Length: $length"
    );

    if(Kojn::$ssl) {
      curl_setopt($curl, CURLOPT_PORT, 443);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    }

    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, self::$api_key);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);

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
    $m = Kojn_log($msg);

    if(Kojn::debug)
      echo $m;
  }
}

function Kojn_create_invoice($kojn, $invoice_data) {
  $json = $kojn->curl('/invoices', 'POST', array("invoice" => $invoice_data));

  return arrayToObject($json);
}

function Kojn_list_invoices($kojn) {
  $invoices = array();
  $json = $kojn->curl('/invoices');

  foreach($json as &$invoice) {
    array_push($invoices, arrayToObject($invoice));
  }

  return $invoices;
}

?>
