<?php
    include('src/connexion.php');
    include('src/entete.php');
    include("src/header.php")
?>
<section class='page-content'>
  <section class="grid">
    <article>
        <h4>Derniers Ajout Client</h4>
        <table>
            <thead>
                <tr>
                    <th>Numéro Client</th>
                    <th>Client</th>
                    <th>Email</th>
                    <th>Téléphone Client</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $req=$db->prepare('SELECT * FROM clients ORDER BY date_creation DESC LIMIT 5 ');
                    $req->execute();
                    while($donnees=$req->fetch()){
                        $lien=$donnees['id_client'];
                ?>
                <tr>
                    <th><?=$donnees['id_client']?></th>
                    <th><?=$donnees['civilite_client'].'&nbsp;'.$donnees['nom_client'].'&nbsp;'.$donnees['prenom_client']?></th>
                    <th><?= $donnees['email_client']?></th>
                    <th><?php
                    if($donnees['telephone_fixe_client']!=''){
                    echo'<i class="uil uil-phone-alt"></i>'.$donnees['telepone_fixe_client'].'&nbsp;-&nbsp;<i class="uil uil-mobile-android"></i>'.$donnees['telephone_portable_client'];
                    }elseif($donnees['telephone_fixe_client']==''){
                        echo '<i class="uil uil-mobile-android"></i>'.$donnees['telephone_portable_client'];
                    }elseif($donnees['telephone_portable_client']==""){
                        echo'<i class="uil uil-phone-alt"></i>'.$donnees['telepone_fixe_client'];
                    }
                    ?></th>
                    <th><div class="flex item-center justify-center">
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"><a href="client_info.php?id=<?=$lien?>">                                   
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                        </div>
                                    
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"><a href="delete.php?id=<?=$lien?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            </a>
                                        </div>
                                    </div></th>


                </tr>
                <?php }?>
            </tbody>
        </table>
    </article>
    <article>
        Chiffre Affaire 
    </article>
    <article>
    Achat Matériel
    </article>
    <article>Devis en cours</article>
    <article></article>
    <article></article>
    <article></article>
    <article></article>
  </section>
</section>


<?php include('src/pied_page.php')?>