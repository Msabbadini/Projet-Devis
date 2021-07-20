<?php
require('src/connexion.php');
include('src/function.php');
$id=null;
$success=0;
$nDevis=1;
$nFacture=2;

if(!empty($_GET['id'])){
    $id=$_REQUEST['id'];
    $success=0;
}

if ($_SERVER['REQUEST_METHOD']== 'POST' && !empty($_POST)) {
    $nom=$_POST['nom'];
    $prenom=$_POST['prenom'];
    $genre=$_POST['genre'];
    $mail=$_POST['email'];
    $info=$_POST['info_complementaire'];
    $telPortalble=$_POST['telephone_portable'];
    $telFixe=$_POST['telephone_fixe'];
    $adresse=$_POST['adresse_postal'];
    $code_postal=$_POST['code_postal'];
    $ville=$_POST['ville'];

    $sql='UPDATE clients SET civilite_client=?,nom_client=?,prenom_client=?,adresse_postal=?,code_postal=?,ville_client=?,email_client=?,telephone_fixe_client=?,telephone_portable_client=?,infos_complementaire=? WHERE id_client='.$id.'';
    $req=$db->prepare($sql);
    $req->execute([$genre,$nom,$prenom,$adresse,$code_postal,$ville,$mail,$telFixe,$telPortalble,$info]);

    $success=1;
}
$req2=$db->prepare('SELECT * FROM clients WHERE id_client=?');
$req2->setFetchMode(PDO::FETCH_ASSOC);
$req2->execute(array($id));
$data=$req2->fetch();

$nom=$data['nom_client'];
$prenom=$data['prenom_client'];
$genre=$data['civilite_client'];
$mail=$data['email_client'];
$info=$data['infos_complementaire'];
$telPortalble=$data['telephone_portable_client'];
$telFixe=$data['telephone_fixe_client'];
$adresse=$data['adresse_postal'];
$code_postal=$data['code_postal'];
$ville=$data['ville_client'];

include('src/entete.php');
include("src/header.php")
?>
<section class="page-content">
    <div class="container">
        <details>
            <summary>
                <div class="button">Modification</div>
                <div class="details-modal-overlay"></div>
            </summary>
            <div class="details-modal">
                <div class="details-modal-close">
                <i class="uil uil-times-circle"></i>
                </div>
                <div class="details-modal-title">
                    <h1>Modification <?=$data['nom_client']?></h1>
                    <?php 
 if($success== 1){
    echo '<p id="success"> Vos modifications ont bien été pris en compte</p>';
}
?>
                </div>
                <div class='details-modal-content'>
 
<form action="" method="POST">
    <legend>Genre</legend>
    <div>
        <input type="radio" name="genre" id="monsieur" value='Monsieur'<?php if(isset($genre) && $genre =="Monsieur") echo"checked";?>><label for="monsieur">Monsieur</label>   
    <input type="radio" name="genre" id="madame" value="Madame"<?php if(isset($genre) && $genre =="Madame") echo"checked";?>><label for="">Madame</label>
    </div>
    <div>
        <label for="">Nom client</label>
        <input type="text" name='nom' value='<?= $nom ?>'>
    </div>
    <div>
        <label for="">Prenom client</label>
        <input type="text" name='prenom' value='<?= $prenom?>'>
    </div>
    <div>
        <label for="">Adresse Postal</label>
        <input type="text" name='adresse_postal' value='<?=$adresse ?>'>
    </div>
    <div>
        <label for="">Code Postal</label>
        <input type="number" name='code_postal' value='<?= $code_postal?>'>
    </div>
    <div>
        <label for="">Ville</label>
        <input type="text" name='ville' value='<?= $ville?>'>
    </div>
    <div>
        <label for="">Adresse Mail</label>
        <input type="mail" name='email' value='<?= $mail?>'>
        <small>Format: adressemail@email.fr</small>
    </div>
    <div>
        <label for="">Téléphone fixe</label>
        <input type="tel" name="telephone_fixe" value='<?= $telFixe?>'>
        <small>Format: 00-00-00-00-00</small>
    </div>
    <div>
        <label for="">Téléphone Portable</label>
        <input type="tel" name="telephone_portable" value='<?= $telPortalble?>'>
        <small>Format: 00-00-00-00-00</small>
    </div>
    <div>
        <legend>Informations Complémentaires</legend>
        <textarea name="info_complementaire" id="" cols="30" rows="10" ><?=$info?></textarea>
    </div>
    <input type="submit" name='submit' value="Envoyer">
    </form>
                </div>
            </div>
        </details>
        <details>
            <summary>
                <div class="button">Suppression Client</div>
                <div class="details-modal-overlay"></div>
            </summary>
            <div class="details-modal">
                <div class="details-modal-close">
                <i class="uil uil-times-circle"></i>
                </div>
                <div class="details-modal-title">
                    <h1>Suppression <?=$data['nom_client']?></h1>
                </div>
                <div class='details-modal-content'>
                   
                </div>
            </div>
        </details>
    </div>
<p>Numéro Client: <?= $data['id_client']?></p>
    <p>Client : <?= $genre.'&nbsp;'.$nom.'&nbsp;'.$prenom?></p>
    <p>Adresse : <?= $adresse.',&nbsp;'.$code_postal.'&nbsp;'.$ville?></p>
    <p>Email : <?=$mail?></p>
    <p>Téléphone Fixe :<?=$telFixe?></p>
    <p>Téléphone Portable :<?=$telPortalble?></p>
    <p>Date création : <?= $data['date_creation']?></p>

<h4>Devis Client</h4>
<?php
$id_client=$_REQUEST['id'];
$req=$db->prepare('SELECT * FROM devis WHERE client_num = ?');
$req->execute(array($id_client));

while($donnees = $req->fetch()){
?>
<h4><?=$donnees['type_devis']?> n°<?=$donnees['devis_num']?></h4>
<p>Date du Devis : <?=$donnees['devis_date']?></p>
<p>Montant Devis : <?=$donnees['devis_montant']?>€</p>
 <a href="./src/edition.php?info=<?=$donnees['client_num'].'-'.$donnees['devis_num'].'-'.$nDevis?>">Impression Devis </a>
 <a href="./src/edition.php?info=<?=$donnees['client_num'].'-'.$donnees['devis_num'].'-'.$nFacture?>">Impression Facture</a>

        <div>
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Désignation Produit</th>
                                <th>Qté</th>
                                <th>PUHT</th>
                                <th>PTHT</th>
                            </tr>
                        </thead>   
                        <tbody>
                        <?php
    $id=$donnees['devis_num'];
        $req2= $db->prepare('SELECT * FROM devis 
        INNER JOIN detail ON devis_num = detail_devis  
        INNER JOIN articles ON details_ref = article_code 
        WHERE devis_num = ? 
        ORDER BY devis_date');
        $req2->execute(array($id));

        while($data=$req2->fetch()){   
    ?>
                            <tr>
                                <th><?=$data['article_designation']?></th>
                                <th><?=$data['details_qte']?></th>
                                <th><?=$data['article_prix'].'€/'.$data['article_qt'].'&nbsp;'.$data['ref_m2_mL']?></th>
                                <th><?php echo $data['article_prix'] * $data['details_qte']?>€</th>
                            </tr>
        <?php  }?>
                        </tbody>
                    </table>
                
                </div>
        </div>
        <?php  }?>

</section>

<script type='text/javascript'>








}
</script>
<?php include('src/pied_page.php')?>