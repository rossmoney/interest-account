<?php

namespace InterestAccount;

class User
{
    private string $userId = '';

    public function __construct(string $uuid)
    {
        if (Utils::isUUID($uuid)) {
            $this->userId = $uuid;
        }
    }

    public function setId(string $uuid): bool
    {
        if (Utils::isUUID($uuid)) {
            $this->userId = $uuid;

            return true;
        }

        return false;
    }

    public function getId(): string
    {
        return $this->userId;
    }
}
