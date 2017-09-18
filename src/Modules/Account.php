<?php

namespace pxgamer\devRant\Modules;

use pxgamer\devRant\Connection;

/**
 * Class Account
 * @package pxgamer\devRant\Modules
 */
class Account
{
    /**
     * @param $username
     * @param $password
     * @return bool|string
     */
    public function login($username, $password)
    {
        if (!is_string($username) || $username === '') {
            return false;
        }

        $result = Connection::post(
            '/users/auth-token',
            ['username' => $username, 'password' => $password]
        );

        if ($result['success'] === true) {
            Connection::$authUserId = $result['auth_token']['user_id'];
            Connection::$tokenId = $result['auth_token']['id'];
            Connection::$tokenKey = $result['auth_token']['key'];
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function logout()
    {
        Connection::$authUserId = 0;
        Connection::$tokenId = 0;
        Connection::$tokenKey = '';
        return true;
    }

    /**
     * @return bool|string
     */
    public function notifs()
    {
        if (Connection::$tokenId === 0) {
            return false;
        }

        return Connection::get('/users/me/notif-feed?user_id=' . Connection::$authUserId . '&token_id=' . Connection::$tokenId . '&token_key=' . Connection::$tokenKey);
    }

    /**
     * @return bool|string
     */
    public function deleteAccount()
    {
        if (Connection::$tokenId === 0) {
            return false;
        }

        return Connection::delete('/users/me?user_id=' . Connection::$authUserId . '&token_id=' . Connection::$tokenId . '&token_key=' . Connection::$tokenKey);
    }
}