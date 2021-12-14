<?php
use modele\dao\Bdd;
use modele\dao\UtilisateurDAO;

/**
 * Contrôleur monProfil
 * Page d'affichage des caractéristiques d'un utilisateur
 * 
 * Vue contrôlée : vueMonProfil
 * Données GET : 
 * 
 * @version 07/2021 intégration couche modèle objet
 * @version 08/2021 gestion erreurs
 */


Bdd::connecter();

if ($_SESSION["Admin"] != true){
        header('Location: ./?action=accueil');
}

// Récupération des données GET, POST, et SESSION

// Récupération des données utilisées dans la vue 
// creation du menu burger
$menuBurger = array();
$menuBurger[] = Array("url"=>"./?action=admin","label"=>"Consulter mon profil");
$menuBurger[] = Array("url"=>"./?action=updProfilAdmin","label"=>"Modifier mon profil");
$menuBurger[] = Array("url"=>"./?action=gererLesUtilisateurs","label"=>"Gérer les utilisateurs");
$menuBurger[] = Array("url"=>"./?action=gererLesRestaurants","label"=>"Gérer les restaurants");
$menuBurger[] = Array("url"=>"./?action=updTypeCuisine","label"=>"Gérer les types de cuisine");
// Construction de la vue
$titre = "Mon profil admin";
if (isLoggedOn()){
    // Si un utilisateur est connecté
    // Données spécifiques à la page vueMonProfil
    $idU = getIdULoggedOn();
    $mailU = getMailULoggedOn();
    $util = UtilisateurDAO::getOneById($idU);   
    $mesRestosAimes = $util->getLesRestosAimes();
    $mesTypeCuisinePreferes = $util->getLesTypesCuisinePreferes();
    // Construction de la vue
    require_once "$racine/vue/entete.html.php";
    require_once "$racine/vue/admin/vueMonProfilAdmin.php";
 }
else{
    // Si un aucun utilisateur n'est connecté
    // Construction de la vue
    ajouterMessage("Profil : aucun utilisateur n'est connecté");
    require_once "$racine/vue/entete.html.php";
}
require_once "$racine/vue/pied.html.php";

?>