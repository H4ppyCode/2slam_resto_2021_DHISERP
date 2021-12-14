<?php

use modele\dao\Bdd;
use modele\dao\RestoDAO;
/**
 * Contrôleur detailResto
 * Page d'affichage des caractéristiques d'un restaurant
 * 
 * Vue contrôlée : vueDetailResto
 * Données GET : $idR identifiant du restaurant à afficher
 * 
 * @version 07/2021 intégration couche modèle objet
 * @version 08/2021 gestion erreurs
 */
Bdd::connecter();

if ($_SESSION["Admin"] != true){
        header('Location: ./?action=accueil');
}

if (!empty($_GET["idR"])){
    RestoDAO::deleteRestaurants($_GET["idR"]);
    header('Location: ./?action=gererLesRestaurants');
}

?>