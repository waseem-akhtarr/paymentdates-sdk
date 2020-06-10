<?php
include('vendor/autoload.php');

use WaseemAkhtarr\PaymentDatesSDK\PaymentDatesClient;

$client = new PaymentDatesClient();
echo $client->generateCSV((isset($argv[1]) ? $argv[1] : 0), isset($argv[2]) ? $argv[2] : 0);
