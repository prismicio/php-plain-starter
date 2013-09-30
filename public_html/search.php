<?php
    require_once("../resources/config.php");
    require_once(LIBRARIES_PATH . "/Prismic.php");
    $title="Search results"
?>

<?php
    $ctx = Prismic::context();
    $maybeQuery = isset($_POST['q']) ? $_POST['q'] : '';
    $q = '[[:d = fulltext(document, "' . $maybeQuery . '")]]';
    $documents = $ctx->api->forms()->everything->query($q)->ref($ctx->ref)->submit();
    $documentsSize = count($documents);
?>

<h1>
  <?php
     if($documentsSize == 0) {
         echo 'No documents found';
     } else if($documentsSize == 1) {
         echo 'One document found';
     } else {
         echo $documentsSize . ' documents found';
     }
  ?>
</h1>

<ul>
  <?php
     foreach($documents as $document) {
         echo '<li><a href="'. Routes::detail($document->id, $document->slug(), $ctx->maybeRef()) .'">' . $document->slug() . '</a>';
     };
  ?>
</ul>