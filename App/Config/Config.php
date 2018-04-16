<?php
namespace App\Config;

class Config
{
    private static $base_api = "http://localhost:3000/";
    private static $client_secret = "Alderan";
    private static $client_id = "R2D2";
    private static $certificate = "App/Resources/CAcerts/SelfSigned.crt";
    public static $debug = false;

    const DELETE_REACTOR_EXHAUST_ENDPOINT = "reactor/exhaust";
    const GET_PRISONER_ENDPOINT = "prisoner";
    const TOKEN_ENDPOINT = "token";

    /**
     * @return string
     */
    public static function getBaseApi()
    {
        return self::$base_api;
    }

    public static function getCertificate()
    {
        return getcwd() . self::$certificate;
    }

    /**
     * @return string
     */
    public static function getClientSecret()
    {
        return self::$client_secret;
    }

    /**
     * @return string
     */
    public static function getClientId()
    {
        return self::$client_id;
    }
}
