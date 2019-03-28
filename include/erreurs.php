<?php
/**
* Vue permettant d'afficher
* les erreurs de saisies 
**/
?>
<div class="erreur bold">
  <ul>
    <?php
      foreach ($_REQUEST['erreurs'] as $error) {
        echo "<li>$error</li>";
      }
     ?>
  </ul>
</div>
