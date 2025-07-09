<?php

namespace Yohpal\Models;

use Yohpal\Models\Model;
use Yohpal\Application\Auth;

/**
 * Jobs Model
 * 
 * Right here with YohPal forever!
 */
class Job extends Model { 
    
    
    /**
     * Gives out the static job skill sets
     *
     * @return array
     */
    public static function skillsets(): array
    {
        $skillsets = [
            'OIUHJDJHDJMNHDN' => 'Accountant', 
            'MUDJEKNDMNBDJDD' => 'Plumber', 
            'MBUHFBUFKJJDKJD' => 'Photography', 
            'UKHOKLJHGHJNDFH' => 'Marketing',
            'KDYDHDJMDLDMJCN' => 'Software Engineering'
        ]; 

        return $skillsets;
    }
    
    /**
     * Generates HTML <option> elements from job skillsets array.
     *
     * @return string HTML string for <select> options
     */
    public static function skillsetDropdownOptions(): string
    {
        $skillsets = self::skillsets();

        $options = '<option value="">-- Skill set, eg. Plumber --</option>';
        foreach ($skillsets as $key => $set) {
            $options .= '<option value="' . $key . '">' . htmlspecialchars($set) . '</option>';
        }

        return $options;
    }
}