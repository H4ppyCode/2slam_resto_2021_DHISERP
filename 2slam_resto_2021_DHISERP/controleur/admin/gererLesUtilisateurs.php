<?php

use modele\dao\Bdd;
use modele\dao\UtilisateurDAO;

/**
 * Contrôleur listeRestos
 * Gère l'affichage de la liste de tous les restaurants
 *
 * @version 09/2021 par NC
 */
Bdd::connecter();

if ($_SESSION["Admin"] != true) {
    header('Location: ./?action=accueil');
}

// creation du menu burger
$menuBurger = array();
$menuBurger[] = array("url" => "./?action=admin", "label" => "Consulter mon profil");
$menuBurger[] = array("url" => "./?action=updProfilAdmin", "label" => "Modifier mon profil");
$menuBurger[] = array("url" => "./?action=gererLesUtilisateurs", "label" => "Gérer les utilisateurs");
$menuBurger[] = array("url" => "./?action=gererLesRestaurants", "label" => "Gérer les restaurants");
$menuBurger[] = array("url" => "./?action=updTypeCuisine", "label" => "Gérer les types de cuisine");

if (isset($_POST["nomTag"])) {
    modele\dao\TypeCuisineDAO::insert($_POST["nomTag"]);
}

if (isset($_GET["id"]) && isset($_POST["supprimer"])) {
    UtilisateurDAO::delete($_GET["id"]);
}


$listeUsers = modele\dao\UtilisateurDAO::getAll();



// Construction de la vue
$titre = "Gérer les utilisateurs";
require_once "$racine/vue/entete.html.php";
require_once "$racine/vue/admin/vueGererLesUtilisateurs.php";
require_once "$racine/vue/pied.html.php";

