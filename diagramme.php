<?php
require_once "fonctions.php";
require_once "models/Niveau.php";
writeHeaderHtml("diagramme MPM",2);
$t = new Niveau;

$data = $t->findBy("nom","id_niveau>0");
foreach ($data as $row) {
    echo $row['nom']."<br />\n";
}
?>
<body >    
    <div class="container-fluid mx-0 px-0">
        <?php writeNavBar(); ?>
    </div>
    <div class="row col-12 mx-0 divlevel">
        <div class="d-flex col-2">  </div>
        <div class="d-flex col-10 displayDiagramme">
        <?php 
        $nbrCol = 10;
        for($i=0;$i<$nbrCol;$i++){
            addLevel($i,3);
        } ?>
        </div>
    </div>
</body>

<?php writeFooterHtml(); ?>

