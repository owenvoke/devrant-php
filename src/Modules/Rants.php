<?php

namespace pxgamer\devRant\Modules;

use pxgamer\devRant\Connection;
use pxgamer\devRant\Rant;

/**
 * Class Rants
 * @package pxgamer\devRant\Modules
 */
class Rants
{
    /**
     * @param Rant $rant
     * @return bool|string
     */
    public function rant(Rant $rant)
    {
        if (Connection::$tokenId === 0 || !is_string($rant->text)
            || $rant->text === ''
        ) {
            return false;
        }

        return Connection::post('/devrant/rants', [
            'rant' => $rant->text,
            'user_id' => Connection::$authUserId,
            'token_id' => Connection::$tokenId,
            'token_key' => Connection::$tokenKey,
            'tags' => $rant->tags,
        ]);
    }

    /**
     * @param $id
     * @return bool|string
     */
    public function deleteRant($id)
    {
        if (Connection::$tokenId === 0 || !is_numeric($id)) {
            return false;
        }

        return Connection::delete('/devrant/rants/' . $id . '?user_id=' . Connection::$authUserId . '&token_id=' . Connection::$tokenId . '&token_key=' . Connection::$tokenKey);
    }

    /**
     * @param string $term
     * @return string
     */
    public function getRants($term = '')
    {
        $get = (empty($term))
            ? '/devrant/rants'
            : '/devrant/search?term=' . urlencode($term);

        $data = Connection::get($get);
        if (!isset($data['success'])) {
            return false;
        }

        $converter = function ($rant) {
            return (new Rant())->populateFrom($rant);
        };

        return array_map($converter,
            (empty($term)) ? $data['rants'] : $data['results']
        );
    }

    /**
     * @param $id
     * @return bool|string
     */
    public function getRantById($id)
    {
        if (!is_numeric($id)) {
            return false;
        }

        $data = Connection::get('/devrant/rants/' . $id);

        return (isset($data['success']))
            ? (new Rant())->populateFrom($data)
            : false;
    }

    /**
     * @param int $rantId
     * @param int $vote
     * @return bool|string
     */
    public function voteRant($rantId, $vote = 1)
    {
        if (Connection::$tokenId === 0 || !is_numeric($vote)) {
            return false;
        }

        return Connection::post('/devrant/rants/' . $rantId . '/vote', [
            'vote' => $vote,
            'user_id' => Connection::$authUserId,
            'token_id' => Connection::$tokenId,
            'token_key' => Connection::$tokenKey,
        ]);
    }
}