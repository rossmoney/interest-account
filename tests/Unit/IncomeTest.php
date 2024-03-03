<?php

use InterestAccount\Income;
use InterestAccount\User;
use StatsAPI\StatsAPI;

test('fetch-income-value-valid-user', function () {

    $statsAPI = new StatsAPI();
    $income = new Income(new User("88224979-406e-4e32-9458-55836e4e1f95"));
    $income->overrideGuzzleClient($statsAPI->getGuzzleClient())
        ->fetchFromAPI();

    expect($income->getIncomeValue())->toBeFloat()->toBe(499999.0);
});

test('income-not-known', function () {

    $statsAPI = new StatsAPI();
    $income = new Income(new User("88224979-406e-4e32-9658-55836e4e1f95"));
    $income->overrideGuzzleClient($statsAPI->getGuzzleClient())
        ->fetchFromAPI();

    expect($income->isIncomeKnown())->toBe(false);
});
