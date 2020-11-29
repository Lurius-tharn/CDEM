<?php $title = "Cdem.fun" ?>
<?php ob_start(); ?>

<div id="container2">
  <input type="text" name="pseudo" id="pseudo" class="element" placeholder="PSEUDO" size="255" maxlength="15" onchange="createCookie('username', value,365)" />

  <div class="blocks">
    <a class="block create element" href="index.php?action=create">
      <div class="plein">
        <p>Créer</p>
      </div>
      <div class="vide"></div>
    </a>

    <a class="block join element" href="index.php?action=join">
      <div class="plein">
        <p>Rejoindre</p>
      </div>
      <div class="vide"></div>
    </a>
  </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php $js = "<script src=\"public/js/script.js\"></script>" ?>
<?php require('template.php'); ?>

<script type="text/javascript">
  document.getElementById('pseudo').value = readCookie('username');
</script>