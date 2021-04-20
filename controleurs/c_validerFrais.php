<?php

/**
 * Gestion d'affichage des listes des visiteurs et mois afin de valider la fiche
 * et la mettre en paiement
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
switch ($action) {	
case 'listeVisiteurs':	
    $etatRecherche=$pdo->uc_visit();	
    $nom=$pdo->getVisiteur($etatRecherche);
    $idVisiteur = filter_input(INPUT_POST, 'visit', FILTER_SANITIZE_STRING);	
    VisiteurSelectionne($idVisiteur);
    $nom=$pdo->getVisiteur($etatRecherche);
    $nomASelectionner = $idVisiteur;
    include 'vues/v_listeVisiteurs.php';
    break;
    	
case 'listeMois':
    $etatRecherche=$pdo->uc_visit();	
    $nom=$pdo->getVisiteur($etatRecherche);
    $idVisiteur = filter_input(INPUT_POST, 'visit', FILTER_SANITIZE_STRING);	
    VisiteurSelectionne($idVisiteur);
    $nomASelectionner = $idVisiteur;
    $lesMois=$pdo->getLesMois($idVisiteur,$etatRecherche);	
    $lesCles = array_keys($lesMois);	
    $mois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);	
    MoisSelectionne($mois);	
    $moisASelectionner = $mois;	
    include 'vues/v_listeMois.php';	
    break;	
}