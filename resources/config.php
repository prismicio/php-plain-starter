<?php

$config = array(
    "prismic" => array(
        "api" => "https://prismic.io",
        "token" => "xxx",
        "clientId" => "xxx",
        "clientSecret" => "xxx"
    )
);

defined("LIBRARIES_PATH") or define("LIBRARIES_PATH", realpath(dirname(__FILE__) . '/libraries'));

defined("VENDORS_PATH") or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/libraries/vendors'));

defined("TEMPLATES_PATH") or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));

ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRCT);

?>