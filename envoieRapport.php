<?php
require_once "models/rapportErreur.php";

$rapport= new rapport;
$rapport->creationRapportErreur($_POST['objetRapport'],$_POST['descriptionRapport']);
header('Location: ./pageRapportErreur.php');
exit();

?>