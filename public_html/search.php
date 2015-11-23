<?php

require_once '../resources/config.php';
include_once(__DIR__.'/../vendor/autoload.php');

use Prismic\Api;

$title="Search results";

try {
    $api = Api::get($PRISMIC_URL);
    $maybeQuery = isset($_GET['q']) ? $_GET['q'] : '';
    $q = '[[:d = fulltext(document, "' . $maybeQuery . '")]]';
    $documents = $api->query($q);
} catch (Guzzle\Http\Exception\BadResponseException $e) {
    handlePrismicException($e);
}

$size = count($documents->getTotalResultsSize());

?>

<h1>
  <?php
     if ($size == 0) {
         echo 'No documents found';
     } elseif ($size == 1) {
         echo 'One document found';
     } else {
         echo $size . ' documents found';
     }
  ?>
</h1>

<ul>
  <?php
     foreach ($documents->getResults() as $document) {
         echo '<li><a href="'. Routes::detail($document->getId(), $document->getSlug()) .'">' . $document->getSlug() . '</a>';
     };
  ?>
</ul>

<p>
  <a href="<?php echo Routes::index() ?>">Back to home</a>
</p>
