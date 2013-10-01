<?php
    require_once("../resources/config.php");
    require_once(LIBRARIES_PATH . "/Prismic.php");

    $api = Prismic::apiHome();
    $params = array(
        "client_id" => Prismic::config('prismic.clientId'),
        "redirect_uri" => Prismic::callback(),
        "scope" => "master+releases"
    );
    $queryString = http_build_query($params);
    header('Location: ' . $api->oauthInitiateEndpoint() . '?' . $queryString, false, 301);
    exit(0);
?>