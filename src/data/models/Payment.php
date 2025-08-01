<?php

namespace Yohpal\Models;

use Yohpal\Models\Model;
use Yohpal\Application\Auth;

/**
 * Payments Model
 * 
 * Right here with YohPal forever!
 */
class Payment extends Model { 
    
    
    /**
     * Gives out the static payment pricing units
     *
     * @return array
     */
    public static function pricingUnits(): array
    {
        $pricingUnits = [
            'OIUHJDJHDJMNHDN' => 'hour', 
            'MUDJEKNDMNBDJDD' => 'day', 
            'MBUHFBUFKJJDKJD' => 'week', 
            'UKHOKLJHGHJNDFH' => 'month'
        ]; 

        return $pricingUnits;
    }
    
    /**
     * Generates HTML <option> elements from payment pricing units array.
     *
     * @return string HTML string for <select> options
     */
    public static function pricingUnitsDropdownOptions(): string
    {
        $units = self::pricingUnits();

        $options = '<option value="">-- Select Unit --</option>';
        foreach ($units as $key => $category) {
            $options .= '<option value="' . $key . '"> Per ' . htmlspecialchars($category) . '</option>';
        }

        return $options;
    }
}