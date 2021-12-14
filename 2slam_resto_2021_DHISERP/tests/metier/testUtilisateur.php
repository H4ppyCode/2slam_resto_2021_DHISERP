<?php
use \modele\metier\Utilisateur;
use modele\metier\TypeCuisine;
require_once '../../includes/autoload.inc.php';
$desTC = array();
$desTC[] = new TypeCuisine(3, "Orientale");
$desTC[] = new TypeCuisine(9, "Tarte");
$user = new Utilisateur(6, 'test@bts.sio', 'seSzpoUAQgIl', 'testeur SIO');
$user->setLesTypesCuisinePreferes($desTC)
?>
<h2>Test unitaire de la classe Utilisateur</h2>
<?php
var_dump($user);

