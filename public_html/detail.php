<?php

require_once '../resources/config.php';
include_once(__DIR__.'/../vendor/autoload.php');

use Prismic\Api;

$id = isset($_GET['id']) ? $_GET['id'] : null;
$slug = isset($_GET['slug']) ? $_GET['slug'] : null;

if (!isset($id) || !isset($slug)) {
    header('HTTP/1.1 400 Bad Request', true, 400);
    exit('Bad Request');
}

$maybeDocument = null;
try {
    $api = Api::get($PRISMIC_URL, $PRISMIC_TOKEN);
    $maybeDocument = $api->getByID($id);
} catch (Guzzle\Http\Exception\BadResponseException $e) {
    handlePrismicHelperException($e);
}

if (isset($maybeDocument)) {
    if ($maybeDocument->getSlug() != $slug && $maybeDocument->containsSlug($slug)) {
        header('Location: ' . Routes::detail($id, $maybeDocument->slug));
        exit('Moved Permanently');
    } elseif ($maybeDocument->getSlug() != $slug) {
        header('HTTP/1.1 404 Not Found', true, 404);
        exit('Not Found');
    }
} else {
    header('HTTP/1.1 404 Not Found', true, 404);
    exit('Not Found');
}

$title="Document detail - " . $slug;

// For ref Form in toolbar.php
$hiddenToolbar = array(
    "id" => htmlspecialchars($id),
    "slug" => htmlspecialchars($slug)
);

?>

<? require_once(TEMPLATES_PATH . "/header.php"); ?>

<article id="<?= $id ?>" data-wio-id="<?= $id ?>">
<?php
    global $linkResolver;
    if (isset($maybeDocument)) {
        echo $maybeDocument->asHtml($linkResolver);
    }
?>
</article>

<? require_once(TEMPLATES_PATH . "/footer.php"); ?>

