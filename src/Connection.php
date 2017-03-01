<?php

namespace pxgamer\devRant;

/**
 * Class Connection
 * @package pxgamer\devRant
 */
class Connection
{
    const API_BASE = 'https://www.devrant.io/api';

    /**
     * No idea what this should be, but it only worked with 3
     */
    const APP_ID = 3;

    public static $authUserId = 0;

    public static $tokenId = 0;

    public static $tokenKey = '';

    /**
     * @param string $endpoint
     * @return array
     */
    public static function get($endpoint)
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
     * @param string $endpoint
     * @param array $content
     * @return array
     */
    public static function post($endpoint, $content)
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
     * @param string $endpoint
     * @return array
     */
    public static function delete($endpoint)
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
