<?php $title = "Se connecter" ?>
<?php ob_start(); ?>

<div class=container style="text-align:center">

    <div class="block" style="padding:10em" style="margin:1em">
        <?php
        if (isset($_GET['incorrect'])) {
            if ($_GET['incorrect'] == 1) {
                echo "<span class=err>Identifiant non reconnu.</span>";
            } else {
                echo "<span class=err>Mot de passe incorrect.</span>";
            }
        }
        ?>

        <form action="co.php" method="post">
            <br>
            Entrez votre identifiant (email):
            <br>
            <input type="text" name=pseudo>

            <br>
            Entrez votre mot de passe:
            <br>
            <input type="password" name=mdp>
            <br>
            <input type=submit>
        </form>

        <br>
        Pas encore de compte ?
        <br>

        <a>créer un compte !</a>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>