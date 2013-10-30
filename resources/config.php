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

defined("TEMPLATES_PATH") or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));

require_once(LIBRARIES_PATH . "/Prismic.php");

class Routes
{
    private static function baseUrl()
    {
        $host = $_SERVER["HTTP_HOST"];
        $protocol = "http";
        if (isset($_SERVER['HTTPS'])) {
            $protocol = $protocol . 's';
        }
        $protocol = $protocol . '://';

        return $protocol . $host;
    }

    public static function index($maybeRef=null)
    {
        $parameters = array();
        if (isset($maybeRef)) {
            $parameters['ref'] = $maybeRef;
        }
        $queryString = http_build_query($parameters);

        return Routes::baseUrl() . '/index.php?' . $queryString;
    }

    public static function detail($id, $slug, $maybeRef=null)
    {
        $parameters = array(
            "id" => $id,
            "slug" => $slug
        );
        if (isset($maybeRef)) {
            $parameters['ref'] = $maybeRef;
        }
        $queryString = http_build_query($parameters);

        return Routes::baseUrl() . '/detail.php?' . $queryString;
    }

    public static function search($maybeRef=null)
    {
        $parameters = array();
        if (isset($maybeRef)) {
            $parameters['ref'] = $maybeRef;
        }
        $queryString = http_build_query($parameters);

        return Routes::baseUrl() . '/search.php?' . $queryString;
    }

    public static function signin()
    {
        return Routes::baseUrl() . '/signin.php';
    }

    public static function authCallback($maybeCode=null, $maybeRedirectUri=null)
    {
        $parameters = array();
        if (isset($maybeCode)) {
            $parameters['code'] = $maybeCode;
        }
        if (isset($maybeRedirectUri)) {
            $parameters['redirect_uri'] = $maybeRedirectUri;
        }
        $queryString = http_build_query($parameters);

        return Routes::baseUrl() . '/oauthCallback.php?' .$queryString;
    }

    public static function signout()
    {
        return Routes::baseUrl() . '/signout.php';
    }
}

class LinkResolver extends \Prismic\LinkResolver {
    public function resolve($link) {
        return Routes::detail($link->getId(), $link->getSlug(), Prismic::context()->getRef());
    }
};
$linkResolver = new LinkResolver();

ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRICT);
