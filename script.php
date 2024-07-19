// script.php
require 'vendor/autoload.php';

use CommissionCalculator\Operation;
use CommissionCalculator\CommissionFeeCalculator;

$calculator = new CommissionFeeCalculator();

$inputFile = $argv[1];
$file = fopen($inputFile, 'r');

$transactions = [];
while (($line = fgetcsv($file)) !== FALSE) {
    list($date, $userId, $userType, $operationType, $amount, $currency) = $line;
    $operation = new Operation($date, $userId, $userType, $operationType, $amount, $currency);

    $weekNumber = date('W', strtotime($date));
    $transactions[$userId][$weekNumber][] = [
        'date' => $date,
        'amount' => $amount,
        'currency' => $currency
    ];

    $weeklyTransactions = $transactions[$userId][$weekNumber];
    $commission = $calculator->calculate($operation, $weeklyTransactions);
    echo $commission . PHP_EOL;
}

fclose($file);
