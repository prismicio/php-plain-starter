<?php
    require_once '../resources/config.php';
    require_once(LIBRARIES_PATH . "/PrismicHelper.php");
    $title="Search results";

    try {
        $ctx = PrismicHelper::context();
        $maybeQuery = isset($_GET['q']) ? $_GET['q'] : '';
        $q = '[[:d = fulltext(document, "' . $maybeQuery . '")]]';
        $documents = $ctx->getApi()->forms()->everything->query($q)->ref($ctx->getRef())->submit();
    } catch (Guzzle\Http\Exception\BadResponseException $e) {
        PrismicHelper::handlePrismicException($e);
    }

    $documentsSize = count($documents);
?>

<h1>
  <?php
     if ($documents->getTotalResultsSize() == 0) {
         echo 'No documents found';
     } elseif ($documents->getTotalResultsSize() == 1) {
         echo 'One document found';
     } else {
         echo $documents->getTotalResultsSize() . ' documents found';
     }
  ?>
</h1>

<ul>
  <?php
     foreach ($documents->getResults() as $document) {
         echo '<li><a href="'. Routes::detail($document->getId(), $document->getSlug(), $ctx->getRef()) .'">' . $document->getSlug() . '</a>';
     };
  ?>
</ul>

<p>
  <a href="<?php echo Routes::index() ?>">Back to home</a>
</p>
