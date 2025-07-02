<?php

namespace Yohpal\Application;

/**
 * YPRequest Service Class
 * 
 * Provides a cleaner way to handle and access HTTP request data.
 */
class YPRequest
{
    protected array $input = [];

    public function __construct()
    {
        $this->mergeRequestData();
    }

    /**
     * Merge and parse incoming request data.
     */
    protected function mergeRequestData()
    {
        $this->input = $_REQUEST;

        // Handle raw JSON input if Content-Type is application/json
        if (
            isset($_SERVER['CONTENT_TYPE']) &&
            stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== false
        ) {
            $json = file_get_contents('php://input');
            $jsonData = json_decode($json, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($jsonData)) {
                $this->input = array_merge($this->input, $jsonData);
            }
        }
    }

    /**
     * Get the value of a given input key.
     *
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    public function req(string $key = null, mixed $default = null)
    {
        if ($key === null) {
            return $this->input;
        }

        return $this->input[$key] ?? $default;
    }

    /**
     * Outputs a response and terminates script execution.
     *
     * If the provided response is an array, it is JSON-encoded before output.
     * However, if the response is not an array, the returned as it is.
     *
     * @param mixed $response The response data to send to the frontend/client side.
     */
    public function res($response): mixed
    {
        echo is_array($response) ? json_encode($response) : $response;
        exit;
    }

    /**
     * Check if a given key exists in the input.
     *
     * @param string $key
     * @return bool
     */
    public function contains(string $key)
    {
        return array_key_exists($key, $this->input);
    }

    /**
     * Return only the specified keys from the input.
     *
     * @param array $keys
     * @return array
     */
    public function query(array $keys)
    {
        return array_intersect_key($this->input, array_flip($keys));
    }

    /**
     * Return all input data except the specified keys.
     *
     * @param array $keys
     * @return array
     */
    public function exclusive(array $keys)
    {
        return array_diff_key($this->input, array_flip($keys));
    }
}
