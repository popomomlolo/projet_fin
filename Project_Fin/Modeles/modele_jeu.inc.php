<?php
require_once __DIR__ . '/modele.inc.php';

function verifierLogin($log, $mdp) {
    try {
        $bdd = connexionBdd();
        // recherche du couple login/mdp dans la table user
        $requete = $bdd->prepare("select questions.reponse from questions,type_questions where questions.id = :log;");
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

function obtenirCategorie() {
    try {
        $bdd = connexionBdd();
        $requete = $bdd->query('SELECT id, nom, prenom FROM users;');
        $requete->execute();

        $listeUtilisateurs = array();
        while ($reponse = $requete->fetch(PDO::FETCH_ASSOC)) {
            array_push($listeUtilisateurs, $reponse);
        }
        $requete->closeCursor();
        return $listeUtilisateurs;
    } catch (PDOException $exc) {
        print("<br/> Pb obtenirPersonnes :" . $exc->getMessage());
        die();
    }
}

function obtenirQuestion($id) {
    try {
        $bdd = connexionBdd();
        $requete = $bdd->prepare("select nom_type from type_question where id = :idU ;");
        $requete->bindParam(":idU", $id);
        $requete->execute() or die(print_r($requete->errorInfo()));
        if ($requete->rowCount() == 0) {
            $question = "pas de question";
        } else {
            $question = $requete->fetchColumn();
        }
        $requete->closeCursor();
        return($question);
    } catch (PDOException $ex) {
        print "Erreur : " . $ex->getMessage() . "<br/>";
        die();
    }
}

function obtenirListeQuestion() {
    try {
        $bdd = connexionBdd();
        $requete = $bdd->query('SELECT id, nom_type FROM type_questions;');
        $requete->execute();

        $listeQuestion = array();
        while ($reponse = $requete->fetch(PDO::FETCH_ASSOC)) {
            array_push($listeQuestion, $reponse);
        }
        $requete->closeCursor();
        return $listeQuestion;
    } catch (PDOException $exc) {
        print("<br/> Pb obtenirQuestion:" . $exc->getMessage());
        die();
    }
}
