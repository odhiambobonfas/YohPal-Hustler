<?php

namespace Yohpal\Application;


/**
 * Auth class handles user session management and authentication state.
 *
 * Usage:
 * - Auth::login($user): Log in a user and store their info in the session.
 * - Auth::user(): Retrieve the logged-in user as an object.
 * - Auth::logout(): Remove user data from the session.
 * - Auth::session(): Ensure the session is started before accessing it.
 */
class Auth {
    /**
     * Ensure session is started
     * @return void
     */
    public static function session() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Log in a user by storing their info in the session
     *
     * @param array|object $user User data to store in session
     * @return void
     */
    public static function login($user) {
        self::session();
        $_SESSION['auth_user'] = $user;
    }

    /**
     * Get the currently logged-in user
     *
     * @return Array|Object|null Logged-in user as object or null if not set
     */
    public static function user() {
        self::session();
        if (isset($_SESSION['auth'])) {
            return is_object($_SESSION['auth'])
                ? $_SESSION['auth']
                : (object)$_SESSION['auth'];
        }

        return null;
    }

    /**
     * Get the currently logged-in hustler
     *
     * @return Array|Object|null Logged-in hustler as object or null if not set
     */
    public static function hustler() {
        self::session();
        if (isset($_SESSION['hustler'])) {
            return is_object($_SESSION['hustler'])
                ? $_SESSION['hustler']
                : (object)$_SESSION['hustler'];
        }

        return null;
    }

    /*
     * Get the current user status
     *
     * @return <missing>|object|null*/
    public static function hustlerStatus() {
        self::session();
        if (isset($_SESSION['hustlerStatus'])) {
            return is_object($_SESSION['hustlerStatus'])
                ? $_SESSION['hustlerStatus']
                : (object)$_SESSION['hustlerStatus'];
        }

        return null;
    }

    /**
     * Creates session.
     *
     * @return Boolen True|False If the session gets created accordingly
     */
    public static function create(string $group, mixed $vars): bool {
        self::session();

        $_SESSION[$group] = $vars;

        if (isset($_SESSION[$group])) {
            $_SESSION[$group] = (object)$_SESSION[$group];
            return true;
        }

        return false;
    }

    /**
     * Gets session in respect to group specified.
     */
    public static function get(string $group): Array|Object|null {
        self::session();
        if (isset($_SESSION[$group])) {
            return is_object($_SESSION[$group])
                ? $_SESSION[$group]
                : (object)$_SESSION[$group];
        }

        return null;
    }

    /**
     * Update session.
     *
     * @return Boolen True|False If the session gets updated accordingly
     */
    public static function update(string $group, string $key, mixed $vars): bool {
        self::session();

        if (isset($_SESSION[$group]) && is_object($_SESSION[$group])) {
            $_SESSION[$group] = json_decode(json_encode($_SESSION[$group]), true);
        }

        $_SESSION[$group][$key] = $vars;

        if (isset($_SESSION[$group][$key])) {
            $_SESSION[$group] = (object)$_SESSION[$group];
            return true;
        }

        return false;
    }

    /**
     * Log out the current user by removing their session data
     */
    public static function del_session(string $group): void {
        self::session();
        if (isset($_SESSION[$group])) unset($_SESSION[$group]);
    }

    /**
     * Log out the current user by removing their session data
     * @return void
     */
    public static function logout() {
        self::session();
        unset($_SESSION['auth']);
    }
}
