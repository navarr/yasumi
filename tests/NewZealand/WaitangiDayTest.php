<?php
/**
 *  This file is part of the Yasumi package.
 *
 *  Copyright (c) 2015 - 2016 AzuyaLabs
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <stelgenhof@gmail.com>
 */

namespace Yasumi\tests\NewZealand;

use DateTime;
use DateTimeZone;
use Yasumi\tests\YasumiTestCaseInterface;
use Yasumi\Holiday;

/**
 * Class for testing Waitangi day in the New Zealand.
 */
class WaitangiDayTest extends NewZealandBaseTestCase implements YasumiTestCaseInterface
{
    /**
     * The name of the holiday
     */
    const HOLIDAY = 'waitangiDay';

    /**
     * The year in which the holiday was first established
     */
    const ESTABLISHMENT_YEAR = 1974;

    /**
     * Tests Waitangi Day
     *
     * @dataProvider HolidayDataProvider
     *
     * @param int      $year     the year for which the holiday defined in this test needs to be tested
     * @param DateTime $expected the expected date
     */
    public function testHoliday($year, $expected)
    {
        $this->assertHoliday(self::REGION, self::HOLIDAY, $year,
            new DateTime($expected, new DateTimeZone(self::TIMEZONE)));
    }

    /**
     *  Tests that Holiday is not present before 1974
     */
    public function testNotHoliday()
    {
        $this->assertNotHoliday(self::REGION, self::HOLIDAY, self::ESTABLISHMENT_YEAR - 1);
    }

    /**
     * Tests the translated name of the holiday defined in this test.
     */
    public function testTranslation()
    {
        $this->assertTranslatedHolidayName(self::REGION, self::HOLIDAY,
            $this->generateRandomYear(self::ESTABLISHMENT_YEAR), [self::LOCALE => 'Waitangi Day']);
    }

    /**
     * Returns a list of test dates
     *
     * @return array list of test dates for the holiday defined in this test
     */
    public function HolidayDataProvider()
    {
        $data = [];

        for ($i = 0; $i < 100; $i++) {
            $year = $this->generateRandomYear(self::ESTABLISHMENT_YEAR);
            $date = new DateTime("$year-02-06", new DateTimeZone(self::TIMEZONE));

            // in 2015 some policy was introduced to make sure this holiday was celebrated during the working week.
            if ($year >= 2015 && in_array($date->format('w'), [0, 6])) {
                $date->modify('next monday');
            }

            $data[] = [$year, $date->format('Y-m-d')];
        }

        return $data;
    }

    /**
     * Tests type of the holiday defined in this test.
     */
    public function testHolidayType()
    {
        $this->assertHolidayType(self::REGION, self::HOLIDAY, $this->generateRandomYear(self::ESTABLISHMENT_YEAR),
            Holiday::TYPE_NATIONAL);
    }
}