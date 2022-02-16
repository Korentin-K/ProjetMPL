<?php
require_once "fonctions.php";
session_start();
writeHeaderHtml("diagramme MPM",2);
// $idUser=$_SESSION['User'];
$idUser=0;
$idProjet = "21";
// loadFakeData();
?>
<body >  
<?php   ?>
    <div class="container-fluid mx-0 px-0">
        <?php writeNavBar($idUser); ?>
     <!-- <?php //writeNavBar($_SESSION['User']); ?> !-->

    </div>
    <div class="row col-12 mx-0 divlevel">
        <div class="d-flex flex-wrap align-content-start col-2 px-0"> 
            <!-- Ajouter un niveau au projet -->
            <button id="buttonAddLevelMenu" type="button" class="d-flex col-12 collapsible" >
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
            </div>
            <!-- Ajouter une tache à un niveau -->
            <button id="buttonAddTaskMenu" type="button" class="d-flex col-12 collapsible" >
                <div id="titleMenuTask" class="col-10 ps-4">Ajouter une tâche</div>
                <div class="col-2 d-flex justify-content-end align-items-center pe-4"><i class="iconLeftMenu far fa-plus-square"></i></div>
            </button>                
            <div id="taskContent" class="content">
                <div class="mb-3 col-12">    
                    <label for="idLevelAddTask" class="form-label">Niveau</label>                   
                    <select class="form-select" id="idLevelAddTask" name="idLevelAddTask" >
                        <?php 
                        echo getLevelByIdProjet($idProjet,"select");                            
                        ?>                        
                    </select>
                    <label for="nameTask" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nameTask" name="nameTask" >
                    <div class="d-flex col-12 justify-content-between">
                         <div class="col-5 d-flex flex-wrap">
                            <label for="letterTask" class="form-label">Réf.</label>
                            <input type="text" class="form-control" id="letterTask" name="letterTask" placeholder="auto" disabled>
                        </div>
                        <div class="col-5 d-flex flex-wrap">                        
                            <label for="dureeTask" class="form-label">Durée</label>
                            <input type="text" class="form-control" id="dureeTask" name="dureeTask" >
                        </div>                        
                    </div>
                    <label for="parentTask" class="form-label">Tache antérieur (TXX,..)</label>
                    <input type="text" class="form-control" id="parentTask" name="parentTask" >
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
        <?php echo getLevelByIdProjet($idProjet,"view");  ?>
        </div>
    </div>
