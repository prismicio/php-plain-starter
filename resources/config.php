<?php

$CONFIG = array(
    "prismic" => array(
        "api" => "https://lesbonneschoses-ui2p4lgij04c2yle.prismic.io/api",
        "token" => "MC5Va1A0bWN1dnphQUNOQzZt.J--_ve-_vUxrJ--_ve-_vQBR77-9Me-_ve-_ve-_vTbvv73vv70seO-_vVYo77-9CmXvv73vv71677-9XO-_vQ",
        "clientId" => "UkP4mcuvzaACNC6l",
        "clientSecret" => "034d312c82301b153c3f16347e5cf1ae",
        "callback" => "/auth_callback"
    )
);

class Routes {

    public static function detail($id, $slug, $maybeRef) {
        $host = $_SERVER["HTTP_HOST"];
        $protocol = "http";
        if(isset($_SERVER['HTTPS'])) {
            $protocol = $protocol . 'S';
        }
        $protocol = $protocol . '://';
        $parameters = array(
            "id" => $id,
            "slug" => $slug
        );
        if(isset($maybeRef)) {
            $parameters['ref'] = $maybeRef;
        }
        $queryString = http_build_query($parameters);
        return $protocol . $host . '/documents/' . $queryString;
    }

    public static function search($maybeRef) {
    }

    public static function index($maybeRef) {
    }
}

defined("LIBRARIES_PATH") or define("LIBRARIES_PATH", realpath(dirname(__FILE__) . '/libraries'));

defined("VENDORS_PATH") or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/libraries/vendors'));

defined("TEMPLATES_PATH") or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));

ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRCT);

?>