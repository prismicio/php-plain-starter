<?php

require_once("../resources/config.php");
require_once("../resources/libraries/vendors/prismicio.php");

use prismic\API as API;

class Context {

    private $api;
    private $ref;
    private $maybeAccessToken;

    function __construct($api, $ref, $maybeAccessToken) {
        $this->api = $api;
        $this->ref = $ref;
        $this->maybeAccessToken = $maybeAccessToken;
    }

    function maybeRef() {
        if($this->ref != $this->api->master()->ref) {
            return $this->ref;
        } else {
            return null;
        }
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
}

class Prismic {

    private static function array_get($path, $array) {
        if(empty($path)) {
            return $array;
        } else if(empty($array)){
            return null;
        } else {
            $key = array_shift($path);
            if(!isset($array[$key])) {
                return null;
            }
            return self::array_get($path, $array[$key]);
        }
    }

    public static function config($key) {
        $path = explode('.', $key);
        global $CONFIG;
        $value = self::array_get($path, $CONFIG);
        if(isset($value)) {
            return $value;
        } else {
            throw new Exception("Missing configuration [" . $key . "]");
        }
    }

    public static function context() {
        $maybeAccessToken = isset($_GET["ref"]) ? $_GET["ACCESS_TOKEN"] : self::config('prismic.token');
        $api = self::apiHome($maybeAccessToken);
        $ref = isset($_GET["ref"]) ? $_GET["ref"] : $api->master()->ref;
        return new Context($api, $ref, $maybeAccessToken);
    }

    public static function apiHome($maybeAccessToken) {
        return API::get(self::config('prismic.api'));
    }

    public static function getDocument($id) {
        $ctx = self::context();
        $documents = $ctx->api->forms()->everything->query('[[:d = at(document.id, "'. $id .'")]]')->ref($ctx->ref)->submit();
        return $documents[0];
    }
}

?>