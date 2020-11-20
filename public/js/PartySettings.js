
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


    
// var dfd = document.getElementById("PlayerScroll");
// var dfd2 = document.getElementById("ScoreScroll");

// name(dfd);
// name(dfd2);


// function name(object) {
//     var elem = document.getElementById('vddv');
// var rect = elem.getBoundingClientRect();
//     isMouseDown = false;
// var oldx =0;
//     var vitesse = 150; 
// object.addEventListener('mousedown', e => {
//     isMouseDown = true;
   
//   });
// window.addEventListener('mouseup', e => {
//     if (isMouseDown === true) {
//     isMouseDown= false;
   
//     }
//   });

//   object.addEventListener('mousemove', e => {
//     if (isMouseDown === true) {
//         if (e.pageX <= rect.left) {
          
//             isMouseDown= false;
//         }else{

//             var direction =1;
//             object.inner
//                 var anc = e.clientX; 
//                  // Déplac
//                  var xBloc = parseFloat(getComputedStyle(object).left);
//                 if (e.pageX < oldx) {
                     
//                      direction *= -1;
//                 }  oldx = e.pageX;
        
//                 object.style.left =   + 30 * direction + "px";
//         }
               
//         isMouseDown = true;
             
//         }
       
      
       
//   });



// }

function updateValue(direction,var1,var2) {
    var scrollPoint = document.getElementById(var1);
    var PointValue = document.getElementById(var2);
    var values_Array; 
    var xBloc = parseFloat(getComputedStyle(scrollPoint).left);
    var vitesse = 75; // Valeur du déplacement en pixels
    var n=1
    switch (var1) {
        case "PlayerScroll":
            values_Array = [2,4,6,8,10]
            break;
    
        case "ScoreScroll":
            values_Array = [50,100, 135,175,200]
            break;
    }
    switch (direction) {
        case "left":
            scrollPoint.style.transition = "1000ms";
            scrollPoint.style.left = (xBloc + vitesse*-1) + "px";
            PointValue.textContent = values_Array[(xBloc - vitesse )/xBloc];

            break;
    
        case"right":
        scrollPoint.style.transition = "1000ms";
        scrollPoint.style.left = (xBloc + vitesse) + "px";
        PointValue.textContent = values_Array[((xBloc+ vitesse ))/xBloc];

            break;
    }

}