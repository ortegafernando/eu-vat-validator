<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017-2021, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types=1);

namespace PH7\Eu\Tests\Tin\Provider;

use PH7\Eu\Tin\Provider\EuropaTIN;
use PHPUnit\Framework\TestCase;

class ProviderTestTIN extends TestCase
{
    /** @var Europa */
    private $oEuropa;

    protected function setUp(): void
    {
        $this->oEuropa = new EuropaTIN;
    }

    public function testApiUrl(): void
    {
        $this->assertEquals(EuropaTIN::EU_TIN_API_URL . EuropaTIN::EU_TIN_WSDL_ENDPOINT, $this->oEuropa->getApiUrl());
    }
}
