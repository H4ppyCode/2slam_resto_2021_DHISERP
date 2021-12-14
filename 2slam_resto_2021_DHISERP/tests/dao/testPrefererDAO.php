<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>PrefererDAO : tests unitaires</title>
    </head>

    <body>

        <?php

        use modele\dao\PrefererDAO;
        use modele\dao\Bdd;

        require_once '../../includes/autoload.inc.php';

        try {
            Bdd::connecter();
            ?>
            <h2>Test PrefererDAO</h2>

            <h3>1- insert</h3>
            <?php 
            $unIdTC = 2 ; $unIdU = 1; 
            $ok = PrefererDAO::insert($unIdU, $unIdTC)
            ?>
            Réussite de l'ajout : 
            <?php var_dump($ok); ?>
            
            
            <h3>3- delete</h3>
            <?php 
            $ok = PrefererDAO::delete($unIdU, $unIdTC)
            ?>
            Réussite de la suppression : 
            <?php var_dump($ok); 
            
            
            Bdd::deconnecter();
        } catch (Exception $ex) {
            ?>
            <h4>*** Erreur récupérée : <br/> <?= $ex->getMessage() ?> <br/>***</h4>
            <?php
        }
       
        ?>

    </body>
</html>
