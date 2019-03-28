<?php
/**
* Vue permettant d'afficher
* les messages d'info
**/
?>
<div class="succes bold">
  <ul>
    <?php
      foreach ($_REQUEST['messages'] as $msg) {
        echo "<li>$msg</li>";
      }
     ?>
  </ul>
</div>
