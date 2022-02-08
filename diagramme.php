<?php
require_once "fonctions.php";

writeHeaderHtml("diagramme MPM",2);
$idProjet = "11";
// loadFakeData();
?>
<body >  
<?php   ?>
    <div class="container-fluid mx-0 px-0">
        <?php writeNavBar(); ?>
    </div>
    <div class="row col-12 mx-0 divlevel">
        <div class="d-flex flex-wrap align-content-start col-2 px-0"> 
            <!-- Ajouter un niveau au projet -->
            <button type="button" class="d-flex col-12 collapsible" >
                <div class="col-10 ps-4">Ajouter un niveau</div>
                <div class="col-2 d-flex justify-content-end align-items-center pe-4"><i class="iconLeftMenu far fa-plus-square"></i></div>
            </button>                
            <div class="content col-12">
                <div class="mb-3 col-8">
                    <label for="nameLevel" class="form-label">Nom du niveau</label>
                    <input type="text" class="form-control" id="nameLevel" name="nameLevel" >
                </div>
                <div class="col-12 d-flex justify-content-end"><button onclick="addLevel();" class="btn btnSubmitForm">Ajouter</button></div>
            </div>
            <!-- Ajouter une tache à un niveau -->
            <button type="button" class="d-flex col-12 collapsible" >
                <div class="col-10 ps-4">Ajouter une tâche</div>
                <div class="col-2 d-flex justify-content-end align-items-center pe-4"><i class="iconLeftMenu far fa-plus-square"></i></div>
            </button>                
            <div class="content">
                <div class="mb-3 col-12">    
                    <label for="idLevelAddTask" class="form-label">Niveau</label>                   
                    <select class="form-select" id="idLevelAddTask" name="idLevelAddTask">
                        <?php 
                        echo getLevelByIdProjet($idProjet,"select");                            
                        ?>                        
                    </select>
                    <label for="nameTask" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nameTask" name="nameTask" >
                    <label for="descTask" class="form-label">Description</label>
                    <div class="form-floating">
                        <textarea class="form-control" id="descTask" name="descTask" ></textarea>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-end"><button onclick="addTask();" class="btn btnSubmitForm">Ajouter</button></div>
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
        $.ajax({
            url : 'ajax_treatment.php',
            type : 'POST',
            data : {
                add : 1,
                task : name.value,
                desc : desc.value,
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
    function modifyTask(idTask){
        console.log("modification de : "+idTask)
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
</script>

<?php writeFooterHtml(); ?>

