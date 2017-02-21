<?php

namespace pxgamer\devRant;

/**
 * Class Rant
 * @package pxgamer\devRant
 */
class Rant
{
    private $id;
    private $text;
    private $num_upvotes;
    private $num_downvotes;
    private $score;
    private $created_time;
    private $attached_image;
    private $num_comments;
    private $tags;
    private $vote_state;
    private $edited;
    private $user_id;
    private $user_username;
    private $user_score;
    private $user_avatar;

    public function __construct($text = '', $tags = [])
    {
        $this->text = $text;
        $this->tags = $tags;
    }

    public function __get($var)
    {
        return $this->$var;
    }

    public function populateFrom($rant)
    {
        unset($rant['success']);
        array_walk($rant, function ($val, $key) {
            $this->$key = $val;
        });
        return $this;
    }
}
