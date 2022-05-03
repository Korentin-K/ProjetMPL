<?php
$page="";
if(isset($_GET['page']) && $_GET['page']!="") $page=htmlspecialchars($_GET['page']);

if($page==""){
    exit;
}

require_once "./asset/lib/fpdf/fpdf.php";
require_once "models/Models.php";
require_once "fonctions.php";

function setHeader($pdf,$header,$page=null)
{
    $i=0;
    foreach($header as $col){
        $w = $i==0 ? 10 : 30;
        if($page == "anomalie" && $i>0) $w=40;
        $pdf->Cell($w,7,utf8_decode($col),1,0,'C');
        $i++;
    }
    $pdf->Ln();
    return $pdf;
}
function setDataRow($pdf,$page){
    $model = new Models;
    $body="";$i=1;
    $pos='C';$border=1;
    $pdf->SetFont('Arial','',10);
    if($page=="risque"){
        $data =  $model->customQuery("select * from risque order by date_risque"); 
        foreach($data as $row){ 
                
                $w = 10;
                $pdf->Cell($w,7,utf8_decode($i),1,0,$pos);
                $w = 30;
                $pdf->Cell($w,7,utf8_decode($row['type_risque']),$border,0,$pos);
                $pdf->Cell($w,7,utf8_decode($row['nom_risque']),$border,0,$pos);
                $pdf->Cell($w,7,utf8_decode($row['probabilite_risque']),$border,0,$pos);
                $pdf->Cell($w,7,utf8_decode($row['severite_risque']),$border,0,$pos);
                $pdf->Cell($w,7,utf8_decode($row['cout_risque']),$border,0,$pos);
                $pdf->Cell($w,7,utf8_decode($row['proprietaire_risque']),$border,0,$pos);
                $pdf->Cell($w,7,utf8_decode($row['detection_risque']),$border,0,$pos);
                $pdf->Cell($w,7,utf8_decode($row['correction_risque']),$border,0,$pos);
                $date = date_create($row['date_risque'])->format("d/m/y à H:i");
                $pdf->Cell($w,7,utf8_decode($date),'TBR',1,$pos);
            $i++;
        }
    }
    else if($page=="anomalie"){
        $data =  $model->customQuery("select * from rapporterreur order by dateRapport"); 
        foreach($data as $row){                 
                $w = 10;
                $pdf->Cell($w,7,utf8_decode($i),1,0,$pos);
                $w = 40;
                $pdf->Cell($w,7,utf8_decode($row['objetRapport']),$border,0,$pos);
                $pdf->Cell($w,7,utf8_decode($row['descriptionRapport']),$border,0,$pos);
                $date = date_create($row['dateRapport'])->format("d/m/y");
                $pdf->Cell($w,7,utf8_decode($date),$border,0,$pos);
                if($row['statutRapport'] == 0) $state="fermé";
                else $state = "ouvert";
                $pdf->Cell($w,7,utf8_decode($state),'TBR',1,$pos);
            $i++;
        }
    }
    return $pdf;
}

if($page == "risque"){
    $header = ["#","Type","Nom","Proba","Sévérité","Coût","Proprio","Détection","Correction","Date"];
    $pdf = new FPDF('L');
    $pdf->SetRightMargin(10);
    $pdf->SetLeftMargin(10);
    $pdf->AddPage();
    $pdf->SetAuthor('Application MPM');
    $currentDate = date_create()->format("dmy");
    $pdf->SetTitle('rapport_risque_'.$currentDate);
    $pdf->SetFont('Arial','B',13);
    $pdf->Cell(0,10,'Rapport des risques',0,1,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->Ln();
    $pdf = setHeader($pdf,$header);
    $pdf = setDataRow($pdf,$page);
    $pdf->Output();
}
else if($page == "anomalie"){
    $header = ["#","Objet","Description","Date","Statut"];
    $pdf = new FPDF();
    $pdf->SetRightMargin(10);
    $pdf->SetLeftMargin(10);
    $pdf->AddPage();
    $pdf->SetAuthor('Application MPM');
    $currentDate = date_create()->format("dmy");
    $pdf->SetTitle('rapport_anomalie_'.$currentDate);
    $pdf->SetFont('Arial','B',13);
    $pdf->Cell(0,10,'Rapport des anomalies',0,1,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->Ln();
    $pdf = setHeader($pdf,$header,$page);
    $pdf = setDataRow($pdf,$page);
    $pdf->Output();
}