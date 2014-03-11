<?php
    require_once '../resources/config.php';
    require_once(LIBRARIES_PATH . "/Prismic.php");

    try {
        $ctx = Prismic::context();
        $documents = $ctx->getApi()->forms()->everything->ref($ctx->getRef())->submit();
    } catch (Guzzle\Http\Exception\BadResponseException $e) {
        Prismic::handlePrismicException($e);
    }

    $title="All documents";
    $documentsSize = isset($documents) ? count($documents) : 0;
?>

<?php
    require_once(TEMPLATES_PATH . "/header.php");
?>

<form action="<?php echo Routes::search($ctx->getRef()); ?>" method="POST">
  <input type="text" name="q" value="">
  <input type="submit" value="Search">
</form>

<hr>

<h2>
  <?php
     if ($documentsSize == 0) {
         echo 'No documents found';
     } elseif ($documentsSize == 1) {
         echo 'One document found';
     } else {
         echo $documentsSize . ' documents found';
     }
  ?>
</h2>

<ul>
  <?php
     foreach ($documents as $document) {
         echo '<li><a href="'. Routes::detail($document->getId(), $document->getSlug(), $ctx->getRef()) .'">' . $document->getSlug() . '</a>';
     };
  ?>
</ul>

<?php
    require_once(TEMPLATES_PATH . "/footer.php");
