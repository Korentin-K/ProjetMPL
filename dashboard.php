<?php
require_once "fonctions.php";
require_once "models/dashboard.php";
writeHeaderHtml('dashboard',4);
$nomPersonne=$_SESSION['User'];
$u = new Utilisateur;
$idUser = $u->customQuery("select * from utilisateur limit 1")[0]["id_utilisateur"];
$_SESSION['id']=$idUser;
// $idUser=$_SESSION['idUser'];
// echo $idUser;
?>
<body >    
    <?php writeNavBar($nomPersonne); ?>
    <div class="d-flex justify-content-end mt-1 me-2">
      <input id="newProjectName" name="newProjectName" type="text"  placeholder="nom nouveau projet">
      <a class="btn btn-light" onclick="addProject()">Creer un projet</a>
    </div>
    <div class="d-flex justify-content-center">
     
      <div id="list_project" class="bloc-list col-auto">
         <div id="tableauScroll" style="padding: 4px;"> <?php tableauProjet($idUser); ?> </div>
    </div>
  </div>
  </body>
  <script>console.log("js")
function addProject(){
    var name = document.getElementById('newProjectName')
    $.ajax({
        url : 'ajax_treatment.php',
        type : 'POST',
        data : {
            add : 1,
            title : name.value,
            projet : "new"
            } ,
        success : function(data){
            name.value = "";  
            console.log(data)
            document.getElementById('list_project').innerHTML = "";
            data = data=="ok" ? "pas de sessions" : data; 
            document.getElementById('list_project').innerHTML = data;
        },
        error : function(resultat, statut, erreur){
            console.log(erreur)
        }
    });    
  } 
    function deleteProject(id){
      console.log(id)
    $.ajax({
        url : 'ajax_treatment.php',
        type : 'POST',
        data : {
            delete : 1,
            projet : id,
            confirm : "true"
            } ,
        success : function(data){
            name.value = "";  
            console.log(data)
            document.getElementById('list_project').innerHTML = "";
            data = data=="ok" ? "pas de sessions" : data; 
            document.getElementById('list_project').innerHTML = data;
        },
        error : function(resultat, statut, erreur){
            console.log(erreur)
        }
    });
  }     
   </script>
<?php writeFooterHtml(); ?>