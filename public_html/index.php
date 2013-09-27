<?php
    require_once("../resources/config.php");
    require_once(LIBRARIES_PATH . "/Prismic.php");
    $title="All documents"
?>

<?php
    $ctx = Prismic::context();
    $documents = $ctx->api->forms()->everything->ref($ctx->ref)->submit();
    $documentsSize = count($documents);
?>

<?php
    require_once(TEMPLATES_PATH . "/header.php");
?>

<form action="#" method="GET">
  <input type="text" name="q" value="">
  <input type="submit" value="Search">
</form>

<hr>

<h2>
  <?php
     if($documentsSize == 0) {
         echo 'No documents found';
     } else if($documentsSize == 1) {
         echo 'One document found';
     } else {
         echo $documentsSize . ' documents found';
     }
  ?>
</h2>

<ul>
  <?php
     foreach($documents as $document) {
         echo '<li><a href="'. Routes::detail($document->id, $document->slug(), $ctx->maybeRef()) .'">' . $document->slug() . '</a>';
     };
  ?>
</ul>

<?php
    require_once(TEMPLATES_PATH . "/footer.php");
?>
