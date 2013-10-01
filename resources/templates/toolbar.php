<?php
    $hasPrivilegedAccess = $ctx->hasPrivilegedAccess();
    if($hasPrivilegedAccess) {
?>
<div id="toolbar">
  <form method="GET">
    <label for="releaseSelector">See this website: </label>
    <select id="releaseSelector" name="ref" onchange="this.form.submit()">
       <?php
          $values = array_values($ctx->api->refs());
          $refs = array_map(function($value) { return $value->ref; }, $values);
          if(!in_array($ctx->ref, $refs)) {
              echo '<option>?</option>';
          }
       ?>
       <option value=""<?php echo ($ctx->ref == $ctx->api->master()->ref) ? 'selected="selected"' : '' ?>>As currently seen by guest visitors</option>
       <optgroup label="Or preview the website in a future release:">
       <?php
         $allButMaster = array_filter($values, function($value) { return !$value->isMasterRef; });
         foreach($allButMaster as $ref) {
             echo '<option value="' . $ref->ref . '" '. (($ctx->ref == $ref->ref) ? "selected=\"selected\"" : "") . '>As '. $ref->label . ' ' . $ref->scheduledAt . '</option>';
         }
       ?>
      </optgroup>
    </select>
    <?php
         if(isset($hiddenToolbar)) {
             foreach($hiddenToolbar as $name => $value) {
                 echo '<input type="hidden" name="' .$name. '" value="'.$value.'" />';
             }
         }
     ?>
  </form>

  <form action="<?php echo Routes::signout() ?>" method="POST">
    <input type="submit" value="Disconnect">
  </form>
</div>
<?php } ?>
