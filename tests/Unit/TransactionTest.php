<?php

use InterestAccount\Transaction;

test('get-amount-formatted', function () {

    $transaction = new Transaction();
    $transaction->setAmount(5456);

    expect($transaction->getAmountFormatted())->toBeString()->toBe("£54.56");
});
