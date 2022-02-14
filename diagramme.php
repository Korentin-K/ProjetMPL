<?php
require_once "fonctions.php";
require_once "models/Datafaker.php";

writeHeaderHtml("diagramme MPM",2);
new Projet;
new Niveau;
new Tache;
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
        getLevelByIdProjet("1");
        // $nbrCol = 10;
        // for($i=0;$i<$nbrCol;$i++){
        //     addLevel($i,3);
        // } 
        ?>
        </div>
    </div>
</body>
<?php //j'ai mis ça ici en attendant je sais que c'est à mettre dans les fonctions mais 
        // je voulais revoir avec toi ce qui est draggable ou non ?>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#draggable" ).draggable();
  } );
  </script>
<?php writeFooterHtml(); ?>

