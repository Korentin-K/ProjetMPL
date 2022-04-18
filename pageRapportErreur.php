<?php
require_once "fonctions.php";
writeHeaderHtml('dashboard',4);
?>
<body>
    <div class="d-flex row flex-wrap">
    	<form action="envoieRapport.php" method="POST">
    		<input type="text" name="objetRapport">
    		<input type="text" name="descriptionRapport">
    		<input type="submit" name="buttonEnvoieRapport" value="">
    	</form>
    </div>
</div>
</body>
<?php writeFooterHtml(); ?>