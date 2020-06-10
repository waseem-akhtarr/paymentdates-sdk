<?php

namespace WaseemAkhtarr\PaymentDatesSDK\Tests;

use WaseemAkhtarr\PaymentDatesSDK\Exceptions\InvalidMonthException;
use WaseemAkhtarr\PaymentDatesSDK\Exceptions\InvalidYearException;
use WaseemAkhtarr\PaymentDatesSDK\PaymentDatesClient;

class PaymentDatesClientTest extends TestCase
{
    /**
     * @return array|array[]
     */
    public function datesDataProvider(): array
    {
        return [
            'Start from June 2020'      => ['Month' => 6, 'Year' => 2020, 'Expected Output' => $this->getJune2020Response()],
            'Start from February 2021'  => ['Month' => 2, 'Year' => 2021, 'Expected Output' => $this->getFebruary2021Response()],
        ];
    }

    /**
     * @return array|array[]
     */
    public function invalidYearDataProvider(): array
    {
        return [
            'Invalid Year 12'   => ['Year' => 12],
            'Invalid Year 123'  => ['Year' => 123]
        ];
    }

    /**
     * @return array|array[]
     */
    public function invalidMonthDataProvider(): array
    {
        return [
            'Invalid Month 13'  => ['Month' => 13],
            'Invalid Month 14'  => ['Month' => 14]
        ];
    }

    /**
     * Test that Generate payment dates is working correctly using data provider.
     *
     * @dataProvider datesDataProvider
     * @param int $month
     * @param int $year
     * @param array $expectedOutput
     * @throws InvalidMonthException
     * @throws InvalidYearException
     */
    public function testGeneratePaymentDatesGivesCorrectResults(int $month, int $year, array $expectedOutput): void
    {
        $paymentDatesClient = new PaymentDatesClient();
        $results = $paymentDatesClient->generatePaymentDates($month, $year);
        $this->assertEquals($expectedOutput, $results);
    }

    /**
     * Test exception is thrown if invalid month is passed
     *
     * @dataProvider invalidMonthDataProvider
     * @param int $invalidMonth
     * @throws InvalidMonthException
     * @throws InvalidYearException
     */
    public function testExceptionIsThrownIfMonthIsInvalid(int $invalidMonth): void
    {
        $this->expectExceptionObject(new InvalidMonthException($invalidMonth));
        $paymentDatesClient = new PaymentDatesClient();
        $paymentDatesClient->generatePaymentDates($invalidMonth, getenv('VALID_YEAR'));
    }

    /**
     * Test exception is thrown if invalid year is passed.
     *
     * @dataProvider invalidYearDataProvider
     * @param int $invalidYear
     * @throws InvalidMonthException
     * @throws InvalidYearException
     */
    public function testExceptionIsThrownIfYearIsInvalid(int $invalidYear): void
    {
        $this->expectExceptionObject(new InvalidYearException($invalidYear));
        $paymentDatesClient = new PaymentDatesClient();
        $paymentDatesClient->generatePaymentDates(getenv('VALID_MONTH'), $invalidYear);
    }
}

