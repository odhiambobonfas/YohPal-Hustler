<?php

use Yohpal\Application\YPLogger;
use \Carbon\Carbon;
use Yohpal\Application\YPException;

/**
 * Mutates an array and transforms to an object. 
 */
function array_mutate(array $arrays): object {
    return (object)(array_map(fn($array) => (object)$array, $arrays));
}

/**
 * Group serialized data that comes right from frontend.
 * Data maybe serialized by serializer function using javascript.
 */
function groupSerializedForm(array $data): array {
    $grouped = [];

    foreach ($data as $item) {
        $name = rtrim($item['name'], '[]');
        $value = $item['value'];

        if (str_ends_with($item['name'], '[]')) {
            $grouped[$name][] = $value;
        } else {
            $grouped[$name] = $value;
        }
    }

    return $grouped;
}


/**
 * Convert an object to an array gracefully.
 * Recursively converts an object (and any nested objects) to an associative array.
 *
 * @param object $obj The object to convert
 * @return array The converted array
 */
function objectToArray(?object $obj): array { 
    return !empty($obj) ? json_decode(json_encode($obj), true) : [];
}

/**
 * Check whether a request is an ajax. This provides a cleaner way
 * of avoiding conflicts when using same route for different request methods.
 */
function isAjaxRequest(): bool {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/**
 * This function extracts messages from YPLogger exception class gracefully. 
 * Well, If the exception is an instance of YPLogger, it returns the actual message.
 * Otherwise, it returns a custom message if provided, or a provided fallback.
 *
 * @param \Throwable $exception The caught error
 * @param string|null $customLog Optional custom fallback message
 * @return string The resolved error message
 */
function ypLog(\Throwable $exception, string $customLog = null): string
{
    return $exception instanceof YPLogger
        ? $exception->getMessage()
        : ($customLog ?: 'An error occurred!');
}

/**
 * A cleaner to parse URLs with dynamic params on the fly.
 * 
 * Example:
 * ```php
 * api_url_parser('https://trusty-usually-wildcat.ngrok-free.app/roles/store/{storeId}/all', ['storeId' => 123]);
 * // Returns: 'https://trusty-usually-wildcat.ngrok-free.app/roles/store/123/all'
 * ```
 * 
 * @param string $url    The URL containing placeholders like {storeId}
 * @param array  $params Key-value pairs to replace placeholders
 * 
 * @return string The parsed URL with all placeholders replaced
 */
function api_url_parser(string $url, array $params = []): string {
    foreach ($params as $key => $value) { 
        if ($value !== null) {
            $url = str_replace('{' . $key . '}', $value, $url);
        }
    }
    
    return $url;
}

/**
 * Parses a Firebase Firestore timestamp from a document or timestamp object.
 *
 * Accepts either:
 * - A document/row containing a 'createdAt' field (array/object)
 * - A direct timestamp object with '_seconds' and '_nanoseconds'
 *
 * @param array|object $doc
 * @return Carbon|null
 */
function fbTimeParser($doc): mixed {
    $timestamp = null;
    
    if (isset($doc['_seconds'])) {
        $timestamp = $doc['_seconds'] + (($doc['_nanoseconds'] ?? 0) / 1e9);
    }
 
    if (isset($doc['createdAt']['_seconds'])) {
        $timestamp = $doc['createdAt']['_seconds'] + (($doc['createdAt']['_nanoseconds'] ?? 0) / 1e9);
    }

    return $timestamp ? Carbon::createFromTimestamp($timestamp) : null;
}

/**
 * Filters a doc array by a given date key, Either by desc, asc.
 * By default, Doc array gets filtered by desc order.
 */
function docFilterByDate(array $items, string $targetDate = null, string $order = 'desc') {
    $parsed = []; 

    foreach ($items as $doc) {
        if (isset($doc['createdAt']['_seconds'])) {   
            $date = fbTimeParser($doc);
            if ($date instanceof Carbon) {
                $doc['createdAt'] = $date->format('Y-m-d H:i:s');   
            }
        }

        $parsed[] = $doc;
    }  
    // Sort by _parsedDate
    usort($parsed, function ($a, $b) use ($order) {
        $aTime = Carbon::parse($a['createdAt'])->timestamp;
        $bTime = Carbon::parse($b['createdAt'])->timestamp;
    
        return $order == 'asc'
            ? $aTime <=> $bTime
            : $bTime <=> $aTime; 
    });
    
    return $parsed;
}

/**
 * Get the ID from the URL for a specified resource from Frontend.
 */
function getIdParam(array $path, bool $throwErr=false):?string {
    $path_slugs = explode('/', current($path)); 

    if ($throwErr && count($path_slugs) > 1) {
        throw new YPException("Oops, An error Occurred. The path appears to be invalid or not found!");
    }

    return count($path_slugs) >= 1 ? current($path_slugs) : null;
}

/**
 * Get the ID from the URL for a specified resource from Frontend.
 */
function getIdParams(array $path, bool $throwErr=false):?array {
    $path_slugs = explode('/', current($path)); 

    if ($throwErr && count($path_slugs) > 1) {
        throw new YPException("Oops, An error Occurred. The path appears to be invalid or not found!");
    }

    return count($path_slugs) >= 1 ? $path_slugs : null;
}

/**
 * Gets a number and formats it in respect to stardard reads on the frontend.
 * By default, the function applies a 2 decimal place to a number.
 * 
 * @return mixed - a single string or array of strings, containing formatted number(s)
 */
function num_formatter(mixed $num, $decimals=2, $apply_dc=false): mixed {
    if (!is_array($num)) {
        if (!is_numeric($num)) {
            throw new YPException('Invalid number to string conversion');
        }

        return number_format($num, $apply_dc ?? $decimals);
    }

    if (is_array($num)) {
        $formatted = [];
        foreach ($num as $value) {
            $formatted[] = number_format($value, $apply_dc ?? $decimals);
        }

        return $formatted;
    }
}

/**
 * Takes care of account locking against authentication & onboarding
 */
function authLocked(): bool {
    if (!empty(auth()->user()) && auth()->user()->clientHustleStatus != 'active') {
        return true;
    }

    return false;
}
