<?php
require_once "./fonctions.php";

$idProjet="";
if(isset($_POST['projet']) && $_POST['projet'] != "") $idProjet = htmlspecialchars($_POST['projet']);

//-------------------------------Rafraichissement niveau select-------------------------------
if(isset($_POST['reload']) && $_POST['reload'] == 1) {
    $data="";
    if(isset($_POST['type']) && $_POST['type'] != "") $type = htmlspecialchars($_POST['type']);
    if($type == "level") $data = getLevelByIdProjet($idProjet,"select");
    echo $data;
    exit;
}
//-------------------------------Ajout d'un �l�ment-------------------------------
if(isset($_POST['add']) && $_POST['add'] == 1) {
    $html="";
    //  Ajout niveau
    if(isset($_POST['level'])) {
        $idLevel="";
        if(isset($_POST['level']) && $_POST['level'] != "") $nameLevel = htmlspecialchars($_POST['level']);
        // perssistance des donn�es
        $lvl = new Niveau;
        $lvl->insert(["",$nameLevel,$idProjet]);
        // rafraichissement de l'affichage
        $html = getLevelByIdProjet($idProjet,"view");
        echo $html;
        exit;
    }
    // Ajout tache
    if(isset($_POST['task'])) {
        $nameTask="";$descTask="";$idLevel="";$dureeTask="";$parentTask="";
        if(isset($_POST['task']) && $_POST['task'] != "") $nameTask = htmlspecialchars($_POST['task']);
        if(isset($_POST['desc']) && $_POST['desc'] != "") $descTask = htmlspecialchars($_POST['desc']);
        if(isset($_POST['time']) && $_POST['time'] != "") $dureeTask = htmlspecialchars($_POST['time']);
        if(isset($_POST['parent']) && $_POST['parent'] != "") $parentTask = htmlspecialchars($_POST['parent']);
        if(isset($_POST['idLevel']) && $_POST['idLevel'] != "") $idLevel = htmlspecialchars($_POST['idLevel']);
        // perssistance des donn�es
        $task = new Tache;
        $values = ["",$nameTask,$idLevel,"$dureeTask",$descTask,"","","","","$parentTask",$idProjet];
        $task->insert($values);
        // rafraichissement de l'affichage
        $html = getLevelByIdProjet($idProjet,"view");
        echo $html;
        exit;
    }
}
//-------------------------------Suppression d'un �l�ment-------------------------------

if(isset($_POST['delete']) && $_POST['delete'] == 1) {
    $html="";
    //  Suppression niveau
    if(isset($_POST['idLevel'])) {
        $idLevel="";
        if(isset($_POST['idLevel']) && $_POST['idLevel'] != "") $idLevel = htmlspecialchars($_POST['idLevel']);
        // perssistance des donn�es
        $level = new Niveau;
        $level->delete("id_niveau='".$idLevel."' and id_projet='".$idProjet."'");
        $task = new Tache;
        $task->delete("id_niveau_tache='".$idLevel."'");
        // rafraichissement de l'affichage
        $html = getLevelByIdProjet($idProjet,"view");
        echo $html;
        exit;
    }
    //  Suppression tache
    if(isset($_POST['idTask'])) {
        $idTask="";
        if(isset($_POST['idTask']) && $_POST['idTask'] != "") $idTask = htmlspecialchars($_POST['idTask']);
        // perssistance des donn�es
        $task = new Tache;
        $task->delete("id_tache='".$idTask."' and id_projet='".$idProjet."'");
        // rafraichissement de l'affichage
        $html = getLevelByIdProjet($idProjet,"view");
        echo $html;
        exit;
    }
}
//-------------------------------Modification d'un �l�ment-------------------------------
if(isset($_POST['modify']) && $_POST['modify'] == 1) {
    $html="";
    if((isset($_POST['update']) && $_POST['update'] == 0)){
        //  Recuperation informations niveau
        if(isset($_POST['idLevel'])) {
            $idLevel="";
            if(isset($_POST['idLevel']) && $_POST['idLevel'] != "") $idLevel = htmlspecialchars($_POST['idLevel']);
            // recup�ration des donn�es
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
            // recup�ration des donn�es
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
        // Modification tache
        if(isset($_POST['idLevel'])) {
            $idLevel="";$nameLevel="";
            if(isset($_POST['idLevel']) && $_POST['idLevel'] != "") $idLevel = htmlspecialchars($_POST['idLevel']);                        
            if(isset($_POST['level']) && $_POST['level'] != "") $nameLevel = htmlspecialchars($_POST['level']);
            // perssistance des donn�es
            if($nameLevel!=""){
                $level = new Niveau;
                $level->update("nom_niveau","$nameLevel","id_niveau='".$idLevel."' and id_projet='".$idProjet."'");
            }
           // rafraichissement de l'affichage
            $html = getLevelByIdProjet($idProjet,"view");
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
            // perssistance des donn�es
            if($nameTask!="" && $descTask!="" && $idTaskLevel!="" && $dureeTask!=""){
                $task = new Tache;
                $task->update("nom_tache","$nameTask","id_tache='".$idTask."' and id_projet='".$idProjet."'");
                $task->update("contenu_tache","$descTask","id_tache='".$idTask."' and id_projet='".$idProjet."'");
                $task->update("id_niveau_tache","$idTaskLevel","id_tache='".$idTask."' and id_projet='".$idProjet."'");
                $task->update("duree_tache","$dureeTask","id_tache='".$idTask."' and id_projet='".$idProjet."'");
                $task->update("tacheAnterieur_tache","$parentTask","id_tache='".$idTask."' and id_projet='".$idProjet."'");
            }
           // rafraichissement de l'affichage
            $html = getLevelByIdProjet($idProjet,"view");
            echo $html;
            exit;
        }
    }
}