</body>
<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;
    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        });
    }
    function reloadLevelSelect(){
        $.ajax({
            url : 'ajax_treatment.php',
            type : 'POST',
            data : {
                reload : 1,
                type : "level",
                projet : <?php echo $idProjet;?>
                } ,
            success : function(data){
                document.getElementById('idLevelAddTask').innerHTML = "";
                document.getElementById('idLevelAddTask').innerHTML = data;    
            },
            error : function(resultat, statut, erreur){
                console.log(erreur)
            }
        });     
    }
    // Ajout niveau asynchrone
    function addLevel(){
        var name = document.getElementById('nameLevel')
        $.ajax({
            url : 'ajax_treatment.php',
            type : 'POST',
            data : {
                add : 1,
                level : name.value,
                projet : <?php echo $idProjet;?>
                } ,
            success : function(data){
                name.value = "";
                document.getElementById('projetView').innerHTML = "";
                document.getElementById('projetView').innerHTML = data;    
                reloadLevelSelect()           
            },
            error : function(resultat, statut, erreur){
                console.log(erreur)
            }
        });     
    }   
    // Ajout tache asynchrone
    function addTask(){
        var idLevel = document.getElementById('idLevelAddTask')
        var name = document.getElementById('nameTask')
        var desc = document.getElementById('descTask')
        var duree = document.getElementById('dureeTask')
        var parent = document.getElementById('parentTask')
        $.ajax({
            url : 'ajax_treatment.php',
            type : 'POST',
            data : {
                add : 1,
                task : name.value,
                desc : desc.value,
                time : duree.value,
                parent : parent.value,
                idLevel : idLevel.value,
                projet : <?php echo $idProjet;?>
                } ,
            success : function(data){
                idLevel.value = "-1"
                name.value = "";
                desc.value = "";
                document.getElementById('projetView').innerHTML = "";
                document.getElementById('projetView').innerHTML = data;                
            },
            error : function(resultat, statut, erreur){
                console.log(erreur)
            }
        });     
    } 
    // modification tache
    function modifyTask(id){
        var addMenu = document.getElementById('buttonAddTaskMenu')       
        var cancelForm = document.getElementById('btnCancelTask')       
        var contentMenu = document.getElementById('taskContent')
        contentMenu.style.display = "none" 
        cancelForm.hidden = false  
        $.ajax({
            url : 'ajax_treatment.php',
            type : 'POST',
            data : {
                modify : 1,
                update : 0,
                idTask : id,              
                projet : <?php echo $idProjet;?>} ,
            success : function(data){ 
                addMenu.click()
                var json = JSON.parse(data)[0]
                document.getElementById('titleMenuTask').innerHTML = "Modification de tâche"
                document.getElementById('idLevelAddTask').value = json['id_niveau_tache'] 
                document.getElementById('nameTask').value = json['nom_tache'] 
                document.getElementById('descTask').value = json['contenu_tache']
                document.getElementById('dureeTask').value = json['duree_tache']
                document.getElementById('parentTask').value = json['tacheAnterieur_tache']
                document.getElementById('btnSubmitTask').innerHTML = "Modifier"
                document.getElementById('btnSubmitTask').setAttribute('onclick', 'updateTask('+id+');')
            },
            error : function(resultat, statut, erreur){
                console.log("error :")
                console.log(erreur)
            }
        });
    }
    // Enregistrement changement tache
    function updateTask(id){ 
        var idLevel = document.getElementById('idLevelAddTask')
        var name = document.getElementById('nameTask')
        var desc = document.getElementById('descTask')
        var duree = document.getElementById('dureeTask')
        var parent = document.getElementById('parentTask')
        $.ajax({
            url : 'ajax_treatment.php',
            type : 'POST',
            data : {
                modify : 1,
                update : 1,
                idTask : id,
                task : name.value,
                desc : desc.value,
                time : duree.value,
                parent : parent.value,
                idTaskLevel : idLevel.value,             
                projet : <?php echo $idProjet;?>} ,
            success : function(data){ 
                document.getElementById('buttonAddTaskMenu').click()               
                document.getElementById('projetView').innerHTML = "";
                document.getElementById('projetView').innerHTML = data; 
                resetMenuAddTask()  
            },
            error : function(resultat, statut, erreur){
                console.log("error :")
                console.log(erreur)
            }
        });
    }
    // modification niveau
    function modifyLevel(id){
        var addMenu = document.getElementById('buttonAddLevelMenu')       
        var cancelForm = document.getElementById('btnCancelLevel')       
        var contentMenu = document.getElementById('levelContent')
        contentMenu.style.display = "none" 
        cancelForm.hidden = false  
        $.ajax({
            url : 'ajax_treatment.php',
            type : 'POST',
            data : {
                modify : 1,
                update : 0,
                idLevel : id,              
                projet : <?php echo $idProjet;?>} ,
            success : function(data){ 
                addMenu.click()
                console.log(data)
                var json = JSON.parse(data)[0]
                console.log(json)
                console.log(json['nom_tache'])
                document.getElementById('titleMenuLevel').innerHTML = "Modification de niveau"
                document.getElementById('nameLevel').value = json['nom_niveau'] 
                document.getElementById('btnSubmitLevel').innerHTML = "Modifier"
                document.getElementById('btnSubmitLevel').setAttribute('onclick', 'updateLevel('+id+');')
            },
            error : function(resultat, statut, erreur){
                console.log("error :")
                console.log(erreur)
            }
        });
    }    
    // Enregistrement changement niveau
    function updateLevel(id){ 
        var name = document.getElementById('nameLevel')
        $.ajax({
            url : 'ajax_treatment.php',
            type : 'POST',
            data : {
                modify : 1,
                update : 1,
                idLevel : id,
                level : name.value,                           
                projet : <?php echo $idProjet;?>} ,
            success : function(data){ 
                document.getElementById('buttonAddLevelMenu').click()               
                document.getElementById('projetView').innerHTML = "";
                document.getElementById('projetView').innerHTML = data; 
                resetMenuAddLevel()  
            },
            error : function(resultat, statut, erreur){
                console.log("error :")
                console.log(erreur)
            }
        });
    }
    function resetMenuAddLevel(){
        document.getElementById('btnCancelLevel').hidden = true
        document.getElementById('levelContent').style.display = "none"   
        document.getElementById('titleMenuLevel').innerHTML = "Ajouter une tâche"
        document.getElementById('nameLevel').value = ""
        document.getElementById('btnSubmitLevel').innerHTML = "Ajouter"
        document.getElementById('btnSubmitLevel').setAttribute('onclick', 'addLevel();')
    }
    function resetMenuAddTask(){
        document.getElementById('btnCancelTask').hidden = true
        document.getElementById('taskContent').style.display = "none"   
        document.getElementById('titleMenuTask').innerHTML = "Ajouter une tâche"
        document.getElementById('idLevelAddTask').value = ""
        document.getElementById('nameTask').value = ""
        document.getElementById('descTask').value = ""
        document.getElementById('dureeTask').value = ""
        document.getElementById('parentTask').value = ""
        document.getElementById('btnSubmitTask').innerHTML = "Ajouter"
        document.getElementById('btnSubmitTask').setAttribute('onclick', 'addTask();')
    }
    // suprresion de niveau
    function deleteLevel(id){
        $.ajax({
            url : 'ajax_treatment.php',
            type : 'POST',
            data : {
                delete : 1,
                idLevel : id,              
                projet : <?php echo $idProjet;?>} ,
            success : function(data){   
                document.getElementById('projetView').innerHTML = "";
                document.getElementById('projetView').innerHTML = data;                
            },
            error : function(resultat, statut, erreur){
                console.log("error :")
                console.log(erreur)
            }
        });   
    }  
    // suprresion de tache
    function deleteTask(id){
        $.ajax({
            url : 'ajax_treatment.php',
            type : 'POST',
            data : {
                delete : 1,
                idTask : id,              
                projet : <?php echo $idProjet;?>} ,
            success : function(data){   
                document.getElementById('projetView').innerHTML = "";
                document.getElementById('projetView').innerHTML = data;                
            },
            error : function(resultat, statut, erreur){
                console.log("error :")
                console.log(erreur)
            }
        });   
    } 
    $("document").ready(function() {
        $(".task-item").draggable({
            revert: true,
            revertDuration:0,
            zIndex: 100,
            refreshPositions: true,
            helper: "clone",
              helper: function(e) {
                var original = $(e.target).hasClass("ui-draggable") ? $(e.target) :  $(e.target).closest(".ui-draggable");
                return original.clone().css({
                width: original.width()
                });                
            },
            start: function( event, ui ) {
                $(".ui-draggable").not(ui.helper.css("z-index", "1")).css("z-index", "0");
            },
          

        })
        $(".levelCol").droppable({
            accept: '.task-item',
            activeClass: "ui-hover",
            hoverClass: "ui-active",
            drop: function(event, ui) {
            $(this).append($(ui.draggable));
            }
        })
    }) 
</script>

<?php writeFooterHtml(); ?>

