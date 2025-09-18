<?php

/**
 * ==========================================================================================
 * PERMISSIONS BINDINGS FILE
 * ------------------------------------------------------------------------------------------
 * This file defines permission bindings across different modules and roles in the system.
 * It acts as a centralized permission map to determine which roles are allowed to perform
 * specific actions throughout the YohPal Market Web Application (Sellers' CRM Panel).
 * 
 * STRUCTURE:
 * - Each key (e.g., 'users', 'products', 'orders') represents a module or entity.
 * - Under each key, you define specific actions (e.g., 'view', 'create', 'edit', 'delete').
 * - Each action maps to an array of roles allowed to perform it (e.g., ['admin', 'seller']).
 * 
 * WHY THIS EXISTS:
 * - To make access control scalable, maintainable, and consistent across the platform.
 * - To provide a clear, human-readable map of role capabilities.
 * - To serve as the foundation for middleware checks, policy methods, and UI role guards.
 * 
 * NOTE:
 * - You can later replace static arrays with dynamic permission bindings from a DB if needed.
 * - Ensure the roles used here (e.g., 'admin', 'seller', 'support') match those in your system.
 * 
 * @author: Bernard Kung'u - YohPal Dev Team Member
 * LAST UPDATED: 26th May 2025
 * ==========================================================================================
 */

 return [
    // Auth Management
    'auth' => [
        'access'  => 'auth.access',
        'create'  => 'auth.create',
        'edit'    => 'auth.edit',
        'delete'  => 'auth.delete',
        'suspend' => 'auth.suspend',
    ],

    // Users Management
    'users' => [
        'view'   => 'users.view',
        'create' => 'users.create',
        'edit'   => 'users.edit',
        'delete' => 'users.delete',
    ],

    // Roles Management
    'roles' => [
        'view'   => 'roles.view',
        'create' => 'roles.create',
        'edit'   => 'roles.edit',
        'delete' => 'roles.delete',
    ],
 
    // Tickets
    'support_tickets' => [
        'view' => 'support_tickets.view',
        'reply' => 'support_tickets.reply',
        'assign' => 'support_tickets.assign',
    ],

    // Roles & Permissions
    'roles' => [
        'view' => 'roles.view',
        'assign' => 'roles.assign',
    ],
];
