<!DOCTYPE html>
<html>
    <head>
    <title>se connecter</title>
        <meta charset=utf-8 />
        <!-- je l'ai pas mis pck ça fait que de la merde vu que je sais pas quels blocs correspondent à quoi<link rel=stylesheet href="style.css" />-->
    </head>
    <body>
        <div class=container style="text-align:center">
        <div class="block" style="padding:10em" style="margin:1em">
            <?php
            if(isset($_GET['incorrect'])){
                if($_GET['incorrect']==1){
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
            Pas encore de compte?
            <br>
            <a>créer un compte!</a>
        </div>
        </div>
        
    </body>
</html>