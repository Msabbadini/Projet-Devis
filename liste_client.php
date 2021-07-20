<?php
    include('src/connexion.php');
    include('src/entete.php');
    include("src/header.php")
?>

<section class="page-content">
    <section class=" ">
        <article class='mb-7'>
            <h4 class="text-center font-bold">Derniers Clients ajoutés </h4>
        <table class='w-full text-center border-collapse'>
            <thead class='border-4 border-red-500  text-black'>
                <tr class='p-4'>
                    <th class='w-28'>Numéro Client</th>
                    <th class=''>Client</th>
                    <th>Email</th>
                    <th>Téléphone Client</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class='divide-y-2 divide-red-500'>
                <?php
                    $req=$db->prepare('SELECT * FROM clients ORDER BY date_creation ');
                    $req->execute();
                    while($donnees=$req->fetch()){
                        $lien=$donnees['id_client'];
                ?>
                <tr>
                    <th class='w-auto p-1'><?=$donnees['id_client']?></th>
                    <th class='w-auto'><?=$donnees['civilite_client'].'&nbsp;'.$donnees['nom_client'].'&nbsp;'.$donnees['prenom_client']?></th>
                    <th class='w-auto'><?= $donnees['email_client']?></th>
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
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"><a href="client_info.php?id=<?=$lien?>" title='Voir Client'>                                   
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                        </div>
                                        
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"><a href="delete.php?client=<?=$lien?>" title='Suppression Client'>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            </a>
                                        </div>
                                        <div class="w-4 mr-2 transform hover:text-red-500 hover:scale-110">
                                            <a href="#" title="Impression Fiche Client">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#A22121" d="M12,20H5a1,1,0,0,1-1-1V5A1,1,0,0,1,5,4h5V7a3,3,0,0,0,3,3h3v1a1,1,0,0,0,2,0V9s0,0,0-.06a1.31,1.31,0,0,0-.06-.27l0-.09a1.07,1.07,0,0,0-.19-.28h0l-6-6h0a1.07,1.07,0,0,0-.28-.19.32.32,0,0,0-.09,0A.88.88,0,0,0,11.05,2H5A3,3,0,0,0,2,5V19a3,3,0,0,0,3,3h7a1,1,0,0,0,0-2ZM12,5.41,14.59,8H13a1,1,0,0,1-1-1ZM7,8a1,1,0,0,0,0,2H8A1,1,0,0,0,8,8ZM21.71,20.29l-1.17-1.16A3.44,3.44,0,0,0,20,15h0A3.49,3.49,0,0,0,14,17.49a3.46,3.46,0,0,0,5.13,3.05l1.16,1.17a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29Zm-3.17-1.75a1.54,1.54,0,0,1-2.11,0A1.5,1.5,0,0,1,16,17.49a1.46,1.46,0,0,1,.44-1.06,1.48,1.48,0,0,1,1-.43A1.47,1.47,0,0,1,19,17.49,1.5,1.5,0,0,1,18.54,18.54ZM13,12H7a1,1,0,0,0,0,2h6a1,1,0,0,0,0-2Zm-2,6a1,1,0,0,0,0-2H7a1,1,0,0,0,0,2Z"/></svg>
                                            </a>

                                        </div>
                                    </div></th>


                </tr>
                <?php }?>
            </tbody>
        </table>


        </article>
        <article>
            <h4 class='text-center font-bold'>Devis en Cours</h4>
            <table class='w-full'>
                <thead class='bg-red-500 rounded'>
                    <tr>
                        <th>N° Devis</th>
                        <th>Client </th>
                        <th>Montant HT</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>        
                <tbody>
                    <?php
                        $req2=$db->prepare('SELECT * FROM devis INNER JOIN clients ON devis.client_num=clients.id_client ORDER BY devis_date DESC  ');
                        $req2->execute();
                        
                        while($data=$req2->fetch()){
                            $lien=$data['client_num'];
                            if($data['statut_devis'] == 'En attente' && $data['type_devis'] == 'Devis'){
                    ?>
                        <tr>
                            <th><?=$data['devis_num']?></th>
                            <th><?=$data['nom_client'].' '.$data['prenom_client'].' -'.$data['ville_client']?></th>
                            <th><?= $data['devis_montant']?>€</th>
                            <th><?=$data['statut_devis']?></th>
                            <th>
                                <div class="flex item-center justify-center">
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"><a href="client_info.php?id=<?=$lien?>" title='Voir Client'>                                   
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                        </div>
                                        
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"><a href="delete.php?devis=<?=$lien?>" title='Suppression Client'>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            </a>
                                        </div>
                                        <div class="w-4 mr-2 transform hover:text-red-500 hover:scale-110">
                                            <a href="#" title='Impression Client'>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#A22121" d="M12,20H5a1,1,0,0,1-1-1V5A1,1,0,0,1,5,4h5V7a3,3,0,0,0,3,3h3v1a1,1,0,0,0,2,0V9s0,0,0-.06a1.31,1.31,0,0,0-.06-.27l0-.09a1.07,1.07,0,0,0-.19-.28h0l-6-6h0a1.07,1.07,0,0,0-.28-.19.32.32,0,0,0-.09,0A.88.88,0,0,0,11.05,2H5A3,3,0,0,0,2,5V19a3,3,0,0,0,3,3h7a1,1,0,0,0,0-2ZM12,5.41,14.59,8H13a1,1,0,0,1-1-1ZM7,8a1,1,0,0,0,0,2H8A1,1,0,0,0,8,8ZM21.71,20.29l-1.17-1.16A3.44,3.44,0,0,0,20,15h0A3.49,3.49,0,0,0,14,17.49a3.46,3.46,0,0,0,5.13,3.05l1.16,1.17a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29Zm-3.17-1.75a1.54,1.54,0,0,1-2.11,0A1.5,1.5,0,0,1,16,17.49a1.46,1.46,0,0,1,.44-1.06,1.48,1.48,0,0,1,1-.43A1.47,1.47,0,0,1,19,17.49,1.5,1.5,0,0,1,18.54,18.54ZM13,12H7a1,1,0,0,0,0,2h6a1,1,0,0,0,0-2Zm-2,6a1,1,0,0,0,0-2H7a1,1,0,0,0,0,2Z"/></svg>
                                            </a>

                                        </div>
                                    </div></th>
                        </tr>
                    <?php }
                        }
                    ?>
                </tbody>
            </table>
        
        
        </article>
                <article>
            <h4 class="text-center font-bold">Facture En attente</h4>
                <table class="w-full">
                    <thead class="bg-red-500">
                        <tr>
                            <th>N°Facture</th>
                            <th>Client</th>
                            <th>Montant TTC</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                             $req3=$db->prepare('SELECT * FROM devis INNER JOIN clients ON devis.client_num=clients.id_client ORDER BY devis_date DESC  ');
                             $req3->execute();
                             
                             while($data=$req3->fetch()){
                                 $lien=$data['client_num'];
                                 if($data['statut_devis'] == 'En attente' && $data['type_devis'] == 'Facture'){
                        ?>
                        <tr>
                            <th><?=$data['devis_num']?></th>
                            <th><?=$data['nom_client'].' '.$data['prenom_client'].' -'.$data['ville_client']?></th>
                            <th><?= $data['devis_montant']?>€</th>
                            <th><?=$data['statut_devis']?></th>
                            <th>
                                <div class="flex item-center justify-center">
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"><a href="client_info.php?id=<?=$lien?>" title='Voir Client'>                                   
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                        </div>
                                        
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"><a href="#" onclick='confirmer()' title='Suppression Client' >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            </a>
                                        </div>
                                        <div class="w-4 mr-2 transform hover:text-red-500 hover:scale-110">
                                            
                                            <a href="#"title="Impression Fiche Client">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#A22121" d="M12,20H5a1,1,0,0,1-1-1V5A1,1,0,0,1,5,4h5V7a3,3,0,0,0,3,3h3v1a1,1,0,0,0,2,0V9s0,0,0-.06a1.31,1.31,0,0,0-.06-.27l0-.09a1.07,1.07,0,0,0-.19-.28h0l-6-6h0a1.07,1.07,0,0,0-.28-.19.32.32,0,0,0-.09,0A.88.88,0,0,0,11.05,2H5A3,3,0,0,0,2,5V19a3,3,0,0,0,3,3h7a1,1,0,0,0,0-2ZM12,5.41,14.59,8H13a1,1,0,0,1-1-1ZM7,8a1,1,0,0,0,0,2H8A1,1,0,0,0,8,8ZM21.71,20.29l-1.17-1.16A3.44,3.44,0,0,0,20,15h0A3.49,3.49,0,0,0,14,17.49a3.46,3.46,0,0,0,5.13,3.05l1.16,1.17a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29Zm-3.17-1.75a1.54,1.54,0,0,1-2.11,0A1.5,1.5,0,0,1,16,17.49a1.46,1.46,0,0,1,.44-1.06,1.48,1.48,0,0,1,1-.43A1.47,1.47,0,0,1,19,17.49,1.5,1.5,0,0,1,18.54,18.54ZM13,12H7a1,1,0,0,0,0,2h6a1,1,0,0,0,0-2Zm-2,6a1,1,0,0,0,0-2H7a1,1,0,0,0,0,2Z"/></svg>
                                            </a>

                                        </div>
                                    </div></th>
                        </tr>
                        <?php }
                             }
                        ?>
                    </tbody>
                </table>
        </article>


    </section>
</section>

<script type='text/javascript'>
    
    function confirmer(){
        var res = confirm("Etes vous sûr de vouloir la suppression ?")
        if(res){
            $req=$db->prepare('DELETE FROM devis WHERE devis_num= ?');
            $req->execute($îd)
        }
    }
</script>
<?php include('src/pied_page.php')?>