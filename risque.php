<?php

require_once "fonctions.php";
writeHeaderHtml("Risque");
checkAccessPermission();
$nomUser=$_SESSION['User'];
?>
<body >  
<?php   ?>
    <div class="container-fluid mx-0 px-0">
        <?php writeNavBar($nomUser); ?>
    </div>
    <div class="d-flex col-12 justify-content-center flex-wrap">
        <div class="col-8  mx-0 d-flex flex-wrap justify-content-center risque mt-2 p-2">
            <div class="col-12 d-flex fw-bold h4">Ajout risque</div>
            <div class="col-6 d-flex justify-content-center flex-wrap">
                <input class="form-control" type="text" placeholder="Risque">
                <input class="form-control mt-2" type="text" placeholder="votre message">
            </div>
        </div>
        <div class="col-8 mx-0 d-flex flex-wrap justify-content-center risque mt-4 p-2">
            <div class="col-12 d-flex fw-bold h4">Historique</div>
            <div class="col-10 d-flex justify-content-center flex-wrap">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Type de risque</th>
                    <th scope="col">Message</th>
                    <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    </tr>
                    <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                    </tr>
                    <tr>
                    <th scope="row">3</th>
                    <td colspan="2">Larry the Bird</td>
                    <td>@twitter</td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

<?php writeFooterHtml(); ?>
