<?php
require_once'config/Database.php';

if(isset($_POST['identifiant'])) $nom = $_POST['identifiant'];
else $nom = "";

if(isset($_POST['passwordC'])) $passwordConnexion = $_POST['passwordC'];
else $passwordConnexion = "";

if(isset($_POST['identifiantI'])) $nomI = $_POST['identifiantI'];
else $nomI = "";

if(isset($_POST['email'])) $email = $_POST['email'];
else $email = "";

if(isset($_POST['passwordI'])) $passwordInscription = $_POST['passwordI'];
else $passwordInscription= "";

if(isset($_POST['passwordI2'])) $passwordInscription2 = $_POST['passwordI2'];
else $passwordInscription2 = "";

if($nom!="")
{

	//$query= "SELECT * FROM `utilisateur` WHERE nom='$nom' and motdepasse='".hash('sha256', $passwordConnexion)."'";
	 echo "test Connexion";
	
	
}
if($nomI!="" and $nom=="") 
{	
	//on regarde si l'identifiant n'est pas déjà utilisé
	//$maRequete = $conn-> exec("SELECT * FROM utilisateur WHERE nom='$nomI'");
	$maRequete = $conn-> prepare("INSERT INTO utilisateur(nom_utilisateur,mail_utilisateur,mdp_utilisateur) VALUE (name,email,mdp)");
	$nomI = mysqli_real_escape_string($conn, $nom); 
	$maRequete->bindParam('name', $nomI);
	$email = mysqli_real_escape_string($conn, $email); 
	$maRequete->bindParam('email', $email);
	if($passwordInscription==$passwordInscription2)
	{
		$leMotDePasse=password_hash($passwordInscription, PASSWORD_DEFAULT);
		$maRequete->bindParam('mdp', $leMotDePasse);
	}
	echo "test Inscription";
}
