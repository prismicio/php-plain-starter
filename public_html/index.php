<?php

require_once '../resources/config.php';
include_once(__DIR__.'/../vendor/autoload.php');

use Prismic\Api;

try {
    $api = Api::get($PRISMIC_URL, $PRISMIC_TOKEN);
    $documents = $api->query(null);
} catch (Guzzle\Http\Exception\BadResponseException $e) {
    handlePrismicHelperException($e);
}

$title="All documents";
?>

<?php
    require_once(TEMPLATES_PATH . "/header.php");
?>

<form action="<?php echo Routes::search(); ?>" method="GET">
  <input type="text" name="q" value="">
  <input type="submit" value="Search">
</form>

<hr>

<h2>
  <?php
     if ($documents->getTotalResultsSize() == 0) {
         echo 'No documents found';
     } elseif ($documents->getTotalResultsSize() == 1) {
         echo 'One document found';
     } else {
         echo $documents->getTotalResultsSize() . ' documents found';
     }
  ?>
</h2>

<ul>
  <?php
     foreach ($documents->getResults() as $document) {
         echo '<li><a href="'. Routes::detail($document->getId(), $document->getSlug()) .'">' . $document->getSlug() . '</a>';
     };
  ?>
</ul>

<?php
    require_once(TEMPLATES_PATH . "/footer.php");
