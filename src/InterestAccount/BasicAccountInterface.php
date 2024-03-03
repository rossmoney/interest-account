<?php

namespace InterestAccount;

interface BasicAccountInterface
{
    public function isOpen(): bool;
    public function getAccount(): BasicAccount;
    public function depositToAccount(float $pounds): bool;
    public function getAccountBalance(): float;
    public function listAccountStatement(): string;
}
