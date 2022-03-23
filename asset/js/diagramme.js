var idProjet = document.getElementById("idProjet").value;
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
            projet : idProjet
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
            projet : idProjet
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
            projet : idProjet
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
            projet : idProjet} ,
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
            projet : idProjet} ,
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
            projet : idProjet} ,
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
            projet : idProjet} ,
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
            projet : idProjet} ,
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
            projet : idProjet} ,
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

// var line = new LeaderLine(
//     document.getElementById('taskItem_41'),
//     document.getElementById('taskItem_42')
//   );
  