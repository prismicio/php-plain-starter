<?php
  $urlWithoutPagination = rtrim($urlWithoutPagination, '?');
  $urlHasParameters = parse_url($urlWithoutPagination, PHP_URL_QUERY);
  if($urlHasParameters)
  {
    $urlWithoutPagination .= '&page=';
  }
  else
  {
    $urlWithoutPagination .= '?page=';
  }
?>

<?php if($documents->getTotalPages()>1) { ?>

  <hr>

  <ul>

    <?php if($documents->getPrevPage()) { ?>
      <li>
        <a href="<?php echo $urlWithoutPagination . ($documents->getPage() - 1) ?>">
          Previous
        </a>
      </li>
    <?php } ?>

    <?php for($i = 1; $i <= $documents->getTotalPages(); $i++) { ?>
      <li>
        <?php
          if($documents->getPage() == $i) echo $i;
          else {
        ?>
          <a href="<?php echo $urlWithoutPagination . $i ?>"><?php echo $i ?></a>
        <?php } ?>
      </li>
    <?php } ?>

    <?php if($documents->getNextPage()) { ?>
      <li>
        <a href="<?php echo $urlWithoutPagination . ($documents->getPage() + 1) ?>">
          Next
        </a>
      </li>
    <?php } ?>

  </ul>
<?php } ?>