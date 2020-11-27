<?php $title = "Se connecter" ?>
<?php ob_start(); ?>


<div class="connectBlocks">
    <form action="index.php?action=check" method="post" class="connectblock">
        <div class="connectForm">
            <h1>Déjà membre ?</h1>
            <div class="inputBlocks">
                <div class="inputBlock">
                    <h2>Email</h2>
                    <input type="text" name="emailCon" class="element" placeholder="Votre Email" maxlength="255" />
                </div>
                <div class="inputBlock">
                    <h2>Mot de passe</h2>
                    <input type="password" name="pwdCon" class="element" placeholder="8 caractères min." maxlength="255" />
                    <a href="index.php?action=forgottenPwd">Mot de passe oublié ?</a>
                </div>
            </div>
        </div>

        <button class="button" type="submit" name="buttonCon">
            <p>Se connecter</p>
        </button>
    </form>

    <form action="index.php?action=new" method="post" class="connectblock">
        <div class="connectForm">
            <h1>Pas encore membre ?</h1>
            <div class="inputBlocks">
                <div class="inputBlock">
                    <h2>Email</h2>
                    <input type="text" name="emailIns" class="element" placeholder="Votre Email" maxlength="255" />
                </div>
                <div class="inputBlock">
                    <h2>Mot de passe</h2>
                    <input type="password" name="pwdIns" class="element" placeholder="8 caractères min." maxlength="255" />
                </div>
                <div class="inputBlock">
                    <h2>Confirmation de votre mot de passe</h2>
                    <input type="password" name="pwdInsCheck" class="element" placeholder="8 caractères min." maxlength="255" />
                </div>
            </div>
        </div>

        <button class="button" type="submit" name="buttonIns">
            <p>S'inscrire</p>
        </button>
    </form>
</div>

<?php $content = ob_get_clean(); ?>
<?php $css = "<link href=\"public/css/connexion.css?v=<?php echo time(); ?>\" rel=\"stylesheet\" />" ?>
<?php require('template.php'); ?>