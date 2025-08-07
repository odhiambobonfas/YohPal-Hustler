<?php

namespace Yohpal\Models;

use Yohpal\Application\YPLogger;
use GuzzleHttp\Exception\RequestException;
use Yohpal\Models\Model;
use Yohpal\Application\Auth;

/**
 * Category Model - Takes care of everything in regards to Category module.
 *
 * Right here with YohPal forever!
 */
class Category extends Model
{
    /**
     * Returns a raw array of hustle categories.
     *
     * @return array<int, array<string, mixed>>|array<string, mixed> List of categories or error info
     */
    public static function hustleCategories(): array
    {
        try {
            $instance = new self();
            $endpoint = $instance->util->getEndpoint('get_service_categories');
            $response = $instance->client->get($endpoint->route, [
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);

            $json = $response->getBody()->getContents();
            $data = json_decode($json, true);

            if (isset($data['services']) && is_array($data['services'])) {
                return $data['services'];
            }

            return $data;

        } catch (RequestException $error) {
            YPLogger::error($error->getMessage());

            return [
                'error' => true,
                'message' => $error->getMessage(),
                'response' => $error->hasResponse() ? $error->getResponse()->getBody()->getContents() : null,
            ];
        }
    }

    /**
     * Returns subcategories with their jobs for a given super category ID
     *
     * @param int $slug The ID of the super category
     * @return array<int, array<string, mixed>> List of subcategories with jobs
     */
    public static function hustleSubCategoriesBySlug(string $slug): array
    {
        $subCategories = array();
        $superCategories = self::hustleCategories();

        foreach ($superCategories as $category) {
            if ($category['slug'] == $slug) {
                $subCategories = $category['subcategory'];
            }
        }

        return $subCategories;
    }

    /**
     * Generates HTML <option> elements from hustle categories array.
     *
     * @return string HTML string for <select> options
     */
    public static function hustleCategoriesDropdownOptions(): string
    {
        $categories = self::hustleCategories();

        $options = '<option value="" disabled>-- Select Skill --</option>';
        foreach ($categories as $category) {
            foreach ($category["subcategory"] as $c) {
                foreach ($c["sampleFields"] as $field) {
                    $options .= '<option value="' . htmlspecialchars($field) . '">' . htmlspecialchars($field) . '</option>';
                }
            }
        }

        return $options;
    }

    public static function pricingUnits(): string
    {
        $units = [
            "Daily",
            "Monthly",
            "Per project" ,
        ];

        $options = '<option value="" disabled>--Units--</option>';
        foreach ($units as $unit) {
            $options .= '<option value="' . $unit . '">' . htmlspecialchars($unit) . '</option>';
        }

        return $options;
    }
}
