<?php $title = "Rejoindre" ?>
<?php ob_start(); ?>

<div id = "partyBlock" >
  <div class="title">
    <h1>Rejoindre une partie</h1>
  </div>

  <div class="choice">
    <button class="buttonChoice" type="button" name="Privé">
      <p>Privé</p>
    </button>
    <button class="buttonChoice hidden" type="button" name="Public">
      <p>Public</p>
    </button>
  </div>

  <div class="code">
    <div class="codeText">
      <p>code</p>
    </div>
    <div class="codeInput">
      <input type="text" placeholder="HXFEAS">
    </div>
  </div>

</div>
<div class="control">
  <button type="button" name="button">
    <p>Retour</p>
  </button>
  <button type="button" name="button">
    <p>Rejoindre</p>
  </button>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>
