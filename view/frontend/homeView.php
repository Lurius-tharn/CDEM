<?php $title ="cdem.fun";?>
<?php ob_start();?>

<div id = "container2">

      
           
            <input  type="text" name="pseudo" id="pseudo"  class ="element" placeholder="PSEUDO" size="300" maxlength="10" />
  
    <a class = "block create element" href = "index.php?action=create"> 
        <p>Créer</p>
    </a>

    <a class = "block join element" href = "index.php?action=join"   > 
        <p>Rejoindre</p>
    </a>
    
</div>



<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>uj

