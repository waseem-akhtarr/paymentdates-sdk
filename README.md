# Payment Dates SDK

## Purpose And Specifications

This is an application to calculate salary and salary bonus dates with following business rules.

• Staff get their basic monthly pay on the last working day of the month (MON-
FRI).
If the last day of the month is a Saturday or Sunday, the payment date will be
the previous Friday.

• On the 10th of every month bonuses are paid for the previous month, unless the
10 th is Saturday or Sunday. In that case, staff get their bonuses on the first
Tuesday after the 10th .

## Getting Started

These instructions will let you know how to get this SDK up and running on your local machine for development and testing purposes.

### Prerequisites

SDK is developed in PHP 7.4 environment, some of its functionalities may or may not run in older PHP versions, so please make sure you have PHP 7.4 installed.

### Installing to your project

Add to `composer.json`:

```JSON
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:waseem-akhtarr/paymentdates-sdk.git"
    }
],
"require": {
    "waseem-akhtarr/paymentdates-sdk": "^1"
}
```

Composer update:

```shell
composer update
OR
composer require waseem-akhtarr/paymentdates-sdk
```

## Usage Documentation
### 1-Use it in external project

E.g below will give you an idea how to use it.

```PHP

use WaseemAkhtarr\PaymentDatesSDK\PaymentDatesClient;
$client = new PaymentDatesClient();

$monthNo = 6;
$year = 2020;
$datesArray = $client->generatePaymentDates($monthNo, $year);

//OR if you want to use current month and current year you can do it like

$datesArray = $client->generatePaymentDates();

```

### 2-Test it independently

Get its copy on your local system.
Run following command at the root of project.

```shell
composer install
```

Run unit tests to test with following command at root of project.

```shell
vendor/bin/phpunit tests
```

Run following command at root of project to get CSV Results in terminal ,where 2 is the month and 2020 is the year. 

```shell
php index.php 2 2020
```

Run following command at root of project to get CSV Results in CSV file path ,where 2 is the month , 2020 is the year and ~/Desktop/csvfilename.csv is the file path where you want to store results.

```shell
php index.php 2 2020 > ~/Desktop/csvfilename.csv
```

### Tests Covered

It covers following tests

```shell script
 ✔ Generate payment dates gives correct results with Start·from·June·2020
 ✔ Generate payment dates gives correct results with Start·from·February·2021
 ✔ Exception is thrown if month is invalid with Invalid·Month·13
 ✔ Exception is thrown if month is invalid with Invalid·Month·14
 ✔ Exception is thrown if year is invalid with Invalid·Year·12
 ✔ Exception is thrown if year is invalid with Invalid·Year·123

```

If you want to add more combinations in tests you can just add more elements in dataprovider functions in tests/PaymentDatesClientTest.php.

For any further queries you can contact me on **waseem.akhtar37@gmail.com**