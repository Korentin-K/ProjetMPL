<?php
require_once "fonctions.php";
writeHeaderHtml("Rapport d'erreur");
checkAccessPermission();
$nomUser=$_SESSION['User'];
?>
<body >  
    <div class="container-fluid mx-0 px-0">
        <?php writeNavBar($nomUser); ?>
    </div>
    <div class="d-flex col-12 justify-content-center flex-wrap">
        <div class="col-8  mx-0 d-flex flex-wrap justify-content-center risque mt-2 p-2">
            <div class="col-12 d-flex fw-bold h4">Ajout anomalie</div>
            <form class="col-6 d-flex justify-content-center flex-wrap" method="post" action="envoieRapport.php">
                <label class="col-12 text-start h5" for="objetRapport">Objet du rapport:</label>                 
                <input  id="objetRapport" name="objetRapport" class="form-control" type="text" placeholder="Objet">                
                <label class="col-12 text-start h5 mt-2" for="descriptionRapport">Description du rapport:</label>  
                <input id="descriptionRapport" name="descriptionRapport" class="form-control " type="text" placeholder="description">
                <button id="submit" class="btn btn-primary mt-2">Ajouter</button>
            </form>
        </div>
        <div class="col-8 mx-0 d-flex flex-wrap justify-content-center risque mt-4 p-2">
        <div class="col-12 d-flex fw-bold h4 justify-content-between"><span>Historique</span><a class="btn btn-secondary" href="pdf.php?page=anomalie" target="_blank" >Télécharger le rapport</a></div>
            <div class="col-10 d-flex justify-content-center flex-wrap">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Objet</th>
                    <th scope="col">Description</th>
                    <th scope="col">Date</th>
                    <th scope="col">Statut</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                  <?php echo displayTableAnomalie(); ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
    <!-- <div class="d-flex row flex-wrap">
    	<form action="envoieRapport.php" method="POST">
    		objet du rapport: 
    		<input type="text" name="objetRapport">
    		description du rapport: 
    		<input type="text" name="descriptionRapport">
    		<input type="submit" name="buttonEnvoieRapport" value="Envoyer">
    	</form>
    	<canvas id="myChart" width="400" height="400"></canvas> -->
<script>
function deleteAnomalie(id){
    $.ajax({
    url : 'ajax_treatment.php',
    type : 'POST',
    data : {
        anomalie : 1,
        idAnomalie : id,
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
const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
</div>

</div>
</body>

<?php writeFooterHtml(); ?>