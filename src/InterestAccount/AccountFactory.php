<?php

namespace InterestAccount;

use StatsAPI\StatsAPI;

class AccountFactory extends AbstractAccountFactory
{
    private bool $fetchFromAPI = true;

    public function openBasicAccount(User $user): BasicAccountInterface
    {
        $basicAccount = new BasicAccount();
        $basicAccount->openAccount($user);

        return $basicAccount;
    }

    public function openInterestAccount(User $user): InterestAccountInterface
    {
        $interestAccount = new InterestAccount();
        if (empty($user->getId())) {
            return $interestAccount;
        }
        $statsAPI = new StatsAPI();
        $income = new Income($user);
        $income->overrideGuzzleClient($statsAPI->getGuzzleClient());
        if ($this->fetchFromAPI) {
            $income->fetchFromAPI();
            $interestAccount->setUserIncome($income);
        }
        $interestAccount->openAccount($user);

        return $interestAccount;
    }

    public function setFetchFromApi(bool $fetchFromAPI) : void
    {
        $this->fetchFromAPI = $fetchFromAPI;
    }
}
