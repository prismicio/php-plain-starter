    <footer>
      <hr/>
      <?php
          if (!$ctx->hasPrivilegedAccess()) {
             echo '<a href="'. Routes::signin() . '">Sign in to preview changes</a>';
          }
      ?>
    </footer>
  </body>
</html>
