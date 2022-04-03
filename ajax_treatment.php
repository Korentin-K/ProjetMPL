<?php
require_once "./fonctions.php";

$idProjet="";$idUser="";
if(isset($_POST['projet']) && $_POST['projet'] != "") $idProjet = htmlspecialchars($_POST['projet']);
if(isset($_SESSION['id']) && $_SESSION['id'] != "") $idUser = intval($_SESSION['id']);

//-------------------------------Rafraichissement niveau select-------------------------------
if(isset($_POST['reload']) && $_POST['reload'] == 1) {
    $data="";
    if(isset($_POST['type']) && $_POST['type'] != "") $type = htmlspecialchars($_POST['type']);
    if($type == "level") $data = getLevelByIdProjet($idProjet,"select");
    echo $data;
    exit;
}
//-------------------------------Ajout d'un élément-------------------------------
if(isset($_POST['add']) && $_POST['add'] == 1) {
    $html="";
    //  Ajout niveau
    // if(isset($_POST['level'])) {
    //     $idLevel="";
    //     if(isset($_POST['level']) && $_POST['level'] != "") $nameLevel = htmlspecialchars($_POST['level']);
    //     // perssistance des données
    //     $lvl = new Niveau;
    //     $lvl->insert(["",$nameLevel,$idProjet]);
    //     // rafraichissement de l'affichage
    //     $html = getLevelByIdProjet($idProjet,"view");
    //     echo $html;
    //     exit;
    // }
    // Ajout tache
    if(isset($_POST['task']) && $idProjet!="") {
        $getLevelId = false;
        $nameTask="";$descTask="";$idLevel="";$dureeTask="";$parentTask="";
        if(isset($_POST['task']) && $_POST['task'] != "") $nameTask = htmlspecialchars($_POST['task']);
        if(isset($_POST['desc']) && $_POST['desc'] != "") $descTask = htmlspecialchars($_POST['desc']);
        if(isset($_POST['time']) && $_POST['time'] != "") $dureeTask = htmlspecialchars($_POST['time']);
        if(isset($_POST['parent']) && $_POST['parent'] != "") $parentTask = htmlspecialchars($_POST['parent']);
        // if(isset($_POST['idLevel']) && $_POST['idLevel'] != "") $idLevel = htmlspecialchars($_POST['idLevel']);
        // Verifier si projet est vide
        $task = new Tache;
        $nbrTask = $task->customQuery("select count(*) as count from niveau where id_projet=$idProjet")[0]["count"];
        $lvl = new Niveau;
        if($nbrTask == 0){
            $lvl->insert(["","niveau 0",$idProjet]);
        }
        else if($parentTask!=""){
            $maxLevelIdFromParentTask = $task->customQuery("select max(id_niveau_tache) as max from tache where id_tache in ($parentTask);")[0]["max"];
            $maxLevelIdFromProject = $lvl->customQuery("select max(id_niveau) as last from niveau where id_projet=$idProjet")[0]["last"];
            if($maxLevelIdFromParentTask == $maxLevelIdFromProject){
                $lvl->insert(["","niveau",$idProjet]);
            }
            else {
                $list=array();
                $allLevelOfProject = $lvl->findBy("id_niveau","id_projet=$idProjet");
                foreach($allLevelOfProject as $project){
                    array_push($list,$project["id_niveau"]);
                }
                $maxLevelIdFromParentTaskPos = array_search($maxLevelIdFromParentTask,$list);
                $idLevel = $list[$maxLevelIdFromParentTaskPos+1];
                $getLevelId = true;
            }
        }
        else {
            $parentTask = "null";
        }
        if($getLevelId == false) {
            $idLevel = $lvl->customQuery("select max(id_niveau) as last from niveau where id_projet=$idProjet")[0]["last"];
        } 
        // perssistance des données
        $values = ["",$nameTask,$idLevel,"$dureeTask",$descTask,"","","","","$parentTask",$idProjet];
        $task->insert($values);
        // rafraichissement de l'affichage
        $html = updateDiagrammeProjet($idProjet);
        echo $html;
        exit;
    }
    //  Ajout projet
    if($idProjet == "new") {
        $titleProject="";
        if(isset($_POST['title']) && $_POST['title'] != "") $titleProject = htmlspecialchars($_POST['title']);
        // perssistance des données
        $pjt = new Projet;
        $pjt->insert(["",$titleProject,"NOW()","NOW()"]);
        if($idUser!=""){
            $idProjet = $pjt->findBy("id_projet","titre_projet='$titleProject'")[0]["id_projet"];
            $psd = new Posseder;
            $psd->insert([$idProjet,$idUser]);
        }
            // rafraichissement de l'affichage
            $html = $idUser!="" ? tableauProjet($idUser) : "ok";
        echo $html;
        exit;
    }
}
//-------------------------------Suppression d'un élément-------------------------------

