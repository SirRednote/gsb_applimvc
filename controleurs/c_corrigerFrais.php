<?php
/**
 * Validation des fiches 
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

$idVisiteur = $_SESSION['idVisiteur'];
$mois = $_SESSION['mois'];
MoisSelectionne($mois);
$moisASelectionner = $mois;
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

switch ($action) {
    case'afficherFrais' :
        $mois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $etatRecherche = $pdo->uc_visit();
        $nom = $pdo->getVisiteur($etatRecherche);
        $nomASelectionner = $idVisiteur;
        $_SESSION['mois'] = $mois;
        $moisASelectionner = $mois;
    break;

    case 'validerMajFraisForfait':
        $etatRechercher = $pdo->uc_visit();
        $nom = $pdo->getVisiteur($etatRechercher);
        $nomASelectionner = $idVisiteur;
        $_SESSION['mois'] = $mois;
        $moisASelectionner = $mois;
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        if (lesQteFraisValides($lesFrais)) {
            $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
        }
        else {
            ajouterErreur('Les valeurs des frais doivent être numériques');
            include 'vues/v_erreurs.php';
        }
    break;
    
    case 'horsForfait':
        $etatRecherche = $pdo->uc_visit();
        $nom = $pdo->getVisiteur($etatRecherche);
        $nomASelectionner = $idVisiteur;
        $_SESSION['mois'] = $mois;
        $moisASelectionner = $mois;
        try {
            $date = filter_input(INPUT_POST, 'lesFraisD', FILTER_DEFAULT, FILTER_FORCE_ARRAY); 
            $libelle = filter_input(INPUT_POST, 'lesFraisL', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
            $montant = filter_input(INPUT_POST, 'lesFraisM', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
            $idFrais = filter_input(INPUT_POST, 'fraisHorsForfait', FILTER_DEFAULT , FILTER_FORCE_ARRAY);
            if (isset($_POST['corriger'])) {
                $pdo->supprimerFrais($idVisiteur, $mois,$libelle,$idFrais);
            } elseif (isset($_POST['reporter'])) {
                $moisASelectionner = $moisASelectionner+1;
                if ($pdo->estPremierFraisMois($idVisiteur, $moisASelectionner)) {
                    $pdo->creeNouvellesLignesFrais($idVisiteur, $moisASelectionner);
                }
                $pdo->creeFraisHorsForfait($idVisiteur, $moisASelectionner, $libelle, $date, $montant, $idFrais);
                $moisASelectionner = $moisASelectionner-1;
                $pdo->supprimerLeFraisHorsForfait($idFrais,$moisASelectionner);
    }
}
catch(Exception $e) {
    exit('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
}
break;

    case 'validerFrais':
    $etatRechercher = $pdo->uc_visit();
    $nom = $pdo->getVisiteur($etatRecherche);
    $nomASelectionner = $idVisiteur; 
    $_SESSION['mois'] = $mois;
    $moisASelectionner = $mois;
    $nbJustificatifs = filter_input(INPUT_POST, 'nbJustificatifs', FILTER_SANITIZE_STRING );
    try { 
        $pdo->majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs)  ;
        $etat = "VA";
        $pdo-> majEtatFicheFrais($idVisiteur, $mois,$etat);
    } catch(Exception $e) {
        exit('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
    }
    echo '<script type="text/javascript">window.alert("La fiche a bien été validée, vous pouvez choisir une autre fiche");</script>';
    $quantite = 0;
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois); // pour avoir le montant totale
    foreach ($lesFraisForfait as $unFraisForfait) {
        $quantite = $quantite+$unFraisForfait['quantite'];
    } 
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
    foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
        $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
        $ref = substr($libelle, 0, 7); // permet de ne pas prendre en compte les frais refuser
        if ($ref !== "REFUSER") {
            $quantite = $quantite+$unFraisHorsForfait['montant'];
        }
    }
    $pdo->montantValider($idVisiteur,$mois,$quantite);
    break;
}
$etat = "CL";
$lesMois = $pdo->getLesMois($idVisiteur,$etatRecherche);
require 'vues/v_mois.php'; 
$lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $moisASelectionner);
require 'vues/v_listeFraisForfait.php';
$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $moisASelectionner);
require 'vues/v_fraisHorsForfait.php';