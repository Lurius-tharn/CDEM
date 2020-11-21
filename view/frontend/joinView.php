<?php $title = "Rejoindre" ?>
<?php ob_start(); ?>

<div class="joinPage">
  <div id="partyBlock">

    <h1>Rejoindre une partie</h1>

    <div class="choices">
      <div class="choice">
        <button class="buttonChoice" type="button" id="Privé" onclick="buttonChange('private')">
          <p>Privé</p>
        </button>
        <button class="buttonChoice " type="button" id="Public" onclick="buttonChange('public')">
          <p>Public</p>
        </button>
      </div>

      <div id="private" class="choice">
        <div class="code choice">
          <p>Code</p>
          <div class="inputBlock">
            <input type="text" name="code" id="codeJoin" size="6" placeholder="HXFEAS" maxlength="6" />
          </div>
        </div>
      </div>

      <div id="public" class="hidden choice">
        <div class="code">
        </div>
        <div class="random">
          <a>Vous allez rejoindre une partie aléatoire</a>
        </div>
      </div>
    </div>

  </div>

  <div class="buttons">
    <button class="button" type="button" name="button" onclick="window.location.href='index.php';">
      <p>Retour</p>
    </button>
    <button class="button" type="submit" name="button" onclick="window.location.href='index.php?action=createParty&varia';">
      <p>Créer</p>
    </button>
  </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php $css = "<link href=\"public/css/game.css\" rel=\"stylesheet\" />" ?>
<?php $js = "<script src=\"public/js/PartySettings.js\"></script>" ?>
<?php require('template.php'); ?>