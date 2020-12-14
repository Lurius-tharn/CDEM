class CalcMental{

    constructor() {
      this.loop;
      this.nombre1;
      this.nombre2;
      this.nombre3;
      this.symbol = ["+", "-"];
      this.result;
      this.body = document.querySelector(".gameContainer");
      this.container = document.createElement("div");
      this.h1 = document.createElement("h1");
      this.progressBar = document.createElement("progress");
      this.input = document.createElement("input");
      this.confirm = document.createElement("button");
  
      this.configuration();
      this.addToHtml();
    }
  
    configuration(){
      this.container.style.height = "100%";
      this.container.style.width = "100%";
      this.container.style.display = "flex";
      this.container.style.justifyContent = "center";
      this.container.style.alignItems = "center";
      this.container.style.flexDirection = "column";
  
      this.progressBar.max = 5;
      this.progressBar.value = 0;
      this.progressBar.style.height = "7em";
      this.progressBar.style.width = "70%";
  
      this.h1.style.color = "#000000";
      this.h1.style.fontFamily = "Montserrat, 'Segoe ui'";
      this.h1.style.textTransform = "uppercase";
      this.h1.innerHTML = this.generateEquation();
      this.h1.style.paddingBottom = "1em";
  
      this.input.style.height = "2em";
      this.input.setAttribute("type", "number");
      this.input.style.width = "10em";
      this.input.style.border = "none";
      this.input.style.borderRadius = "1em";
      this.input.style.backgroundColor = "#2ecc71";
      this.input.style.color = "#fff";
      this.input.style.fontSize = "2em";
      this.input.style.textAlign = "center";
  
      this.confirm.style.height = "10em";
      this.confirm.style.width = "10em";
      this.confirm.style.border = "none";
      this.confirm.style.borderRadius = "1em";
      this.confirm.style.backgroundColor = "#f44";
      this.confirm.style.margin = "0em";
      this.confirm.setAttribute("onClick", "gameManager.miniGame.clicked()");
      this.confirm.setAttribute("draggable", "false");
      this.confirm.style.outline = "none";
    }
    addToHtml(){
      this.body.appendChild(this.container);
      this.container.appendChild(this.h1);
      this.container.appendChild(this.progressBar);
      this.container.appendChild(this.input);
      this.container.appendChild(this.confirm);
    }
  
    getRandomInt(max) {
      return Math.floor(Math.random() * Math.floor(max));
    }
  
    generateEquation(){
      let symbole1 = this.getRandomInt(2);
      let symbole2 = this.getRandomInt(2);
      this.nombre1 = this.getRandomInt(1000);
      this.nombre2 = this.getRandomInt(1000);
      this.nombre3 = this.getRandomInt(1000);
      let equation;
  
      switch (this.symbol[symbole1]) {
        case "+":
          this.result = (this.nombre1 + this.nombre2);
          equation = (this.nombre1 + " + " + this.nombre2);
          break;
        case "-":
          this.result = (this.nombre1 - this.nombre2);
          equation = (this.nombre1 + " - " + this.nombre2);
          break;
      }
      switch (this.symbol[symbole2]) {
        case "+":
          this.result += this.nombre3;
          equation += (" + " + this.nombre3);
          break;
        case "-":
        this.result -= this.nombre3;
        equation += (" - " + this.nombre3);
          break;
      }
      console.log(this.result);
      return equation;
    }
  
    checkResult(){
      if(this.input.value == this.result){
         this.progressBar.value += 1;
         this.h1.innerHTML = this.generateEquation();
       }
       else {
         this.malus();
       }
    }
  
    malus(){
      this.h1.innerHTML = "Concentre toi bon sang !";
      let that = this;
      setTimeout(function(){
        that.h1.innerHTML = that.generateEquation();
      }, 2000);
    }
  
    clicked(){
      this.checkResult();
      this.input.value = "";
    }
  
    finish(){
      gameManager.endGame();
    }
  }