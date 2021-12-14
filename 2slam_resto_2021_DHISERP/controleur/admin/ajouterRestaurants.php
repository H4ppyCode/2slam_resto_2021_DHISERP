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


if (isset($_POST["nomR"], $_POST["numAdrR"], $_POST["voieAdrR"], $_POST["cpR"], $_POST["villeR"], $_POST["descR"], $_POST["horaireR"])){
    $unResto = new modele\metier\Resto(0, $_POST["nomR"], $_POST["numAdrR"], $_POST["voieAdrR"], $_POST["cpR"],
        $_POST["villeR"], 0, 0, $_POST["descR"], $_POST["horaireR"], );
    RestoDAO::insertResto($unResto);
    header('Location: ./?action=gererLesRestaurants');
}


// Construction de la vue
$titre = "Ajouter un restaurant";
require_once "$racine/vue/entete.html.php";
require_once "$racine/vue/admin/vueAjouterRestaurants.php";
require_once "$racine/vue/pied.html.php";

?>
