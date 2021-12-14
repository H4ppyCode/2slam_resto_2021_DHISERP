<?php
/**
 * --------------
 * vueUpdProfil
 * --------------
 * 
 * @version 07/2021 par NB : intégration couche modèle objet
 * 
 * Variables transmises par le contrôleur detailResto contenant les données à afficher : 
  ----------------------------------------------------------------------------------------  */
/** @var Utilisateur  $util utilisateur à afficher */
/** @var array $mesTypeCuisinePreferes  */
/** @var array $mesRestosAimes  */
/** @var array $lesAutresTypesCuisine */
/**
 * Variables supplémentaires :  
  ------------------------- */
/** @var Resto $unResto */
/** @var TypeCuisine $unTC */
?>

<h1>Modifier mon profil</h1>

Mon adresse électronique : <?= $util->getMailU() ?> <br />
Mon pseudo : <?= $util->getPseudoU() ?> <br />
Mettre à jour mon pseudo : 
<form action="./?action=updProfil" method="POST">
    <input type="text" name="pseudoU" placeholder="Nouveau pseudo" /><br />
    <input type="submit" value="Enregistrer" />
    <hr>
    Mettre à jour mon mot de passe : <br />
    <input type="password" name="mdpU" placeholder="Nouveau mot de passe" /><br />
    <input type="password" name="mdpU2" placeholder="Confirmer la saisie" /><br />
    <input type="submit" value="Enregistrer" />
    
    <hr>

    Gerer les restaurants que j'aime : <br />
    <?php 
    for ($i = 0; $i < count($mesRestosAimes); $i++) { 
        $unResto = $mesRestosAimes[$i];
        ?>
    <input type="checkbox" name="lstidR[]" id="resto<?= $i ?>" value="<?= $unResto->getIdR() ?>" >
    <label for="resto<?= $i ?>"><?= $unResto->getNomR() ?></label><br />
    <?php 
    } ?>
    <input type="submit" value="Supprimer" />

    <hr>
    
    Les types de cuisine que je préfère : <br />
    <ul id="tagFood">
    <?php 
    for ($i = 0; $i < count($mesTypeCuisinePreferes); $i++) { 
        $unTC = $mesTypeCuisinePreferes[$i];
        ?>
        <input type="checkbox" name="delLstidTC[]" id="delType<?= $i ?>" value="<?= $unTC->getIdTC() ?>" >
        <label for="delType<?= $i ?>"><li class="tag"><span class="tag">#</span><?= $unTC->getLibelleTC() ?></li></label><br />
    <?php } ?>
    </ul>
    <br />
    <input type="submit" value="Supprimer" />
    <br /><br />
    
    
    <hr>
    
    Choisir d'autres types de cuisine : <br />
    <ul id="tagFood">
    <?php 
    for ($i = 0; $i < count($lesAutresTypesCuisine); $i++) { 
        $unTC = $lesAutresTypesCuisine[$i];
        ?>
        <input type="checkbox" name="addLstidTC[]" id="addType<?= $i ?>" value="<?= $unTC->getIdTC() ?>" >
        <label for="addType<?= $i ?>"><li class="tag"><span class="tag">#</span><?= $unTC->getLibelleTC() ?></li></label><br />
    <?php } ?>
    </ul>
    <br />
    <input type="submit" value="Ajouter" />
    <br /><br />
     
</form>


