<?php
require_once "fonctions.php";
writeHeaderHtml("Connexion/Inscription",3);
?>
<body>
    <div class="d-flex row flex-wrap">
    <div class="bloc-connexion col-6" >
       <p>Déjà Inscrit ?</p>
          <form action="Authentification.php" method="POST" class="form-connexion" >
          <div class="form-connexion">
            <input type="text"  placeholder="Identifiant" arial-label="Identifiant" name="identifiant" required>
          </div>
          <div class="form-connexion">
            <input type="text"  placeholder="Mot de Passe" arial-label="password" name="passwordC" required>
          </div>
          <div class="form-connexion">
            <input type="submit" value="Connexion">
          </div>
        </form>
    </div>
    <div class="bloc-inscription col-6">
      <p>Vous n'avez pas encore de compte ?
         Inscrivez vous en complétant les champs ci-dessous :</p>

        <form  action="Authentification.php" method="POST" class="form-inscription"> 
        <div class="form-inscription">
          <input type="text"  placeholder="Identifiant" arial-label="Identifiant" name="identifiantI" required>
        </div>
        <div class="form-inscription">
          <input type="text"  placeholder="E-mail" arial-label="email" name="email" required>
        </div>
         <div class="form-inscription">
          <input type="text"  placeholder="Mot de Passe" arial-label="password" name="passwordI" required>
        </div>
         <div class="form-inscription">
          <input type="text"  placeholder="Retaper Mot de Passe" arial-label="passwordI2" name="passwordI2" required>
        </div>
        <div class="form-inscription">
          <input type="submit" value="Inscription">
        </div>
    </div>
</div>
</body>
<?php writeFooterHtml(); ?>