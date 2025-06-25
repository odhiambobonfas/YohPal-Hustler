<?php

namespace Yohpal\Models;

use GuzzleHttp\Client;

/**
 * Model class acts as the Base class model. A bridge to other models if need be. 
 * 
 * A cleaner approach to modelling structure.
 * Right here with YohPal forever!
 */
class Model
{

    protected $client;

    protected $endpoint;

    protected $auth_token;

    public function __construct()
    {
        $this->client = new Client([
            'debug' => env('API_DEBUG', false)
        ]);
    }
    /**
     * Returns a raw array of hustle categories.
     *
     * @return array<int, array<string, mixed>> List of categories with 'id' and 'name'
     */
    public static function hustleCategories(): array
    {
        return [
            ['id' => 1, 'name' => 'Technology'],
            ['id' => 2, 'name' => 'Design'],
            ['id' => 3, 'name' => 'Management'],
            ['id' => 4, 'name' => 'Marketing'],
            ['id' => 5, 'name' => 'Writing'],
            ['id' => 6, 'name' => 'Finance'],
        ];
    }

    /**
     * Generates HTML <option> elements from hustle categories array.
     *
     * @return string HTML string for <select> options
     */
    public static function hustleCategoriesDropdownOptions(): string
    {
        $categories = self::hustleCategories();

        $options = '<option value="">-- Select Category --</option>';
        foreach ($categories as $category) {
            $options .= '<option value="' . $category['id'] . '">' . htmlspecialchars($category['name']) . '</option>';
        }

        return $options;
    }
}
