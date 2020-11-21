
function buttonClicked(ClickedButton)
{
    var privateButton = document.getElementById("Privé");
    var publicButton = document.getElementById("Public");
    if (ClickedButton== "Privé") {
        privateButton.classList.remove("notClick");
        publicButton.classList.add("notClick");
    }if (ClickedButton == "Public" ) {
        privateButton.classList.add("notClick");
     publicButton.classList.remove("notClick");
    }
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




window.addEventListener("load",function(){
    buttonClicked('Privé');
});