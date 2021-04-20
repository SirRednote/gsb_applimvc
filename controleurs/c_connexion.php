<?php
/**
 * Gestion de la connexion
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
if (!$uc) {
    $uc = 'demandeconnexion';
}

switch ($action) {
case 'demandeConnexion':
    include 'vues/v_connexion.php';
    break;
case 'valideConnexion':
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
    $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING);
    $visiteur = $pdo->getInfosVisiteur($login, $mdp);
    $comptable= $pdo->getInfosComptable($login, $mdp);
    if ((!is_array($visiteur)) && !is_array($comptable)){
        ajouterErreur('Login ou mot de passe incorrect');
        include 'vues/v_erreurs.php';
        include 'vues/v_connexion.php';
    } else {
        if(is_array($visiteur)) {
            $idUtilisateur = $visiteur['id'];	
            $nom = $visiteur['nom'];	
            $prenom = $visiteur['prenom'];	
            $statut = 'visiteur';
        }
        elseif(is_array ($comptable)) {	
            $idUtilisateur = $comptable['id'];	
            $nom = $comptable['nom'];	
            $prenom = $comptable['prenom'];   	
            $statut = 'comptable';	
        }	
        connecter($idUtilisateur, $nom, $prenom, $statut);	
        header('Location: index.php');
    }
    break;
default:
    include 'vues/v_connexion.php';
    break;
}
