<?php
    require_once("../resources/config.php");
    require_once(LIBRARIES_PATH . "/Prismic.php");
    $title="Search results";

    try {
        $ctx = Prismic::context();
        $maybeQuery = isset($_POST['q']) ? $_POST['q'] : '';
        $q = '[[:d = fulltext(document, "' . $maybeQuery . '")]]';
        $documents = $ctx->getApi()->forms()->everything->query($q)->ref($ctx->getRef())->submit();
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
         echo '<li><a href="'. Routes::detail($document->getId(), $document->slug(), $ctx->getRef()) .'">' . $document->slug() . '</a>';
     };
  ?>
</ul>

<p>
  <a href="<?php echo Routes::index($ctx->ref) ?>">Back to home</a>
</p>
