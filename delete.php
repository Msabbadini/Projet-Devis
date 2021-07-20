<?php

include('src/connexion.php');
include('src/entete.php');
include("src/header.php");

if(isset($_GET['client']) && $_GET['client'] != ''){
    $id=$_GET['client'];

    echo ' client n°'.$id;
    
}elseif(isset($_GET['devis']) && $_GET['devis'] !=''){
    $id=$_GET['devis'];

    echo' Devis n°'.$id;
}elseif(isset($_GET['facture']) && $_GET['facture'] != ''){
    $id=$_GET['facture'];

    echo' Facture n° '.$id;
}
if(isset($_POST['submit'])){
    $test='TRUE';
    echo $test;
}
?>
<section class="flex justify-center ">
    <section class='content-center'>
        <div class="w-72 h-36 bg-grey-500 ring-2 ">
        <h4>Validation suppression</h4>
        <h5><?= $id?></h5>
       
        <button type='button'class='bg-green-500 rounded'>Retour</button>
        <button type='submit' name='submit' class='bg-red-700 rounded w'>Valider</button>
    </div>
    </section>
    


</section>

