<?php
/**
 * --------------
 * vueRechercheResto
 * --------------
 * 
 * @version 07/2021 par NB : intégration couche modèle objet
 * 
 * Variables transmises par le contrôleur rechercheResto contenant les données à afficher : 
  ----------------------------------------------------------------------------------------  */
/** @var string $critere (nom, adresse, type, multi) = critere de filtrage */
/** @var string $nomR nom du restaurant recherché */
/** @var string $villeR nom du restaurant recherché */
/** @var string $cpR nom du restaurant recherché */
/** @var string $voieAdrR nom du restaurant recherché */
/** @var array $mesTypeCuisinePreferes  */
/** @var array $lesAutresTypesCuisine */
/**
 * Variables supplémentaires :  
  ------------------------- */
/** @var TypeCuisine $unTC */
?>

<h1>Recherche d'un restaurant</h1>
<form action="./?action=recherche&critere=<?= $critere ?>" method="POST">


    <?php
    switch ($critere) {
        case "nom":
            ?>
            Recherche par nom : <br />
            <input type="text" name="nomR" placeholder="nom" value="<?= $nomR ?>" /><br />
            <?php
            break;
        case "adresse":
            ?>
            Recherche par adresse : <br />
            <input type="text" name="villeR" placeholder="ville" value="<?= $villeR ?>"/><br />
            <input type="text" name="cpR" placeholder="code postal" value="<?= $cpR ?>"/><br />
            <input type="text" name="voieAdrR" placeholder="rue" value="<?= $voieAdrR ?>"/><br />
            <?php
            break;
        case "type":
            ?> 
            Recherche par type de cuisine :<br />
            Selectionner un ou plusieurs types de cuisine<br />
            <?php
            // mes types de cuisine
//            foreach ($mesTypeCuisinePreferes as $unTC) {
            for ($i = 0; $i < count($mesTypeCuisinePreferes); $i++) {
                $unTC = $mesTypeCuisinePreferes[$i];
                if (count($tabIdTC) == 0) {
                    $check = "checked"; // on ne provient pas du formulaire de recherche
                } else {
                    $check = ""; // on provient du formulaire de recherche, checked sera peut etre fait dans la condition suivante

                    if (in_array($unTC->getIdTC(), $tabIdTC)) {
                        $check = "checked";
                    }
                }
                ?>
            <input type="checkbox" <?= $check ?> name="tabIdTC[]" id="aime<?= $i ?>" value="<?= $unTC->getIdTC() ?>" >
            <label for="aime<?= $i ?>"><?= $unTC->getLibelleTC() ?></label><br />
                <?php
            }
            // les autres types de cuisine
            for ($i = 0; $i < count($lesAutresTypesCuisine); $i++) {
                $unTC = $lesAutresTypesCuisine[$i];
                $check = "";
                if (in_array($unTC->getIdTC(), $tabIdTC)) {
                    $check = "checked";
                }
                ?>
                <input type="checkbox" <?= $check ?> name="tabIdTC[]" id="autres<?= $i ?>" value="<?= $unTC->getIdTC() ?>" >
                <label for="autres<?= $i ?>"><?= $unTC->getLibelleTC() ?></label><br />
                <?php
            }
            ?>  <br /><?php
            break;
        case "multi":
            ?>
            Recherche multi-critères<br />
            <input type="text" name="nomR" placeholder="nom du restaurant" value="<?= $nomR ?>"/>
            <input type="text" name="voieAdrR" placeholder="rue" value="<?= $voieAdrR ?>"/><br />
            <input type="text" name="cpR" placeholder="code postal" value="<?= $cpR ?>"/>
            <input type="text" name="villeR" placeholder="ville" value="<?= $villeR ?>"/>

            <br />
            <?php
            // mes types de cuisine
            for ($i = 0; $i < count($mesTypeCuisinePreferes); $i++) {
                $unTC = $mesTypeCuisinePreferes[$i];
                if (count($tabIdTC) == 0) {
                    $check = "checked"; // on ne provient pas du formulaire de recherche
                } else {
                    $check = ""; // on provient du formulaire de recherche, checked sera peut etre fait dans la condition suivante

                    if (in_array($unTC->getIdTC(), $tabIdTC)) {
                        $check = "checked";
                    }
                }
                ?>
            <input type="checkbox" <?= $check ?> name="tabIdTC[]" id="aime<?= $i ?>" value="<?= $unTC->getIdTC() ?>" >
            <label for="aime<?= $i ?>"><?= $unTC->getLibelleTC() ?></label><br />
                <?php
            }
            // les autres types de cuisine
            for ($i = 0; $i < count($lesAutresTypesCuisine); $i++) {
                $unTC = $lesAutresTypesCuisine[$i];
                $check = "";
                if (in_array($unTC->getIdTC(), $tabIdTC)) {
                    $check = "checked";
                }
                ?>
                <input type="checkbox" <?= $check ?> name="tabIdTC[]" id="autres<?= $i ?>" value="<?= $unTC->getIdTC() ?>" >
                <label for="autres<?= $i ?>"><?= $unTC->getLibelleTC() ?></label><br />
                <?php
            }
            break;
    }
    ?>
    <br /><br />
    <input type="submit" value="Rechercher" />

</form>
