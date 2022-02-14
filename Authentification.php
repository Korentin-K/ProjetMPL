<?php
require_once "models/Utilisateur.php";
session_start();
if(isset($_POST['identifiant'])) $emailId = $_POST['identifiant'];
else $emailId = "";

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
$User = new Utilisateur;

if($emailId!="")
{
	if (filter_var($emailID, FILTER_VALIDATE_EMAIL)){
			$leMotDePasse=password_hash($passwordConnexion, PASSWORD_DEFAULT);
	 if($User->rechercheConnexion($emailId,$leMotDePasse)==true){
	 	header('Location: ./dashboard.php');
	 	$nameUser=$User->rechercheNom($emailId);
	 	$_SESSION['user']=$nameUser;
  		exit();
	 }
	 else{
	 	header('Location: ./PageConnexion.php');
  			exit();
	 }
	}
	else{
	 	header('Location: ./PageConnexion.php');
  			exit();
	 }
	 //echo "test Connexion";
	
	
}

//variable à la place de localhost
if($nomI!="" and $emailId=="") 
{	if (filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		if($User->rechercheCompteExiste($email)==true)
		{
			if($passwordInscription==$passwordInscription2)
			{
		    	$leMotDePasse=password_hash($passwordInscription, PASSWORD_DEFAULT);
				$User->inscriptionSite($nomI,$email,$leMotDePasse);
				header('Location: ./dashboard.php');
				$_SESSION['user']=$nomI;
  				exit();
			}
			else
			{
				header('Location: ./PageConnexion.php');
  				exit();

			}
		}
		else
		{
			header('Location: ./PageConnexion.php');
  			exit();
		}

	}
	else
	{
		header('Location: ./PageConnexion.php');
  		exit();

	}
	//echo $passwordInscription.",".$passwordInscription2;
	//echo "test Inscription";
}
