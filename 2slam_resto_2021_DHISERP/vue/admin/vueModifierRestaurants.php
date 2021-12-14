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

<h1>Modifier le restaurant : <?= $unResto->getNomR() ?></h1>

<form action="./?action=modifierRestaurants&idR=<?= $unResto->getIdR() ?>" method="POST">
    Nom actuel : <?= $unResto->getNomR() ?><br />
    <input type="text" name="nomR" placeholder="Nouveau nom" /><br />
    <input type="submit" value="Enregistrer" />
    <hr>
    Adresse actuelle : <br />
    <?= $unResto->getNumAdr() ?>
    <?= $unResto->getVoieAdr() ?><br /> 
    <?= $unResto->getCpR() ?>
    <?= $unResto->getVilleR() ?><br />
    <input type="text" name="numAdrR" placeholder="Nouveau numéro de voie" /><br />
    <input type="text" name="voieAdrR" placeholder="Nouveau nom de rue" /><br />
    <input type="text" name="cpR" placeholder="Nouveau code postal" /><br />
    <input type="text" name="villeR" placeholder="Nouveau nom de ville" /><br />
    <input type="submit" value="Enregistrer" />
    <hr>
    Description actuelle : <br /> 
    <?= $unResto->getDescR() ?> <br /> 
    <input type="text" name="descR" placeholder="Nouvelle description" /><br />
    <input type="submit" value="Enregistrer" />
    <hr>
    Horaires actuels : <br /> 
    <?= $unResto->getHorairesR() ?> <br />
    
    <input style="width: 800px; height: 50px" type="text" name="horaireR" value='<?= $unResto->getHorairesR() ?>'/>
    <input type="submit" value="Enregistrer" />
    <hr>
    <br>
    Les types de cuisine proposer par le restaurant : <br />
    <br>
    <ul id="tagFood">
    <?php 
    for ($i = 0; $i < count($lesTypeCuisines); $i++) { 
        $unTC=$lesTypeCuisines[$i];
        ?>
        <input type="checkbox" name="delLstidTC[]" id="delType<?= $i ?>" value="<?= $unTC->getIdTC() ?>" >
        <label for="delType<?= $i ?>"><li class="tag"><span class="tag">#</span><?= $unTC->getLibelleTC() ?></li></label><br />
    <?php } ?>
    </ul>
    <br />
    <input type="submit" value="Supprimer" />
    
        <hr>
    
    Ajouter d'autres types de cuisine au restaurant: <br />
    <ul id="tagFood">
    <?php 
    for ($i = 0; $i < count($toutLesTypes); $i++) { 
        $unTC = $toutLesTypes[$i];
        ?>
        <input type="checkbox" name="addLstidTC[]" id="addType<?= $i ?>" value="<?= $unTC->getIdTC() ?>" >
        <label for="addType<?= $i ?>"><li class="tag"><span class="tag">#</span><?= $unTC->getLibelleTC() ?></li></label><br />
    <?php } ?>
    </ul>
    <br />
    <input type="submit" value="Ajouter" />
    
    
<!--    <table>
    <thead>
        <tr>
            <th>Ouverture</th><th>Semaine</th>	<th>Week-end</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="label">Midi</td>
            <td class="cell">de <input type="a" name="h1"> à <input type="a" name="h2"></td>
            <td class="cell">de <input type="a" name="h3"> à <input type="a" name="h4"></td>
        </tr>
        <tr>
            <td class="label">Soir</td>
            <td class="cell">de <input type="a" name="h5"> à <input type="a" name="h6"></td>
            <td class="cell">de <input type="a" name="h7"> à <input type="a" name="h8"></td>	
        </tr>
        <tr>
            <td class="label">À emporter</td>
            <td class="cell">de <input type="a" name="h9"> à <input type="a" name="h10"></td>
            <td class="cell">de <input type="a" name="h11"> à <input type="a" name="h12"></td>
        </tr>
    </tbody>
</table>-->
    

</form>


