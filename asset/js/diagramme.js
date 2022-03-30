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
// Enregistrement changement tache depuis interface
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
// Enregistrement changement tache depuis interface
function switchTaskLevel(idLevel,idTask){     
    $.ajax({
        url : 'ajax_treatment.php',
        type : 'POST',
        data : {
            modify : 1,
            update : 1,
            idTask : idTask,
            idTaskLevel : idLevel,             
            projet : idProjet} ,
        success : function(data){ 
            document.getElementById('projetView').innerHTML = "";
            document.getElementById('projetView').innerHTML = data; 
            getParentAndDrawLine()

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


function drawLine(start,end){
    parent = "taskItem_"+start
    child = "taskItem_"+end
    line = new LeaderLine(
            document.getElementById(parent),
            document.getElementById(child)
          );
    line.path = 'fluid'
    line.setOptions({startSocket: 'right', endSocket: 'left'});
}

function getParentAndDrawLine(){
    var lines = document.querySelectorAll("[class='leader-line']")
    lines.forEach((line)=>{
        console.log(line)
        line.remove()
    })
    var elms = document.querySelectorAll("[id^='parent_']")
    elms.forEach((el)=>{
        id = el.id
        idTask = id.substr(id.indexOf('_')+1,id.length)
        console.log("el : "+idTask)
        idParent = el.value.split(',')
        console.log("idParent array : "+idParent)
        idParent.forEach((p)=>{
            console.log("p: "+p+" idTask: "+idTask)
            drawLine(p,idTask)
        })
        // console.log(idTask)
        // console.log(idParent)
    })
}

$("document").ready(function() {
    // $(".task-item").draggable({
    //     revert: true,
    //     revertDuration:0,
    //     zIndex: 100,
    //     refreshPositions: true,
    //     helper: "clone",
    //     helper: function(e) {
    //         var original = $(e.target).hasClass("ui-draggable") ? $(e.target) :  $(e.target).closest(".ui-draggable");
    //         return original.clone().css({
    //         width: original.width()
    //         });                
    //     },
    //     start: function( event, ui ) {
    //         $(".ui-draggable").not(ui.helper.css("z-index", "1")).css("z-index", "0");
    //     },
    

    // })
    // $(".levelCol").droppable({
    //     accept: '.task-item',
    //     activeClass: "ui-hover",
    //     hoverClass: "ui-active",
    //     drop: function(event, ui) {
    //     $(this).append($(ui.draggable));
    //     }
    // })
    // target elements with the "draggable" class
// interact('.draggable')
// .draggable({
//   // enable inertial throwing
//   inertia: true,
//   // keep the element within the area of it's parent
//   modifiers: [
//     interact.modifiers.restrictRect({
//       restriction: 'parent',
//       endOnly: true
//     })
//   ],
//   // enable autoScroll
//   autoScroll: true,
//   listeners: {
//     // call this function on every dragmove event
//     move: dragMoveListener,
//   }
// })

getParentAndDrawLine()

function dragMoveListener (event) {
var target = event.target
// keep the dragged position in the data-x/data-y attributes
var x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx
var y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy
// translate the element
target.style.transform = 'translate(' + x + 'px, ' + y + 'px)'
// update the posiion attributes
target.setAttribute('data-x', x)
target.setAttribute('data-y', y)
}

// enable draggables to be dropped into this
interact('.dropzone').dropzone({
    // only accept elements matching this CSS selector
    //accept: '#yes-drop',
    // Require a 75% element overlap for a drop to be possible
   // overlap: 0.75,
  
    // listen for drop related events:
  
    ondropactivate: function (event) {
      // add active dropzone feedback
      event.target.classList.add('drop-active')
    },
    ondragenter: function (event) {
      var draggableElement = event.relatedTarget
      var dropzoneElement = event.target
  
      // feedback the possibility of a drop
      dropzoneElement.classList.add('drop-target')
      draggableElement.classList.add('can-drop')
      draggableElement.textContent = 'Dragged in'
    },
    ondragleave: function (event) {
      // remove the drop feedback style
      console.log("drag leave")
      event.target.classList.remove('drop-target')
      event.relatedTarget.classList.remove('can-drop')
      event.relatedTarget.textContent = 'Dragged out'
    },
    ondrop: function (event) {
      console.log("on drop")
      idLevel = event.target.parentElement.id
      idTask = event.relatedTarget.id
      idLevel = idLevel.substr(idLevel.indexOf("_")+1,idLevel.length)
      idTask = idTask.substr(idTask.indexOf("_")+1,idTask.length)
    //   console.log(idLevel)
    //   console.log(idTask)
      switchTaskLevel(idLevel,idTask)
      event.relatedTarget.textContent = 'Dropped'
    },
    ondropdeactivate: function (event) {
      // remove active dropzone feedback
      event.target.classList.remove('drop-active')
      event.target.classList.remove('drop-target')
    }
  })
  
  interact('.draggable')
    .draggable({
      inertia: true,
      modifiers: [
        interact.modifiers.restrictRect({
          //restriction: 'parent',
          endOnly: true
        })
      ],
      autoScroll: true,
      // dragMoveListener from the dragging demo above
      listeners: { move: dragMoveListener }
    })
  
  //Snapping 

  //console.log(document.getElementById('taskItem_3872'))
}) 
// var line = new LeaderLine(
//     document.getElementById('taskItem_3877'),
//     document.getElementById('taskItem_3878')
//   );
function choiceParentTask(){

}
var choice = false
  $(document).ready(function () {
    var fieldParent = document.getElementById("parentTask")
    var tasks = document.querySelectorAll("[id^='taskItem_']")

    $("#btnAddParent").on('click', function (e) {
        choice = choice==false ? true : false;
        console.log(choice)
        if(choice){
            $(this).removeClass("btn-primary");
            $(this).addClass("isParent");
            $(this).html("<i class='fas fa-mouse-pointer'></i>");
            tasks.forEach((t)=>{
                $(t).addClass("choice")
            })
        }
        else {
            $(this).removeClass("isParent");
            $(this).addClass("btn-primary");
            $(this).html("<i class='fas fa-plus-circle'></i>");
            tasks.forEach((t)=>{
                $(t).removeClass("choice")
                $(t).off("click")
            })
        }
        $("[id^='taskItem_']").on('click', function (e) {
            if(choice == true){
                idTask = this.id
                idTask = idTask.substr(idTask.indexOf("_")+1,idTask.length)
                newValues = fieldParent.value
                if(!this.classList.contains("isParent")){
                    $(this).addClass('isParent');
                    if(newValues != "") newValues += ","
                    newValues += idTask
                }
                else {
                    $(this).removeClass('isParent');
                    newValues = newValues.replace(idTask,'')
                    newValues = newValues.replace(',,',',')
                }
                if(newValues.substr(newValues.length-1) == ",") newValues = newValues.slice(0,-1);
                if(newValues.substr(0,1) == ",") newValues = newValues.substr(1);
                fieldParent.value = newValues
            }
        });
    });
});