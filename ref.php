<?php
    include('src/connexion.php');
    include('src/entete.php');
    include("src/header.php");

    if(!empty($_POST['insert'])){
        $ref=$_POST['reference'];
        $prix=$_POST['prix_reference'];
        $qt=$_POST['quantite'];
        $ref_Qt=$_POST['ref_qt'];
        $fournisseur=$_POST['fournisseur'];
        $ref_fournisseur=$_POST['ref_fournisseur'];

        $req=$db->prepare('INSERT INTO articles(article_designation,article_prix,article_qt,ref_m2_mL,fournisseur,ref_fournisseur) VALUES (?,?,?,?,?,?)');
        $req->execute([$ref,$prix,$qt,$ref_Qt,$fournisseur,$ref_fournisseur]);
        header('Refresh:2');
    }
    if(isset($_POST['update'])){
        $id=$_POST['ref_code'];
        $ref=$_POST['reference'];
        $prix=$_POST['prix_reference'];
        $qt=$_POST['quantite'];
        $ref_Qt=$_POST['ref_qt'];
        $fournisseur=$_POST['fournisseur'];
        $ref_fournisseur=$_POST['ref_fournisseur'];
        $req2=$db->prepare('UPDATE articles SET article_designation=? , article_prix=? , article_qt=? , ref_m2_mL=? , fournisseur=? , ref_fournisseur=? WHERE article_code='.$id.'');
        $req2->execute(array($ref,$prix,$qt,$ref_Qt,$fournisseur,$ref_fournisseur));
        header('Refresh:2');
    }
    if(isset($_POST['delete'])){
        $id=$_POST['id_delete'];
        $req=$db->prepare('DELETE FROM articles WHERE article_code='.$id.'');
        $req->execute();
        header('Refresh:2');
    }
    
?>

<section class="page-content">
    <article>
        <form action="" method='POST'>
            <Legend>Ajout Référence Devis</Legend>
            <div>
                <label for="">Désignation Référence</label>
                <input type="text" name='reference'>
            </div>
            <div>
                <label for="">Prix unitaire HT</label>
                <input type="text" name='prix_reference'>
            </div>
            <div>
                <label for="">Quantite reference</label>
                <input type="text" name='quantite'>
            </div>
            <div>
                <label for="">M² | ML</label>
                <input type="radio" name="ref_qt" value='M²' id=""><label for="">M²</label>
                <input type="radio" name="ref_qt" value='ML' id=""><label for="">ML</label>
                <input type="radio" name="ref_qt" value='unite' id=""><label for="">Unitaire</label>
                <input type="radio" name="ref_qt" value='' id=""><label for="">Aucun</label>
                

            </div>
            <div>
                <label for="">Fournisseur</label>
              
                <input type="radio" name="fournisseur" value='Point_Z' id=""><label for="">Point Z</label>
                <input type="radio" name="fournisseur" value='Wurth' id=""><label for="">Wurth</label>
                <input type="radio" name="fournisseur" value='' id=""><label for="">Aucun</label>
            </div>
            <div>
                <label for="">Référence Fournisseur</label>
                <input type="text" name='ref_fournisseur'>
            </div>
            <div>
                <input type="submit" name='insert'value="Envoyer">
            </div>
        </form>
    </article>
    <article>
        Liste Référence
        <table>
            <thead>
                <tr>
                    <th>Code Référence</th>
                    <th>Désignation Référence</th>
                    <th>Prix Référence</th>
                    <th>Quantite Référence</th>
                    <th>Fournisseur</th>
                    <th>Référence Fournisseur</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $req=$db->prepare('SELECT * FROM articles ORDER BY article_code');
                    $req->execute();
                    while($data=$req->fetch()){
                ?>
                    <tr>
                        <th><?=$data['article_code']?></th>
                        <th><?=$data['article_designation']?></th>
                        <th><?=$data['article_prix']?></th>
                        <th><?=$data['article_qt'].'&nbsp;'.$data['ref_m2_mL']?></th>
                        <th><?=$data['fournisseur']?></th>
                        <th><?=$data['ref_fournisseur']?></th>
                        <th>
                        <details>
            <summary>
                <div class="button">Suppression</div>
                <div class="details-modal-overlay"></div>
            </summary>
            <div class="details-modal">
                <div class="details-modal-close">
                <i class="uil uil-times-circle"></i>
                </div>
                <div class="details-modal-title">
                    <h1>Suppression <?=$data['article_designation']?></h1>
                </div>
                <div class='details-modal-content'>
                   <h4>Etes-vous sûr de vouloir faire la suppression ?</h4>
                   <form action="" method='post'>
                   <label for=""><?=$data['article_designation']?></label><br>
                   <input type="hidden" name="id_delete" value='<?=$data['article_code']?>'>
                   <input type="submit" name='delete' value="Valider">
                   </form>
                   
                </div>
            </div>
        </details>
                        
                        </th>
                        <!-- MODAL MODIF -->
                        <th> 
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
                    <h1>Modification <?=$data['article_designation']?></h1>
                </div>
                <div class='details-modal-content'>
                <form action="" method='POST'>
                <div>
                <label for="">Code référence</label>
                <input type="text" name='ref_code' value='<?=$data['article_code']?>'>
                </div>
            <div>
                <label for="">Désignation Référence</label>
                <input type="text" name='reference' value='<?=$data['article_designation']?>'>
            </div>
            <div>
                <label for="">Prix unitaire HT</label>
                <input type="text" name='prix_reference' value='<?=$data['article_prix']?>'>
            </div>
            <div>
                <label for="">Quantite reference</label>
                <input type="text" name='quantite' value='<?=$data['article_qt']?>'>
            </div>
            <div>
                <label for="">M² | ML</label>
                <input type="radio" name="ref_qt" value='M²' <?php if(isset($data['ref_m2_mL']) && $data['ref_m2_mL'] =="M²") echo"checked";?>><label for="">M²</label>
                <input type="radio" name="ref_qt" value='ML' <?php if(isset($data['ref_m2_mL']) && $data['ref_m2_mL'] =="ML") echo"checked";?>><label for="">ML</label>
                <input type="radio" name="ref_qt" value='unite' <?php if(isset($data['ref_m2_mL']) && $data['ref_m2_mL'] =="unite") echo"checked";?>><label for="">Unitaire</label>
                <input type="radio" name="ref_qt" value='' <?php if(isset($data['ref_m2_mL']) && $data['ref_m2_mL'] =="") echo"checked";?>><label for="">Aucun</label>

            </div>
            <div>
                <label for="">Fournisseur</label>
              
                <input type="radio" name="fournisseur" value='Point_Z' <?php if(isset($data['fournisseur']) && $data['fournisseur'] =="Point_Z") echo"checked";?>><label for="">Point Z</label>
                <input type="radio" name="fournisseur" value='Wurth' <?php if(isset($data['fournisseur']) && $data['fournisseur'] =="Wurth") echo"checked";?>><label for="">Wurth</label>
                <input type="radio" name="fournisseur" value='' <?php if(isset($data['fournisseur']) && $data['fournisseur'] =="") echo"checked";?>><label for="">Aucun</label>
            </div>
            <div>
                <label for="">Référence Fournisseur</label>
                <input type="text" name='ref_fournisseur' value='<?=$data['ref_fournisseur']?>'>
            </div>
            <div>
                <input type="submit" id='modification' value="Modification" name='update'>
            </div>
        </form>
                </div>
            </div>
        </details></th>
                <?php }?>
                    </tr>
            </tbody>
    </table>
    </article>
    
</section>
<?php include('src/pied_page.php')?>