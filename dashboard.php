<?php
require_once "fonctions.php";
writeHeaderHtml("dashboard",4);
?>
<body >    
    <?php writeNavBar(); ?>
    <div class="d-flex row flex-wrap">
        <div class="bloc-panel col-4">

        </div>
        <div class="bloc-list col">
            <table>
                <tr>
                    <td>Nom du Projet</td>
                    <td>Date de création</td>
                </tr>
                <tr>
                </tr>
            </table>
        </div>
    </div>
  </body>

<?php writeFooterHtml(); ?>