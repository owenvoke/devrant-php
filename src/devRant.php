<?php

namespace pxgamer {

    /**
     * Class devRant
     * @package pxgamer
     */
    class devRant
    {
        public static $api_base = 'https://www.devrant.io/api';

        public static $endpoints = [
            'getRants' => '/devrant/rants',
            'getRantById' => '/devrant/rants/',
            'getUserById' => '/users/',
            'searchRants' => '/devrant/search',
            'getUsersId' => '/get-user-id',
			'getSignIn' => '/users/auth-token',
			'postNewRant' => '/devrant/rants'
        ];

        public static $app_id = 3; // No idea what this should be, but it only worked with 3

        /**
         * devRant constructor.
         */
        public function __construct()
        {
        }

        /**
         * @return string
         */
        public static function getRants()
        {
            return self::get(self::$endpoints['getRants']);
        }

        /**
         * @param $id
         * @return bool|string
         */
        public static function getRantById($id)
        {
            return (isset($id) && is_numeric($id)) ? self::get(self::$endpoints['getRantById'] . $id) : false;
        }

        /**
         * @param $id
         * @return bool|string
         */
        public static function getUserById($id)
        {
            return (isset($id) && is_numeric($id)) ? self::get(self::$endpoints['getUserById'] . $id) : false;
        }

        /**
         * @param $query
         * @return string
         */
        public static function searchRants($query)
        {
            return self::get(self::$endpoints['searchRants'] . '?term=' . urlencode($query));
        }

        /**
         * @param $username
         * @return bool|string
         */
        public static function getUsersId($username)
        {
            return (isset($username) && $username !== '') ? self::get(self::$endpoints['getUsersId'] . '?username=' . urlencode($username)) : false;
        }

        /**
         * @param $username
         * @param $password
         * @return bool|string
         */
        public static function postSignIn($username, $password)
        {
            return (isset($username) && $username !== '') ? self::post(self::$endpoints['getSignIn'], ['username' => $username, 'password' => $password]) : false;
        }

        /**
         * @param $rant_content
         * @param $user_id
         * @param $token_id
         * @param $token_key
         * @param $tags
         * @return bool|string
         */
        public static function postNewRant($rant_content, $user_id, $token_id, $token_key, $tags = '')
        {
            return (isset($rant_content) && $rant_content !== '') ? self::post(self::$endpoints['postNewRant'], ['rant' => $rant_content, 'user_id' => $user_id, 'token_id' => $token_id, 'token_key' => $token_key, 'tags' => $tags]) : false;
        }

        /**
         * @param $endpoint
         * @return mixed
         */
        private static function get($endpoint)
        {
            $url = (strpos($endpoint, '?') == 0) ? self::$api_base . $endpoint . '?app=' . self::$app_id : self::$api_base . $endpoint . '&app=' . self::$app_id;
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

            return $result;
        }

        /**
         * @param $endpoint
         * @return mixed
         */
        private static function post($endpoint, $content)
        {
			$post_array = [
				'app' => self::$app_id,
				'plat' => 3
			];
			
			if (count($content) > 0) $post_array = array_merge($post_array, $content);
			
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
					CURLOPT_POSTFIELDS => http_build_query($post_array)
                ]
            );
            $result = curl_exec($ch);
            curl_close($ch);

            return $result;
        }
    }

}
