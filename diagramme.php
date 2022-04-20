<?php
require_once "fonctions.php";
writeHeaderHtml("diagramme MPM",2);
checkAccessPermission();
$nomUser=$_SESSION['User'];
$idUser=0;
if(isset($_GET['projet']) && $_GET['projet']!="" ) $idProjet = intval($_GET['projet']);
else { // juste le temps du dev
    $p = new Projet;
    $idProjet = $p->customQuery("select * from projet limit 1")[0]["id_projet"];
}
//loadFakeData();
// echo $idProjet;
$projet = new Projet();
$nbProjet = $projet->count_element("projet");
$dataAvailable = true;
if($nbProjet == 0) $dataAvailable = false;

if($dataAvailable){
?>
<body >  
<?php   ?>
    <div class="container-fluid mx-0 px-0">
        <?php writeNavBar($nomUser); ?>
    </div>
    <div class="row col-12 mx-0 divlevel">
        <input id="idProjet" type="text" value="<?php echo $idProjet;?>" hidden>
        <div class="d-flex flex-wrap align-content-start col-2 px-0"> 
            <!-- Ajouter un niveau au projet -->
            <!-- <button id="buttonAddLevelMenu" type="button" class="d-flex col-12 collapsible" >
                <div id="titleMenuLevel" class="col-10 ps-4">Ajouter un niveau</div>
                <div class="col-2 d-flex justify-content-end align-items-center pe-4"><i class="iconLeftMenu far fa-plus-square"></i></div>
            </button>                
            <div id="levelContent" class="content col-12">
                <div class="mb-3 col-8">
                    <label for="nameLevel" class="form-label">Nom du niveau</label>
                    <input type="text" class="form-control" id="nameLevel" name="nameLevel" >
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button id="btnCancelLevel" onclick="resetMenuAddLevel();" class="btn btnCancelForm" hidden>Annuler</button>
                    <button id="btnSubmitLevel" onclick="addLevel();" class="btn btnSubmitForm">Ajouter</button>
                </div>
            </div> -->
            <!-- Ajouter une tache à un niveau -->
            <button id="buttonAddTaskMenu" type="button" class="d-flex col-12 collapsible" >
                <div id="titleMenuTask" class="col-10 ps-4">Ajouter une tâche</div>
                <div class="col-2 d-flex justify-content-end align-items-center pe-4"><i class="iconLeftMenu far fa-plus-square"></i></div>
            </button>                
            <div id="taskContent" class="content">
                <div class="mb-3 col-12">    
                    <label for="idLevelAddTask" class="form-label">Niveau</label>                   
                    <select class="form-select" id="idLevelAddTask" name="idLevelAddTask" disabled>
                        <?php 
                        echo getLevelByIdProjet($idProjet,"select");                            
                        ?>                        
                    </select>
                    <label for="nameTask" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nameTask" name="nameTask" >
                    <div class="d-flex col-12 justify-content-between align-items-end">
                         <div class="col-5 d-flex flex-wrap">
                            <label for="letterTask" class="form-label">Réf.</label>
                            <input type="text" class="form-control" id="letterTask" name="letterTask" placeholder="auto" disabled>
                        </div>
                        <div class="col-5 d-flex flex-wrap">                        
                            <label for="dureeTask" class="form-label">Durée</label>
                            <input type="text" class="form-control" id="dureeTask" name="dureeTask" >
                        </div>                        
                    </div>
                    <div class="d-flex col-12 justify-content-between">
                        <div class="col-10 d-flex flex-wrap">                     
                            <label for="parentTask" class="form-label">Tache antérieur
                            <a id="btnDeleteParent" class=" ps-2" >| Vider</label>
                            <input type="text" class="form-control" id="parentTask" name="parentTask" readonly>
                        </div>
                        <div class="d-flex align-items-end">                     
                            <a id="btnAddParent" class="btn btn-primary" ><i class="fas fa-plus-circle"></i></a>
                        </div>
                    </div>
                        
                    <!-- <div class="d-flex col-12 justify-content-between">
                        <div class="col-5 d-flex flex-wrap">
                            <label for="plusTotTask" class="form-label">Plus tôt</label>
                            <input type="text" class="form-control" id="plusTotTask" name="plusTotTask" >
                        </div>
                        <div class="col-5 d-flex flex-wrap">
                            <label for="plusTardTask" class="form-label">Plus Tard</label>
                            <input type="text" class="form-control" id="plusTardTask" name="plusTotTask" >
                        </div>
                    </div>                     -->
                    <label for="descTask" class="form-label">Description</label>
                    <div class="form-floating">
                        <textarea class="form-control pt-1" id="descTask" name="descTask" ></textarea>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button id="btnCancelTask" onclick="resetMenuAddTask();" class="btn btnCancelForm" hidden>Annuler</button>
                    <button id="btnSubmitTask" onclick="addTask();" class="btn btnSubmitForm">Ajouter</button>
                </div>
            </div>
        </div>
        <div id="projetView" class="d-flex col-10 displayDiagramme">
        <?php echo updateDiagrammeProjet($idProjet);  ?>
        </div>
    </div>
</body>
<script>
    var select = document.getElementById("idLevelAddTask")
    if(select.options.length == 0){
        select.disabled = true
    }
</script>
<?php }else { ?>
    <div class="row col-12 mx-0 divlevel">
            <h1>Pas de données...</h1>
    </div>
<?php } ?>
<?php writeFooterHtml(2); ?>

