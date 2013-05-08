# Kojn

Kojn's PHP API library.

Feel free to fork, modify & redistribute under the MIT license.

## Installation

1) Get the source

    git clone git://github.com/kojnapp/kojn-php.git

2) Include

    <? include_once('kojn.php'); ?>
    

## Usage

### Setup

    $kojn = Kojn::setup(function($config) {
      $config::$api_key = "YOUR_API_KEY"; 
    });
    
### Listing invoices
    
    $invoices = Kojn_list_invoices($kojn);
    
### Creating invoices
    $invoice = array("currency" => "btc", "amount_in_euro" => 3, "description" => "My invoice");
    $invoice = Kojn_create_invoice($kojn, $invoice);

Latest docs can be found here: https://kojn.nl/developer/docs/php_setup

## Contributing

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request
