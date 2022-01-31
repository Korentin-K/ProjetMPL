<?php
require_once "models/Utilisateur.php";

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
$t = new Utilisateur;

if($nom!="")
{
	//$query= "SELECT * FROM `utilisateur` WHERE nom='$nom' and motdepasse='".hash('sha256', $passwordConnexion)."'";
	 echo "test Connexion";
	
	
}
if($nomI!="" and $nom=="") 
{	
	if(rechercheCompteExiste($nomI,$email,$leMotDePasse)==true)
	{
		if($passwordInscription==$passwordInscription2)
		{
		$leMotDePasse=password_hash($passwordInscription, PASSWORD_DEFAULT);
		inscriptionSite($nomI,$email,$leMotDePasse);
		}
	}
	
	echo "test Inscription";
}
