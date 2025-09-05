<?php

namespace Yohpal\Application;

use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;
use \Monolog\Formatter\LineFormatter;

/**
 * YPLogger is a utility wrapper for Monolog's Logger class.
 * It initializes a single logger instance and provides static methods
 * for writing logs at various critical levels.
 *
 * Log entries are written to the "store/logs/app.log" file using a stream handler.
 * 
 * Right here with YohPal forever!
 */
class YPLogger
{
    /**
     * Holds the Monolog Logger instance.
     *
     * @var Logger|null
     */
    protected static ?Logger $logger = null;

    /**
     * Initializes the logger if it hasn't been created already.
     *
     * Sets up a stream handler for structured log output.
     */
    protected static function init(): void
    {
        if (self::$logger !== null) {
            return;
        }

        $logFile = config('PUBLIC_PATH') . '/store/logs/app.log';
        $stream = new StreamHandler($logFile, Logger::DEBUG);

        $formatter = new LineFormatter(null, null, true, true);
        $stream->setFormatter($formatter);

        self::$logger = new Logger('app');
        self::$logger->pushHandler($stream);
    }

    /**
     * Logs an info level message.
     *
     * @param string $message The message to log
     * @param array $context Optional context array
     */
    public static function info(string $message, array $context = []): void
    {
        self::init();
        self::$logger->info($message, $context);
    }

    /**
     * Logs a warning level message.
     *
     * @param string $message The message to log
     * @param array $context Optional array
     */
    public static function warning(string $message, array $context = []): void
    {
        self::init();
        self::$logger->warning($message, $context);
    }

    /**
     * Logs an error level message.
     *
     * @param string $message The message to log
     * @param array $context Optional array
     */
    public static function error(string $message, array $context = []): void
    {
        self::init();
        self::$logger->error($message, $context);
    }

    /**
     * Logs a debug level message.
     *
     * @param string $message The message to log
     * @param array $context Optional array
     */
    public static function debug(string $message, array $context = []): void
    {
        self::init();
        self::$logger->debug($message, $context);
    }

    /**
     * Logs a message with a custom severity level.
     *
     * @param string|int $level  The log level
     * @param string $message The message to log
     * @param array $context Optional array
     */
    public static function log($level, $message, array $context = []): void
    {
        self::init();
        self::$logger->log($level, $message, $context);
    }
}
