<?php $title = "Se connecter" ?>
<?php ob_start(); ?>


<div class="connectBlocks">
    <div class="connectblock">
        <div class="connectForm">
            <h1>Déjà membre ?</h1>
            <div class="inputBlocks">
                <div class="inputBlock">
                    <h2>Pseudo</h2>
                    <input type="text" name="pseudo" id="pseudoCon" class="element" placeholder="Votre Pseudo" maxlength="30" />
                </div>
                <div class="inputBlock">
                    <h2>Mot de passe</h2>
                    <input type="text" name="pwd" id="pwdCon" class="element" placeholder="8 caractères min." maxlength="255" />
                    <a href="">Mot de passe oublié ?</a>
                </div>
            </div>
        </div>

        <button class="button" type="button" name="buttonCon">
            <p>Se connecter</p>
        </button>
    </div>

    <div class="connectblock">
        <div class="connectForm">
            <h1>Pas encore membre ?</h1>
            <div class="inputBlocks">
                <div class="inputBlock">
                    <h2>Email</h2>
                    <input type="text" name="email" id="emailIns" class="element" placeholder="Votre Email" maxlength="255" />
                </div>
                <div class="inputBlock">
                    <h2>Pseudo</h2>
                    <input type="text" name="pseudo" id="pseudoIns" class="element" placeholder="Votre Pseudo" maxlength="255" />
                </div>
                <div class="inputBlock">
                    <h2>Mot de passe</h2>
                    <input type="text" name="pwd" id="pwdIns" class="element" placeholder="8 caractères min." maxlength="10" />
                </div>
            </div>
        </div>

        <button class="button" type="button" name="buttonIns">
            <p>S'inscrire</p>
        </button>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php $css = "<link href=\"public/css/connexion.css?v=<?php echo time(); ?>\" rel=\"stylesheet\" />" ?>
<?php require('template.php'); ?>