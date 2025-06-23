<?php

namespace Yohpal\Models;

use Yohpal\Models\Model;
use Yohpal\Application\Auth;

/**
 * Roles Model
 * 
 * Right here with YohPal forever!
 */
class Roles extends Model { 
    protected $sys_roles = [ 
        'Admin',
        'Super Admin'
    ];

    /**
     * Access system default roles and returns them upon request.
     */
    public static function default_roles ():array {
        return (new self())->sys_roles;
    }
}