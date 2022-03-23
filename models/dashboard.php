<?php
require_once "Models.php";

class Dashboard extends Models {

    public function __construct(){
        new Models;
        $this->getInstance();
    }

    function tableauProjet($userName)
    {
        echo "<table>
                <tr>   
                    <td> Nom du Projet </td>
                    <td> Date du projet </td>
                </tr>";
    }

}
