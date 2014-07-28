<?php
    $hasPrivilegedAccess = isset($ctx) ? $ctx->hasPrivilegedAccess() : false;
    if ($hasPrivilegedAccess) {
?>
<div id="toolbar">
  <form method="GET">
    <label for="releaseSelector">See this website: </label>
    <select id="releaseSelector" name="ref" onchange="this.form.submit()">
       <?php
          $values = array_values($ctx->getApi()->refs());
          $refs = array_map(function ($value) { return $value->getRef(); }, $values);
          if (!in_array($ctx->getRef(), $refs)) {
              echo '<option>?</option>';
          }
       ?>
       <option value="<?php echo $ctx->getApi()->master()->getRef()?>" <?php echo ($ctx->getRef() == $ctx->getApi()->master()->getRef()) ? 'selected="selected"' : '' ?>>
           As currently seen by guest visitors
       </option>
       <optgroup label="Or preview the website in a future release:">
       <?php
         $allButMaster = array_filter($values, function ($value) { return !$value->isMasterRef(); });
         foreach ($allButMaster as $ref) {
             echo '<option value="' . $ref->getRef() . '" '. (($ctx->getRef() == $ref->getRef()) ? "selected=\"selected\"" : "") . '>As '. $ref->getLabel() . ' ' . $ref->getScheduledAt() . '</option>';
         }
       ?>
      </optgroup>
    </select>
    <?php
         if (isset($hiddenToolbar)) {
             foreach ($hiddenToolbar as $name => $value) {
                 echo '<input type="hidden" name="' .$name. '" value="'.$value.'" />';
             }
         }
     ?>
  </form>

  <?php if ($ctx->hasPrivilegedAccess()) { ?>
  <form action="<?php echo Routes::signout() ?>" method="POST">
    <input type="submit" value="Disconnect">
  </form>
  <?php } ?>
</div>
<?php }
