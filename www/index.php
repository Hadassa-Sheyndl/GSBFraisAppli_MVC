<?php
/**
 * Index du projet GSB
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @author Hadassa-Sheyndl DUPRAZ
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

require_once 'includes/fct.inc.php';
//appel d'une page  obligatoire sinon erreur fatale
require_once 'includes/class.pdogsb.inc.php';
session_start();
//fonction php qui sert a lancer la super globale session 
$pdo = PdoGsb::getPdoGsb();
//comme c'est un objet , il fait parti d'une classe
$estConnecteV = estConnecteV();
$estConnecteC = estConnecteC();

require 'vues/v_entete.php';
$uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_SPECIAL_CHARS);
if ($uc && !$estConnecteC && !$estConnecteV) {
    $uc = 'connexion';
} elseif (empty($uc)) {
    $uc = 'accueil';
}
switch ($uc) {
case 'connexion':
    include 'controleurs/c_connexion.php';
    break;
case 'accueil':
    include 'controleurs/c_accueil.php';
    break;
case 'gererFrais':
    include 'controleurs/c_gererFrais.php';
    break;
case 'etatFrais':
    include 'controleurs/c_etatFrais.php';
    break;
case 'validerFrais':
    include 'controleurs/c_validerFrais.php';
    break;
case 'mettreEnPaiement':
    include 'controleurs/c_mettreEnPaiement.php';
    break;
case 'deconnexion':
    include 'controleurs/c_deconnexion.php';
    break;
}
require 'vues/v_pied.php';
