<?php

include_once(__DIR__.'/../vendor/autoload.php');

$PRISMIC_URL = "https://lesbonneschoses-vcerzcwaaohojzo.prismic.io/api";
$PRISMIC_TOKEN = null;

defined("LIBRARIES_PATH") or define("LIBRARIES_PATH", realpath(dirname(__FILE__) . '/libraries'));
defined("TEMPLATES_PATH") or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));

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

    public static function index()
    {
        $parameters = array();
        $queryString = http_build_query($parameters);

        return Routes::baseUrl() . '/index.php?' . $queryString;
    }

    public static function detail($id, $slug)
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

    public static function search()
    {
        $parameters = array();
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
        return Routes::detail($link->getId(), $link->getSlug());
    }
};
$linkResolver = new LinkResolver();

function handlePrismicException($e)
{
    $response = $e->getResponse();
    if ($response->getStatusCode() == 403) {
        exit('Forbidden');
    } elseif ($response->getStatusCode() == 404) {
        header("HTTP/1.0 404 Not Found");
        exit("Not Found");
    } else {
        setcookie(Prismic\PREVIEW_COOKIE, "", time() - 1);
        header('Location: ' . '/');
    }
}


