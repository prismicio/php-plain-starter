<?php
    require_once("../resources/config.php");
    require_once(LIBRARIES_PATH . "/Prismic.php");

    $maybeCode = isset($_GET['code']) ? $_GET['code'] : null;
    if(!isset($maybeCode)) {
        header('HTTP/1.1 400 Bad Request', true, 400);
        exit('Bad Request');
    }

    $maybeRedirectUri = isset($_GET['redirect_uri']) ? $_GET['redirect_uri'] : null;

    $api = Prismic::apiHome();
    $data = array(
        "grant_type" => array('authorization_code'),
        "code" => $maybeCode,
        "redirect_uri" => Prismic::callback(),
        "client_id" => Prismic::config("prismic.clientId"),
        "client_secret" => Prismic::config("prismic.clientSecret")
    );

    try {
        $response = Prismic\Api::getClient()->post($api->oauthTokenEndpoint(), null, $data)->send();
        $url = isset($maybeRedirectUri) ? $maybeRedirectUri : Routes::index();
        $json = $response->json();
        setcookie('ACCESS_TOKEN', $json['access_token']);
        header('Location: ' . $url);
    } catch (Guzzle\Http\Exception\BadResponseException $e) {
        header('HTTP/1.0 401 Unauthorized');
        exit($response->getStatusCode());
    }
?>