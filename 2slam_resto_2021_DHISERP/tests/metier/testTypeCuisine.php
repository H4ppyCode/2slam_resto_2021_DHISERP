<?php
use modele\metier\TypeCuisine;
require_once '../../includes/autoload.inc.php'; 
$unTC = new TypeCuisine(3, "Orientale");
?>
<h2>Test unitaire de la classe TypeCuisine</h2>
<?php
var_dump($unTC);


