<?
include("../kojn.php");

Kojn::log("This app serves as a php Kojn PHP test.");

$test_object = new StdClass();
$test_object->hello = 'world';
Kojn::log($test_object);

$kojn = Kojn::setup(function($config) {
  Kojn::log("in #setup - Setting up kojn");
  $config::$api_key = "faa4793da011c771b9d9284941a0290d";
  $config::$ipn_sec = "integrity";
});

#Kojn::log("Fetching all transactions");
#var_dump(Kojn_list_invoices($kojn));

#Kojn::log("Creating new invoice");
var_dump(Kojn_create_invoice($kojn, array(
  "amount_in_fiat" => 1,
  "description" => "Test invoice",
  "external_id" => 4,
  "currency" => "btc",
  "source_currency" => "eur"
)));

?>
