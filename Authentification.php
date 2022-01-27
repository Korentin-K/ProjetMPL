<?php
require_once'config/config_db.php'


if(isset($_POST['identifiant'])) $nom = $_POST['identifiant'];
else $nom = "";

if(isset($_POST['passwordC'])) $passwordConnexion = $_POST['passwordC'];
else $passwordConnexion = "";

if(isset($_POST['identifiantI'])) $passwordConnexion = $_POST['identifiantI'];
else $passwordConnexion = "";

if(isset($_POST['email'])) $email = $_POST['email'];
else $email = "";

if(isset($_POST['passwordI'])) $passwordInscription = $_POST['passwordI'];
else $passwordInscription= "";

if(isset($_POST['passwordI2'])) $passwordInscription2 = $_POST['passwordI2'];
else $passwordInscription2 = "";

if($id=!"")
{
	//$query= "SELECT * FROM `utilisateur` WHERE nom='$nom' and motdepasse='".hash('sha256', $passwordConnexion)."'";

	 
}

else 
{
	$maRequete = $conn-> prepare("INSERT INTO utilisateur(nom,mail,motdepasse) VALUE (name,email,mdp)");
	$nom = mysqli_real_escape_string($conn, $nom); 
	$maRequete->bindParam('name', $nom);
	$email = mysqli_real_escape_string($conn, $email); 
	$maRequete->bindParam('email', $email);
	if($passwordInscription==$passwordInscription2)
	{
		$leMotDePasse=password_hash($passwordInscription, PASSWORD_DEFAULT)
		$maRequete->bindParam('mdp', $leMotDePasse);
	}
	
}
