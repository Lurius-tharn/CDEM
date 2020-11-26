<?php $title = "cdem.fun"; ?>
<?php ob_start(); ?>

<div id="container2">
  <input type="text" name="pseudo" id="pseudo" class="element" placeholder="PSEUDO" size="255" maxlength="10" />

  <div class="blocks">
    <a class="block create element"  href=""  onclick="this.href='index.php?action=create&pseudo='+document.getElementById('pseudo').value">
      <div class="plein">
        <p>Créer</p>
      </div>
      <div class="vide"></div>
    </a>

    <a class="block join element" href=""  onclick="this.href='index.php?action=join&pseudo='+document.getElementById('pseudo').value">
      <div class="plein">
        <p>Rejoindre</p>
      </div>
      <div class="vide"></div>
    </a>
  </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>