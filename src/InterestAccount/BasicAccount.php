<?php

namespace InterestAccount;

class BasicAccount extends Account implements BasicAccountInterface
{
    /**
     * Opens an account, providing user id is valid
     * 
     * @param string $userId UUID-v4 format unique ID of the user
     *
     * @return bool True if valid UUID-v4 and account not already opened, otherwise False
     */
    public function openAccount(User $user): BasicAccount
    {
        if (!empty($user->getId())) {
            $this->setUser($user);
            $this->setTimeAccountOpened(time());
        }

        return $this;
    }

    public function getAccount(): BasicAccount
    {
        return $this;
    }
}
