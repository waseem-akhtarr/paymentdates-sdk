<?php

namespace WaseemAkhtarr\PaymentDatesSDK;

use WaseemAkhtarr\PaymentDatesSDK\Exceptions\InvalidMonthException;
use WaseemAkhtarr\PaymentDatesSDK\Exceptions\InvalidYearException;

class PaymentDatesClient
{
    /**
     *
     */
    private const DEFAULT_BONUS_DATE_DAY = 10;

    /**
     * @var int
     */
    private int $currentMonthNo;

    /**
     * @var BankHolidays
     */
    private BankHolidays $bankHolidays;

    /**
     * PaymentDatesClient constructor.
     */
    public function __construct()
    {
        $this->currentMonthNo = (int)date('m');
        $this->bankHolidays = new BankHolidays();
    }

    /**
     * @return string
     */
    private function getCSVHeader(): string
    {
        return 'Month,Salary Date, Bonus Date' . PHP_EOL;
    }

    /**
     * @param int $monthNo
     * @param int $givenYear
     * @return array
     * @throws InvalidMonthException
     * @throws InvalidYearException
     */
    public function generatePaymentDates(int $monthNo = 0, int $givenYear = 0): array
    {
        $this->validateParams($monthNo, $givenYear);
        $result = [];
        $monthNo = ($monthNo == 0) ? $this->currentMonthNo : $monthNo;
        $bonusDateDay = self::DEFAULT_BONUS_DATE_DAY;

        for ($month = $monthNo; $month < $monthNo + 12; $month++) {

            $currentMonth = date('F', mktime(0, 0, 0, $month, 1));

            if($givenYear > 0) {
                $year = date('Y', mktime(0, 0, 0, $month, 1, $givenYear));
            } else {
                $year = date('Y', mktime(0, 0, 0, $month, 1));
            }

            $lastDayOfMonth = date('Y-m-t', strtotime('last day of ' . $currentMonth . ' ' . $year));

            $dayName = date('D', strtotime($lastDayOfMonth));
            $bankHolidaysArray = $this->bankHolidays->calculateBankHolidays($year);

            // If salary payment date is weekend fall back to previous date of weekend.
            if ($dayName == 'Sat') {
                $salaryDate = date('Y-m-d', strtotime('-1 day', strtotime($lastDayOfMonth)));
            } elseif ($dayName == 'Sun') {
                $salaryDate = date('Y-m-d', strtotime('-2 day', strtotime($lastDayOfMonth)));
            } else {
                $salaryDate = $lastDayOfMonth;
            }

            // If salary payment date is bank holiday then move salary date to previous working day.
            $salaryDayName = date('D', strtotime($salaryDate));
            if (in_array($salaryDate, $bankHolidaysArray)) {
                if ($salaryDayName == 'Mon') {
                    $salaryDate = date('Y-m-d', strtotime('-3 day', strtotime($salaryDate)));
                } elseif ($salaryDayName == 'Fri') {
                    $salaryDate = date('Y-m-d', strtotime('-1 day', strtotime($salaryDate)));
                }
            }

            // If bonus payment date is Sat or Sun move it forward to Tuesday.
            $bonusDate = date('Y-m', strtotime($salaryDate)) . '-' . $bonusDateDay;
            $bonusDateDayName = date('D', strtotime($bonusDate));
            if ($bonusDateDayName == 'Sat') {
                $bonusDate = date('Y-m-d', strtotime('+3 day', strtotime($bonusDate)));
            } elseif ($bonusDateDayName == 'Sun') {
                $bonusDate = date('Y-m-d', strtotime('+2 day', strtotime($bonusDate)));
            }

            $result[] = [
                'month_name'    => $currentMonth,
                'salary_date'   => $salaryDate,
                'bonus_date'    => $bonusDate
            ];
        }

        return $result;
    }

    /**
     * @param int $monthNo
     * @param int $givenYear
     * @return string
     * @throws InvalidMonthException
     * @throws InvalidYearException
     */
    public function generateCSV(int $monthNo = 0, int $givenYear = 0): string
    {
        $result = $this->generatePaymentDates($monthNo, $givenYear);
        $csv = $this->getCSVHeader();

        foreach ($result as $item) {
            $csv .= $item['month_name'] . ',' . $item['salary_date'] . ',' . $item['bonus_date'] . PHP_EOL;
        }
        return $csv;
    }

    /**
     * @param int $monthNo
     * @param int $givenYear
     * @throws InvalidMonthException
     * @throws InvalidYearException
     */
    private function validateParams(int $monthNo = 0, int $givenYear = 0)
    {
        if($monthNo > 12 || $monthNo < 0) {
            throw new InvalidMonthException($monthNo);
        }

        if($givenYear < 1000 || $givenYear > 3000) {
            throw new InvalidYearException($givenYear);
        }
    }
}

