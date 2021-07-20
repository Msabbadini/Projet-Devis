<?php
    include('src/connexion.php');
    include('src/entete.php');
    include("src/header.php");
    include('src/function.php');
    if(!empty($_POST['submit'])){
        $nom=htmlspecialchars($_POST['nom']);
        $prenom=htmlspecialchars($_POST['prenom']);
        $genre=htmlspecialchars($_POST['genre']);
        $mail=htmlspecialchars($_POST['email']);
        $info=htmlspecialchars($_POST['info_complementaire']);
        $telPortalble=htmlspecialchars($_POST['telephone_portable']);
        $telFixe=htmlspecialchars($_POST['telephone_fixe']);
        $adresse=htmlspecialchars($_POST['adresse_postal']);
        $code_postal=htmlspecialchars($_POST['code_postal']);
        $ville=htmlspecialchars($_POST['ville']);
        $verifClientNom=verifClientNom($nom);
        $verifClientPrenom=verifClientPrenom($prenom);
        // if(!filter_var($mail,FILTER_VALIDATE_EMAIL)){
        //     header('location:./add_client.php?error=1&email=1');
        // };
    
        // Voir si client = inexistant
        // $verifClient=verifClient($nom,$prenom);
        // echo $verifClient.'test';
        if($verifClientNom==0 && $verifClientPrenom==0){
            $req=$db->prepare('INSERT INTO clients(civilite_client,nom_client,prenom_client,adresse_postal,code_postal,ville_client,email_client,telephone_fixe_client,telephone_portable_client,infos_complementaire) VALUES (?,?,?,?,?,?,?,?,?,?)');
            $req->execute([$genre,$nom,$prenom,$adresse,$code_postal,$ville,$mail,$telFixe,$telPortalble,$info]);
           header('location:./ajout_client.php?success=1') ;
        }
        else if($verifClientNom==0 && $verifClientPrenom==1){
            $req=$db->prepare('INSERT INTO clients(civilite_client,nom_client,prenom_client,adresse_postal,code_postal,ville_client,email_client,telephone_fixe_client,telephone_portable_client,infos_complementaire) VALUES (?,?,?,?,?,?,?,?,?,?)');
            $req->execute([$genre,$nom,$prenom,$adresse,$code_postal,$ville,$mail,$telFixe,$telPortalble,$info]);
            header('location:./ajout_client.php?success=1') ;
     
        }
        else if($verifClientNom!=0 && $verifClientPrenom==0){
            $req=$db->prepare('INSERT INTO clients(civilite_client,nom_client,prenom_client,adresse_postal,code_postal,ville_client,email_client,telephone_fixe_client,telephone_portable_client,infos_complementaire) VALUES (?,?,?,?,?,?,?,?,?,?)');
            $req->execute([$genre,$nom,$prenom,$adresse,$code_postal,$ville,$mail,$telFixe,$telPortalble,$info]);
           header('location:./ajout_client.php?success=1') ;
     
        }
        else{
            header('location:./ajout_client.php?error=1');
        }
    }
?>

<section class="page-content">
    <section class="grid">
        <article>
        <?php 
    if (isset($_GET['error'])){
    
     echo'<p id="error">Votre client est déja existant</p>';
    
    header('Refresh:2; url=ajout_client.php');    
    
    }elseif(isset($_GET['success'])){
       echo' <p>Votre ajout client est bien pris en compte</p>';
    
    header('Refresh:2; location:./liste_client.php') ;   
}
    ?>
     <form action="" method="POST">
    <legend>Genre</legend>
    <div>
        <input type="radio" name="genre" id="monsieur" value='Monsieur'><label for="monsieur">Monsieur</label>   
    <input type="radio" name="genre" id="madame" value="Madame"><label for="">Madame</label>
    </div>
    <div>
        <label for="">Nom client</label>
        <input type="text" name='nom' value=''>
    </div>
    <div>
        <label for="">Prenom client</label>
        <input type="text" name='prenom'>
    </div>
    <div>
        <label for="">Adresse Postal</label>
        <input type="text" name='adresse_postal'>
    </div>
    <div>
        <label for="">Code Postal</label>
        <input type="number" name='code_postal'>
    </div>
    <div>
        <label for="">Ville</label>
        <input type="text" name='ville'>
    </div>
    <div>
        <label for="">Adresse Mail</label>
        <input type="mail" name='email'>
        <small>Format: adressemail@email.fr</small>
    </div>
    <div>
        <label for="">Téléphone fixe</label>
        <input type="tel" name="telephone_fixe">
        <small>Format: 00-00-00-00-00</small>
    </div>
    <div>
        <label for="">Téléphone Portable</label>
        <input type="tel" name="telephone_portable" id="" >
        <small>Format: 00-00-00-00-00</small>
    </div>
    <div>
        <legend>Informations Complémentaires</legend>
        <textarea name="info_complementaire" id="" cols="30" rows="10"></textarea>
    </div>
    <input type="submit" name='submit' value="Envoyer">
    </form>
    
        </article>
        

    </section>
</section>
<?php include('src/pied_page.php');?>