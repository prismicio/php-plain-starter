<?php

require_once '../resources/config.php';
include_once(__DIR__.'/../vendor/autoload.php');

use Prismic\Api;

global $linkResolver;

try {
    $token = isset($_GET['token']) ? $_GET['token'] : null;
    $api = Api::get($PRISMIC_URL, $PRISMIC_TOKEN);
    $url = $api->previewSession($token, $linkResolver, '/');
    setcookie(Prismic\PREVIEW_COOKIE, $token, time() + 1800, '/', null, false, false);
    header('Location: ' . $url);
} catch (Guzzle\Http\Exception\BadResponseException $e) {
    handlePrismicHelperException($e);
}

