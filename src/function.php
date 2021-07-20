<!-- Verif client inexistant -->
<?php
require('src/connexion.php');


function verifClientNom($nom){
    require('src/connexion.php');
    $req=$db->prepare('SELECT count(*) as numberNomClient FROm clients WHERE nom_client=?');
    $req->execute(array($nom));
    $nbNom=0;
    while($nom_verif=$req->fetch()){
        $nbNom=$nom_verif['numberNomClient'];
    }
    return $nom=$nbNom;
}

function verifClientPrenom($prenom){
    require('src/connexion.php');
    $req2=$db->prepare('SELECT count(*) as numberPrenomClient FROM clients WHERE prenom_client=?');
    $req2->execute(array($prenom));
    $nbPrenom=0;
    while($prenom_verif=$req2->fetch()){
        $nbPrenom=$prenom_verif['numberPrenomClient'];
    }

    return $prenom=$nbPrenom;
}


function update(){
    
}
