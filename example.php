<?php
/**
 * @author         Pierre-Henry Soria <pierrehenrysoria@gmail.com>
 * @copyright      (c) 2017-2019, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

require 'src/autoloader.php';

use PH7\Eu\Vat\Provider\EuropaVAT;
use PH7\Eu\Vat\Validator;

use PH7\Eu\Tin\Provider\EuropaTIN;
use PH7\Eu\Tin\ValidatorTIN;

$oVatValidator = new Validator(new EuropaVAT, '0472429986', 'BE');

echo $oVatValidator->all() . '<br />';
echo 'Check: ' . ($oVatValidator->check() ? 'true' : 'false') . '<br />';

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
    echo 'Invalid VAT number' . '<br />';
}

echo '<br />';

$oVatValidatorInvalid = new Validator(new EuropaVAT, '047242998', 'BE');

echo $oVatValidatorInvalid->all() . '<br />';
echo 'Check: ' . ($oVatValidatorInvalid->check() ? 'true' : 'false') . '<br />';

if ($oVatValidatorInvalid->check()) {
    $sRequestDate = $oVatValidatorInvalid->getRequestDate();
    // Optional, format the date
    $sFormattedRequestDate = (new DateTime)->format('d-m-Y');

    echo 'Business Name: ' . $oVatValidatorInvalid->getName() . '<br />';
    echo 'Address: ' . $oVatValidatorInvalid->getAddress() . '<br />';
    echo 'Request Date: ' . $sFormattedRequestDate . '<br />';
    echo 'Member State: ' . $oVatValidatorInvalid->getCountryCode() . '<br />';
    echo 'VAT Number: ' . $oVatValidatorInvalid->getVatNumber() . '<br />';
} else {
    echo 'Invalid VAT number' . '<br />';
}

echo '<br />';

$oTinValidator = new ValidatorTIN(new EuropaTIN, '78888888S', 'ES');

echo $oTinValidator->all() . '<br />';

if ($oTinValidator->check()) {
    $sRequestDate = $oTinValidator->getRequestDate();
    // Optional, format the date
    $sFormattedRequestDate = (new DateTime)->format('d-m-Y');
    echo 'Request Date: ' . $sFormattedRequestDate . '<br />';
    echo 'TIN Number: ' . $oTinValidator->getTinNumber() . '<br />';
    
} else {
    echo 'Invalid TIN number' . '<br />';
    echo 'Structure: ' . ($oTinValidator->checkStructure() ? 'true' : 'false'). '<br />';
    echo 'Syntax: ' . ($oTinValidator->checkSyntax() ? 'true' : 'false') . '<br />';
}

echo '<br />';

$oTinValidatorInvalid = new ValidatorTIN(new EuropaTIN, '78888888R', 'ES');

echo $oTinValidatorInvalid->all() . '<br />';

if ($oTinValidatorInvalid->check()) {
    $sRequestDate = $oTinValidatorInvalid->getRequestDate();
    // Optional, format the date
    $sFormattedRequestDate = (new DateTime)->format('d-m-Y');
    echo 'Request Date: ' . $sFormattedRequestDate . '<br />';
    echo 'TIN Number: ' . $oTinValidatorInvalid->getTinNumber() . '<br />';
    
} else {
    echo 'Invalid TIN number' . '<br />';
    echo 'Structure: ' . ($oTinValidatorInvalid->checkStructure() ? 'true' : 'false') . '<br />';
    echo 'Syntax: ' . ($oTinValidatorInvalid->checkSyntax() ? 'true' : 'false') . '<br />';
}

echo '<br />';

$oTinValidatorInvalid2 = new ValidatorTIN(new EuropaTIN, '7888S8888', 'ES');

echo $oTinValidatorInvalid2->all() . '<br />';

if ($oTinValidatorInvalid2->check()) {
    $sRequestDate = $oTinValidatorInvalid2->getRequestDate();
    // Optional, format the date
    $sFormattedRequestDate = (new DateTime)->format('d-m-Y');
    echo 'Request Date: ' . $sFormattedRequestDate . '<br />';
    echo 'TIN Number: ' . $oTinValidatorInvalid2->getTinNumber() . '<br />';
    
} else {
    echo 'Invalid TIN number' . '<br />';
    echo 'Structure: ' . ($oTinValidatorInvalid2->checkStructure() ? 'true' : 'false') . '<br />';
    echo 'Syntax: ' . ($oTinValidatorInvalid2->checkSyntax() ? 'true' : 'false') . '<br />';
}