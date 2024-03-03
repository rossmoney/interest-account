<?php

use InterestAccount\User;
use InterestAccount\AccountFactory;

test('open-account-invalid-uuid', function () {

    $accountFactory = new AccountFactory();
    $interestAccount = $accountFactory->openInterestAccount(new User("88224979-406e-4e3-9458-55836e4e1f95"));

    expect($interestAccount->isOpen())->toBe(false);
});

test('deposit-to-account', function () {

    $accountFactory = new AccountFactory();
    $interestAccount = $accountFactory->openInterestAccount(new User("88224979-406e-4e32-9458-55836e4e1f95"));

    if ($interestAccount->isOpen()) {
        $interestAccount->depositToAccount(500);
    }

    expect($interestAccount->getAccountBalance() / 100)->toBeFloat()->toBe(500.0);
});

test('no-income-api-call', function () {

    $accountFactory = new AccountFactory();
    $accountFactory->setFetchFromAPI(false);
    $interestAccount = $accountFactory->openInterestAccount(new User("88224979-406e-4e32-9458-55836e4e1f95"));

    expect($interestAccount->isOpen())->toBe(false);
});

test('calculate-interest', function () {

    $accountFactory = new AccountFactory();
    $interestAccount = $accountFactory->openInterestAccount(new User("88224979-406e-4e32-9458-55836e4e1f95"));

    if ($interestAccount->isOpen()) {
        //account opened
        $interestAccount->depositToAccount(2000);

        $interestAccount->getAccount()->addInterestDays(6);
        $interestAccount->calculateInterest();
    }

    expect($interestAccount->getAccountBalance() / 100)->toBeFloat()->toBe(2000.3057999999999);
});

test('list-account-statement', function () {

    $accountFactory = new AccountFactory();
    $interestAccount = $accountFactory->openInterestAccount(new User("88224979-406e-4e32-9458-55836e4e1f95"));

    if ($interestAccount->isOpen()) {
        //account opened
        $interestAccount->depositToAccount(500);
    }

    expect($interestAccount->listAccountStatement())->toContain("£500");
});

test('calculate-interest-check-statement-for-interest', function () {

    $accountFactory = new AccountFactory();
    $interestAccount = $accountFactory->openInterestAccount(new User("88224979-406e-4e32-9458-55836e4e1f95"));

    if ($interestAccount->isOpen()) {
        $interestAccount->depositToAccount(2000);

        $interestAccount->getAccount()->addInterestDays(1);
        $interestAccount->calculateInterest();
    }

    expect($interestAccount->listAccountStatement())->toContain("£2,000.05")->toContain("£0.05")->toContain("interest");
});