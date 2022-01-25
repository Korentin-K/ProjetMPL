<?php
require_once "fonctions.php";
writeHeaderHtml("diagramme MPM",2);
?>

<body class="container-fluid d-flex">
    
<?php 
$nbrCol = 10;
for($i=0;$i<$nbrCol;$i++){
    addLevel($i);
} ?>
    
</body>

<?php writeFooterHtml(); ?>

