<?php
    include('src/connexion.php');
    include('src/entete.php');
    include("src/header.php");

    $id_client=null;
    $id_devis=null;
    $success=0;
    $total_commande=0;
    $i = 0;
    if(!empty($_GET['id'])){
        $id_client=htmlspecialchars($_REQUEST['id']) ;
        $id_devis=htmlspecialchars($_REQUEST['devis']);
        $success=0;
    }
        
    
    // Requete Update Start
    if(isset($_POST['submit'])){
        foreach ($_POST['quantite'] as $num_ligne => $value) {
            $req3= $db->prepare('UPDATE detail SET details_qte =? WHERE detail_num = '.$num_ligne.'');
            $req3->execute([$value]);
        }
        $total= htmlspecialchars($_POST['total_line']);
        var_dump($total);
        $query= 'UPDATE devis SET devis_montant='.$total.' WHERE devis_num='.$id_devis.'';
        var_dump($query); 
        $req2= $db->query($query);
        // $req2->execute(array($total));
    }
    
    $req=$db->prepare('SELECT * FROM devis WHERE client_num = ? AND devis_num=?');
    $req->execute(array($id_client,$id_devis));



    
// Requete Update End

?>

<section class="page-content">

<?php
    while($donnees = $req->fetch()){
?>
    <form action="modif_devis.php?id=<?= $id_client?>&devis=<?=$id_devis?>" method='post'>
         <legend>Type : </legend> 
         <div>
         <input type='radio' name='type' Value='Devis' <?php if (isset($donnees['type_devis']) && $donnees['type_devis']) echo 'checked';?>> <label for="">Devis</label> <input type="radio" name="type" value='Facture' <?php if(isset($donnees['type_devis']) && $donnees['type_devis'] == 'Facture') echo'checked'; ?>><label for='Facture'>Facture</label> 
         </div>
         <legend>Statut Devis</legend>
        <div>
            <input type="radio" name="statut_devis" value='En attente'
            <?php if(isset($donnees['statut_devis']) && $donnees['statut_devis'] == 'En attente') echo'checked' ?>>
            <label for="">En attente</label>
            <input type="radio" name="statut" value='Validation'
            <?php if(isset($donnees['statut_devis']) && $donnees['statut_devis'] == 'Validation') echo'checked' ?>>
            <label for="">Validation Client</label>
            <input type="radio" name="statut" value='Refus'
            <?php if(isset($donnees['statut_devis']) && $donnees['statut_devis'] == 'Refus') echo'checked' ?>>
            <label for="">Refus Client</label>
        </div>
        <legend>Statut Facture</legend>
        <div>
            <input type="radio" name="statut_facture" value='30%' <?php if(isset($donnees['statut_facture']) && $donnees['statut_facture'] == "30%") echo'checked' ?>>
            <label for="">Acompte 30% Début chantier</label>
            <input type="radio" name="statut_facture" value='40%'
            <?php if(isset($donnees['statut_facture']) && $donnees['statut_facture'] == '40%') echo'checked' ?>>
            <label for="">Acompte 40% Milieu Chantier</label>
            <input type="radio" name="statut_facture" value='fin'
            <?php if(isset($donnees['statut_facture']) && $donnees['statut_facture'] == 'fin') echo'checked' ?>>
            <label for="">Acompte Fin chantier</label>
            <input type="radio" name='statut_facture' value='clos'
            <?php if(isset($donnees['statut_facture']) && $donnees['statut_facture'] == 'clos') echo'checked' ?>>
            <label for="">Facture réglée</label>
        </div>
        <legend>Date devis</legend>
        <div>
            <input type="text" value='<?= $donnees['devis_date'] ?>' disabled>
        </div>
        <legend>Date Modification Devis/Facture</legend>
        <div>
            <input type="date" name="modification_devis" value='<?=$donnees["date_devis_modification"]?>'>
        </div>
        <legend>Références devis / Facture </legend>
        <table>
            <thead>
                <tr>
                    <th>Ligne</th>
                    <th>Référence produit</th>
                    <th>Qté</th>
                    <th>PUHT</th>
                    <th>PTHT</th>
                </tr>
            </thead>
            <tbody>
                <?php 
        $req2= $db->prepare('SELECT * FROM devis 
        INNER JOIN detail ON devis_num = detail_devis  
        INNER JOIN articles ON details_ref = article_code 
        WHERE devis_num = ?  ORDER BY article_code');
        $req2->execute(array($id_devis));
        while($data=$req2->fetch()){ 
            $prix_total=$data["article_prix"] * $data['details_qte'];
        ?>
        <tr class='border-b border-red-700 mb-3 mt-3'>
            <th><input type="text"  value='<?= $data['detail_num'] ?>' disabled > </th>
            <th class='text-left w-5/12  mb-5'><?=$data['article_designation']?></th>
            <th><input class='w-20 shadow appearance-none border border-red-500 rounded  py-2 px-3 text-gray-700 m-3 leading-tight focus:outline-none focus:shadow-outline"' type="text" name='quantite["<?=$data['detail_num'] ?>"]' value='<?=$data['details_qte']?>'></th>
            <th class=''><input class='shadow appearance-none border border-red-500 rounded w-20 py-2 px-3 text-gray-700 m-3 leading-tight focus:outline-none focus:shadow-outline"'  type="text" value='<?=$data["article_prix"]?>€' disabled></th>
            <th class=''><input class='shadow appearance-none border border-red-500 rounded w-20 py-2 px-3 text-gray-700 m-3 leading-tight focus:outline-none focus:shadow-outline"' type="text" onchange='verif(this.value)' value='<?=$prix_total ?>€' disabled></th>
        </th>
                
            </tr >
            <?php 
        $i++;
        $total_commande = $total_commande+$prix_total;
    } ?> 
        <tr>
            <th><input type='number' value='<?= $total_commande ?>' name='total_line' class='hidden'></th>
            <th></th>
            <th></th>
            <th>Total : </th>
            <th> <?=$total_commande?>€</th>
        </tr> 
    </tbody>
        </table>
        <input type="submit" value="Modifier" name='submit' class='w-36 h-10 bg-green-500 rounded '>
    </form>
<?php } ?>

</section>
<script>
    function recupID(monId){
        id=monId.id;
    }
    function verif(valeur){
        
    }


</script>
<?php include('src/pied_page.php')?>



