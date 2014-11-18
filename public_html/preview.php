<?php
    require_once '../resources/config.php';
    require_once '../vendor/autoload.php';
    require_once(LIBRARIES_PATH . "/PrismicHelper.php");

    global $linkResolver;
    $token = isset($_GET['token']) ? $_GET['token'] : null;

    if (!isset($token)) {
        header('HTTP/1.1 400 Bad Request', true, 400);
        exit('Bad Request');
    }

    try {
        $ctx = PrismicHelper::context();
        $url = $ctx->getApi()->previewSession($token, $linkResolver, '/');
        setcookie(Prismic\PREVIEW_COOKIE, $token, time() + 1800, '/', null, false, false);
        header('Location: ' . $url);
    } catch (Guzzle\Http\Exception\BadResponseException $e) {
        PrismicHelper::handlePrismicException($e);
    }

