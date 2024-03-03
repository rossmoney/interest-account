<?php

namespace InterestAccount;

use InterestAccount\Transaction;
use InterestAccount\User;

/**
 * Implements the base account functionality that isn't associated with interest rates or calculation of interest.
 * I.e getting the account balance, adding a transaction, depositing an amount, and listing all transactions.
 */
abstract class Account
{
    /** @var string $userId The ID of the user, in UUID-v4 format */
    protected string $userId;
    /** @var Transaction[] $transactions Array of Transaction objects to keep track of all transactions added */
    protected array $transactions = [];
    /** @var int $timeAccountOpened Unix timestamp of the time the account was opened */
    private int $timeAccountOpened = 0;

    protected User $user;

    abstract public function openAccount(User $user): Account;

    public function isOpen(): bool
    {
        if ($this->timeAccountOpened >= time()) {
            return true;
        }

        return false;
    }

    protected function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function setTimeAccountOpened(int $timeAccountOpened): void
    {
        $this->timeAccountOpened = $timeAccountOpened;
    }

    public function getTimeAccountOpened(): int
    {
        return $this->timeAccountOpened;
    }

    /**
     * Returns account balance, formatted as string like £0,000.00
     *
     * @return string
     */
    public function getAccountBalanceFormatted(): string
    {
        return '£' . number_format($this->getAccountBalance() / 100, 2, '.', ',');
    }

    /**
     * Returns account balance, formatted to 2 decimal places
     *
     * @return float
     */
    public function getAccountBalance(): float
    {
        $balance = 0;
        foreach ($this->transactions as $transaction) {
            $balance += $transaction->getAmount();
        }
        return (float) number_format($balance, 2, ".", "");
    }

    /**
     * Internal: Adds a transaction to the list of transactions to display in account summary later.
     *
     * @param string $type Type of transaction, currently 'interest' or 'deposit'
     * @param float $amountPence Amount of the transaction, in pence
     *
     * @return true
     */
    protected function addTransaction(string $type, float $amountPence): void
    {
        $transaction = new Transaction();
        $transaction->setAmount($amountPence);
        $transaction->setType($type);
        $this->transactions[] = $transaction;
    }

    /**
     * Deposit amount to account 
     * 
     * @param float $pounds Amount in pounds to deposit
     *
     * @return boolean
     */
    public function depositToAccount(float $pounds): bool
    {
        if ($this->addTransaction(type: 'deposit', amountPence: $pounds * 100)) {
            return true;
        }
        return false;
    }

    /**
     * Print out account statement to screen, along with all transactions thus far
     * 
     * @param float $pounds Amount in pounds to deposit
     *
     * @return boolean
     */
    public function listAccountStatement(): string
    {
        $output = "\r\n";
        $output .= 'Your account balance is ' . $this->getAccountBalanceFormatted() . "\r\n";
        $output .= "\r\n";
        $output .= "Your recent transactions:" . "\r\n";
        $output .= "=========================" . "\r\n";
        $output .= "\r\n";
        foreach ($this->transactions as $transaction) {
            $output .= "Type: " . $transaction->getType() . ", Amount: " . $transaction->getAmountFormatted() . "\r\n";
        }
        return $output;
    }
}
