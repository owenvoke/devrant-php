<?php

namespace pxgamer\devRant\Modules;

use pxgamer\devRant\Connection;

/**
 * Class Comments
 * @package pxgamer\devRant\Modules
 */
class Comments
{
    /**
     * @param $rantId
     * @param $comment
     * @return bool|string
     */
    public function comment($rantId, $comment)
    {
        if (Connection::$tokenId === 0 || !is_string($comment)
            || $comment === ''
        ) {
            return false;
        }

        return Connection::post('/devrant/rants/' . $rantId . '/comments', [
            'comment' => $comment,
            'user_id' => Connection::$authUserId,
            'token_id' => Connection::$tokenId,
            'token_key' => Connection::$tokenKey,
        ]);
    }

    /**
     * @param int $commentId
     * @param int $vote
     * @return bool|string
     */
    public function voteComment($commentId, $vote = 1)
    {
        if (Connection::$tokenId === 0 || !is_numeric($vote)) {
            return false;
        }

        return Connection::post('/comments/' . $commentId . '/vote', [
            'vote' => $vote,
            'user_id' => Connection::$authUserId,
            'token_id' => Connection::$tokenId,
            'token_key' => Connection::$tokenKey,
        ]);
    }

    /**
     * @param $id
     * @return bool|string
     */
    public function deleteComment($id)
    {
        if (Connection::$tokenId === 0 || !is_numeric($id)) {
            return false;
        }

        return Connection::delete('/comments/' . $id . '?user_id=' . Connection::$authUserId . '&token_id=' . Connection::$tokenId . '&token_key=' . Connection::$tokenKey);
    }
}