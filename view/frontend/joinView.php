<?php $title = "Rejoindre" ?>
<?php ob_start(); ?>

<div id="partyBlock">
  <div class="title">
    <h1>Rejoindre une partie</h1>
  </div>

  <div class="choice">
    <button class="buttonChoice" type="button" id="Privé" onclick="buttonChange('private')">
      <p>Privé</p>
    </button>
    <button class="buttonChoice " type="button" id="Public" onclick="buttonChange('public')">
      <p>Public</p>
    </button>
  </div>

  <div id = "private"  >
    <div class="code">
      <div class="codeText">
        <p>code</p>
      </div>
      <div class="codeInput">
        <input type="text" placeholder="HXFEAS" maxlength="6">
      </div>
    </div>
  </div>
  
  <div id = "public" class="hidden" > 
    <div class="code">
      
      </div>
    <div class="random" >
      <a>Vous allez rejoindre une partie aléatoire</a>
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
<?php $css = "<link href=\"public/css/game.css\" rel=\"stylesheet\" />" ?>
<?php $js="<script src=\"public/js/PartySettings.js\"></script>" ?>
<?php require('template.php'); ?>
