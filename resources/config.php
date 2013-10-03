<?php

$CONFIG = array(
    "prismic" => array(
        "api" => "https://lesbonneschoses.prismic.io/api",
        "token" => null,
        "clientId" => null,
        "clientSecret" => null,
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

    public static function index($maybeRef=null) {
        $parameters = array();
        if(isset($maybeRef)) {
            $parameters['ref'] = $maybeRef;
        }
        $queryString = http_build_query($parameters);
        return Routes::baseUrl() . '/index.php?' . $queryString;
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
        $parameters = array();
        if(isset($maybeRef)) {
            $parameters['ref'] = $maybeRef;
        }
        $queryString = http_build_query($parameters);
        return Routes::baseUrl() . '/search.php?' . $queryString;
    }

    public static function signin() {
        return Routes::baseUrl() . '/signin.php';
    }

    public static function authCallback($maybeCode=null, $maybeRedirectUri=null) {
        $parameters = array();
        if(isset($maybeCode)) {
            $parameters['code'] = $maybeCode;
        }
        if(isset($maybeRedirectUri)) {
            $parameters['redirect_uri'] = $maybeRedirectUri;
        }
        $queryString = http_build_query($parameters);
        return Routes::baseUrl() . '/oauthCallback.php?' .$queryString;
    }

    public static function signout() {
        return Routes::baseUrl() . '/signout.php';
    }
}

$linkResolver = function($link) {
    return Routes::detail($link->id, $link->slug, Prismic::context()->ref);
};

ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRICT);

?>
