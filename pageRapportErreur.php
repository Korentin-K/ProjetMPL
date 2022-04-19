<?php
require_once "fonctions.php";
writeHeaderHtml("Rapport d'erreur",4);
?>
<body>
    <div class="d-flex row flex-wrap">
    	<form action="envoieRapport.php" method="POST">
    		objet du rapport: 
    		<input type="text" name="objetRapport">
    		description du rapport: 
    		<input type="text" name="descriptionRapport">
    		<input type="submit" name="buttonEnvoieRapport" value="Envoyer">
    	</form>
    </div>
</div>
</body>
<?php writeFooterHtml(); ?>