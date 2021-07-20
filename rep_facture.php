<?php 
    include('src/connexion.php');

	
		if(isset($_POST["param"]))
		{		

			switch($_POST["param"])
			{
				case "recup_client":
					$requete = "SELECT * FROM clients WHERE id_client = ".$_POST["ref_client"].";";
					$retours=$db->prepare($requete);
					$retours->execute();
					$retour = $retours->fetch();
					$chaine = $retour["civilite_client"]."|".$retour["nom_client"]."|".$retour["prenom_client"]."|".$retour['adresse_postal']."|".$retour['code_postal']."|".$retour['ville_client']."|".$retour['email_client']."|".$retour['telephone_fixe_client']."|".$retour['telephone_portable_client']."|".$retour['infos_complementaire'];
					print($chaine);					
				break;
				
				case "recup_article":
					$requete = "SELECT * FROM articles WHERE article_code = '".$_POST["ref_produit"]."';";
					$retours=$db->prepare($requete);
					$retours->execute();
					$retour = $retours->fetch();
					$chaine = $retour["article_designation"]."|".$retour["article_prix"]."|".$retour["article_qt"].'|'.$retour['ref_m2_mL'];	
					print($chaine);					
				break;

				case "creer_client":
					$requete = "SELECT COUNT(id_client) AS nb FROM clients WHERE nom_client='".$_POST["nom_client"]."' AND prenom_client='".$_POST["prenom_client"]."';";
					$retours=$db->prepare($requete);
					$retours->execute();
					$retour = $retours->fetch();
					if($retour["nb"]>0)	
						print("ok");
					else
					{
						$requete = "INSERT INTO clients(civilite_client, nom_client, prenom_client,adresse_postal,code_postal,ville_client,email_client,telephone_fixe_client,telephone_portable_client,infos_complementaire) VALUES ('".$_POST["civilite"]."', '".$_POST["nom_client"]."', '".$_POST["prenom_client"].'","'.$_POST["adresse_postal"]."','".$_POST["code_postal"]."','".$_POST['ville_client']."','".$_POST['email']."','".$_POST['telephone_fixe']."','".$_POST['telephone_portable']."','".$_POST['infos_complementaire']."');";
						$retours=$db->prepare($requete);
						$retours->execute();
						if($retours==1)
							print(mysqli_insert_id($db));
					}
				break;
				case "facturer":
					$com_client=$_POST['ref_client'];
					$com_date = date('d/m/Y');
					$com_montant = $_POST["total_com"];
					$texte_com = $_POST["chaine_com"];
					$tab_com = explode('|',$texte_com);
					$requete = 	"INSERT INTO devis(client_num, devis_date, devis_montant) VALUES (".$com_client.", '".$com_date."', ".$com_montant.");";
					$retours=$db->prepare($requete);
					$retours->execute();

					
					// $retours =mysqli_query($db, $requete);
					
					
					if($retours== True){
						$details_com=$db->lastInsertId();
							for($ligne=0;$ligne<sizeof($tab_com);$ligne++){
								if($tab_com[$ligne]!=""){
									$ligne_com = explode(';', $tab_com[$ligne]);
									$requete = "INSERT INTO detail(detail_devis, details_ref, details_qte) VALUES (".$details_com.", '".$ligne_com[0]."',".$ligne_com[1].");";
									$retours = $db->prepare($requete);
									$retours->execute();
								}
							}
							print("ok");
					}else{
						print("nok");
					}
				break;
				}
		}
	

?>
