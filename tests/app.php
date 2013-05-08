<?
include("../kojn.php");

Kojn::log("This app serves as a php Kojn PHP test.");

$test_object = new StdClass();
$test_object->hello = 'world';
Kojn::log($test_object);

$kojn = Kojn::setup(function($config) {
  Kojn::log("in #setup - Setting up kojn");
  $config::$api_key = "09367d4b49ae1f1d9ee0a326bd3619f1";

  $config::$host    = "localhost";
  $config::$port    = 3000;
  $config::$ssl     = false;
});

Kojn::log("Fetching all transactions");
//var_dump(Kojn_list_invoices($kojn));

Kojn::log("Creating new invoice");
var_dump(Kojn_create_invoice($kojn, array(
  "amount_in_euro" => 1,
  "description" => "Test invoice"
)));

?>
