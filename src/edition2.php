<?php
try{
    $db= new PDO('mysql:host=localhost;dbname=lionel','root','');
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die($e->getMessage());
}

if(isset($_GET['info']) && $_GET['info'] !=''){
    require('../fpdf/tfpdf.php');

    $pdf= new tFPDF('P','mm','A4');
    $pdf->AddPage();
    $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
    $pdf->SetFont('DejaVu','',14);    
    $tab_param=explode("-",$_GET['info']);
    $num_client=$tab_param[0];
    $num_devis=$tab_param[1];
    
    $c_civ=""; $c_nom=""; $c_pre=""; $c_date=""; $c_tot="";
    $c_ref =""; $c_des=""; $c_qte=""; $c_pht=0; $c_mht=0; $compteur=0;
    
    $req=$db->prepare('SELECT * FROM clients a, devis b, detail c WHERE a.id_client= ? AND b.devis_num=? AND c.detail_devis=? ;');
    $req->execute(array($num_client,$num_devis,$num_devis));
    $retour=$req->fetch();
    $c_civ = $retour["civilite_client"];
    $c_nom=$retour["nom_client"]; $c_pre=$retour["prenom_client"];
    $c_date=$retour["devis_date"]; $c_tot=$retour["devis_montant"];
    $ref=$retour['details_ref'];
    $c_qte = $retour["details_qte"];
    $pdf->Cell(35,10,"",0,1,'R');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(120,5,"ETS THIBAUD",0,0,'L');
    $pdf->Cell(60,5,$c_civ." ".$c_pre." ".$c_nom,0,1,'L');
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(120,5,"LE BOUISSET RD8, Quartier de la plaine",0,0,'L');
    $pdf->Cell(60,5,$retour['adresse_postal'],0,1,'L');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(120,5,"83380, Saint Aygulf",0,0,'L');
    $pdf->Cell(60,5,$retour['code_postal'].', '.$retour['ville_client'],0,1,'L');
    $pdf->Cell(120,5,"Email: ets-thibaud@hotmail.fr",0,0,'L');
    $pdf->Cell(60,5,"",0,1,'L');
    $pdf->Cell(120,5,"04 94 82 71 03 - 06 29 02 90 14 ",0,0,'L');
    $pdf->Cell(35,10,"",0,1,'R');
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(120,5,"Numero devis : ".$num_devis,0,0,'L');
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(60,5,"Date de Devis : ".$c_date,0,1,'L');
    $pdf->Cell(35,10,"",0,1,'R');

$req2=$db->prepare('SELECT * FROM articles WHERE article_code=?');
$req2->execute(array($ref));
$data=$req2->fetch();
$pdf->Cell(20,10,"",0,0,'R');
$pdf->Cell(70,10,"Désignation",1,0,'L');
$pdf->Cell(10,10,$c_qte,1,0,'R');
$pdf->Cell(30,10,$c_pht,1,0,'R');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,10,'Montant HT',1,1,'R');
$pdf->SetFont('Arial','',9);
$req3=$db->prepare('SELECT count(*) FROM detail WHERE detail_devis=? ');
$req3->execute(array($num_devis));
while($data=$req2->fetch()){
$c_ref = $data["article_code"]; $c_des=$data["article_designation"];
$c_pht=number_format($data["article_prix"],2, ',', ' ');
$c_mht = number_format($c_qte*$data["article_prix"],2, ',', ' ');
$pdf->Cell(20,10,"",0,0,'L');
$pdf->Cell(70,10,$c_des,1,0,'L');
$pdf->Cell(10,10,$c_qte,1,0,'R');
$pdf->Cell(30,10,$c_pht,1,0,'R');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,10,$c_mht,1,1,'R');
$pdf->SetFont('Arial','',9);
   
}



$pdf->SetFont('Arial','B',11);
$pdf->Cell(35,10,"",0,1,'R');
$pdf->Cell(120,10,"Montant total HT : ",0,0,'R');
$pdf->Cell(30,10,"",0,0,'R');
$pdf->Cell(30,10,number_format((float)$c_tot, 2, ',', ' '),1,1,'R');
$pdf->Cell(120,10,"TVA : 10%",0,0,'R');
$pdf->Cell(30,10,"",0,0,'R');
$pdf->Cell(30,10,number_format((float)$c_tot/100*10, 2, ',', ' '),1,1,'R');
$pdf->Cell(120,10,"Montant total TTC : ",0,0,'R');
$pdf->Cell(30,10,"",0,0,'R');
$pdf->Cell(30,10,number_format((float)$c_tot + (float)$c_tot/100*10, 2, ',', ' '),1,1,'R');
$pdf->Cell(30,30,"",0,1,'R');
$pdf->SetFont('Arial','U',11);
$pdf->Output();

}


?>