
<?php
use modele\dao\Bdd;

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

if (isset($_POST["nomTag"]) && $_POST["nomTag"] != ""){
    modele\dao\TypeCuisineDAO::insert($_POST["nomTag"]);
}

if (isset($_GET["idTC"]) && isset($_POST["supprimer"])){
    modele\dao\TypeCuisineDAO::delete($_GET["idTC"]);
}

// appel des fonctions permettant de recuperer les donnees utiles a l'affichage 
$listeTypesCuisine = modele\dao\TypeCuisineDAO::getAll();


// Construction de la vue
$titre = "Gérer les types de cuisine";
require_once "$racine/vue/entete.html.php";
require_once "$racine/vue/admin/vueUpdTypeCuisine.php";
require_once "$racine/vue/pied.html.php";

?>