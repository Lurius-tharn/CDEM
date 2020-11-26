
function buttonClicked(ClickedButton)
{
    var privateButton = document.getElementById("Privé");
    var publicButton = document.getElementById("Public");
    var boolPArty = document.getElementById("hiddenBool");
    if (ClickedButton== "Privé") {
        privateButton.classList.remove("notClick");
        publicButton.classList.add("notClick");
        
    }if (ClickedButton == "Public" ) {
        privateButton.classList.add("notClick");
     publicButton.classList.remove("notClick");
    }
    boolPArty.value  =ClickedButton;
}



function buttonChange( button) 
{
    var privateBlock = document.getElementById("private");
    var publicBlock = document.getElementById("public");
   
    if (button == 'private') {
       
        privateBlock.classList.remove("hidden");
        publicBlock.classList.add("hidden");
        buttonClicked("Privé");
        
    }
    if (button == 'public') {
        publicBlock.classList.remove("hidden");
        privateBlock.classList.add("hidden");
        buttonClicked("Public");
 
        
        

    }
}


function ScrollValue(Scroll, Value) {
    var slider = document.getElementById(Scroll);
    var output = document.getElementById(Value);
    output.innerHTML = slider.value;
    slider.onInput = function() {
        output.innerHTML = this.value;
      } 

}

function PseudoValidator(liens) {
    var pseudo =document.getElementById('pseudo');
    if(pseudo.value == null){
        pseudo.style.backgroundColor ='red';
    }else{
        var link =this.href='index.php?action='+liens+'&pseudo='+pseudo.value;
        return link;
    }
    
}


window.addEventListener("load",function(){
    buttonClicked('Privé');
});