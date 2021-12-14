
<h1>Gérer les types de cuisine</h1>

<table>
    <?php
    foreach ($listeTypesCuisine as $unTypeCuisine) {
        ?>
        <tr>

            <th>
                <ul id="tagFood">		
                    <li class="tag"><span class="tag">#</span><?= $unTypeCuisine->getLibelleTC() ?></li>
                </ul>
            </th>
            <th>
                <form action='./?action=updTypeCuisine&idTC=<?= $unTypeCuisine->getIdTC() ?>' method='post'> 
                    <button type='submit' name='supprimer'>Supprimer</button>
                </form>
            </th>

        </tr>
        <?php
    }
    ?>
    <tr>
        <th>
            <form action='./?action=updTypeCuisine' name="formTag" method='post'> 
                <input name="nomTag">
            </form>
        </th>
        <th>
            <button onclick="document.formTag.submit();">Ajouter</button>
        </th>

    </tr>
</table>
