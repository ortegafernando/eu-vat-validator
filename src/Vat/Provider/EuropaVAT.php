<?php
/**
 * @author         Pierre-Henry Soria <pierrehenrysoria@gmail.com>
 * @copyright      (c) 2017-2022, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types=1);

namespace PH7\Eu\Vat\Provider;

use PH7\Eu\Vat\Exception;
use SoapClient;
use SoapFault;
use stdClass;

class EuropaVAT implements Providable
{
    protected const VAT_EU_COUNTRY_LIST = ['AT','BE','BG','CY','CZ','DE','DK','EE','EL','ES','FI','FR','HR','HU','IE','IT','LU','LV','LT','MT','NL','PL','PT','RO','SE','SI','SK','XI'];
    private const COUNTRY_NOT_VALID = 'Country not valid in Europa VAT Service: %s';
    
    public const EU_VAT_API = 'https://ec.europa.eu';
    public const EU_VAT_WSDL_ENDPOINT = '/taxation_customs/vies/checkVatService.wsdl';

    private const IMPOSSIBLE_CONNECT_API_MESSAGE = 'Impossible to connect to the Europa VAT SOAP: %s';
    private const IMPOSSIBLE_RETRIEVE_DATA_MESSAGE = 'Impossible to retrieve the VAT details: %s';

    /** @var SoapClient */
    private $oClient;

    /**
     * EuropaVAT Provider constructor
     *
     * @throws Exception
     */
    public function __construct()
    {
        try {
            $this->oClient = new SoapClient($this->getApiUrl());
        } catch (SoapFault $oExcept) {
            throw new Exception(
                sprintf(self::IMPOSSIBLE_CONNECT_API_MESSAGE, $oExcept->faultstring),
                0,
                $oExcept
            );
        }
    }

    public function getApiUrl(): string
    {
        return static::EU_VAT_API . static::EU_VAT_WSDL_ENDPOINT;
    }

    /**
     * Send the VAT number and country code to europa.eu API and get the data.
     *
     * @param int|string $sVatNumber The VAT number
     * @param string $sCountryCode The country code
     *
     * @return stdClass The VAT number's details.
     *
     * @throws Exception
     */
    public function getResource($sVatNumber, string $sCountryCode): stdClass
    {
        if (!in_array(strtoupper($sCountryCode), self::VAT_EU_COUNTRY_LIST)) {
            throw new Exception(
                sprintf(self::COUNTRY_NOT_VALID, strtoupper($sCountryCode))
            );
        } 
        try {
            $aDetails = [
                'countryCode' => strtoupper($sCountryCode),
                'vatNumber' => $sVatNumber
            ];
            return $this->oClient->checkVat($aDetails);
        } catch (SoapFault $oExcept) {
            throw new Exception(
                sprintf(self::IMPOSSIBLE_RETRIEVE_DATA_MESSAGE, $oExcept->faultstring)
            );
        }
    }
}
