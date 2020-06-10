<?php

namespace WaseemAkhtarr\PaymentDatesSDK;

class BankHolidays
{
    /**
     * @var array
     */
    private array $bankHolidays = [];

    /**
     * @param int $year
     * @return void
     */
    private function setNewYearHolidays(int $year): void
    {
        switch (date('w', strtotime($year . '-01-01 12:00:00'))) {
            case 6:
                $this->bankHolidays[] = $year . '-01-03';
                break;
            case 0:
                $this->bankHolidays[] = $year . '-01-02';
                break;
            default:
                $this->bankHolidays[] = $year . '-01-01';
        }
    }

    /**
     * @param int $year
     * @return void
     */
    private function setMayHolidays(int $year): void
    {
        if ($year == 1995) {
            $this->bankHolidays[] = '1995-05-08'; // VE day 50th anniversary year exception.
        } else {
            switch (date('w', strtotime($year . '-05-01 12:00:00'))) {
                case 0:
                    $this->bankHolidays[] = $year . '-05-02';
                    break;
                case 1:
                    $this->bankHolidays[] = $year . '-05-01';
                    break;
                case 2:
                    $this->bankHolidays[] = $year . '-05-07';
                    break;
                case 3:
                    $this->bankHolidays[] = $year . '-05-06';
                    break;
                case 4:
                    $this->bankHolidays[] = $year . '-05-05';
                    break;
                case 5:
                    $this->bankHolidays[] = $year . '-05-04';
                    break;
                case 6:
                    $this->bankHolidays[] = $year . '-05-03';
                    break;
            }
        }
    }

    /**
     * @param int $year
     * @return void
     */
    private function setWhitsunHolidays(int $year): void
    {
        if ($year == 2002) { // Exception year.
            $this->bankHolidays[] = '2002-06-03';
            $this->bankHolidays[] = '2002-06-04';
        } else {
            switch (date('w', strtotime($year . '-05-31 12:00:00'))) {
                case 0:
                    $this->bankHolidays[] = $year . '-05-25';
                    break;
                case 1:
                    $this->bankHolidays[] = $year . '-05-31';
                    break;
                case 2:
                    $this->bankHolidays[] = $year . '-05-30';
                    break;
                case 3:
                    $this->bankHolidays[] = $year . '-05-29';
                    break;
                case 4:
                    $this->bankHolidays[] = $year . '-05-28';
                    break;
                case 5:
                    $this->bankHolidays[] = $year . '-05-27';
                    break;
                case 6:
                    $this->bankHolidays[] = $year . '-05-26';
                    break;
            }
        }
    }

    /**
     * @param int $year
     * @return void
     */
    public function setSummerHolidays(int $year): void
    {
        switch (date('w', strtotime($year . '-08-31 12:00:00'))) {
            case 0:
                $this->bankHolidays[] = $year . '-08-25';
                break;
            case 1:
                $this->bankHolidays[] = $year . '-08-31';
                break;
            case 2:
                $this->bankHolidays[] = $year . '-08-30';
                break;
            case 3:
                $this->bankHolidays[] = $year . '-08-29';
                break;
            case 4:
                $this->bankHolidays[] = $year . '-08-28';
                break;
            case 5:
                $this->bankHolidays[] = $year . '-08-27';
                break;
            case 6:
                $this->bankHolidays[] = $year . '-08-26';
                break;
        }
    }

    /**
     * @param int $year
     * @return void
     */
    private function setChristmasHolidays(int $year): void
    {
        switch (date('w', strtotime($year . '-12-25 12:00:00'))) {
            case 5:
                $this->bankHolidays[] = $year . '-12-25';
                $this->bankHolidays[] = $year . '-12-28';
                break;
            case 6:
                $this->bankHolidays[] = $year . '-12-27';
                $this->bankHolidays[] = $year . '-12-28';
                break;
            case 0:
                $this->bankHolidays[] = $year . '-12-26';
                $this->bankHolidays[] = $year . '-12-27';
                break;
            default:
                $this->bankHolidays[] = $year . '-12-25';
                $this->bankHolidays[] = $year . '-12-26';
        }
    }

    /**
     * @param int $year
     */
    private function setGoodFridayHoliday(int $year): void
    {
        $this->bankHolidays[] = date('Y-m-d', strtotime('+' . (easter_days($year) - 2) . ' days', strtotime($year . '-03-21 12:00:00')));
    }

    /**
     * @param int $year
     */
    private function setEasterMondayHoliday(int $year): void
    {
        $this->bankHolidays[] = date('Y-m-d', strtotime('+' . (easter_days($year) + 1) . ' days', strtotime($year . '-03-21 12:00:00')));
    }

    /**
     * @param int $year
     * @return array
     */
    public function calculateBankHolidays(int $year): array
    {
        // New Year's Holidays.
        $this->setNewYearHolidays($year);

        // Good friday.
        $this->setGoodFridayHoliday($year);

        // Easter Monday.
        $this->setEasterMondayHoliday($year);

        // May Day.
        $this->setMayHolidays($year);

        // Whitsun.
        $this->setWhitsunHolidays($year);

        // Summer Bank Holiday.
        $this->setSummerHolidays($year);

        // Christmas.
        $this->setChristmasHolidays($year);

        return $this->bankHolidays;
    }
}
