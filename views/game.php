<?php $title = 'CDEM.fun' ?>
<div class="gameContainer" style="height: 80vh; width:90%;background-color:#fff;border-radius:3em;box-shadow:rgba(0,0,0,0.3) 0 0.6em 0">

</div>

<!--  Pages specials  -->
<script src="public/js/rank.js"></script>
<script src="public/js/rankMinigame.js"></script>
<script src="public/js/endScreen.js"></script>
<script src="public/js/waiting.js"></script>

<!--  Mini Jeux  -->
<script src="public/js/taupe.js"></script>
<script src="public/js/spammer.js"></script>
<script src="public/js/clicker.js"></script>
<script src="public/js/calcMental.js"></script>

<!--  Manager de partie  -->
<script src="public/js/gameManager.js"></script>

<script type="text/javascript">
    document.getElementById("connect").innerHTML = "<a> Code : " + "<?= $data['code'] ?>" + "</a>";
    document.getElementById("connect").classList.remove("connectHover");
    gameManager = new GameManager();
</script>
<?php $css = "<link href=\"public/css/game.css\" rel=\"stylesheet\" />" ?>
<?php $js = "<script src=\"public/js/PartySettings.js\"></script>" ?>