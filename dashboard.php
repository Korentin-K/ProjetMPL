<?php
require_once "fonctions.php";
require_once "models/Dashboard.php";
writeHeaderHtml('dashboard',4);
$nomPersonne=$_SESSION['User'];
?>
<body >    
    <?php writeNavBar($nomPersonne); ?>
    <div class="d-flex row flex-wrap">
        <div class="bloc-panel col-4">

        </div>
        <div class="bloc-list col">
           <?php tableauProjet($_SESSION['User'] ); ?>
        </div>
    </div>
  </body>
<?php writeFooterHtml(); ?>