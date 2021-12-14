<?php
/**
 * --------------
 * vueMonProfil
 * --------------
 * 
 * @version 07/2021 par NB : intégration couche modèle objet
 * 
 * Variables transmises par le contrôleur detailResto contenant les données à afficher : 
  ---------------------------------------------------------------------------------------- */
/** @var Utilisateur  $util utilisteur à afficher */
/** @var array $mesTypeCuisinePreferes  */
/** @var array $mesRestosAimes  */
/** @var int $idU  */
/** @var string $mailU  */
/**
 * Variables supplémentaires :  
  ------------------------- */
/** @var Resto $unResto */
/** @var TypeCuisine $unTC */
?>

<h1>Mon profil</h1> 

Mon adresse électronique : <?= $util->getMailU() ?> <br />
Mon pseudo : <?= $util->getPseudoU() ?> <br />

<hr>

les restaurants que j'aime : <br />
<?php
foreach ($mesRestosAimes as $unResto) {
    ?>
    <a href="./?action=detail&idR=<?= $unResto->getIdR() ?>"><?= $unResto->getNomR() ?></a><br />
    <?php
}
?>
<hr>
les types de cuisine que j'aime : 
<ul id="tagFood">		
<?php
foreach($mesTypeCuisinePreferes as $unTC){
    ?>
    <li class="tag"><span class="tag">#</span><?= $unTC->getLibelleTC() ?></li>
    <?php
}
?>
</ul>
<hr>
<a href="./?action=deconnexion">se deconnecter</a><br />

