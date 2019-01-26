<div>
  <ul>
    <?php
      foreach ($_REQUEST['erreurs'] as $error) {
        echo "<li>$error</li>";
      }
     ?>
  </ul>
</div>
