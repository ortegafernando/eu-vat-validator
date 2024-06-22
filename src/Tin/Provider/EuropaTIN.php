<?php
/**
 * @author         Pierre-Henry Soria <pierrehenrysoria@gmail.com>
 * @copyright      (c) 2017-2022, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types=1);

namespace PH7\Eu\Tin\Provider;

use PH7\Eu\Tin\Exception;
use SoapClient;
use SoapFault;
use stdClass;

class EuropaTIN implements Providable
{
    public const EU_TIN_API = 'https://ec.europa.eu';
    public const EU_TIN_WSDL_ENDPOINT = '/taxation_customs/tin/services/checkTinService.wsdl';

    private const IMPOSSIBLE_CONNECT_API_MESSAGE = 'Impossible to connect to the Europa TIN SOAP: %s';
    private const IMPOSSIBLE_RETRIEVE_DATA_MESSAGE = 'Impossible to retrieve the TIN details: %s';

    /** @var SoapClient */
    private $oClient;

    /**
     * EuropaTIN Provider constructor
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
        return static::EU_TIN_API . static::EU_TIN_WSDL_ENDPOINT;
    }

    /**
     * Send the TIN number and country code to europa.eu API and get the data.
     *
     * @param int|string $sTinNumber The TIN number
     * @param string $sCountryCode The country code
     *
     * @return stdClass The TIN number's details.
     *
     * @throws Exception
     */
    public function getResource($sTinNumber, string $sCountryCode): stdClass
    {
        try {
            $aDetails = [
                'countryCode' => strtoupper($sCountryCode),
                'tinNumber' => $sTinNumber
            ];
            return $this->oClient->checkTin($aDetails);
        } catch (SoapFault $oExcept) {
            throw new Exception(
                sprintf(self::IMPOSSIBLE_RETRIEVE_DATA_MESSAGE, $oExcept->faultstring)
            );
        }
    }
}
