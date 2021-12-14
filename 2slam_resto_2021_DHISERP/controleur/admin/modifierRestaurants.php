<?php
use modele\dao\Bdd;
use modele\dao\RestoDAO;
use modele\dao\ProposerDAO;
use modele\dao\TypeCuisineDAO;


/**
 * Contrôleur listeRestos
 * Gère l'affichage de la liste de tous les restaurants
 * 
 * @version 09/2021 par NC
 */
Bdd::connecter();

if ($_SESSION["Admin"] != true){
        header('Location: ./?action=accueil');
}

// creation du menu burger
$menuBurger = array();
$menuBurger[] = Array("url"=>"./?action=admin","label"=>"Consulter mon profil");
$menuBurger[] = Array("url"=>"./?action=updProfilAdmin","label"=>"Modifier mon profil");
$menuBurger[] = Array("url"=>"./?action=gererLesUtilisateurs","label"=>"Gérer les utilisateurs");
$menuBurger[] = Array("url"=>"./?action=gererLesRestaurants","label"=>"Gérer les restaurants");
$menuBurger[] = Array("url"=>"./?action=updTypeCuisine","label"=>"Gérer les types de cuisine");

$idResto = intval($_GET["idR"]);
$unResto = RestoDAO::getOneById($idResto);
$lesTypeCuisines = $unResto->getLesTypesCuisineProposes();
//$toutLesTypes = TypeCuisineDAO::getAll();
$toutLesTypes=TypeCuisineDAO::getAllNonProposerByIdR($idResto);
if (isset($_POST["nomR"])){
    $nomR = $_POST["nomR"];
    if ($nomR !=""){
       $unResto->setNomR($nomR);
        RestoDAO::updateResto($unResto);
    }
}

if (isset($_POST["numAdrR"])){
    $numAdrR = $_POST["numAdrR"];
    if ($numAdrR !=""){
        $unResto->setNumAdr($numAdrR);
        RestoDAO::updateResto($unResto);
    }
}

if (isset($_POST["voieAdrR"])){
    $voieAdrR = $_POST["voieAdrR"];
    if ($voieAdrR !=""){
        $unResto->setVoieAdr($voieAdrR);
        RestoDAO::updateResto($unResto);
    }
}

if (isset($_POST["cpR"])){
    $cpR = $_POST["cpR"];
    if ($cpR !=""){
        $unResto->setCpR($cpR);
        RestoDAO::updateResto($unResto);
    }
}

if (isset($_POST["villeR"])){
    $villeR = $_POST["villeR"];
    if ($villeR !=""){
        $unResto->setVilleR($villeR);
        RestoDAO::updateResto($unResto);
    }
}

if (isset($_POST["descR"])){
    $descR = $_POST["descR"];
    if ($descR !=""){
        $unResto->setDescR($descR);
        RestoDAO::updateResto($unResto);
    }
}

if (isset($_POST["horaireR"])){
    $horaireR = $_POST["horaireR"];
    if ($horaireR !=""){
        $unResto->setHorairesR($horaireR);
        RestoDAO::updateResto($unResto);
    }
}

if (isset($_POST["delLstidTC"])) {
        $delLstidTC = $_POST["delLstidTC"];
        for ($i = 0; $i < count($delLstidTC); $i++) {
            ProposerDAO::delete($idResto, $delLstidTC[$i]);
            header('Location: ./?action=modifierRestaurants&idR='.$idResto);
        }
    }
    
    if (isset($_POST["addLstidTC"])) {
        $addLstidTC = $_POST["addLstidTC"];
        for ($i = 0; $i < count($addLstidTC); $i++) {
            ProposerDAO::insert($idResto, $addLstidTC[$i]);
            header('Location: ./?action=modifierRestaurants&idR='.$idResto);
        }
    }
// Construction de la vue
$titre = "Modifier un Restaurant";
require_once "$racine/vue/entete.html.php";
require_once "$racine/vue/admin/vueModifierRestaurants.php";
require_once "$racine/vue/pied.html.php";

?>
