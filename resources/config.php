<?php

$CONFIG = array(
    "prismic" => array(
        "api" => "http://lesbonneschoses.wroom.dev/api",
        "token" => "MC5Va1A0bWN1dnphQUNOQzZt.J--_ve-_vUxrJ--_ve-_vQBR77-9Me-_ve-_ve-_vTbvv73vv70seO-_vVYo77-9CmXvv73vv71677-9XO-_vQ",
        "clientId" => "UkP4mcuvzaACNC6l",
        "clientSecret" => "034d312c82301b153c3f16347e5cf1ae",
        "callback" => "/auth_callback"
    )
);

defined("LIBRARIES_PATH") or define("LIBRARIES_PATH", realpath(dirname(__FILE__) . '/libraries'));

defined("VENDORS_PATH") or define("VENDORS_PATH", realpath(dirname(__FILE__) . '/libraries/vendors'));

defined("TEMPLATES_PATH") or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));

require_once(LIBRARIES_PATH . "/Prismic.php");

class Routes {

    private static function baseUrl() {
        $host = $_SERVER["HTTP_HOST"];
        $protocol = "http";
        if(isset($_SERVER['HTTPS'])) {
            $protocol = $protocol . 'S';
        }
        $protocol = $protocol . '://';
        return $protocol . $host;
    }

    public static function detail($id, $slug, $maybeRef=null) {
        $parameters = array(
            "id" => $id,
            "slug" => $slug
        );
        if(isset($maybeRef)) {
            $parameters['ref'] = $maybeRef;
        }
        $queryString = http_build_query($parameters);
        return Routes::baseUrl() . '/detail.php?' . $queryString;
    }

    public static function search($maybeRef=null) {
        if(isset($maybeRef)) {
            $parameters['ref'] = $maybeRef;
        }
        return Routes::baseUrl() . '/search.php';
    }
}

$linkResolver = function($link) {
    return Routes::detail($link->id, $link->slug, Prismic::context()->ref);
};

ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRCT);

?>