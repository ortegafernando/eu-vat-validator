<?php
/**
 * @author         Pierre-Henry Soria <hi@ph7.me>
 * @copyright      (c) 2017-2021, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License; <https://www.gnu.org/licenses/gpl-3.0.en.html>
 */

declare(strict_types=1);

namespace PH7\Eu\Tests\Tin;

use PH7\Eu\Tin\Exception;
use PH7\Eu\Tin\Provider\EuropaTin;
use PH7\Eu\Tin\Provider\Providable;
use PH7\Eu\Tin\ValidatorTin;
use Phake;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use stdClass;

class ValidatorTestTin extends TestCase
{
    /**
     * @dataProvider validTinNumbers
     *
     * @param int|string $sTinNumber The TIN number
     * @param string $sCountryCode The country code
     */
    public function testValidTinNumbers($sTinNumber, string $sCountryCode): void
    {
        try {
            $oTinValidator = new ValidatorTIN(new EuropaTIN, $sTinNumber, $sCountryCode);
            $this->assertTrue($oTinValidator->check());
        } catch (Exception $oExcept) {
            $this->assertIsResponseFailure($oExcept);
        }
    }

    /**
     * @dataProvider invalidTinNumbers
     *
     * @param int|string $sTinNumber The TIN number
     * @param string $sCountryCode The country code
     */
    public function testInvalidTinNumbers($sTinNumber, string $sCountryCode): void
    {
        try {
            $oTinValidator = new ValidatorTIN(new EuropaTIN, $sTinNumber, $sCountryCode);
            $this->assertFalse($oTinValidator->check());
        } catch (Exception $oExcept) {
            $this->assertIsResponseFailure($oExcept);
        }
    }

    /**
     * @dataProvider validTinNumberDetails
     */
    public function testValidTinNumberStatus(stdClass $oTinDetails): void
    {
        $oValidator = $this->setUpAndMock($oTinDetails);
        $this->assertTrue($oValidator->check());
    }

    /**
     * @dataProvider invalidTinNumberDetails
     */
    public function testInvalidTinNumberStatus(stdClass $oTinDetails): void
    {
        $oValidator = $this->setUpAndMock($oTinDetails);
        $this->assertFalse($oValidator->check());
    }

    /**
     * @dataProvider validTinNumberDetails
     */
    public function testCountryCode(stdClass $oTinDetails): void
    {
        $oValidator = $this->setUpAndMock($oTinDetails);
        $this->assertEquals('BE', $oValidator->getCountryCode());
    }

    /**
     * @dataProvider validTinNumberDetails
     */
    public function testTinNumber(stdClass $oTinDetails): void
    {
        $oValidator = $this->setUpAndMock($oTinDetails);
        $this->assertEquals('0472429986', $oValidator->getTinNumber());
    }

    /**
     * @dataProvider validTinNumberDetails
     */
    public function testRequestDate(stdClass $oTinDetails): void
    {
        $oValidator = $this->setUpAndMock($oTinDetails);
        $this->assertEquals('2017-01-22+01:00', $oValidator->getRequestDate());
    }

    public function testResource(): void
    {
        try {
            $oEuropaTINProvider = new EuropaTIN;
            $this->assertInstanceOf(stdClass::class, $oEuropaTINProvider->getResource('0472429986', 'BE'));
        } catch (Exception $oExcept) {
            $this->assertIsResponseFailure($oExcept);
        }
    }

    public function validTinNumberDetails(): array
    {
        $oData = new stdClass;
        $oData->valid = true;
        $oData->countryCode = 'BE';
        $oData->TinNumber = '0472429986';
        $oData->requestDate = '2017-01-22+01:00';
        return [
            [$oData]
        ];
    }

    public function invalidTinNumberDetails(): array
    {
        $oData = new stdClass;
        $oData->valid = false;

        return [
            [$oData]
        ];
    }

    public function validTinNumbers(): array
    {
        return [
            ['78888888S', 'ES'],
            ['9763375H', 'IE'],
            ['RSSMRA85T10A562S', 'IT']
        ];
    }

    public function invalidTinNumbers(): array
    {
        return [
            [243852752, 'UK'], // Has to be 'GB'
            [29672050085, 'FRANCE'],
            ['blablabla', 'DE']
        ];
    }

    private function setUpAndMock(stdClass $oTinDetails): Phake_IMock
    {
        $oProvider = Phake::mock(Providable::class);
        Phake::when($oProvider)->getResource(Phake::anyParameters())->thenReturn($oTinDetails);
        $oValidator = Phake::partialMock(ValidatorTIN::class, $oProvider, '78888888S', 'ES');
        Phake::verify($oValidator)->sanitize();
        Phake::verify($oProvider)->getResource('78888888S', 'ES');

        return $oValidator;
    }

    private function assertIsResponseFailure(Exception $oExcept): void
    {
        $this->assertRegexp('/^Impossible to retrieve the TIN details/', $oExcept->getMessage());
    }
}
