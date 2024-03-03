<?php

namespace InterestAccount;

interface InterestAccountInterface
{
    public function isOpen(): bool;
    public function getAccount(): InterestAccount;
    public function depositToAccount(float $pounds): bool;
    public function getAccountBalance(): float;
    public function listAccountStatement(): string;
    public function calculateInterest(): int;
}
