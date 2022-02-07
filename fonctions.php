<?php
require_once "models/Projet.php";
require_once "models/Niveau.php";
require_once "models/Tache.php";
require_once "models/Datafaker.php";

//========================================================
// FONCTIONS : generations de fausses données
//========================================================
function loadFakeData(){
    $data = new Datafaker;
}

//========================================================
// FONCTIONS : généralistes structure HTML
//========================================================
// Répertorie les liens CSS
function getDependances(int $codePage){
    $path_css = "asset/css";
    $path_lib = "asset/lib";
    $link = "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>";
    $link .= "<link rel=\"stylesheet\" type='text/css' href=\"".$path_lib."/font_icon/css/all.css\">";
    $link .= "<link rel=\"stylesheet\" type='text/css' href=\"".$path_css."/main.css\">";
    if ($codePage == 2 ) $link .= "<link rel=\"stylesheet\" type='text/css' href=\"".$path_css."/diagramme.css\">";
    if($codePage == 3) $link.= "<link rel=\"stylesheet\" type='text/css' href=\"".$path_css."/PageConnexion.css\">";
    if($codePage == 4) $link.= "<link rel=\"stylesheet\" type='text/css' href=\"".$path_css."/dashboard.css\">";
    return $link;
}
// Répertorie les scripts JS
function getScript(){
    $path_js = "asset/js";
    $script = "<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js\" integrity=\"sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p\" crossorigin=\"anonymous\"></script>";
    $script .= "<script src='https://code.jquery.com/jquery-3.6.0.min.js' integrity='sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=' crossorigin='anonymous'></script>";
    return $script;
}
// Ecrit l'en-tête HTML de la page
function writeHeaderHtml(string $title,int $codePage=0){
    $title = $title!="" ? $title : "";
    $html = " <!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>".$title."</title>";
    $html .= getDependances($codePage);
    $html .= "</head>";
    echo $html;
}
// Ecris le pied de la page HTML
function writeFooterHtml(){
    $html = getScript();
    $html .= "</html>";
    echo $html;
}
// Ecris la barre de navigation de l'application
function writeNavBar(){
    $is_authenticate = false;
    if($is_authenticate){
        $html = "<nav class='navbar navbar-expand-lg navbar-light bg-light py-0'>
                <div class='container-fluid'>
                    <a class='navbar-brand' href='#'>MPM</a>
                    <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
                    <span class='navbar-toggler-icon'></span>
                    </button>
                    <div class='collapse navbar-collapse d-flex justify-content-end' id='navbarNav'>
                    <ul class='navbar-nav align-items-center'>
                        <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='#'>Home</a>
                        </li>
                        <li class='nav-item'>
                        <a class='nav-link' href='#'>Features</a>
                        </li>
                        <li class='nav-item'>
                        <span class='mx-2' >Nom Prenom</span>
                        </li>
                        <li class='nav-item'>
                        <a class='nav-link fw-bolder py-auto my-0'><i class='far fa-user-circle fa-3x'></i></a>
                        </li>
                    </ul>
                    </div>
                </div>
                </nav>";
    }else {
        $html = "<nav class='navbar navbar-expand-lg navbar-light bg-light'>
            <div class='container-fluid'>
                <a class='navbar-brand' href='#'>MPM</a>
                <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
                </button>
                <div class='collapse navbar-collapse d-flex justify-content-end' id='navbarNav'>
                <ul class='navbar-nav'>
                    <li class='nav-item'>
                    <a class='nav-link active' aria-current='page' href='#'>Home</a>
                    </li>
                    <li class='nav-item'>
                    <a class='nav-link' href='#'>Features</a>
                    </li>
                    <li class='nav-item'>
                    <a class='nav-link' href='#'></a>
                    </li>
                    <li class='nav-item'>
                    <a class='nav-link disabled'>Mon compte</a>
                    </li>
                </ul>
                </div>
            </div>
            </nav>";
    }
    echo $html;
}

//========================================================
// FONCTIONS : page diagramme
//========================================================
// recuperation des niveaux
function getLevelByIdProjet($idProjet,$display){
    $level = new Niveau;
    $getLevel = $level->findBy("id_niveau, nom_niveau","id_projet=".$idProjet);
    $html="";
    if($display == "view") {
        foreach($getLevel as $row){
            $html .= addLevel($idProjet,$row["id_niveau"],$row["nom_niveau"]);
        }
    }elseif ($display == "select") {
        $html .= "<option value='-1' selected>Choix du niveau...</option>";
        foreach($getLevel as $row){
            $html .= "<option value=".$row['id_niveau'].">".$row['nom_niveau']."</option>";
        }
    }
    return $html;
}
// recuperation des tâches par niveau
function getTaskByLevel($idProjet,$idLevel){
    $html = "";
    $task = new Tache;
    $getTask = $task->findBy("id_tache,nom_tache","id_projet=$idProjet and id_niveau_tache=$idLevel");
    $nbrtask = count($getTask);
    foreach($getTask as $row){
        $html .= addTask($row["id_tache"],$row["nom_tache"]);
    }
    return $html;
}
// Ajout d'un niveau
function addLevel($idProjet,$idLevel,$nameLevel){    
    $marginLeft = $idLevel == 0 ? "mx-0" : "";
    $html = " <div id='level_".$idLevel."' class='d-flex col-12 h-100 justify-content-center levelStyle $marginLeft'>
                <div class='row d-flex justify-content-center'>
                    <div class='d-flex mt-1 col-10 justify-content-around titleLevel ' >
                        <div class='col-8 d-flex justify-content-center'>".strval($nameLevel)."</div>
                        <a id='addTaskLevel_".$idLevel."' class='col-2 d-flex justify-content-end ' title='Ajouter une tâche' onclick=''><i id='iconPlus' class='fas fa-plus'></i></a>
                    </div>
                    ".getTaskByLevel($idProjet,$idLevel)."
                </div>       
            </div>";
    return $html;
}
// Affichage d'une tache
function addTask($id,$name){
    $html="";
    $html .= "<div id='taskItem_$id' class='row d-flex col-10 mt-1 task-item'>
    <div class=' task-title d-flex col-12 align-items-center'><span class='d-flex col-10'>".$name."</span>
    <span class='col-2 d-flex justify-content-end ' type='button' id='taskMenu_$id' data-bs-toggle='dropdown' aria-expanded='false'>
    <i class='fas fa-ellipsis-v'></i>
    </span></div>
    <div class='task-content w-100'>Une courte description..</div>
    </div>";
    $html .= "<ul class='dropdown-menu' aria-labelledby='taskMenu_$id'>
        <li><a class='dropdown-item' href='#'>Action</a></li>
        <li><a class='dropdown-item' href='#'>Another action</a></li>
        <li><a class='dropdown-item' href='#'>Something else here</a></li>
    </ul>";
    return $html;
}