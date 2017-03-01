<?php

namespace pxgamer\devRant\Modules;

use pxgamer\devRant\Connection;

class Users
{
    /**
     * @param $id
     * @return bool|string
     */
    public function getUserById($id)
    {
        return (is_numeric($id)) ? Connection::get('/users/' . $id) : false;
    }

    /**
     * @param $username
     * @return bool|string
     */
    public function getUserId($username)
    {
        return (is_string($username) && $username !== '')
            ? Connection::get('/get-user-id?username=' . urlencode($username))
            : false;
    }
}