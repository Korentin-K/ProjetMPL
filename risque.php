<?php

require_once "models/Models.php";
require_once "fonctions.php";
writeHeaderHtml("Risque");
checkAccessPermission();
$nomUser=$_SESSION['User'];

//-------------------- DEBUT : POST FORMULAIRE ------------------------
$type="";$nom="";$probabilite="";$severite="";$cout="";$proprietaire="";$detection="";$correction="";
if(isset($_POST['type_risque']) && $_POST['type_risque'] != "" ) $type=htmlspecialchars($_POST['type_risque']);
if(isset($_POST['nom_risque']) && $_POST['nom_risque'] != "" ) $nom=htmlspecialchars($_POST['nom_risque']);
if(isset($_POST['probabilite_risque']) && $_POST['probabilite_risque'] != "" ) $probabilite=htmlspecialchars($_POST['probabilite_risque']);
if(isset($_POST['severite_risque']) && $_POST['severite_risque'] != "" ) $severite=htmlspecialchars($_POST['severite_risque']);
if(isset($_POST['cout_risque']) && $_POST['cout_risque'] != "" ) $cout=htmlspecialchars($_POST['cout_risque']);
if(isset($_POST['proprietaire_risque']) && $_POST['proprietaire_risque'] != "" ) $proprietaire=htmlspecialchars($_POST['proprietaire_risque']);
if(isset($_POST['detection_risque']) && $_POST['detection_risque'] != "" ) $detection=htmlspecialchars($_POST['detection_risque']);
if(isset($_POST['correction_risque']) && $_POST['correction_risque'] != "" ) $correction=htmlspecialchars($_POST['correction_risque']);

if($type!=""){
    $model = new Models;
    $sql="INSERT INTO risque (id_risque, type_risque, nom_risque, probabilite_risque, severite_risque, cout_risque, proprietaire_risque, detection_risque, correction_risque, date_risque) 
    VALUES (NULL, '$type', '$nom', '$probabilite', '$severite', '$cout', '$proprietaire', '$detection', '$correction', NOW());";
    $model->customQuery($sql);                    
}
$_POST=null;
//-------------------- FIN : POST FORMULAIRE ------------------------
$typeRisque=["Ressources insuffisantes","Incidents opérationnels","Faibles performances","Manque de transparence","Dérive des objectifs","Coûts élevés","Délais serrés"];
$selectType="";
foreach($typeRisque as $risque){
    $selectType.="<option value='$risque'>$risque</option>";
}
$severite=["1","2","3","4"];
$selectSeverite="";
foreach($severite as $value){
    $selectSeverite.="<option value='$value'>$value</option>";
}
?>
<body >  
    <div class="container-fluid mx-0 px-0">
        <?php writeNavBar($nomUser); ?>
    </div>
    <div class="d-flex col-12 justify-content-center flex-wrap">
        <div class="col-8  mx-0 d-flex flex-wrap justify-content-center risque mt-2 p-2">
            <div class="col-12 d-flex fw-bold h4">Ajout risque</div>
            <form id="add_risque" class="col-10 d-flex justify-content-center flex-wrap" method="post" action="">
                <div class="flex-nowrap d-flex col-12 justify-content-between">
                    
                    <span class="col-5"><span class="fw-bolder">Type</span><select name="type_risque" class="form-select" type="text"><?= $selectType ?></select></span>
                    <span class="col-5"><span class="fw-bolder">Nom</span><input name="nom_risque" class="form-control" type="text" required></span>
                </div>
                <div class="flex-nowrap d-flex col-12 justify-content-between mt-2">
                    <span class="col-5"><span class="fw-bolder">Probabilité</span><input name="probabilité_risque" class="form-control" type="text" required></span>
                    <span class="col-5"><span class="fw-bolder">Sévérité</span><select name="type_risque" class="form-select" type="text"><?= $selectSeverite ?></select></span>
                </div>
                <div class="flex-nowrap d-flex col-12 justify-content-between mt-2">
                    <span class="col-5"><span class="fw-bolder">Coût</span><input name="cout_risque" class="form-control" type="text" required></span>
                    <span class="col-5"><span class="fw-bolder">Propriétaire</span><input name="proprietaire_risque" class="form-control" type="text" required></span>
                </div>
                <div class="flex-nowrap d-flex col-12 justify-content-between mt-2">
                    <span class="col-5"><span class="fw-bolder">Détection</span><input name="detection_risque" class="form-control" type="text" required></span>
                    <span class="col-5"><span class="fw-bolder">Correction</span><input name="correction_risque" class="form-control" type="text" required></span>
                </div>
                <div class="col-12 text-center"><button id="submit" class="btn btn-primary mt-2">Ajouter</button></div>
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
                    <th scope="col">Nom</th>
                    <th scope="col">Probabilité</th>
                    <th scope="col">Sévérité</th>
                    <th scope="col">Coût</th>
                    <th scope="col">Propriétaire</th>
                    <th scope="col">Détection</th>
                    <th scope="col">Correction</th>
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
