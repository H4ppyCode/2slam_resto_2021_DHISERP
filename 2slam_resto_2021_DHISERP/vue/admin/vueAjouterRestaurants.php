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

<h1>Ajouter restaurant : </h1>

<form action='./?action=ajouterRestaurants&idR=1' method="POST">
    Nom du restaurant :<br />
    <input type="text" name="nomR" placeholder="nom" required="required"  /><br />
   numéro de voie : <br />
    <input type="text" name="numAdrR" placeholder=Numéro de voie" required="required"  /><br />
    Nom de rue : <br />
    <input type="text" name="voieAdrR" placeholder="Nom de rue" required="required"  /><br />
    Code postal : <br />
    <input type="text" name="cpR" placeholder="Code postal" required="required"  /><br />
    Nom de ville : <br />
    <input type="text" name="villeR" placeholder="Nom de ville" required="required"  /><br />
    Description : <br /> 
    <input type="text" name="descR" placeholder="description" required="required"  /><br />
    Horaires : <br /> 
    <input style="width: 800px; height: 50px" type="text" name="horaireR" value='<table>    <thead>        <tr>            <th>Ouverture</th><th>Semaine</th>	<th>Week-end</th>        </tr>    </thead>    <tbody>        <tr>            <td class="label">Midi</td>            <td class="cell">de ? à ?</td>            <td class="cell">de ? à ?</td>        </tr>        <tr>            <td class="label">Soir</td>            <td class="cell">de ? à ?</td>            <td class="cell">de ? à ?</td>	        </tr>        <tr>            <td class="label">À emporter</td>            <td class="cell">de ? à ?</td>            <td class="cell">de ? à ?</td>        </tr>    </tbody></table>'/>
    <input type="submit" value="Enregistrer">
    
    


</form>


