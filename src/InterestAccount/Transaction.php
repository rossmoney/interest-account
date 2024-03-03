<?php

namespace InterestAccount;

use \DateTime;

/**
 * Basic class for storing the individual transaction amount and type of transaction, 'interest' or 'deposit'
 */
class Transaction
{
    /** @var float $income Amount in pence */
    protected float $amount;
    /** @var string $type Type of transaction 'interest' or 'deposit' */
    protected string $type;
    /** @var \DateTime $date DateTime object of when the transaction was made */
    protected DateTime $date;

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Returns amount, formatted as string like £0,000.00
     *
     * @return string
     */
    public function getAmountFormatted(): string
    {
        return '£' . number_format($this->getAmount() / 100, 2, '.', ',');
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }
}
