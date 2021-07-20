<?php
    include('src/connexion.php');
    include('src/entete.php');
    include("src/header.php")
?>
<section class="page-content">
<article>
<h1>Liste Devis </h1>
<table>
    <thead>
        <tr>
            <th>Numero Devis</th>
            <th>Nom client</th>
            <th>Montant Devis</th>
            <th>Date devis</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $req=$db->prepare('SELECT * FROM devis  INNER JOIN clients AS c ON client_num = id_client ORDER BY devis_num');
        $req->execute();

        while($data=$req->fetch()){
            $lien=$data['client_num'];
            $devis=$data['devis_num'];
        ?>
        <tr>
            <th><?=$data['devis_num']?></th>
            <th><?=$data['nom_client'].'&nbsp;'.$data['prenom_client'].'-'.$data['ville_client']?></th>
            <th><?=$data['devis_montant']?></th>
            <th><?=$data['devis_date']?></th>
            <th><button onclick='window.location.href="client_info.php?id=<?=$lien?>"'>Voir Devis</button></th>
            <th class='ml-6'><button onclick='window.location.href="modif_devis.php?id=<?=$lien?>&devis=<?=$devis?>"'>Modifier Devis</button></th>
        <?php }?>
        </tr>
    </tbody>

</table>
</article>
</section>
<?php include('src/pied_page.php')?>