if(isset($_POST['delete']) && $_POST['delete'] == 1) {
    $html="";
    //  Suppression niveau
    if(isset($_POST['idLevel'])) {
        $idLevel="";
        if(isset($_POST['idLevel']) && $_POST['idLevel'] != "") $idLevel = htmlspecialchars($_POST['idLevel']);
        // perssistance des données
        $level = new Niveau;
        $level->delete("id_niveau='".$idLevel."' and id_projet='".$idProjet."'");
        $task = new Tache;
        $task->delete("id_niveau_tache='".$idLevel."'");
        // rafraichissement de l'affichage
        $html = updateDiagrammeProjet($idProjet);
        echo $html;
        exit;
    }
    //  Suppression tache
    if(isset($_POST['idTask'])) {
        $idTask="";
        if(isset($_POST['idTask']) && $_POST['idTask'] != "") $idTask = htmlspecialchars($_POST['idTask']);
        // perssistance des données
        $task = new Tache;
        $task->delete("id_tache='".$idTask."' and id_projet='".$idProjet."'");
        // rafraichissement de l'affichage
        $html = updateDiagrammeProjet($idProjet);
        echo $html;
        exit;
    }
    //  Suppression projet
    if(isset($_POST['confirm']) && $_POST['confirm'] == "true" && $idProjet!="") {
        $pjt = new Projet;
        $pjt->delete("id_projet='$idProjet'");
        $psd = new Posseder;
        $psd->delete("id_projet='$idProjet'");
        $lvl = new Niveau;
        $lvl->delete("id_projet='$idProjet'");
        $task = new Tache;
        $task->delete("id_projet='$idProjet'");
        // rafraichissement de l'affichage
        $html = $idUser!="" ? tableauProjet($idUser) : "ok";
        echo $html;
        exit;
    }
}
//-------------------------------Modification d'un élément-------------------------------
if(isset($_POST['modify']) && $_POST['modify'] == 1) {
    $html="";
    if((isset($_POST['update']) && $_POST['update'] == 0)){
        //  Recuperation informations niveau
        if(isset($_POST['idLevel'])) {
            $idLevel="";
            if(isset($_POST['idLevel']) && $_POST['idLevel'] != "") $idLevel = htmlspecialchars($_POST['idLevel']);
            // recupération des données
            $level = new Niveau;
            $result = $level->findBy("nom_niveau","id_niveau='".$idLevel."' and id_projet='".$idProjet."'");
            $data = array();
            foreach($result as $key => $value){
                $data[$key] = $value;
            }
            echo json_encode($data);
            exit;
        }
        //  Recuperation informations tache
        if(isset($_POST['idTask'])) {
            $idTask="";
            if(isset($_POST['idTask']) && $_POST['idTask'] != "") $idTask = htmlspecialchars($_POST['idTask']);
            // recupération des données
            $task = new Tache;
            $result = $task->findBy("*","id_tache='".$idTask."' and id_projet='".$idProjet."'");
            $data = array();
            foreach($result as $key => $value){
                $data[$key] = $value;
            }
            echo json_encode($data);
            exit;
        }
    }
    elseif ((isset($_POST['update']) && $_POST['update'] == 1)) {
        // Modification niveau
        if(isset($_POST['idLevel'])) {
            $idLevel="";$nameLevel="";
            if(isset($_POST['idLevel']) && $_POST['idLevel'] != "") $idLevel = htmlspecialchars($_POST['idLevel']);                        
            if(isset($_POST['level']) && $_POST['level'] != "") $nameLevel = htmlspecialchars($_POST['level']);
            // perssistance des données
            if($nameLevel!=""){
                $level = new Niveau;
                $level->update("nom_niveau","$nameLevel","id_niveau='".$idLevel."' and id_projet='".$idProjet."'");
            }
           // rafraichissement de l'affichage
            $html = updateDiagrammeProjet($idProjet);
            echo $html;
            exit;
        }
        // Modification tache
        if(isset($_POST['idTask'])) {
            $idTask="";$nameTask="";$descTask="";$idTaskLevel="";$dureeTask="";$parentTask="";
            if(isset($_POST['idTask']) && $_POST['idTask'] != "") $idTask = htmlspecialchars($_POST['idTask']);                        
            if(isset($_POST['task']) && $_POST['task'] != "") $nameTask = htmlspecialchars($_POST['task']);
            if(isset($_POST['desc']) && $_POST['desc'] != "") $descTask = htmlspecialchars($_POST['desc']);
            if(isset($_POST['time']) && $_POST['time'] != "") $dureeTask = htmlspecialchars($_POST['time']);
            if(isset($_POST['parent']) && $_POST['parent'] != "") $parentTask = htmlspecialchars($_POST['parent']);
            if(isset($_POST['idTaskLevel']) && $_POST['idTaskLevel'] != "") $idTaskLevel = htmlspecialchars($_POST['idTaskLevel']);
            // perssistance des données
            if($nameTask!="" && $descTask!="" && $idTaskLevel!="" && $dureeTask!=""){
                $task = new Tache;
                $task->update("nom_tache","$nameTask","id_tache='".$idTask."' and id_projet='".$idProjet."'");
                $task->update("contenu_tache","$descTask","id_tache='".$idTask."' and id_projet='".$idProjet."'");
                $task->update("id_niveau_tache","$idTaskLevel","id_tache='".$idTask."' and id_projet='".$idProjet."'");
                $task->update("duree_tache","$dureeTask","id_tache='".$idTask."' and id_projet='".$idProjet."'");
                $task->update("tacheAnterieur_tache","$parentTask","id_tache='".$idTask."' and id_projet='".$idProjet."'");
            }
            elseif($idTask!="" && $idTaskLevel!=""){
                $task = new Tache;
                $task->update("id_niveau_tache","$idTaskLevel","id_tache='".$idTask."' and id_projet='".$idProjet."'");
            }
           // rafraichissement de l'affichage
            $html = updateDiagrammeProjet($idProjet);
            echo $html;
            exit;
        }
    }
}

