<?php
  class Crypto {
    private $access_token;
    private $crypt_method;

    public function __construct($api_key) {
      $this->access_token = $api_key;
      $this->crypt_method = "AES-256-CFB";
    }

    public function decrypt_params($params) {
      return $this->decrypt(base64_decode($params['payload']), $params['iv']);
    }

    public function decrypt($data, $iv) {
      $d = openssl_decrypt($data, $this->crypt_method, $this->access_token, OPENSSL_RAW_DATA, $iv);

      return json_decode($d);
    }

    public function encrypt_params($params) {
      $iv = strval(mt_rand() / mt_getrandmax());

      return array("iv" => $iv, "payload" => base64_encode($this->encrypt($params, $iv)));
    }

    public function encrypt($data, $iv) {
      return openssl_encrypt(json_encode($data), $this->crypt_method, $this->access_token, OPENSSL_RAW_DATA, $iv);
    }

    // Static
    /*
    public static function encrypt($api_key, $data) {
      $kojn = new Crypto($api_key);

      return $kojn->encrypt_params($data);
    }

    public static function decrypt($api_key, $data) {
      $kojn = new Crypto($api_key);

      return $kojn->decrypt_params($data);
    }
     */
  }
?>
