<?php

require_once __DIR__ . '/modele.inc.php';

function obtenirScoresJoueurs()
{
     try {
        $bdd = connexionBdd();
        $requete = $bdd->query("select scores.score, scores.id_joueur from scores, joueurs where joueurs.id=scores.id_joueur;");
        $requete->execute();
        $tab = array();
        while ($ligne = $requete->fetch()) {
            array_push($tab, array('score' => $ligne['score'], 'id_joueur' => $ligne['id_joueur']));
        }
        $requete->closeCursor();
        return $tab;
    } catch (PDOException $exc) {
        print("Pb obtenirScoresJoueurs :" . $exc->getMessage());
        die();
    }
    
}

function obtenirDepartementsPourVille($nomVille) {
    try {
        $bdd = connexionBdd();

        $requete = $bdd->prepare('SELECT ville_nom,departement_nom,ville_code_postal '
                . 'FROM villes,departements '
                . 'where villes.ville_departement_id = departements.departement_id and ville_nom like :nom;');
        $requete->bindParam(":nom", $nomVille);
        $requete->execute();
        $departements = array();
        while ($reponse = $requete->fetch()) {
            array_push($departements, array(
                $reponse['ville_nom'],
                $reponse['ville_code_postal'],
                $reponse['departement_nom']
            ));
        }
        $requete->closeCursor();
        return $departements;
    } catch (PDOException $exc) {
        print(" Pb obtenirDepartementsDeLaRegion :" . $exc->getMessage());
        die();
    }
}
