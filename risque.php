<?php

require_once "models/Models.php";
require_once "fonctions.php";
writeHeaderHtml("Risque");
checkAccessPermission();
$nomUser=$_SESSION['User'];

//-------------------- DEBUT : POST FORMULAIRE ------------------------
$type="";$message="";
if(isset($_POST['type_risque']) && $_POST['type_risque'] != "" ) $type=htmlspecialchars($_POST['type_risque']);
if(isset($_POST['message_risque']) && $_POST['message_risque'] != "" ) $message=htmlspecialchars($_POST['message_risque']);
if($type!="" && $message!=""){
    $model = new Models;
    $model->customQuery("INSERT INTO risque (id_risque, type_risque, message_risque, date_risque) VALUES (NULL, '$type', '$message', NOW());");                    
}
$_POST=null;
//-------------------- FIN : POST FORMULAIRE ------------------------

?>
<body >  
<?php   ?>
    <div class="container-fluid mx-0 px-0">
        <?php writeNavBar($nomUser); ?>
    </div>
    <div class="d-flex col-12 justify-content-center flex-wrap">
        <div class="col-8  mx-0 d-flex flex-wrap justify-content-center risque mt-2 p-2">
            <div class="col-12 d-flex fw-bold h4">Ajout risque</div>
            <form id="add_risque" class="col-6 d-flex justify-content-center flex-wrap" method="post" action="">
                <input name="type_risque" class="form-control" type="text" placeholder="Risque">
                <input name="message_risque" class="form-control mt-2" type="text" placeholder="votre message">
                <button id="submit" class="btn btn-primary mt-2">Ajouter</button>
            </form>
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
                <tbody id="tbody">
                  <?php echo displayTableRisque(); ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script>
    function deleteRisque(id){
        $.ajax({
        url : 'ajax_treatment.php',
        type : 'POST',
        data : {
            risque : 1,
            idRisque : id,
            delete : 1
            } ,
        success : function(data){
            document.getElementById('tbody').innerHTML = "";
            document.getElementById('tbody').innerHTML = data;   
        },
        error : function(resultat, statut, erreur){
            console.log(erreur)
        }
    });   
    }
</script>
<?php writeFooterHtml(); ?>
