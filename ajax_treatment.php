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
        $nameTask="";$descTask="";$idLevel="";
        if(isset($_POST['task']) && $_POST['task'] != "") $nameTask = htmlspecialchars($_POST['task']);
        if(isset($_POST['desc']) && $_POST['desc'] != "") $descTask = htmlspecialchars($_POST['desc']);
        if(isset($_POST['idLevel']) && $_POST['idLevel'] != "") $idLevel = htmlspecialchars($_POST['idLevel']);
        // perssistance des donn�es
        $task = new Tache;
        $values = ["",$nameTask,$idLevel,"",$descTask,"","","","","",$idProjet];
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
        $task = new Niveau;
        $task->delete("id_niveau='".$idLevel."' and id_projet='".$idProjet."'");
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
