<?php

namespace pxgamer;

/**
 * Class devRant
 * @package pxgamer
 */
class devRant
{
    private static $api_base = 'https://www.devrant.io/api';

    private static $endpoints = [
        'getRants' => '/devrant/rants',
        'getRantById' => '/devrant/rants/',
        'getUserById' => '/users/',
        'searchRants' => '/devrant/search?term=',
        'getUsersId' => '/get-user-id?username=',
        'postSignIn' => '/users/auth-token',
        'postNewRant' => '/devrant/rants',
    ];

    /**
     * No idea what this should be, but it only worked with 3
     */
    private static $app_id = 3;

    /**
     * @var bool $return_object Stores whether the instance should return object
     *                          or JSON.
     */
    private $return_object;

    /**
     * @param bool $return_object
     */
    public function __construct($return_object = false)
    {
        $this->return_object = $return_object;
    }

    /**
     * @return string
     */
    public function getRants()
    {
        return $this->get(self::$endpoints['getRants']);
    }

    /**
     * @param $id
     * @return bool|string
     */
    public function getRantById($id)
    {
        return (is_numeric($id))
            ? $this->get(self::$endpoints['getRantById'] . $id)
            : false;
    }

    /**
     * @param $id
     * @return bool|string
     */
    public function getUserById($id)
    {
        return (is_numeric($id))
            ? $this->get(self::$endpoints['getUserById'] . $id)
            : false;
    }

    /**
     * @param $query
     * @return string
     */
    public function searchRants($query)
    {
        return $this->get(self::$endpoints['searchRants'] . urlencode($query));
    }

    /**
     * @param $username
     * @return bool|string
     */
    public function getUsersId($username)
    {
        return (is_string($username) && $username !== '')
            ? $this->get(self::$endpoints['getUsersId'] . urlencode($username))
            : false;
    }

    /**
     * @param $username
     * @param $password
     * @return bool|string
     */
    public function postSignIn($username, $password)
    {
        return (is_string($username) && $username !== '')
            ? $this->post(self::$endpoints['postSignIn'],
                         ['username' => $username, 'password' => $password]
            )
            : false;
    }

    /**
     * @param $rant_content
     * @param $user_id
     * @param $token_id
     * @param $token_key
     * @param $tags
     * @return bool|string
     */
    public function postNewRant($rant_content, $user_id, $token_id, $token_key, $tags = '')
    {
        return (is_string($rant_content) && $rant_content !== '')
            ? $this->post(self::$endpoints['postNewRant'], [
                'rant' => $rant_content,
                'user_id' => $user_id,
                'token_id' => $token_id,
                'token_key' => $token_key,
                'tags' => $tags,
            ])
            : false;
    }

    /**
     * @param $endpoint
     * @return mixed
     */
    private function get($endpoint)
    {
        $url = (strpos($endpoint, '?') == 0)
            ? self::$api_base . $endpoint . '?app=' . self::$app_id
            : self::$api_base . $endpoint . '&app=' . self::$app_id;
        $ch = curl_init();
        curl_setopt_array(
            $ch,
            [
                CURLOPT_URL => $url,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_RETURNTRANSFER => 1,
            ]
        );
        $result = curl_exec($ch);
        curl_close($ch);

        if ($this->return_object)
        {
            $result = json_decode($result);
        }

        return $result;
    }

    /**
     * @param $endpoint
     * @return mixed
     */
    private function post($endpoint, $content)
    {
        $post_array = [
            'app' => self::$app_id,
            'plat' => 3,
        ];

        if (count($content) > 0)
        {
            $post_array = array_merge($post_array, $content);
        }

        $url = self::$api_base . $endpoint;
        $ch = curl_init();
        curl_setopt_array(
            $ch,
            [
                CURLOPT_URL => $url,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => http_build_query($post_array),
            ]
        );
        $result = curl_exec($ch);
        curl_close($ch);

        if ($this->return_object)
        {
            $result = json_decode($result);
        }

        return $result;
    }
}
