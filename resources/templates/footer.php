      <footer>
        <hr/>
        <?php
            $hasPrivilegedAccess = $ctx->hasPrivilegedAccess();
            if (!$hasPrivilegedAccess) {
               echo '<a href="'. Routes::signin() . '">Sign in to preview changes</a>';
            }
        ?>
      </footer>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
