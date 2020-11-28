<?php $title = "Se connecter" ?>
<?php ob_start(); ?>


<div class="connectBlocks">
    <form action="index.php?action=check" method="post" class="connectblock">
        <div class="connectForm">
            <h1>Déjà membre ?</h1>
            <h2 id="connectError"><?php if (isset($_SESSION['connectError']) and !empty($_SESSION['connectError'])) echo($_SESSION['connectError']);unset($_SESSION['connectError']);?></h2>
            <div class="inputBlocks">
                <div class="inputBlock">
                    <h2>Email</h2>
                    <input type="text" name="email" class="element" placeholder="Votre Email" maxlength="255" required/>
                </div>
                <div class="inputBlock">
                    <h2>Mot de passe</h2>
                    <input type="password" name="pwd" class="element" placeholder="8 caractères min." maxlength="255" required />
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
            <h2 id="registerError"><?php if (isset($_SESSION['registerError']) and !empty($_SESSION['registerError'])) echo($_SESSION['registerError']); unset($_SESSION['registerError']);?></h2>
            <div class="inputBlocks">
                <div class="inputBlock">
                    <h2>Email</h2>
                    <input type="text" name="email" class="element" placeholder="Votre Email" maxlength="255" required />
                </div>
                <div class="inputBlock">
                    <h2>Mot de passe</h2>
                    <input type="password" name="pwd" class="element" placeholder="8 caractères min." maxlength="255" required />
                </div>
                <div class="inputBlock">
                    <h2>Confirmation de votre mot de passe</h2>
                    <input type="password" name="pwdCheck" class="element" placeholder="8 caractères min." maxlength="255" required />
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