<?php $title = 'Salle d\'attente' ?>

<form action="Party-room" method="post" class="formCreate">
    <div id="partyBlock">

        <h1>En attente de joueurs...</h1>
        <p id="nbPlayerText"></p>
        <div id="waitContainer">

        </div>
    </div>
    <div class="buttons">
        <button class="button" type="button" name="button" onclick="window.location.href='/CDEM';">
            <p>Retour</p>
        </button>
        <button class="button" type="submit" name="button">
            <p>Lancer la partie</p>
        </button>
    </div>
</form>
<div id="code" class="hidden"><?= $_SESSION['code'] ?></div>

<?php
$css = "<link href=\"public/css/game.css\" rel=\"stylesheet\" />";
?>


<script>
    // //renvoie les informations sur les joueurs
    // async function getPlayers(code) {
    //     return new Promise(function(resolve, reject) {
    //         var reqPlayer = new XMLHttpRequest();

    //         reqPlayer.onreadystatechange = function() {
    //             if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
    //                 resolve(JSON.parse(reqPlayer.responseText));
    //             }
    //         };

    //         reqPlayer.open("GET", "get-players/" + code);
    //         reqPlayer.send();
    //     });
    // }

    // async function showPlayers() {

    //     var code = document.getElementById('code').textContent.trim();
    //     var nbPlayerText = document.getElementById('nbPlayerText');
    //     var nbCurrent = await nbPlayers(code);
    //     var nbMax = await nbMaxPlayers(code);

    //     nbPlayerText.textContent = nbCurrent + "/" + nbMax;

    //     var Container = document.getElementById("waitContainer");
    //     while (Container.firstChild) {
    //         Container.removeChild(Container.firstChild);
    //     }

    //     var players = await getPlayers(code);

    //     for (var i = 0; i < nbCurrent; i++) {

    //         var newDiv = document.createElement("div");
    //         newDiv.className = "element";

    //         var pic = document.createElement("p");
    //         pic.textContent = "CDEM.fun";
    //         var Pseudo = document.createElement("div");

    //         Pseudo.className = "vs";
    //         Pseudo.textContent = players[i + 1]["username"];
    //         newDiv.appendChild(pic);
    //         newDiv.appendChild(Pseudo);
    //         Container.appendChild(newDiv);

    //     }

    // }

    var myData = function() {};
    myData.init = function() {
        // dans le $data du contrôleurs sont passées 3 index :
        // - maxUsers : Nombre d'utilisateurs maximum attendus
        // - code : code de la session
        // - users : le tableau des utilisateurs actuellement connectés

        this.nbMaxPlayers = <?= $data['nbMaxPlayers'] ?>; //Nombre maximum de joueurs
        this.get();
    };
    myData.get = function() {

        var reqPlayer = new XMLHttpRequest();
        reqPlayer.onreadystatechange = function() {
            if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
                var tempData = JSON.parse(reqPlayer.responseText);
                console.log(tempData);
                // Vérifier qu'il n'y a pas de users qui ont disparus dans myData.users
                // -- si c'est le cas, les supprimer de myData.users ET supprimer les éléments du DOM qui les concernents
                // Remplacer myData.users par tempData 
                myData.users = tempData;
                myData.nbUsers = myData.users.length;
                // lancer myData.draw
                myData.draw();
                if(parseInt(myData.nbUsers) < parseInt(myData.nbMaxPlayers)){
                    setTimeout(myData.get(), 1000);
                }
            }
        };
        reqPlayer.open("GET", "get-players/<?= $data['code'] ?>");
        reqPlayer.send();

    }
    myData.draw = function() {
        // vérifier si l'élément du DOM existe déjà
        // si oui, on ne fait rien
        // si non, on crée le nouvel élément du DOM
        var Container = document.getElementById("waitContainer");
        document.getElementById('nbPlayerText').textContent = this.nbUsers + "/" + this.nbMaxPlayers;
        for (var i = 0; i < this.nbUsers; i++) {
            var id = myData.users[i]["username"];
            if (!document.getElementById(id)) {
                var newDiv = document.createElement("div");
                newDiv.className = "element";
                newDiv.id = id;

                var pic = document.createElement("p");
                pic.textContent = "CDEM.fun";
                var Pseudo = document.createElement("div");

                Pseudo.className = "vs";
                Pseudo.textContent = id;
                newDiv.appendChild(pic);
                newDiv.appendChild(Pseudo);
                Container.appendChild(newDiv);
            }
        }
    }

    $(document).ready(function() {
        myData.init();
    });
</script>