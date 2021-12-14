<script>
    function confirmAction(){
      var confirmed = confirm("Voulez vous supprimer ?");
      return confirmed;
}
</script>

<h1>Gérer les restaurants</h1>

<?php
foreach ($listeRestos as $unResto) {
    $lesTypesCuisineProposes = $unResto->getLesTypesCuisineProposes();
    $lesPhotos = $unResto->getLesPhotos();
    ?>
    <div class="card">
        <div>
            <a href="./?action=modifierRestaurants&idR=<?= $unResto->getIdR() ?>">Modifier</a>
            <a>&emsp;</a>
            <a style="text-decoration: none; color: red"  href="./?action=supprimerRestaurants&idR=<?= $unResto->getIdR() ?>" onClick="return confirmAction()">Supprimer</a>
            
        </div>
        
        <hr>
        
        <div class="descrCard">
            <a href="./?action=detail&idR=<?= $unResto->getIdR() ?>"><?= $unResto->getNomR() ?></a>
            <br />
            <?= $unResto->getNumAdr() ?>
            <?= $unResto->getVoieAdr() ?>
            <br />
            <?= $unResto->getCpR() ?>
            <?= $unResto->getVilleR() ?>
        </div>
        
        
        <div class="tagCard">
            <ul id="tagFood">		
                <?php
                foreach ($lesTypesCuisineProposes as $unTC) {
                    ?>
                    <li class="tag"><span class="tag">#</span><?= $unTC->getLibelleTC() ?></li>
                    <?php
                } ?>
            </ul>
        </div>
    </div>
    <?php
}
?>
<div class="card">
    <div class="descrCard">
        <a href="./?action=ajouterRestaurants" > Ajouter </a>
    </div>
</div>
