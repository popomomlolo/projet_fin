<?php

require_once __DIR__.'/../Modeles/modele_joueur.inc.php';
require_once __DIR__.'/../Modeles/modele_jeu.inc.php';

// test de la méthode d'envois des données
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'GET') {
    // récupération de la donnée 'commande'
    $commande = filter_input(INPUT_GET, 'commande');
     header('Content-Type: application/json', JSON_NUMERIC_CHECK);
    switch ($commande) {        
        case 'getScore' :

            echo json_encode(obtenirScoresJoueurs());
            
            break;
        case 'getDepartementsPourVille' :
            // récupération du numéro de département
            $nomVille = filter_input(INPUT_GET, 'nomVille');
            // $numero est bien un entier
            if ($nomVille != false) {
                echo json_encode(obtenirDepartementsPourVille($nomVille));
            }
            break;
            case 'obtenirQuestion ':
            // récupération de l'id de l'utilisateur
            $id = filter_input(INPUT_GET, 'idUser',FILTER_VALIDATE_INT);
            // $numero est bien un entier
            if ($id!=false)
            {
                //echo json_encode(obtenirAdresse($id));
                echo json_encode(obtenirPrenom($id));
            }
            break;
            case 'listeQuestion' :            
            echo json_encode(obtenirListeQuestion());
            break;
        default:
            header('Content-Type: application/json');
            echo json_encode("commande inconnue");
    }
}
