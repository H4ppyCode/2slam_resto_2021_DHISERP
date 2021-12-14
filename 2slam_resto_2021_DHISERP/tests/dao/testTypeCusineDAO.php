<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>TypeCuisineDAO : tests unitaires</title>
    </head>

    <body>

        <?php

        use modele\dao\TypeCuisineDAO;
        use modele\dao\Bdd;

        require_once '../../includes/autoload.inc.php';

        try {
            Bdd::connecter();
            ?>
            <h2>Test TypeCuisineDAO</h2>

            <h3>1- getOneById</h3>
            <?php $id = 3; ?>
            <p>Le type de cuisine n° <?=$id?></p>
            <?php
            $objet = TypeCuisineDAO::getOneById($id);
            var_dump($objet);
            ?>
            
            <h3>2- getAll</h3>
            <p>Tous les types de cuisine </p>
            <?php
            $lesObjets = TypeCuisineDAO::getAll();
            var_dump($lesObjets);
            ?>
            
            <h3>3- getAllPreferesByIdU</h3>
            <?php $idU = 6; ?>
            <p>Les types de cuisine que préfère l'utilisateur n° <?=$idU?></p>
            <?php
            $lesObjets = TypeCuisineDAO::getAllPreferesByIdU($idU);
            var_dump($lesObjets);
            ?>
            
            <h3>4- getAllNonPreferesByIdU</h3>
            <p>Les type de cuisine que NE préfère PAS l'utilisateur n° <?=$idU?></p>
            <?php
            $lesObjets = TypeCuisineDAO::getAllNonPreferesByIdU($idU);
            var_dump($lesObjets);
            ?>
            
            <h3>5- getAllProposesByIdR</h3>
            <?php $idR = 11; ?>
            <p>Les type de cuisine proposés par le restaurant n° <?=$idR?></p>
            <?php
            $lesObjets = TypeCuisineDAO::getAllProposesByIdR($idR);
            var_dump($lesObjets);
            
            
            
            Bdd::deconnecter();
        } catch (Exception $ex) {
            ?>
            <h4>*** Erreur récupérée : <br/> <?= $ex->getMessage() ?> <br/>***</h4>
            <?php
        }
        ?>

    </body>
</html>
