<?php
/**
 * @author         Pierre-Henry Soria <pierrehenrysoria@gmail.com>
 * @copyright      (c) 2017-2019, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types=1);

namespace PH7\Eu\Tin;

use PH7\Eu\Tin\Provider\Providable;
use stdClass;

class ValidatorTIN implements Validatable
{
    /** @var int|string */
    private $sTinNumber;

    /** @var string */
    private $sCountryCode;

    /** @var stdClass */
    private $oResponse;

    /**
     * @param Providable $oProvider The API that checks the TIN no. 
     * @param int|string $sTinNumber The TIN number.
     * @param string $sCountryCode The country code.
     */
    public function __construct(Providable $oProvider, $sTinNumber, string $sCountryCode)
    {
        $this->sTinNumber = $sTinNumber;
        $this->sCountryCode = $sCountryCode;

        $this->sanitize();
        $this->oResponse = $oProvider->getResource($this->sTinNumber, $this->sCountryCode);
    }


    public function all(): string
    {
        return json_encode($this->oResponse);
    }

    /**
     * Check if the TIN number is valid or not
     *
     * @return bool
     */
    public function check(): bool
    {
        return ($this->checkStructure() and $this->checkSyntax());
    }

    public function checkStructure(): bool
    {
        return (bool)$this->oResponse->validStructure;
    }    

    public function checkSyntax(): bool
    {
        return (bool)$this->oResponse->validSyntax;
    }      

    public function getRequestDate(): string
    {
        return $this->oResponse->requestDate ?? '';
    }

    public function getCountryCode(): string
    {
        return $this->oResponse->countryCode ?? '';
    }

    public function getTinNumber(): string
    {
        return $this->oResponse->tinNumber ?? '';
    }

    public function sanitize(): void
    {
        $aSearch = [$this->sCountryCode, '-', '_', '.', ',', ' '];
        $this->sTinNumber = trim(str_replace($aSearch, '', $this->sTinNumber));
        $this->sCountryCode = strtoupper($this->sCountryCode);
    }

}
