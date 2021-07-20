<?php
try{
    $db= new PDO('mysql:host=localhost;dbname=lionel','root','');
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die($e->getMessage());
}

define('EURO',chr(128));


if(isset($_GET['info']) && $_GET['info'] !=''){
    require('cell.php');

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
    $c_ttc=$c_tot + $c_tot/100*10;
    $c_30=$c_ttc*0.3;
    $c_final=$c_ttc-$c_30;
    $c_40=$c_final*0.4;
    $c_final=$c_final-$c_40;
    $m_toiture=283;


// class PDF extends FPDF{

//     //header
//     function Header(){
//         $this->Cell(210,39,'');
//         //saut de ligne
//         $this->Ln(20);
//     }

//       // Footer
//   function Footer() {
//     // Positionnement à 1,5 cm du bas
//     $this->SetY(-15);
//     // Police Arial italique 8
//     $this->SetFont('Helvetica','I',9);
//     // Numéro de page, centré (C)
//     $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
//   }
// }
    $pdf= new CellPDF('P','mm','A4');
    $pdf->AddPage();
    $pdf->SetFont('Helvetica','',9);
    $pdf->SetTextColor(0);
    $pdf->AliasNbPages();
// Header
    $pdf->SetFont('Helvetica','B',11);
    $pdf->cell(125,10,'',0,0);
    $pdf->Cell(60,5,$c_civ." ".$c_pre." ".$c_nom,0,1,'C');
    $pdf->SetFont('Helvetica','B',11);
    $pdf->cell(125,10,'',0,0);
    $pdf->Cell(60,5,$retour['adresse_postal'],0,1,'C');
    $pdf->SetFont('Helvetica','B',11);
    $pdf->cell(125,10,'',0,0);
    $pdf->Cell(60,5,$retour['code_postal'].', '.$retour['ville_client'],0,1,'C');
    $pdf->Ln(10);
    $pdf->Cell(110,10,utf8_decode('Devis n°: ').$num_devis,0,0,'L');
    $pdf->Cell(80,10,'Fait le '.$c_date,0,1,'R');
    $pdf->Cell(0,10,'RENOVATION TOITURE '.$m_toiture.'M2',1,1,'C');
    $pdf->SetFont('Helvetica','',11);
    $pdf->Cell(130,5,'Designation',1,0,'C');
    $pdf->Cell(30,5,'QUANTITES',1,0,'C');
    $pdf->Cell(30,5,'Montant HT',1,1,'C');
// contenu tableau 

$req2= $db->prepare('SELECT * FROM devis 
INNER JOIN detail ON devis_num = detail_devis  
INNER JOIN articles ON details_ref = article_code 
WHERE devis_num = ? 
ORDER BY devis_date');
$req2->execute(array($num_devis));

while($data=$req2->fetch()){  
    if($data['article_prix']==0){
        $qte='';
        $prix='';
    }else{
        $qte=$data['details_qte'].' '.$data['ref_m2_mL'];
        $prix=$data['article_prix']*$data['details_qte'].EURO;
    };

$pdf->Cell(130,5,$data['article_designation'],'LR',0,'L');
$pdf->Cell(30,5,$qte,'LR',0,'R');
$pdf->Cell(30,5,$prix,'LR',1,'R');

}
$pdf->Cell(0,0,'','T',1,'L');
    $pdf->SetFont('Helvetica','B',11);
    $pdf->Cell(130,5,'',0,0,'L');
    $pdf->Cell(30,5,'PRIX M2',1,0,'L');
    $pdf->Cell(30,5,number_format((float)$c_tot/$m_toiture,2,',','').EURO,1,1,'R');
    $pdf->Cell(130,5,'',0,0,'L');
    $pdf->Cell(30,5,'TOTAL HT',1,0,'L');
    $pdf->Cell(30,5,number_format((float)$c_tot,2,',',' ').EURO,1,1,'R');
    $pdf->Cell(130,5,'',0,0,'L');
    $pdf->Cell(30,5,'TVA 10 %',1,0,'L');
    $pdf->Cell(30,5,number_format((float)$c_tot/100*10, 2, ',', ' ').EURO,1,1,'R');
    $pdf->Cell(130,5,'',0,0,'L');
    $pdf->Cell(30,5,'TOTAL TTC',1,0,'L');
    $pdf->Cell(30,5,number_format((float)$c_tot + (float)$c_tot/100*10, 2, ',', ' ').EURO,1,1,'R');
    $pdf->Ln(10);
    // Footer
    $pdf->SetFont('Helvetica','',10);

    $pdf->Cell(0,5,'Assurances THIBAUD : Allianz',0,1,'C');
    $pdf->Cell(0,5,'Ces Travaux Beneficient de la garantie decennale couverture',0,1,'C');
    $pdf->Cell(0,5,utf8_decode('UN acompte de 30% est demandé à la signature du devis soit ').number_format((float)$c_30,2,',',' ').EURO.' TTC',0,1,'C');
    $pdf->Cell(0,5,'Une Situation de chantier (milieu des travaux) de 40% soit '.number_format((float)$c_40,2,',',' ').EURO.' TTC',0,1,'C');
    $pdf->Cell(0,5,utf8_decode('Le solde à la fin des travaux soit ').number_format((float)$c_final,2,',',' ').EURO.' TTC',0,1,'C');
    $pdf->Ln(5);
    
    $pdf->SetFont('Helvetica','B',10);
    $pdf->Cell(95,5,'   BON POUR ACCORD',0,0,'L');
    $pdf->Cell(95,5,'L\'ENTREPRISE',0,1,'R');
    $pdf->SetFont('Helvetica','',10);
    $pdf->Cell(95,5,'(date et signature du client)',0,0,'L');
    $pdf->Ln(25);
    $nom_file="devis_".$c_nom.'_'.$c_pre.'_'.$c_date;
    $pdf->Output('I', $nom_file);
}
?>