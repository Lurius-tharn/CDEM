
<?php $title = "Se connecter" ?>
<?php ob_start(); ?>

<div id="container2">
  <div class="blocks">
    <div class="block">
        <div class="fond">
            <h1>Déjà membre?</h1>
            Pseudo
            <input type="text" name="pseudo" id="pseudo" class="element" placeholder="Votre Pseudo" size="255" maxlength="10" />
            Mot de passe
            <input type="text" name="pseudo" id="pseudo" class="element" placeholder="8 caractères minimum" size="255" maxlength="10" />
            <a>mot de passe oublié?</a>
        </div>
        <button class="button" type="button" name="button">
            <p>Se connecter</p>
        </button>
    </div>
     <div class="block">
        <div class="fond">
            <h1>Pas encore membre?</h1>
            Email
            <input type="text" name="pseudo" id="pseudo" class="element" placeholder="Votre Email" size="255" maxlength="10" />
            Pseudo
            <input type="text" name="pseudo" id="pseudo" class="element" placeholder="Votre Pseudo" size="255" maxlength="10" />
            Mot de passe
            <input type="text" name="pseudo" id="pseudo" class="element" placeholder="8 caractères minimum" size="255" maxlength="10" />
        </div>
        <button class="button" type="button" name="button">
            <p>S'inscrire</p>
        </button>
    </div>
  </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php $css = "<link href=\"co.css?v=<?php echo time(); ?>\" rel=\"stylesheet\" />" ?>
<?php require('template.php'); ?>
