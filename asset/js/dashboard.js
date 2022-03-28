// Ajout projet
console.log("ok")
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