<?php $title ="cdem.fun";?>
<?php ob_start();?>

<div id = "container2">

      
           
            <input  type="text" name="pseudo" id="pseudo"  class ="element" placeholder="PSEUDO" size="300" maxlength="10" />
  
    <div class = "block create element" >
        <a href = "index.php?action=create"> Créer</a>
    </div>

    <div class = "block join element" >
        <a href = "index.php?action=join"> Rejoindre</a>
    </div>
</div>



<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>

