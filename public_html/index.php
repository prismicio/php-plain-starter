<?php
    require_once("../resources/config.php");
    $title="All documents";
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
  No documents found
  One document found
  n documents found
</h2>

<ul>
  <li>
    <a href="">
      slug
    </a>
  </li>
</ul>

<?php
    require_once(TEMPLATES_PATH . "/footer.php");
?>
