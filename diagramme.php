<?php
require_once "fonctions.php";
require_once "models/Datafaker.php";

writeHeaderHtml("diagramme MPM",2);
new Projet;
new Niveau;
new Tache;
// $t = new Tache;
// var_dump($t->getNiveauByProjet());
// loadFakeData();
?>
<body >  
<?php   ?>
    <div class="container-fluid mx-0 px-0">
        <?php writeNavBar(); ?>
    </div>
    <div class="row col-12 mx-0 divlevel">
        <div class="d-flex col-2">  </div>
        <div class="d-flex col-10 displayDiagramme">
        <?php 
        // getLevelByIdProjet("1");
        // $nbrCol = 10;
        // for($i=0;$i<$nbrCol;$i++){
        //     addLevel($i,3);
        // } 
        ?>
        </div>
    </div>
</body>

<?php writeFooterHtml(); ?>

