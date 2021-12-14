
<?php
use modele\dao\Bdd;
use modele\dao\RestoDAO;

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

// appel des fonctions permettant de recuperer les donnees utiles a l'affichage 
$listeRestos =  RestoDAO::getAll();


// Construction de la vue
$titre = "Gérer les restaurants";
require_once "$racine/vue/entete.html.php";
require_once "$racine/vue/admin/vueGererLesRestaurants.php";
require_once "$racine/vue/pied.html.php";

?>