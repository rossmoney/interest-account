<?php 
require __DIR__ . "/vendor/autoload.php";

use InterestAccount\AccountFactory;
use InterestAccount\User;

echo "\r\n\r\n";
echo "Interest Account Example\r\n";
echo "========================\r\n";

$accountFactory = new AccountFactory();
$interestAccount = $accountFactory->openInterestAccount(new User("88224979-406e-4e32-9458-55836e4e1f95"));

if ($interestAccount->isOpen()) {
    echo "Add a deposit of £2000.\r\n";
    $interestAccount->depositToAccount(2000);

    echo "Rewind to 10-2-2024.\r\n";
    $interestAccountObject = $interestAccount->getAccount();
    $interestAccountObject->setLastDateInterestCalculated("10-2-2024");
    $interestDays = $interestAccount->calculateInterest();
    echo "Calculate interest for 10-2-2024 till today ("  . $interestDays . " days).\r\n";

    echo "Add a further £500.\r\n";
    $interestAccount->depositToAccount(500);
    $interestDays = $interestAccount->calculateInterest();
}

echo "Print summary.\r\n";
echo $interestAccount->listAccountStatement();

echo "\r\n\r\n";
echo "Basic Account Example\r\n";
echo "=====================\r\n";

$basicAccount = $accountFactory->openBasicAccount(new User("88224979-406e-4e32-9458-55836e4e1f95"));

if ($basicAccount->isOpen()) {
    echo "Add a single deposit of £123.\r\n";
    $basicAccount->depositToAccount(123);
}

echo "Print summary.\r\n";
echo $basicAccount->listAccountStatement();
