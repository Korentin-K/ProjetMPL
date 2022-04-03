<?php
session_start();

require_once "models/Projet.php";
require_once "models/Niveau.php";
require_once "models/Tache.php";
require_once "models/Utilisateur.php";
require_once "models/Posseder.php";
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
$path_lib = "asset/lib";
// Répertorie les liens CSS
function getDependances(int $codePage){
    global $path_lib;
    $path_css = "asset/css";
    $link = "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>";
    $link .= "<link rel=\"stylesheet\" type='text/css' href=\"".$path_lib."/font_icon/css/all.css\">";
    $link .= "<link rel=\"stylesheet\" type='text/css' href=\"".$path_css."/main.css\">";
    if ($codePage == 2 ){
        $link .= "<link rel=\"stylesheet\" type='text/css' href=\"".$path_css."/diagramme.css\">";
        $link .= "<script src=\"".$path_lib."/leader_line/leader-line.min.js\"></script>";

    } 
    if($codePage == 3) $link.= "<link rel=\"stylesheet\" type='text/css' href=\"".$path_css."/pageConnexion.css\">";
    if($codePage == 4) $link.= "<link rel=\"stylesheet\" type='text/css' href=\"".$path_css."/dashboard.css\">";
    return $link;
}
// Répertorie les scripts JS
function getScript($codePage=null){
    global $path_lib;
    $path_js = "asset/js";
    $script="";
    if($codePage==null){
        $script = "<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js\" integrity=\"sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p\" crossorigin=\"anonymous\"></script>";
        $script .= "<script src=\"https://code.jquery.com/jquery-3.6.0.js\"></script>";
        $script .= "<script src=\"https://code.jquery.com/ui/1.13.1/jquery-ui.js\"></script>";
    }
    if($codePage == 2){
        $script .= "<script src='https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js'></script>";
        // $script .= "<script src=\"".$path_js."/diagramme_effect.js\"></script>";
        $script .= "<script src=\"".$path_js."/diagramme.js\"></script>";
        $script .= "<script src=\"".$path_lib."/plain_draggable/src/plain-draggable.js\"></script>";
    }
    if($codePage == 4){
        $script .= "<script src=\"".$path_js."/dashboard.js\"></script>";
    }
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
function writeFooterHtml($codePage=0){
    $html="";
    $html .= getScript($codePage);
    $html .= "</html>";
    echo $html;
}
// Ecris la barre de navigation de l'application
//function writeNavBar($nomUser)
function writeNavBar(){
    //$_SESSION['User'] = "test";
    $nomPersonne=$_SESSION['User'];
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

function checkAccessPermission(){
    if(!isset($_SESSION['User'])){
        header('Location: denied_access.php');
    }
}

//========================================================
// FONCTIONS : page diagramme
//========================================================
// Recupere donnée de la bdd et retourne tableau d'objet
// $data[0] = niveau (objets) / $data[1] = tache (objets)
function getAllData($idProjet){
    $data_task = array();
    $task = new Tache;
    $allTaskOfProjet = $task->findBy("*","id_projet=$idProjet");
    foreach($allTaskOfProjet as $taskOfProjet){
        $t = new Tache;
        $t->setId_tache($taskOfProjet['id_tache']);
        $t->setNom_tache($taskOfProjet['nom_tache']);
        $t->setId_niveau_tache($taskOfProjet['id_niveau_tache']);
        $t->setDuree_tache($taskOfProjet['duree_tache']);
        $t->setContenu_tache($taskOfProjet['contenu_tache']);
        $t->setTacheAnterieur_tache($taskOfProjet['tacheAnterieur_tache']);
        $t->setId_projet($taskOfProjet['id_projet']);
        array_push($data_task,$t);
    }
    $task = null;
    $data_level = array();
    $lvl = new Niveau;
    $allLvlOfProjet = $lvl->findBy("*","id_projet=$idProjet");
    foreach($allLvlOfProjet as $lvlOfProjet){
        $l = new Niveau;
        $l->setId_niveau($lvlOfProjet['id_niveau']);
        $l->setNom_niveau($lvlOfProjet['nom_niveau']);
        array_push($data_level,$l);
    }
    $data = [$data_level,$data_task];
    return $data;
}
//Compter nombre de taches par niveau
function countTaskByLevel($data){
    $result = array();
    $data_level= $data[0];
    $data_task = $data[1];
    foreach($data_level as $lvl){
        $lvlId = $lvl->getId_niveau();
        $result[$lvlId] = 0;
    }
    foreach($data_task as $task){
        $lvlIdOfTask = $task->getId_niveau_tache();
        if(isset($result[$lvlIdOfTask])) $result[$lvlIdOfTask] += 1 ;
    }
    return $result;
}
// Gestion affichage diagramme
// retourne html
function updateDiagrammeProjet($idProjet){
    $html="";$allData=null;
    $allData = getAllData($idProjet);
    if($allData!=null){
        $countTaskByLvl = countTaskByLevel($allData);
        //calculAllData($idProjet);
        //Creation rendu html pour chaque tache
        $content_level = array();
        foreach($allData[1] as $task){
            $render = render_task($task);
            $task->setHtml($render);
        }
        foreach($allData[0] as $level){
            $render = render_level($level, $countTaskByLvl, $allData[1]);
            $html .= $render;
        }
        $levelEnd = new Niveau;
        $levelEnd->setNom_niveau("FIN");      
        $levelEnd->setNom_niveau("FIN");      
        $html .= render_level($levelEnd);
    }
    return $html;
}
function getLevelByIdProjet($idProjet,$display){
    $html="";$getLevel="";$data=null;
    $allData = getAllData($idProjet);
    $countTaskByLvl = countTaskByLevel($allData);
    calculAllData($idProjet);
    $level = new Niveau;
    $getLevel = $level->findBy("id_niveau, nom_niveau","id_projet=".$idProjet);
    if($getLevel!="" && !empty($getLevel)){
        if($display == "view") {
            $position=0;
            foreach($getLevel as $row){
                $html .= addLevel($idProjet,$row["id_niveau"],$row["nom_niveau"],$position);
                $position += 1;
            }
            $dureeTotale = getTotalDuree($idProjet);        
            $html.= addLevel($idProjet,"F".$row["id_niveau"],"FIN",($position+1),$dureeTotale);
        }
        elseif ($display == "select") {
            $html .= "<option value='-1' selected>Choix du niveau...</option>";
            foreach($getLevel as $row){
                $html .= "<option value=".$row['id_niveau'].">".$row['nom_niveau']."</option>";
            }
        }
    }else {
        $html .= "<h1>Projet vide...</h1>";
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
    $html = " <div id='level_".$idLevel."' class=' d-flex col-12 h-100 justify-content-center levelStyle $marginLeft'>
                <div id='levelPosition_$position'></div>
                <div class='row d-flex justify-content-center levelCol dropzone'>
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
// Ajout d'un niveau
function render_level($level,$countTask=null,$taskData=null){  
    $isEnd=false;$dropdown="";
    $nameLevel = $level->getNom_niveau();
    if($nameLevel == "FIN") $isEnd = true;
    if($isEnd) $idLevel = "end";
    else $idLevel = $level->getId_niveau();
    $marginLeft = $idLevel == 0 ? "mx-0" : "";
    $nameLevel = $nameLevel == "" ? "sans nom" : $nameLevel;
    if(!$isEnd){
        $dropdown = "<ul class='dropdown-menu ' aria-labelledby='taskMenu_$idLevel'>
            <li><a class='dropdown-item'  onclick='modifyLevel($idLevel)' >Modifier</a></li>
            <li><a class='dropdown-item'  onclick='deleteLevel($idLevel);'>Supprimer</a></li>
        </ul>";
    }
    $html = " <div id='level_".$idLevel."' class=' d-flex col-12 h-100 justify-content-center levelStyle $marginLeft'>
                <div class='row d-flex justify-content-center levelCol dropzone'>
                    <div class='d-flex mt-1 col-10 justify-content-around titleLevel' >
                        <div class=' task-title d-flex col-12 '>
                            <span class='d-flex col-10 '>".strval($nameLevel)."</span>";
    if(!$isEnd){
        $html.= "<a class='col-2 d-flex justify-content-end ' id='levelMenu_$idLevel' data-bs-toggle='dropdown' aria-expanded='false' data-toggle='dropdown' aria-haspopup='true' data-offset='10,20'><i class='levelIcon fas fa-cog'></i></a>$dropdown";
    }
    $html.="</div></div>";
    if($nameLevel != "FIN"){
        $nbrtask = $countTask[$idLevel];
        $count=0;
        foreach($taskData as $task){
            if($task->getId_niveau_tache() == $idLevel){
                if($task->getTacheAnterieur_tache() == null) $html.="<div class='d-flex px-0 mx-0 justify-content-center border'>";
                $html.=$task->getHtml();
                if($task->getTacheAnterieur_tache() == null) $html.="</div>";
                $count ++;
            }
        }
    }else{
        $dureeTotale = getTotalDuree($level->getId_projet()); 
        $taskEnd = new Tache;
        $taskEnd->setNom_tache("FIN");
        $taskEnd->getDuree_tache($dureeTotale); 
        $html.=render_task($taskEnd);
    }
    $html.="    </div>       
            </div>";
    return $html;
}
// Affichage d'une tache
function render_task($task){
    $html="";
    $name = $task->getNom_tache();
    if($name!="FIN" && $name!=""){
        $id = $task->getId_tache();
        $name = $name == "" ? "sans nom" : $name;
        $content = $task->getContenu_tache();
        $parentTask = $task->getTacheAnterieur_tache();
        $duree = $task->getDuree_tache();
        $dureePlusTot = $task->getDebutPlusTot_tache();
        $dureePlusTard = $task->getDebutPlusTard_tache();
        $margeLibre = $task->getMargeLibre_tache();
        $margeTotale = $task->getMargeTotale_tache();
        $dropdown = "<ul class='dropdown-menu' aria-labelledby='taskMenu_$id'>
            <li><a class='dropdown-item'  onclick='modifyTask($id)' >Modifier</a></li>
            <li><a class='dropdown-item'  onclick='deleteTask($id);'>Supprimer</a></li>
        </ul>";
        $html .= "<div id='taskItem_$id' class='row d-flex col-10 mt-1 task-item draggable'>
        <table class='tableTask'>
            <tbody>
                <tr >    
                    <td>T$id</td>
                    <td>".$duree."</td>
                </tr>
                <tr>    
                    <td>$dureePlusTot</td>
                    <td>$dureePlusTard</td>
                </tr>
                <tr>    
                    <td>$margeLibre</td>
                    <td>$margeTotale</td>
                </tr>";
        if($parentTask != null) {
            $html .=" <tr>    
                        <td colspan=2>".$parentTask."</td>
                    </tr>";
        }
        $html .=" </tbody>
                </table>
                <div class=' task-title d-flex col-12 align-items-center'><span class='d-flex col-10'>".$name."</span>
                <a class='col-2 d-flex justify-content-end ' id='taskMenu_$id' data-bs-toggle='dropdown' aria-expanded='false'>
                <i class='fas fa-ellipsis-h'></i></a>$dropdown</div>
                <div class='task-content w-100'>".$content."</div>
                </div>";
        if($parentTask != null){
            $taskArray=explode(",",$parentTask);
            $parentValue="";
            foreach($taskArray as $taskId){
                $parentValue.=$taskId.",";
            }
            $parentValue = rtrim($parentValue,',');
            $html .= "<input id='parent_$id' type='text' value='$parentValue' hidden>";
        }
    } else {
        $dureeTotale = $task->getDuree_tache();
        $html .= "<div  class='row d-flex col-10 mt-1 task-item'>
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
        $html .= "<div id='taskItem_$id' class='row d-flex col-10 mt-1 task-item draggable'>
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
        if($parentTask != "-"){
            $taskArray=explode(",",$parentTask);
            $parentValue="";
            foreach($taskArray as $taskId){
                $parentValue.=$taskId.",";
            }
            $parentValue = rtrim($parentValue,',');
            $html .= "<input id='parent_$id' type='text' value='$parentValue' hidden>";
        }
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
function getLastLevelNotEmpty($idProjet){
    require_once "models/Models.php";
    $n = new Niveau;
    $idAllLevel = $n->getLevelOfProjet($idProjet);
    if($idAllLevel == NULL) return 0;
    $m = new Models;
    foreach($idAllLevel as $oneLevel){
        $sql = "SELECT id_niveau_tache FROM tache WHERE id_niveau_tache='".$oneLevel['id_niveau']."' and id_projet='$idProjet'";
        $taskInLastLevel = $m->customQuery($sql);
        if($taskInLastLevel != NULL){
            return $oneLevel['id_niveau'];
        }
    }
}
function getTotalDuree($idProjet){
    require_once "models/Models.php";
    $idLevelNotEmpty = getLastLevelNotEmpty($idProjet);
    if($idLevelNotEmpty == NULL) return 0;
    $m = new Models;
    $sql = "SELECT debutPlusTot_tache, duree_tache FROM tache WHERE id_niveau_tache='".$idLevelNotEmpty."' and id_projet='$idProjet'";
    $taskInLastLevel = $m->customQuery($sql);
    if($taskInLastLevel != NULL){
        $duree=array();
        foreach($taskInLastLevel as $task){
            $sum = intval($task['debutPlusTot_tache']) + intval($task['duree_tache']);
            array_push($duree,$sum);
        }
        return max($duree);
    }
    return 0;
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
    // if($getTaskDesc != NULL){
        foreach($getLevel as $row){
            $getTask = $task->findBy("*","id_projet=$idProjet and id_niveau_tache=".$row["id_niveau"]);
            foreach($getTask as $row){
                calculTask($row["tacheAnterieur_tache"],$row["id_tache"]); // MAJ des durees au plus tot de chaque tache
            }
        }
    // }
    //------------------------------------------------------------------------------------
    // CALCUL : DUREE AU PLUS TARD + MARGE LIBRE
    //------------------------------------------------------------------------------------
    $dureeTotale = getTotalDuree($idProjet); // recuperation duree total du projet 
    // $idLastLevel = $level->getMaxLevelByProject($idProjet);
    $idLastLevel = getLastLevelNotEmpty($idProjet);

    //recuperer toutes les taches triee par niveaux en ordre DESCENDANT     
    $getTaskDesc = $task->findBy("*","id_projet=".$idProjet." order by id_niveau_tache DESC");
    if($getTaskDesc != NULL){
        foreach($getTaskDesc as $row){
            if($row['id_niveau_tache'] == $idLastLevel){
                if($row['duree_tache'] != NULL){
                    $dureePlusTard = intval($dureeTotale) - intval($row['duree_tache']);
                    $task->update("debutPlusTard_tache","$dureePlusTard","id_tache='".$row['id_tache']."'");
                }
                if($row['duree_tache'] != NULL && $row['debutPlusTot_tache']!=NULL ){
                    $margeLibre = intval($dureeTotale) - intval($row['debutPlusTot_tache']) - intval($row['duree_tache']);            
                    $task->update("MargeLibre_tache","$margeLibre","id_tache='".$row['id_tache']."'");
                }
            }
            else { // rechercher les taches enfants
                $dureePlusTardChildAvailable = array();
                $dureePlusTotChildAvailable = array();
                $childTask = getIdChildTask($row['id_tache']);
                if($childTask != NULL){
                    foreach($childTask as $array => $content){
                        foreach($content as $key => $idChild){ // pour chaque tache enfant, calculer la duree au plus tard possible
                            $getDureeChild = $task->findBy("debutPlusTard_tache,debutPlusTot_tache","id_projet=$idProjet and id_tache=".$idChild)[0];
                            if($row['duree_tache'] != NULL && $row['debutPlusTard_tache']!=NULL ){
                                $dureeForThisChild = intval($getDureeChild["debutPlusTard_tache"]) - intval($row['duree_tache']);
                                array_push($dureePlusTardChildAvailable,$dureeForThisChild);
                            }
                            if($row['debutPlusTot_tache'] != NULL) array_push($dureePlusTotChildAvailable,$getDureeChild["debutPlusTot_tache"]);
                        }
                    }
                    if($dureePlusTardChildAvailable != NULL){
                        $dureePlusTard = min($dureePlusTardChildAvailable);
                        $task->update("debutPlusTard_tache","$dureePlusTard","id_tache='".$row['id_tache']."'");
                    }
                    if($dureePlusTotChildAvailable != NULL){
                        $dureePlusTotChild = min($dureePlusTotChildAvailable);
                        if($row['duree_tache'] != NULL && $row['debutPlusTot_tache']!=NULL){
                            $margeLibre = intval($dureePlusTotChild) - intval($row['debutPlusTot_tache']) - intval($row['duree_tache']);
                            $task->update("MargeLibre_tache","$margeLibre","id_tache='".$row['id_tache']."'");
                        }
                    }
                }
            }
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

//------------------------------------------------------------------------------------
// FONCTIONS : Dashboard
//------------------------------------------------------------------------------------
function tableauProjet($idUser){
    $html="";
    $posseder = new Posseder;
    $allIdProjectByIdUser = $posseder->findBy("id_projet","id_utilisateur=$idUser");
    $project = new Projet;
    $html="<table width='800px'>
            <tr>
              <th>Titre projet</th>
              <th>Date</th>
              <th>Action</th>
            </tr>";
    foreach($allIdProjectByIdUser as $idProject){
        $id = $idProject["id_projet"];
        $oneProject = $project->findBy("*","id_projet='$id'");
        // var_dump($oneProject);
        if($oneProject!="" && !empty($oneProject)){
            $title = $oneProject[0]["titre_projet"];
            $date = $oneProject[0]["dateCreation_projet"];
            $html.="
                <tr>
                <td>$title</td>
                <td>$date</td>
                <td class='d-flex justify-content-around py-2'>
                <a class='btn btn-secondary' href='diagramme.php?projet=$id'>Voir</a>
                <a class='btn btn-danger' onclick='deleteProject($id)'>Supprimer</a>
                </td>
                </tr>";
        }
    }
    $html.="</table>";
    echo $html;
}