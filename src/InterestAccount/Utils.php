<?php

namespace InterestAccount;

/**
 * Basic class for useful helper functions
 */
class Utils
{
    /**
     * Checks if string is valid UUID
     * 
     * @param string $uuid
     * 
     * @return bool
     */
    public static function isUUID($uuid): bool
    {
        if (is_string($uuid) && preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $uuid)) {
            return true;
        }
        return false;
    }
}
