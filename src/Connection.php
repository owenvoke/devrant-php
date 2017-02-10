<?php

namespace pxgamer\devRant;

/**
 * Class devRant
 * @package pxgamer
 */
class Connection
{
    const API_BASE = 'https://www.devrant.io/api';

    /**
     * No idea what this should be, but it only worked with 3
     */
    const APP_ID = 3;

    private $authUserId = 0;

    private $tokenId = 0;

    private $tokenKey = '';

    /**
     * @return string
     */
    public function getRants($term = '')
    {
        $get = (empty($term))
            ? '/devrant/rants'
            : '/devrant/search?term=' . urlencode($term);

        $data = $this->get($get);
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

        $data = $this->get('/devrant/rants/' . $id);

        return (isset($data['success']))
            ? (new Rant())->populateFrom($data)
            : false;
    }

    /**
     * @param $id
     * @return bool|string
     */
    public function getUserById($id)
    {
        return (is_numeric($id)) ? $this->get('/users/' . $id) : false;
    }

    /**
     * @param $username
     * @return bool|string
     */
    public function getUserId($username)
    {
        return (is_string($username) && $username !== '')
            ? $this->get('/get-user-id?username=' . urlencode($username))
            : false;
    }

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

        $result = $this->post(
            '/users/auth-token',
            ['username' => $username, 'password' => $password]
        );

        if ($result['success'] === true) {
            $this->authUserId = $result['auth_token']['user_id'];
            $this->tokenId = $result['auth_token']['id'];
            $this->tokenKey = $result['auth_token']['key'];
            return true;
        }

        return false;
    }

    public function logout()
    {
        $this->authUserId = 0;
        $this->tokenId = 0;
        $this->tokenKey = '';
    }

    /**
     * @param $rant_content
     * @param $user_id
     * @param $token_id
     * @param $token_key
     * @param $tags
     * @return bool|string
     */
    public function rant(Rant $rant)
    {
        if ($this->tokenId === 0 || !is_string($rant->text)
            || $rant->text === ''
        ) {
            return false;
        }

        return $this->post('/devrant/rants', [
            'rant' => $rant->text,
            'user_id' => $this->authUserId,
            'token_id' => $this->tokenId,
            'token_key' => $this->tokenKey,
            'tags' => $rant->tags,
        ]);
    }

    /**
     * @param $user_id
     * @param $token_id
     * @param $token_key
     * @return bool|string
     */
    public function notifs()
    {
        if ($this->tokenId === 0) {
            return false;
        }

        return $this->get('/users/me/notif-feed?user_id=' . $this->authUserId . '&token_id=' . $this->tokenId . '&token_key=' . $this->tokenKey);
    }

    /**
     * @param $user_id
     * @param $token_id
     * @param $token_key
     * @return bool|string
     */
    public function deleteAccount()
    {
        if ($this->tokenId === 0) {
            return false;
        }

        return $this->delete('/users/me?user_id=' . $this->authUserId . '&token_id=' . $this->tokenId . '&token_key=' . $this->tokenKey);
    }

    /**
     * @param $endpoint
     * @return mixed
     */
    private function get($endpoint)
    {
        $url = (strpos($endpoint, '?') == 0)
            ? self::API_BASE . $endpoint . '?app=' . self::APP_ID
            : self::API_BASE . $endpoint . '&app=' . self::APP_ID;
            
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

        return json_decode($result, true);
    }

    /**
     * @param $endpoint
     * @return mixed
     */
    private function post($endpoint, $content)
    {
        $post_array = [
            'app' => self::APP_ID,
            'plat' => 3,
        ];

        if (count($content) > 0) {
            $post_array = array_merge($post_array, $content);
        }

        $url = self::API_BASE . $endpoint;
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

        return json_decode($result, true);
    }

    /**
     * @param $endpoint
     * @return mixed
     */
    private function delete($endpoint)
    {
        $url = (strpos($endpoint, '?') == 0)
            ? self::API_BASE . $endpoint . '?app=' . self::APP_ID
            : self::API_BASE . $endpoint . '&app=' . self::APP_ID;
            
        $ch = curl_init();
        curl_setopt_array(
            $ch,
            [
                CURLOPT_URL => $url,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_CUSTOMREQUEST => 'DELETE',
            ]
        );
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }
}
