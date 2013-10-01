<?php
    require_once("../resources/config.php");
    require_once(LIBRARIES_PATH . "/Prismic.php");

    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $slug = isset($_GET['slug']) ? $_GET['slug'] : null;
    $maybeRef = isset($_GET['ref']) ? $_GET['ref'] : null;

    if(!isset($id) || !isset($slug)) {
        header('HTTP/1.1 400 Bad Request', true, 400);
        exit('Bad Request');
    }

    try {
        $ctx = Prismic::context();
        $maybeDocument = Prismic::getDocument($id);
    } catch (prismic\ForbiddenException $e) {
        header('Location: ' . Routes::signin());
        exit('Forbidden');
    } catch (prismic\UnauthorizedException $e) {
        header('Location: ' . Routes::index());
        exit('Unauthorized');
    }  catch(prismic\NotFoundException $e) {
        exit("Not Found");
    }

    if(isset($maybeDocument)) {
        if($maybeDocument->slug() != $slug && $maybeDocument->containsSlug($slug)) {
            header('Location: ' . Routes::detail($id, $maybeDocument->slug, $maybeRef));
            exit('Moved Permanently');
        } else if($maybeDocument->slug() != $slug){
            header('HTTP/1.1 404 Not Found', true, 404);
            exit('Not Found');
        }
    }

    $title="Document detail - " . $maybeDocument->slug();

    // For ref Form in toolbar.php
    $hiddenToolbar = array(
        "id" => htmlspecialchars($id),
        "slug" => htmlspecialchars($slug)
    );
?>

<?php
    require_once(TEMPLATES_PATH . "/header.php");
?>

<article id="<?php echo $id ?>">
<?php
    global $linkResolver;
    echo $maybeDocument->asHtml($linkResolver);
?>
</article>

<?php
    require_once(TEMPLATES_PATH . "/footer.php");
?>
