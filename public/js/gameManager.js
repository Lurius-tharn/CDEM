class GameManager {

    constructor() {
      this.games = ["Spammer", "Taupe"];
      //this.games = ["CalcMental"];  //test unitaire
      this.miniGame;
      this.rank = new RankMinigame();
      this.waiting = new Waiting();
      this.rank.hideRank();
      this.startGame();
    }
  
    //Obtient un nombre aléatoire entre 0 et un nombre max (non inclut)
    getRandomInt(max) {
      return Math.floor(Math.random() * Math.floor(max));
    }
  
    //Lance un minijeu
    startGame(){
      let nbGame = this.getRandomInt(this.games.length);
      switch (this.games[nbGame]) {
        case "Spammer": this.miniGame = new Spammer(); break;
        case "Taupe": this.miniGame = new Taupe(); break;
        case "CalcMental": this.miniGame = new CalcMental(); break;
      }
    }
  
    //Nettoie la zone de jeu
    clearContainer(){
      let container = document.querySelector(".gameContainer").childNodes;
      for (var i = 1; i < container.length; i++) {
        container[i].remove();
      }
    }
  
    //Termine un miniJeu la zone de jeu
    endGame(){
      this.clearContainer();
      this.waiting.startWaiting();
      this.checkAllFinished();  //verifie que tous les joueurs ont FINIT le miniJeu
      this.rank.showRank();
      this.rank.hideRank();
      this.rank.showRank();
      this.rank.hideRank();
      this.relaunchGame();  //verifie que: aucun JOUEURS n'a atteint le SCOREMAX, si ce n'est pas le cas on lance le prochain MINIJEU, sinon on lance un écran de FIN.
  
      //this.startGame();
    }
  
    //Verifie que tous les joueurs ont finit
    checkAllFinished(){
      let bool;
  
      return bool;
    }
  }