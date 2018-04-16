<?php

namespace App\Lib;

use App\Config\Config as Config;
use App\Config\MessageBundle as MessageBundle;
use \DateTime as DateTime;

/**
 * Class ApiConnectClass PHP Class
 * author: tobi.o.ogunleye@gmail.com
 */
class ApiConnectClass
{
    private static $main_url = null;
    private static $client_id = null;
    private static $client_secret = null;
    private static $api_key = '';
    private static $api_secret = '';
    private static $access_token = null;
    private static $certificate = null;

    private static $delete_exhaust_endpoint = Config::DELETE_REACTOR_EXHAUST_ENDPOINT;
    private static $token_endpoint = Config::TOKEN_ENDPOINT;
    private static $get_prisoner_endpoint = Config::GET_PRISONER_ENDPOINT;
    private static $debug = false;

    /**
     * ApiConnectClass constructor.
     * to set the config up
     */
    public function __construct()
    {
        self::$main_url =  Config::getBaseApi();
        self::$client_id =  Config::getClientId();
        self::$client_secret = Config::getClientSecret();
        self::$certificate = Config::getCertificate();
        self::$debug = Config::$debug;

        $this->getToken();
    }

    /**
     * method returns token to be used in other request
     */
    private function getToken()
    {
        $path = self::$token_endpoint;
        $output = null;
        $method    = 'GET';

        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode(self::$client_id . ':' . self::$client_secret)
        );
        $data      = array(
            'grant_type' => 'client_credentials'
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::$main_url . $path);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_CAINFO, self::$certificate);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt_array($ch, array(
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_POSTFIELDS     => http_build_query($data),
        ));

        $output = curl_exec($ch);
        curl_close($ch);

        $result    = json_decode($output, true);
        self::$access_token = $result['access_token'];

        if(self::$debug)
        {
            echo "access token :: ". self::$access_token."\n";
            echo "path :: ". $path."\n";

        }
    }


    /**
     * method returns information on prisoner
     * @param int $id
     * @return bool|null|string
     */
    public function deleteExhaust($id)
    {
        if(is_numeric($id)){

            $path = self::$delete_exhaust_endpoint . '/' . $id;
            $method = 'DELETE';
            $output = null;

            //Header request options
            $headers = array(
                'Authorization: Bearer ' . self::$access_token,
                'Content-Type: application/json',
                'x-torpedoes: 2'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, self::$main_url . $path);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_CAINFO, self::$certificate);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

            curl_setopt_array($ch, array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER     => $headers,
            ));

            $output = curl_exec($ch); // This is API Response
            curl_close($ch);

            return true;

        } else {
            return json_encode(["error" => MessageBundle::INVALID_INPUT]);
        }


        return false;
    }

    /**
     * method returns information on prisoner
     * @param $name
     * @return null
     */
    public function getPrisoner($name)
    {
        $output = null;
        $path      = self::$get_prisoner_endpoint.'/'.$name;
        $method    = 'GET';

        $headers   = array(
            'Authorization: Bearer ' . self::$access_token,
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$main_url . $path);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_CAINFO, self::$certificate);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);


        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $headers,
        ));

        $output    = curl_exec($ch); // This is API Response
        curl_close($ch);

        if(self::$debug)
        {
            echo "access token :: ". self::$access_token."\n";
            echo "path :: ". $path."\n";

        }
        return $output;
    }
}
