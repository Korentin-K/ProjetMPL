<?php
require_once "fonctions.php";
writeHeaderHtml("diagramme MPM",2);
?>
<body class="">
    <div class="container-fluid mx-0 px-0">
        <?php writeNavBar(); ?>
    </div>
    <div class="row col-12 divlevel">
        <div class="d-flex col-3">  </div>
        <div class="d-flex col-9 displayDiagramme">
        <?php 
        $nbrCol = 10;
        for($i=0;$i<$nbrCol;$i++){
            addLevel($i);
        } ?>
        </div>
    </div>
</body>

<?php writeFooterHtml(); ?>

