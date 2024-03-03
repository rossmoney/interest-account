<?php

use InterestAccount\AccountFactory;
use InterestAccount\User;

test('open-account-invalid-uuid', function () {

    $accountFactory = new AccountFactory();
    $basicAccount = $accountFactory->openBasicAccount(new User("88224979-406e-4e3-9458-55836e4e1f95"));

    expect($basicAccount->isOpen())->toBe(false);
});

test('deposit-to-account', function () {

    $accountFactory = new AccountFactory();
    $basicAccount = $accountFactory->openBasicAccount(new User("88224979-406e-4e32-9458-55836e4e1f95"));

    if ($basicAccount->isOpen()) {
        $basicAccount->depositToAccount(500);
    }

    expect($basicAccount->getAccountBalance() / 100)->toBeFloat()->toBe(500.0);
});

test('list-account-statement', function () {

    $accountFactory = new AccountFactory();
    $basicAccount = $accountFactory->openBasicAccount(new User("88224979-406e-4e32-9458-55836e4e1f95"));

    if ($basicAccount->isOpen()) {
        $basicAccount->depositToAccount(500);
    }

    expect($basicAccount->listAccountStatement())->toContain("£500");
});
