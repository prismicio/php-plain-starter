<?php
    require_once '../resources/config.php';
    require_once(LIBRARIES_PATH . "/Prismic.php");

    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    try {
        $ctx = Prismic::context();
        $documents = $ctx->getApi()->forms()->everything->page($page)->ref($ctx->getRef())->submit();
    } catch (Guzzle\Http\Exception\BadResponseException $e) {
        Prismic::handlePrismicException($e);
    }

    $title="All documents";
?>

<?php
    require_once(TEMPLATES_PATH . "/header.php");
?>

<form action="<?php echo Routes::search($ctx->getRef()); ?>" method="get">
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
         echo '<li><a href="'. Routes::detail($document->getId(), $document->getSlug(), $ctx->getRef()) .'">' . $document->getSlug() . '</a>';
     };
  ?>
</ul>

<?php
    $urlWithoutPagination = Routes::index();
    require_once(TEMPLATES_PATH . "/pagination.php");
    require_once(TEMPLATES_PATH . "/footer.php");
