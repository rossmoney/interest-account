<?php

namespace InterestAccount;

abstract class AbstractAccountFactory
{
    abstract public function openBasicAccount(User $user): BasicAccountInterface;

    abstract public function openInterestAccount(User $user): InterestAccountInterface;
}
