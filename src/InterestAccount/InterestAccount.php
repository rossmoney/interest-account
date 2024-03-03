<?php

namespace InterestAccount;

use InterestAccount\InterestAccountInterface;
use InterestAccount\User;

/**
 * Implements the interest account functionality, extends the basic account with methods to set the users income, 
 * set the date interest was last calculated for testing purposes, and calculate the interest. openAccount function is extended to 
 * check we have fetched the income as an account must be opened with the income value and cannot be set later. 
 */
class InterestAccount extends Account implements InterestAccountInterface
{
    /** @var int $interestLastCalculated Unix timestamp of date/time interest was last calculated */
    private int $interestLastCalculated;
    /** @var Income $userIncome Class containing details of Users income, fetched from StatsAPI */
    private ?Income $userIncome = null;

    private const MILLISECONDS_IN_DAY = 86400;

    public function setUserIncome(Income $userIncome): void
    {
        $this->userIncome = $userIncome;
    }

    public function getUserIncome(): ?Income
    {
        return $this->userIncome;
    }

    /**
     * Opens an account, providing user id is valid and income has been fetched from the API
     * 
     * @param string $userId UUID-v4 format unique ID of the user
     *
     * @return InterestAccount InterestAccount object
     */
    public function openAccount(User $user): InterestAccount
    {
        if (empty($this->getUserIncome())) {
            return $this;
        }

        if (!empty($user->getId())) {
            $this->setUser($user);
            $timeAccountOpened = time();
            $this->setTimeAccountOpened($timeAccountOpened);
            $this->setInterestLastCalculated($timeAccountOpened);
        }

        return $this;
    }

    public function setInterestLastCalculated(int $timestamp): void
    {
        $this->interestLastCalculated = $timestamp;
    }

    public function getAccount(): InterestAccount
    {
        return $this;
    }

    /**
     * Set the date interest was last calculated for testing purposes
     * 
     * @param string $date Date string, must be parsable by strtotime()
     * 
     * @return void
     */
    public function setLastDateInterestCalculated(string $date): void
    {
        $this->interestLastCalculated = strtotime($date);
    }

    private function getInterestDays(): int
    {
        return number_format((time() - $this->interestLastCalculated) / InterestAccount::MILLISECONDS_IN_DAY, 0);
    }

    /**
     * Set the date (number of days ago) interest was last calculated for testing purposes
     * 
     * @param float $days Number of days, can be half day like 0.5
     * 
     * @return void
     */
    public function addInterestDays(float $days): void
    {
        $this->interestLastCalculated = time() - (InterestAccount::MILLISECONDS_IN_DAY * $days);
    }

    /**
     * Calculates the interest using rate retrieved from income value, and adds new transaction to users account if its over 1 pence.
     * 
     * @return bool Returns true if interest was stored
     * 
     */
    public function calculateInterest(): int
    {
        $daysSinceLastInterestCalc = (time() - $this->interestLastCalculated) / 86400;
        $rate = 0.5;
        if ($this->userIncome->isIncomeKnown()) {
            if ($this->userIncome->getIncomeValue() < (5000 * 100)) {
                $rate = 0.93;
            }
            if ($this->userIncome->getIncomeValue() >= (5000 * 100)) {
                $rate = 1.02;
            }
        }

        // P × n × r / 100 × 1/365
        $interest = $this->getAccountBalance() /*P*/ * $daysSinceLastInterestCalc /*n*/ * ($rate / 100) * (1 / 365);

        $roundedInterest = round($interest, 2);

        if ($roundedInterest >= 1) {
            if ($this->addTransaction(type: 'interest', amountPence: $roundedInterest)) {
                $interestDays = $this->getInterestDays();
                $this->interestLastCalculated = time();
                return $interestDays;
            }
        }

        return 0;
    }
}
