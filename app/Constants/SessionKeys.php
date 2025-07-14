<?php

namespace App\Constants;

/**
 * Session key constants for the application.
 *
 * Centralizes all session keys to avoid magic strings throughout the codebase.
 */

class SessionKeys
{
    /**
     * Session key to indicate that the user needs to change their password.
     *
     * Used during first login to force password change.
     */
    public const REQUIRE_PASSWORD_CHANGE = 'requirePasswordChange';
}
