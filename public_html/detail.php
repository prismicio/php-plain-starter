<?php
    require_once("../resources/config.php");
    require_once(LIBRARIES_PATH . "/Prismic.php");
?>

<?php
    $id = isset($_GET['id']) ? $_GET['id'] : NULL;
    $slug = isset($_GET['slug']) ? $_GET['slug'] : NULL;
    $maybeRef = isset($_GET['ref']) ? $_GET['ref'] : NULL;

    if(!isset($id) || !isset($slug)) {
        //BADREQUEST
    }

    $maybeDocument = Prismic::getDocument($id);
    if(isset($maybeDocument)) {
        if($maybeDocument->slug() != $slug && $maybeDocument->containsSlug($slug)) {
            //REDIRECTION
        } else {
            //NOTFOUND
        }
    }

    $title="Document detail - " . $maybeDocument->slug();
?>

<?php
    require_once(TEMPLATES_PATH . "/header.php");
?>

<article id="@document.id">
<?php /* echo $maybeDocument.asHtml(); */ ?>
</article>

<?php
    require_once(TEMPLATES_PATH . "/footer.php");
?>
