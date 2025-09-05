<?php

/**
 * ==========================================================================================
 * API ROUTE FUNCTION BINDINGS FILE
 * ------------------------------------------------------------------------------------------
 * This file maps API endpoints to their corresponding business functions.
 * It serves as a centralized registry of endpoint purposes for documentation, logging,
 * permissions, and development clarity.
 *
 * STRUCTURE:
 * Each entry defines:
 *     - 'method'  => HTTP method (GET, POST, PUT, DELETE, PATCH)
 *     - 'route'   => API route path
 *     - 'action'  => Functional purpose or description
 *
 * USE CASES:
 * - Can be used to generate API documentation dynamically.
 * - Helps link endpoint behavior with permission checks or logging.
 * - Assists frontend/backend developers in quickly identifying endpoint usage.
 *
 * @author: Bernard Kung'u - YohPal Dev Team Member
 * LAST UPDATED: 26th May 2025
 * ==========================================================================================
 */

return [
    // ==============================
    // USERS
    // ==============================
    'auth_user' => [
        'method' => 'POST',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/signin',
        'action' => 'Sign In User',
    ],

    'auth_register_endpoint' => [
        'method' => 'POST',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/signup',
        'action' => 'Perform user registration',
    ],

    'auth_forgot_password' => [
        'method' => 'POST',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/password_reset',
        'action' => 'Initiate forgot password request',
    ],

    'get_user_profile' => [
        'method' => 'GET',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/profile/{uid}',
        'action' => 'Gets Single User Profile',
    ],

    'get_all_users' => [
        'method' => 'GET',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/api/users',
        'action' => 'List all users',
    ],

    'create_user' => [
        'method' => 'POST',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/api/users',
        'action' => 'Create a new user',
    ],

    'get_single_user' => [
        'method' => 'GET',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/api/users/{id}',
        'action' => 'Retrieve a specific user\'s details',
    ],

    'update_user' => [
        'method' => 'PUT',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/api/users/{id}',
        'action' => 'Update an existing user',
    ],

    'delete_user' => [
        'method' => 'DELETE',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/api/users/{id}',
        'action' => 'Delete a user',
    ],

    // ==============================
    // Job Service Categories
    // ==============================
    'activate_client' => [
        'method' => 'POST',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/client/activate',
        'action' => 'Activate clients',
    ],

    'create_hustler_request' => [
        'method' => 'POST',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/hustler/request',
        'action' => 'create hustler requests',
    ],


    // ==============================
    // Job Service Categories
    // ==============================
    'get_service_categories' => [
        'method' => 'POST',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/services',
        'action' => 'Get service categories',
    ],

    // ==============================
    // Job Booking
    // ==============================
    'get_active_hustlers' => [
        'method' => 'POST',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/jobs/get_active_hustlers/{primarySkill}?start={startTime}',
        'action' => 'Get active hustlers',
    ],

    //==============================
    // Hustlers
    //==============================
    'get_hustler_job_request' => [
        'method' => 'GET',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/hustler/job_requests/{hustlerId}',
        'action' => 'Get a hustler"s job requests',
    ],

    'get_hustler_job_history' => [
        'method' => 'GET',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/hustler/job_history/{hustlerId}',
        'action' => 'Get a hustler"s job requests',
    ],

    'get_hustler_profile' => [
        'method' => 'GET',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/hustler/profile/{hustlerId}',
        'action' => "Get a hustler's profile",
    ],

    'get_hustler_live_location' => [
        'method' => 'GET',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/hustler/live_location/{hustlerId}',
        'action' => "Get a hustler's profile",
    ],

    // ==============================
    // JOBS
    // ==============================

    "create_job" => [
        "method" => "POST",
        "route" => "https://yohpal-hustler-apis-test.onrender.com/jobs/create",
        "action" => "Create a job",

    ],

    'get_job_details' => [
        'method' => 'GET',
        'route' =>  "https://yohpal-hustler-apis-test.onrender.com/jobs/get_details/{jobId}",
        'action' => 'Get a job"s details',
    ],

    'hustler_reject_job' => [
        'method' => 'PUT',
        'route' => 'https://yohpal-hustler-apis-test.onrender.com/hustler/reject_request',
        'action' => 'Reject a job'
    ],

    'hustler_accept_job' => [
        'method' => 'PUT',
        'route' => 'https://yohpal-hustler-apis-test.onrender.com/hustler/accept_request',
        'action' => 'Accept a job'
    ],
    // ==============================
    // COMMUNICATION
    // ==============================
    'send_sms' => [
        'method' => 'POST',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/send_otp',
        'action' => 'Send OTP requests',
    ],

    'send_email' => [
        'method' => 'POST',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/send_email',
        'action' => 'Send Email requests',
    ],

    // ==============================
    // CLIENTS
    // ==============================
    "get_client_job_history" => [
        "method" => "GET",
        "route" => "https://yohpal-hustler-apis-test.onrender.com/client/job_history/{ownerId}",
        "action" => "Get a user's job history"
    ],

    // ==============================
    // ROLES
    // ==============================
    'get_all_roles' => [
        'method' => 'GET',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/roles/store/{storeId}/all',
        'action' => 'Gets list of all roles',
    ],

    'get_role_by_id' => [
        'method' => 'GET',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/roles/store/{storeId}',
        'action' => 'Gets single role by role id, store id specified',
    ],

    'get_filtered_roles' => [
        'method' => 'GET',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/roles/store/{storeId}/filtered',
        'action' => 'Gets list of filtered roles',
    ],

    // ==============================
    // SUPPORT
    // ==============================
    'list_support_tickets' => [
        'method' => 'GET',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/api/tickets',
        'action' => 'List all support tickets',
    ],

    'reply_support_ticket' => [
        'method' => 'POST',
        'route'  => 'https://yohpal-hustler-apis-test.onrender.com/api/tickets/{id}/reply',
        'action' => 'Reply to a support ticket',
    ],
];
