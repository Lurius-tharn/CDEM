<?php $title = "Créer" ?>
<?php ob_start(); ?>

<div id="partyBlock" >
  <div class="title">
    <h1>Créer une partie</h1>
  </div>
  <div class="choice">
    <button class="buttonChoice" type="button" id="Privé" onclick="buttonClicked('Privé')">
      <p>Privé</p>
    </button>
    <button class="buttonChoice " type="button" id="Public" onclick="buttonClicked('Public')">
      <p>Public</p>
    </button>
  </div>
 
  
    <div class="code">
        <div class="codeText" >
            <p>Joueurs</p>
        </div>
        
        <div class="Scrollbar">
              <p id="PlayersValue" class="scrollValue">5</p>
              <div class="LeftValue" onclick="updateValue('left','PlayerScroll','PlayersValue')"></div>
              <div class="HScrollbar "  >
                  <div class="Scrollpoint"  id = "PlayerScroll"  > </div> 
                </div>  <div class="RightValue" onclick="updateValue('right','PlayerScroll','PlayersValue')"></div>

          </div>
    </div>
    
    <div class="code">
        <div class="codeText">
            <p>Score</p>
        </div>
        
        <div class="Scrollbar">
              <p id="ScoreValue" class="scrollValue">5</p>
              <div class="HScrollbar" id="vddv">
                  <div class="Scrollpoint" id = "ScoreScroll" > </div> 
                </div> 
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