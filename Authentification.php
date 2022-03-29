<?php
session_start();
require_once "models/Utilisateur.php";
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
	$leMDP=md5($passwordConnexion);
	if(filter_var($emailId,FILTER_VALIDATE_EMAIL) and $User->rechercheConnexion($emailId,$leMDP)==true)
	{ 
			$nameUser=$User->rechercheNom($emailId);
	 		$_SESSION['User']=$nameUser['nom_utilisateur'];
	 		header('Location: ./dashboard.php');
			exit();	
	}
	else{
		header('Location: ./PageConnexion.php');
			exit();	
	}				
}

//variable à la place de localhost
if($nomI!="" and $emailId=="") 
{	
	if (filter_var($email, FILTER_VALIDATE_EMAIL))
	{	
		if($User->rechercheCompteExiste($email)==true)
		{
			var_dump($email);
			if($passwordInscription==$passwordInscription2)
			{
		    	$leMotDePasse=md5($passwordInscription);
				$User->inscriptionSite($nomI,$email,$leMotDePasse);
				$_SESSION['User']=$nomI;
				header('Location: ./dashboard.php');
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
}
