<?php
// Répertorie les liens CSS
function getDependances(int $codePage){
    $link = "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>";
    if ($codePage == 2 ) $link .= "<link rel=\"stylesheet\" type='text/css' href=\"asset/diagramme.css\">";
    return $link;
}
// Répertorie les scripts JS
function getScript(){
    $script = "<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js\" integrity=\"sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p\" crossorigin=\"anonymous\"></script>";
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
    $html = "<nav class='navbar navbar-expand-lg navbar-light bg-light'>
            <div class='container-fluid'>
                <a class='navbar-brand' href='#'>Navbar</a>
                <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
                </button>
                <div class='collapse navbar-collapse' id='navbarNav'>
                <ul class='navbar-nav'>
                    <li class='nav-item'>
                    <a class='nav-link active' aria-current='page' href='#'>Home</a>
                    </li>
                    <li class='nav-item'>
                    <a class='nav-link' href='#'>Features</a>
                    </li>
                    <li class='nav-item'>
                    <a class='nav-link' href='#'>Pricing</a>
                    </li>
                    <li class='nav-item'>
                    <a class='nav-link disabled'>Disabled</a>
                    </li>
                </ul>
                </div>
            </div>
            </nav>";
    echo $html;
}

function addLevel($levelNbr){
    $html = " <div class='d-flex col-12 h-100 justify-content-center levelStyle'>
                <div class='row'>
                    <span class='mt-1 text-center titleLevel' >Niveau ".strval($levelNbr)."</span>
                    <!--Element tâches -->
                </div>       
            </div>";
    echo $html;
}
