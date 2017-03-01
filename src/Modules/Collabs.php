<?php

namespace pxgamer\devRant\Modules;

use pxgamer\devRant\Connection;

/**
 * Class Collabs
 * @package pxgamer\devRant\Modules
 */
class Collabs
{
    /**
     * @return bool|string
     */
    public function collabs()
    {
        return Connection::get('/devrant/collabs?user_id=' . Connection::$authUserId . '&token_id=' . Connection::$tokenId . '&token_key=' . Connection::$tokenKey);
    }
}