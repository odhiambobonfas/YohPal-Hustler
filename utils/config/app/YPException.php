<?php

namespace Yohpal\Application;

/**
 * Class YPException
 *
 * A user-defined exception handler for gracefully managing application-level
 * errors without exposing sensitive server details such as file paths,
 * stack traces, or internal logic. This ensures that only safe, business-relevant
 * error messages are shown to end users, while allowing developers to handle
 * exceptions in a controlled and secure manner.
 * 
 * For logs related to server, you may find them in the app.log file in store directory.
 *
 * Usage:
 *     throw new YPException("Invalid credentials provided.", 401);
 *
 * Right here with YohPal forever!
 * 
 * @package App\Exceptions
 * @author Bernard - YohPal Dev Team member
 */
class YPException extends \Exception
{
    
    public function __construct(string $message = "An error occurred.", int $code = 500)
    {
        parent::__construct($message, $code);
    }

    // Prevent logging internal details
    public function __toString(): string
    {
        return "YPException: {$this->message}";
    }
}