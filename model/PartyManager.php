<?php

require_once("model/Manager.php");

class PartyManager extends Manager
{

    /* Fonction qui insert dans la base de données le pseudo d'un joueur

    */
    function createPlayer($pseudo){
        $db = $this->dbConnect();
        $player_InsertQuery = $db->prepare('INSERT INTO player(nickname)
            VALUES( :nickname)');
        $player_InsertQuery -> execute(array('nickname' =>$pseudo ));         
    }
    /* Fonction qui crée la Partie(à partir de la page createView) 
        prends en paramètre un tableau comprenant:
            le numéro de l'hote(le numéro qui sera attribué au joueur en page d'acceuil)
            le nombre de joueurs(qui sera mis a jour, 1 au départ),
            le nombre de joueurs max(si le nombre de joueurs max est atteint la party se lance)
            le score max,
            si la partie est en cours(si non, elle est arrété),
            si la partie est en public,
            si oui, le code

    */
    function createParty($partySettings){
        $db = $this->dbConnect();
        $party_InsertQuery = $db->prepare('INSERT INTO game(idHost,nbPlayers,nbMaxPlayers,scoreMax,isInProgress,isPublic,code)
            VALUES( :idHost, :nbPlayers, :nbMaxPlayers, :scoreMax, :isInProgress, :isPublic, :code)');
        $party_InsertQuery -> execute(array
        (
            'idHost'=>$partySettings['idHost'], 
            'nbPlayers'=>1, 
            'nbMaxPlayers'=>$partySettings['nbMaxPlayers'], 
            'scoreMax'=>$partySettings['scoreMax'], 
            'isInProgress'=>1, 
            'isPublic'=>$partySettings['isPublic'], 
            'code'=>$partySettings['code']
        
        ));         
    }

    /* Fonction qui met à jour le nombre de joueurs
        Possibilité de faire un trigger
    */
    function updatenbPlayers($partyId)
    {
        $db = $this->dbConnect();
        $party_UpdateQuery = $db->prepare('UPDATE party SET nbPlayers =(nbPlayers+1)
        WHERE idGame = :idGame');
        $party_UpdateQuery -> execute(array('idGame' => $partyId));
    }

    function getIdHost($nickname){
        $db = $this->dbConnect();
        $host_GetQuery = $db->prepare('SELECT idPlayer FROM  player where nickname = :nickname');
        $host_GetQuery->execute(array('nickname' => $nickname));
        $idHost = null;
        while ($donnees = $host_GetQuery->fetch())
                $idHost= $donnees['idPlayer'];
                $host_GetQuery->closeCursor();
    
        return  $idHost;
    }


}