# EU VAT and TIN Number Validator

A simple and clean PHP class that validates EU VAT and TIN numbers against the central ec.europa.eu database (using the official europa API).

![EU VATIN validator; EU Flag](eu-flag.svg)


## The Problem

Validate VAT and TIN numbers might be difficult and if you use a validation pattern to check if the format is valid, you are never sure if the VAT registration number is still valid.

## The Solution

This [PHP VAT validator library](https://github.com/pH-7/eu-vat-validator) uses real-time data feeds from individual EU member states' VAT and TIN systems so you are sure of the validity of the number and avoid fraud with expired or wrong VAT numbers.

For example, this kind of validation can be very useful on online payment forms.


## Composer Installation

* Be sure PHP **[v7.1](https://www.php.net/releases/7_1_0.php) or higher** is installed.

* Install Composer (https://getcomposer.org).

* Then, include it in your project like belowe,

```bash
composer require ph-7/eu-vat-validator
 ```

* Then, include Composer's autoload (if not already done in your project)

 ```php
require_once 'vendor/autoload.php';
```


## Manual Installation (*the old-fashioned way*)

If you don't use Composer, you can install it without Composer by including the following

```php
require 'src/autoloader.php';
```


## How to Use

### Example

```php
use PH7\Eu\Vat\Validator;
use PH7\Eu\Vat\Provider\EuropaVAT;

$oVatValidator = new Validator(new EuropaVAT, '0472429986', 'BE');

if ($oVatValidator->check()) {
    $sRequestDate = $oVatValidator->getRequestDate();
    // Optional, format the date
    $sFormattedRequestDate = (new DateTime)->format('d-m-Y');

    echo 'Business Name: ' . $oVatValidator->getName() . '<br />';
    echo 'Address: ' . $oVatValidator->getAddress() . '<br />';
    echo 'Request Date: ' . $sFormattedRequestDate . '<br />';
    echo 'Member State: ' . $oVatValidator->getCountryCode() . '<br />';
    echo 'VAT Number: ' . $oVatValidator->getVatNumber() . '<br />';
} else {
    echo 'Invalid VAT number';
}
```


## Optimization (Suggestion)

Depending of the use of this library, it could be handy to cache the result specifically for each specified VAT or TIN number.

## Strict mode

By default this librery clean VAT or TIN numbers before checking them (it cleans by deleting from VAT or TIN numbers: country Code and these special characters: '-', '_', '.', ',', ' ').

If you don't want, you can check numbers in strict mode, just by calling check function with option value TRUE (default value is FALSE). In the above example, you only need to change this line:
```php
if ($oVatValidator->check(true)) {
```
```php
if ($oVatValidator->check(strict: true)) {
```

## Requirements

* PHP 7.1 or higher
* [Composer](https://getcomposer.org)
* [SOAPClient](http://php.net/manual/en/class.soapclient.php) PHP Extension enabled


## About Me

I'm **[Pierre-Henry Soria](https://pierrehenry.be)**, a passionate Software Engineer and the creator of [pH7CMS](https://github.com/pH7Software/pH7-Social-Dating-CMS).


## Where to Contact Me?

You can by email at **pierrehenrysoria+github [[AT]] gmail [[D0T]] com**


## Wordpress Plugin

[VIES Validator WP plugin](https://wordpress.org/plugins/vies-validator/) uses also this [EU VAT Validation library](https://github.com/pH-7/eu-vat-validator/) for WooCommerce checkout, when you need to make sure that the VAT number is valid (that plugin was deleloped by [WpZen](https://wpzen.it), not me :smiley:).


## References

[VAT Information Exchange System (VIES)](http://ec.europa.eu/taxation_customs/vies/)


## License

Under [General Public License 3](http://www.gnu.org/licenses/gpl.html) or later.
