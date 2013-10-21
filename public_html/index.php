<?php
    require_once("../resources/config.php");
    require_once(LIBRARIES_PATH . "/Prismic.php");

    try {
        $ctx = Prismic::context();
        $documents = $ctx->getApi()->forms()->everything->ref($ctx->getRef())->submit();
    } catch (Guzzle\Http\Exception\BadResponseException $e) {
        $response = $e->getResponse();
        if($response->getStatusCode() == 403) {
            header('Location: ' . Routes::signin());
            exit('Forbidden');
        }
        else if($response->getStatusCode() == 401) {
            setcookie('ACCESS_TOKEN', "", time() - 1);
            header('Location: ' . Routes::index());
            exit('Unauthorized');
        }
        else if($response->getStatusCode() == 404) {
            exit("Not Found");
        }
    }

    $title="All documents";
    $documentsSize = count($documents);
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
         echo '<li><a href="'. Routes::detail($document->getId(), $document->slug(), $ctx->getRef()) .'">' . $document->slug() . '</a>';
     };
  ?>
</ul>

<?php
    require_once(TEMPLATES_PATH . "/footer.php");
?>
