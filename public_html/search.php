<?php
    require_once '../resources/config.php';
    require_once(LIBRARIES_PATH . "/Prismic.php");
    $title="Search results";

    try {
        $ctx = Prismic::context();
        $maybeQuery = isset($_GET['q']) ? $_GET['q'] : '';
        $q = '[[:d = fulltext(document, "' . $maybeQuery . '")]]';
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $documents = $ctx->getApi()->forms()->everything->query($q)->page($page)->ref($ctx->getRef())->submit();
    } catch (Guzzle\Http\Exception\BadResponseException $e) {
        Prismic::handlePrismicException($e);
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

<?php
    $urlWithoutPagination = Routes::search($maybeQuery);
    require_once(TEMPLATES_PATH . "/pagination.php");
    require_once(TEMPLATES_PATH . "/footer.php");