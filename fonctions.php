<?php
require_once "models/Projet.php";
require_once "models/Niveau.php";
require_once "models/Tache.php";
require_once "models/Datafaker.php";
//========================================================
// FONCTIONS : generations de fausses données
//========================================================
function loadFakeData(){
    return new Datafaker;
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
    $script .= "<script src=\"https://code.jquery.com/jquery-3.6.0.js\"></script>";
    $script .= "<script src=\"https://code.jquery.com/ui/1.13.1/jquery-ui.js\"></script>";
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
    $html .= getScript();
    $html .= "</head>";
    echo $html;
}
// Ecris le pied de la page HTML
function writeFooterHtml(){
    // $html = getScript();
    $html = "</html>";
    echo $html;
}
// Ecris la barre de navigation de l'application
//function writeNavBar($nomUser)
function writeNavBar(){
    $is_authenticate=false;
    if(isset($_SESSION['User']) && $_SESSION['User'] != "" ) $is_authenticate=true;
    if($is_authenticate==true){
        $html = "<nav class='navbar navbar-expand-lg navbar-light bg-light py-0'>
                <div class='container-fluid'>
                    <a class='navbar-brand' href='#'>MPM</a>
                    <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
                    <span class='navbar-toggler-icon'></span>
                    </button>
                    <div class='collapse navbar-collapse d-flex justify-content-end' id='navbarNav'>
                    <ul class='navbar-nav align-items-center'>
                        <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='dashboard.php'>Tableau de bord</a>
                        </li>
                        <li class='nav-item'>
                        <a class='nav-link' href='#'>Mon compte</a>
                        </li>
                        <li class='nav-item'>
                        <span class='mx-2' >".$_SESSION['User']."</span>
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
                    <a class='nav-link' href='PageConnexion.php'>Connexion</a>
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
    $dureeTotale = calculAllData($idProjet);
    $level = new Niveau;
    $getLevel = $level->findBy("id_niveau, nom_niveau","id_projet=".$idProjet);
    $html="";
    if($display == "view") {
        $position=0;
        foreach($getLevel as $row){
            $html .= addLevel($idProjet,$row["id_niveau"],$row["nom_niveau"],$position);
            $position += 1;
        }
        // $dureeTotale = getTotalDuree($idProjet);        
        $html.= addLevel($idProjet,"F".$row["id_niveau"],"FIN",($position+1),$dureeTotale);
    }elseif ($display == "select") {
        $html .= "<option value='-1' selected>Choix du niveau...</option>";
        foreach($getLevel as $row){
            $html .= "<option value=".$row['id_niveau'].">".$row['nom_niveau']."</option>";
        }
    }
    return $html;
}
// Ajout d'un niveau
function addLevel($idProjet,$idLevel,$nameLevel,$position,$total=null){    
    $marginLeft = $idLevel == 0 ? "mx-0" : "";
    $nameLevel = $nameLevel == "" ? "sans nom" : $nameLevel;
    $dropdown = "<ul class='dropdown-menu ' aria-labelledby='taskMenu_$idLevel'>
        <li><a class='dropdown-item'  onclick='modifyLevel($idLevel)' >Modifier</a></li>
        <li><a class='dropdown-item'  onclick='deleteLevel($idLevel);'>Supprimer</a></li>
    </ul>";
    $html = " <div id='level_".$idLevel."' class='d-flex col-12 h-100 justify-content-center levelStyle $marginLeft'>
                <div id='levelPosition_$position'></div>
                <div class='row d-flex justify-content-center levelCol'>
                    <div class='d-flex mt-1 col-10 justify-content-around titleLevel' >
                        <div class=' task-title d-flex col-12 '>
                            <span class='d-flex col-10 '>".strval($nameLevel)."</span>
                            <a class='col-2 d-flex justify-content-end ' id='levelMenu_$idLevel' data-bs-toggle='dropdown' aria-expanded='false' data-toggle='dropdown' aria-haspopup='true' data-offset='10,20'>
                            <i class='levelIcon fas fa-cog'></i>
                            </a>$dropdown
                        </div>
                    </div>";
    if($nameLevel != "FIN"){
        $html.=getTaskByLevel($idProjet,$idLevel,$position);
    }else{
        $data = ["FIN",$total];
        $html.=addTask($idProjet,$data,$position);
    }
    $html.="    </div>       
            </div>";
    return $html;
}
// recuperation des tâches par niveau
function getTaskByLevel($idProjet,$idLevel,$positionLevel){
    $html = "";
    $task = new Tache;
    $getTask = $task->findBy("*","id_projet=$idProjet and id_niveau_tache=$idLevel");
    foreach($getTask as $row){
        $dataTask = array();
        array_push($dataTask,$row["nom_tache"]);
        array_push($dataTask,$row["contenu_tache"]);
        array_push($dataTask,$row["duree_tache"]);
        array_push($dataTask,$row["tacheAnterieur_tache"]);
        array_push($dataTask,$row["debutPlusTot_tache"]);
        array_push($dataTask,$row["debutPlusTard_tache"]);
        array_push($dataTask,$row["margeLibre_tache"]);
        array_push($dataTask,$row["margeTotale_tache"]);
        $html .= addTask($row["id_tache"],$dataTask,$positionLevel);
    }
    return $html;
}
// Affichage d'une tache
function addTask($id,$data,$positionLevel){
    $html="";
    if($data[0]!="FIN"){
        $data[0] = $data[0] == "" ? "sans nom" : $data[0];
        $parentTask = $data[3]!="" ? $data[3] : "-";
        $dureePlusTot = $positionLevel == 0 ? "0" : $data[4];
        $dureePlusTard = $positionLevel == 0 ? "0" : $data[5];
        $margeLibre = $positionLevel == 0 ? "0" : $data[6];
        $margeTotale = $positionLevel == 0 ? "0" : $data[7];
        $dropdown = "<ul class='dropdown-menu' aria-labelledby='taskMenu_$id'>
            <li><a class='dropdown-item'  onclick='modifyTask($id)' >Modifier</a></li>
            <li><a class='dropdown-item'  onclick='deleteTask($id);'>Supprimer</a></li>
        </ul>";
        $html .= "<div id='taskItem_$id' class='row d-flex col-10 mt-1 task-item'>
        <table class='tableTask'>
            <tbody>
                <tr >    
                    <td>T$id</td>
                    <td>".$data[2]."</td>
                </tr>
                <tr>    
                    <td>$dureePlusTot</td>
                    <td>$dureePlusTard</td>
                </tr>
                <tr>    
                    <td>$margeLibre</td>
                    <td>$margeTotale</td>
                </tr>";
        if($positionLevel > 0) {
            $html .=" <tr>    
                        <td colspan=2>".$parentTask."</td>
                    </tr>";
        }
        $html .=" </tbody>
                </table>
                <div class=' task-title d-flex col-12 align-items-center'><span class='d-flex col-10'>".$data[0]."</span>
                <a class='col-2 d-flex justify-content-end ' id='taskMenu_$id' data-bs-toggle='dropdown' aria-expanded='false'>
                <i class='fas fa-ellipsis-h'></i></a>$dropdown</div>
                <div class='task-content w-100'>".$data[1]."</div>
                </div>";
    } else {
        $dureeTotale = $data[1];
        $html .= "<div id='taskItem_$id' class='row d-flex col-10 mt-1 task-item'>
        <table class='tableTask'>
            <tbody>
                <tr >    
                    <td colspan=2>FIN</td>
                </tr>
                <tr>    
                    <td>$dureeTotale</td>
                    <td>$dureeTotale</td>
                </tr>
                <tr>    
                    <td>0</td>
                    <td>0</td>
                </tr>";
       
    }    
    return $html;
}
// calcul des durées
function calculTask($parentTask,$idTask){
    if($parentTask == null) return 0;
    require_once "models/Models.php";
    // recuperation ids taches antérieures
    $arrayParent = explode(",",$parentTask);
    foreach($arrayParent as $key => $value){
        if($value != ""){
            $arrayParent[$key] = ltrim($value,"T");
        }else {
            $arrayParent[$key] =0;
        }
    }
    $arrayParent = implode(",",$arrayParent);
    $sql="SELECT id_tache, duree_tache, debutPlusTot_tache FROM tache WHERE id_tache in ($arrayParent);";
    $m = new Models;
    $data = $m->customQuery($sql);
    if($data == NULL) return 0;
    else{
        $duree = array();
        foreach($data as $row){
            $sum = intval($row["debutPlusTot_tache"]) + intval($row["duree_tache"]);
            array_push($duree,$sum);
        }
        $dureePlusTot = max($duree);
        $t = new Tache;
        $t->update("debutPlusTot_tache","$dureePlusTot","id_tache='".$idTask."'");
        return $dureePlusTot;
    }

}
function getTotalDuree($idProjet){
    require_once "models/Models.php";
    $n = new Niveau;
    $idLastLevel = $n->getMaxLevelByProject($idProjet);
    if($idLastLevel == NULL) return 0;
    $m = new Models;
    $sql = "SELECT debutPlusTot_tache, duree_tache FROM tache WHERE id_niveau_tache='$idLastLevel' and id_projet='$idProjet'";
    $taskInLastLevel = $m->customQuery($sql);
    if($taskInLastLevel == NULL) return 0;
    $duree=array();
    foreach($taskInLastLevel as $task){
        $sum = intval($task['debutPlusTot_tache']) + intval($task['duree_tache']);
        array_push($duree,$sum);
    }
    return max($duree);
}
// retourne tableau des taches enfant
function getIdChildTask($idParent){
    $task = new Tache;
    $getChild = $task->findBy("id_tache","tacheAnterieur_tache like '%$idParent%'");
    return $getChild;
}

function calculAllData($idProjet){
    $level = new Niveau;
    $task = new Tache;
    //------------------------------------------------------------------------------------
    // CALCUL : DUREE AU PLUS TOT
    //------------------------------------------------------------------------------------
    //recuperer tous les niveaux du projet par ordre ASCENDANT
    $getLevel = $level->findBy("id_niveau, nom_niveau","id_projet=".$idProjet);
    //recuperer toutes les taches de chaque niveau
    if($getTaskDesc != NULL){
        foreach($getLevel as $row){
            $getTask = $task->findBy("*","id_projet=$idProjet and id_niveau_tache=".$row["id_niveau"]);
            foreach($getTask as $row){
                calculTask($row["tacheAnterieur_tache"],$row["id_tache"]); // MAJ des durees au plus tot de chaque tache
            }
        }
    }
    //------------------------------------------------------------------------------------
    // CALCUL : DUREE AU PLUS TARD + MARGE LIBRE
    //------------------------------------------------------------------------------------
    $dureeTotale = getTotalDuree($idProjet); // recuperation duree total du projet 
    $idLastLevel = $level->getMaxLevelByProject($idProjet);
    //recuperer toutes les taches triee par niveaux en ordre DESCENDANT     
    $getTaskDesc = $task->findBy("*","id_projet=".$idProjet." order by id_niveau_tache DESC");
    if($getTaskDesc != NULL){
        foreach($getTaskDesc as $row){
            if($row['id_niveau_tache'] == $idLastLevel){
                $dureePlusTard = intval($dureeTotale) - intval($row['duree_tache']);
                $margeLibre = intval($dureeTotale) - intval($row['debutPlusTot_tache']) - intval($row['duree_tache']);            
            }
            else { // rechercher les taches enfants
                $dureePlusTardChildAvailable = array();
                $dureePlusTotChildAvailable = array();
                $childTask = getIdChildTask($row['id_tache']);
                foreach($childTask as $array => $content){
                    foreach($content as $key => $idChild){ // pour chaque tache enfant, calculer la duree au plus tard possible
                        $getDureeChild = $task->findBy("debutPlusTard_tache,debutPlusTot_tache","id_projet=$idProjet and id_tache=".$idChild)[0];
                        $dureeForThisChild = intval($getDureeChild["debutPlusTard_tache"]) - intval($row['duree_tache']);
                        array_push($dureePlusTardChildAvailable,$dureeForThisChild);
                        array_push($dureePlusTotChildAvailable,$getDureeChild["debutPlusTot_tache"]);
                    }
                }
                $dureePlusTard = min($dureePlusTardChildAvailable);
                $dureePlusTotChild = min($dureePlusTotChildAvailable);
                $margeLibre = intval($dureePlusTotChild) - intval($row['debutPlusTot_tache']) - intval($row['duree_tache']);
            }
            $task->update("debutPlusTard_tache","$dureePlusTard","id_tache='".$row['id_tache']."'");
            $task->update("MargeLibre_tache","$margeLibre","id_tache='".$row['id_tache']."'");
        }
        //------------------------------------------------------------------------------------
        // CALCUL : MARGE TOTALE
        //------------------------------------------------------------------------------------
        $getTaskOfProject = $task->findBy("*","id_projet=".$idProjet);
        foreach($getTaskOfProject as $row){
            $margeTotale = intval($row['debutPlusTard_tache']) - intval($row['debutPlusTot_tache']);
            $task->update("MargeTotale_tache","$margeTotale","id_tache='".$row['id_tache']."'");
        }
    }
    return $dureeTotale;
}

