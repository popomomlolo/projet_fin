<?php
require_once __DIR__ . '/modele.inc.php';

function verifierLogin($log, $mdp) {
    try {
        $bdd = connexionBdd();
        // recherche du couple login/mdp dans la table user
        $requete = $bdd->prepare("select mdp from joueurs where pseudo = :log;");
        $requete->bindParam(":log", $log);
        $requete->execute() or die(print_r($requete->errorInfo()));
        // comptage du nombre de resultats
        $nbLigne = $requete->rowCount();

        if ($nbLigne == 0) {// le couple login/mdp n'est pas présent dans la table user
            // il faudra retourner 'r'
            $retour = 'r';
        } else {   // le couple login/mdp est présent dans la table user
            $motDePasseBdd = $requete->fetchColumn();
            if ($motDePasseBdd == $mdp) {
                // il faudra retourner 'v'
                $retour = 'v';
            } else {
                $retour = 'o';
            }
        }
        $requete->closeCursor();
        return $retour;
    } catch (Exception $exc) {
        print "Erreur : " . $exc->getMessage() . "<br/>";
        die();
    }
}

function obtenirIdJoueur($pseudo) {
    try {
        $bdd = connexionBdd();
        $requete = $bdd->prepare("SELECT id FROM joueurs WHERE pseudo = :pseudo");
        $requete->bindParam(":pseudo", $pseudo);
        $requete->execute();
        return $requete->fetchColumn();
    } catch (Exception $exc) {
        print "Erreur : " . $exc->getMessage() . "<br/>";
        die();
    }
}