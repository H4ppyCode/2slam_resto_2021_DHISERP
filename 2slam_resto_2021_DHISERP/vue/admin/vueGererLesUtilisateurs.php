<h1>Gérer les Utilisateurs</h1>

<table>
    <tr>
        <th>Pseudo</th>
        <th>Email</th>
        <th></th>
    </tr>
    <?php
    foreach ($listeUsers as $unUser) {
        ?>
        <tr>
            <td>
                <?= $unUser->getPseudoU() ?>
            </td>
            <td><?= $unUser->getMailU() ?></td>
            <td>
                <form action='./?action=gererLesUtilisateurs&id=<?= $unUser->getIdU() ?>' method='post'>
                    <button type='submit' name='supprimer'>Supprimer</button>
                </form>
            </td>
        </tr>
        <?php
    }
    ?>

</table>
