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

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);

switch ($action) {
case 'choixVisiteur':
    
    $lesVisiteurs = $pdo->getLesVisiteurs();
    $lesCles = array_keys($lesVisiteurs);
    $visiteurASelectionner = $lesCles[0];    
    $mois = getMois(date('d/m/Y'));
    $douzeMois = getDouzeDernierMois($mois);
    $leTableau = array_keys($douzeMois);
    $moisASelectionner = $leTableau[0];    

    include 'vues/v_choixVisiteur.php';
    
    
break;

case 'ficheVisiteur':
    $lesVisiteurs = $pdo->getLesVisiteurs();
    $lesCles = array_keys($lesVisiteurs);
    $mois2 = getMois(date('d/m/Y'));
    $douzeMois = getDouzeDernierMois($mois2);
    $leTableau = array_keys($douzeMois); 
    
    $idvisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_SPECIAL_CHARS);
    $mois = filter_input(INPUT_POST, 'lstmois', FILTER_SANITIZE_SPECIAL_CHARS);
    
    
    $visiteurASelectionner = $idvisiteur;
    $moisASelectionner = $mois; 
   
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteurASelectionner, $moisASelectionner);
    $lesFraisForfait = $pdo->getLesFraisForfait($visiteurASelectionner, $moisASelectionner);
    $justificatifs = $pdo->getNbjustificatifs($idvisiteur, $mois);

    if (empty($lesFraisForfait)&& empty($lesFraisHorsForfait)) {
        ajouterErreur("'Pas de fiche de frais pour ce visiteur ce mois");
        include 'vues/v_erreurs.php';
        include 'vues/v_choixVisiteur.php';
    }
    else{
    include 'vues/v_valideFrais.php';
   
    }
    
break;

case 'corrigerFraisForfait':     
    $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
    $idvisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_SPECIAL_CHARS);
    $mois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_SPECIAL_CHARS);
    

    $justificatifs = $pdo->getNbjustificatifs($idvisiteur, $mois);
    
 
    if (lesQteFraisValides($lesFrais)) {
        $pdo->majFraisForfait($idvisiteur, $mois, $lesFrais);
        $lesVisiteurs = $pdo->getLesVisiteurs();
        $lesCles = array_keys($lesVisiteurs);
        $mois2 = getMois(date('d/m/Y'));
        $douzeMois = getDouzeDernierMois($mois2);
        $leTableau = array_keys($douzeMois); 
        
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idvisiteur, $mois);
        $lesFraisForfait = $pdo->getLesFraisForfait($idvisiteur, $mois);

        $moisASelectionner = $mois;
        $visiteurASelectionner = $idvisiteur;
        
        include 'vues/v_valideFrais.php';        
        }
        
        
        else {
        ajouterErreur('Les valeurs des frais doivent être numériques');
        include 'vues/v_erreurs.php';
        }
    
    break;
    
    
case 'corrigerFraisHorsForfait':
    
    if(
        isset($_POST["corriger"])){
            
    $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
    $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_SPECIAL_CHARS);
    $montant = filter_input(INPUT_POST, 'montant', FILTER_SANITIZE_SPECIAL_CHARS);
    $idvisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_SPECIAL_CHARS);
    $mois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_SPECIAL_CHARS);

    
    $justificatifs = $pdo->getNbjustificatifs($idvisiteur, $mois);
    $mois2 = getMois(date('d/m/Y'));
    $douzeMois = getDouzeDernierMois($mois2);
    $moisASelectionner = $mois;
    $pdo->majFraisHorsForfait($idvisiteur, $mois, $date, $libelle, $montant);
    $lesFraisForfait = $pdo->getLesFraisForfait($idvisiteur, $mois);
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idvisiteur, $mois);
    $lesVisiteurs = $pdo->getLesVisiteurs();
    $visiteurASelectionner = $idvisiteur;
    }
    
    
    else if(
        isset($_POST["reporter"])){
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
    $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_SPECIAL_CHARS);
    $montant = filter_input(INPUT_POST, 'montant', FILTER_SANITIZE_SPECIAL_CHARS);
    $idvisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_SPECIAL_CHARS);
    $mois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_SPECIAL_CHARS);
    
    
    $justificatifs = $pdo->getNbjustificatifs($idvisiteur, $mois);
    $libelle2 = "Refusé ".$libelle;
    $mois2 = getMois(date('d/m/Y'));
    $douzeMois = getDouzeDernierMois($mois2);
    $moisASelectionner = $mois;
    $moisSuivant = getMoisSuivant($moisASelectionner);
    var_dump($moisSuivant,$moisASelectionner);
    $pdo->majFraisHorsForfait($idvisiteur, $mois, $date, $libelle2, $montant);
        if ($pdo->estPremierFraisMois($idvisiteur, $moisSuivant)) {
        $pdo->creeNouvellesLignesFrais($idvisiteur, $moisSuivant);
    }
    $pdo->creeNouveauFraisHorsForfait($idvisiteur, $moisSuivant, $libelle, $date, $montant);
    $lesFraisForfait = $pdo->getLesFraisForfait($idvisiteur, $mois);
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idvisiteur, $mois);
    $lesVisiteurs = $pdo->getLesVisiteurs();
    $visiteurASelectionner = $idvisiteur;
    
    
        }
        
        
    else if(
        isset($_POST["supprimer"])){
            
    $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
    $idFrais = filter_input(INPUT_POST, 'idFrais', FILTER_SANITIZE_SPECIAL_CHARS);
    $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_SPECIAL_CHARS);
    $montant = filter_input(INPUT_POST, 'montant', FILTER_SANITIZE_SPECIAL_CHARS);
    $idvisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_SPECIAL_CHARS);
    $mois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $justificatifs = $pdo->getNbjustificatifs($idvisiteur, $mois);
    $mois2 = getMois(date('d/m/Y'));
    $douzeMois = getDouzeDernierMois($mois2);
    $moisASelectionner = $mois;
    $pdo->supprimerFraisHorsForfait($idFrais);
    $lesFraisForfait = $pdo->getLesFraisForfait($idvisiteur, $mois);
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idvisiteur, $mois);
    $lesVisiteurs = $pdo->getLesVisiteurs();
    $visiteurASelectionner = $idvisiteur;
    }
    include 'vues/v_valideFrais.php';            
    
    break;
    
case'valider':
    
    
    
    $idvisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_SPECIAL_CHARS);
    $mois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_SPECIAL_CHARS);
    var_dump($idvisiteur, $mois);
    $totalFraisHorsForfait = $pdo->getTotalLesHorsFrais($idvisiteur, $mois);
    $totalFraisForfait = $pdo->getTotalLesFrais($idvisiteur, $mois);
    $total = $totalFraisHorsForfait + $totalFraisForfait;
    var_dump($totalFraisHorsForfait);
    var_dump($totalFraisForfait);
    var_dump($total);
    include 'vues/v_fraisValide.php';
    break;
    }
    
    