<?php
    include('src/connexion.php');
    include('src/entete.php');
    include("src/header.php")
?>
    <script language='javascript' type="text/javascript">
function recolter()
{
	document.getElementById("formulaire").request({
		onComplete:function(transport){
			switch(document.getElementById('param').value)
			{
				case 'recup_client':
					var tab_info = transport.responseText.split('|');
					document.getElementById('civilite').value = tab_info[0];
					document.getElementById('nom_client').value = tab_info[1];
					document.getElementById('prenom_client').value = tab_info[2];
					document.getElementById('adresse_postal').value=tab_info[3];			
					document.getElementById('code_postal').value=tab_info[4];			
					document.getElementById('ville_client').value=tab_info[5];			
					document.getElementById('email').value=tab_info[6];			
					document.getElementById('telephone_fixe').value=tab_info[7];			
					document.getElementById('telephone_portable').value=tab_info[8];			
					document.getElementById('infos_complementaire').value=tab_info[9];			
					break;
				
				case 'recup_article':
					var tab_info = transport.responseText.split('|');
					document.getElementById('designation').value = tab_info[0];
					document.getElementById('puht').value = tab_info[1];
					document.getElementById('qte').value = tab_info[2];
					document.getElementById('ref_qt').value = tab_info[3];					
				break;
				
				case 'facturer':
					var rep = transport.responseText;
					if(rep =="ok"){
						alert("Le devis est crée");
					}else{
						alert('Une erreur est survenue');
						console.log(rep);
					};
				break;
			}	
		}
	});
}
</script>
<section class="page-content">
    <article>
			
									
			
			<div class=' w-1/6 h-10' ></div>
			<div class='w-full'>
			<div class="border border-gray-500 text-center h-16 rounded-md">
			<h1 class='mt-5 font-semibold text-xl'>Devis Client</h1>
			</div>
			</div>
			
			<div class="div_saut_ligne" style="height:30px;">
			</div>
			
			<div  class='w-full h-auto text-center'>
			<form id="formulaire" name="formulaire" method="post" action="rep_facture.php">
				<div class="border border-gray-600 text-center h-auto rounded-md">
					
					<div class="text-lg font-bold text-left text-red-800 m-5">
						<u>Informations du client</u><br />
					</div>
				
					<div class='text-lg font-bold text-left ml-5 w-1/3'>
						Réf. Client :<br />
						<select class='h-auto' id="ref_client" name="ref_client" onchange="document.getElementById('param').value='recup_client';recolter();">
							<option value="0">Choisir client</option>
							<?php 
								$requete = "SELECT * FROM clients ORDER BY id_client;";
								$retours = $db->prepare($requete);
								$retours->execute();
								while($retour=$retours->fetch())
								{
									echo "<option value='".$retour["id_client"]."'>".$retour["nom_client"]."&nbsp;".$retour['prenom_client'].' - '.$retour['ville_client']."</option>";
								}
							?>
						</select>
					</div>
					<div class='flex flex-wrap '>
					<div  class=' w-20 h-3.5 text-sm font-bold text-left  m-5'>
						Civilité :<br />
						<input class='pl-2' type="text" id="civilite" name="civilite" />
					</div>
					<div class='w-auto h-3.5 text-sm font-bold text-left  m-5'>
						Nom du client :<br />
						<input class='pl-2' type="text" id="nom_client" name="nom_client" />
					</div>
					<div class='w-1/6 h-3.5 text-sm font-bold text-left  m-5'>
						Prénom du client :<br />
						<input class='pl-2' type="text" id="prenom_client" name="prenom_client" />
					</div>					
					

					<div class='w-2/5 text-left text-md font-bold m-5'>
					Adresse Postal:<br>
								<input class='pl-2' type="text" id='adresse_postal' name='adresse_postal'>
					</div>
					<div class='w-1/6 text-left text-md font-bold m-5' >
								code Postal:<br>
								<input class='pl-2' type="text" id='code_postal' name='code_postal'>
					</div>
					<div  class=' w-1/5 text-md font-bold text-left m-5'>
								Ville:<br>
								<input class='pl-2' type="text" id='ville_client' name='ville_client'>
					</div>
					
					
					<div  class='w-2/5 text-md font-bold text-left m-5'>
								Email:<br>
								<input class='pl-2' type="text" id='email' name='email'>
					</div>
					<div  class='w-1/5 text-md text-left font-bold m-5'>
								Telephone Fixe:<br>
								<input class='pl-2' type="text" id='telephone_fixe' name='telephone_fixe'>
					</div>
					<div class='w-1/5 text-md text-left font-bold m-5' >
								Telephone Portable:<br>
								<input class='pl-2' type="text" id='telephone_portable' name='telephone_portable'>
					</div>
				
					</div>

			<div class="div_saut_ligne" style="height:5px;">
			</div>

					
					<div class='w-4/5 h-auto text-lg font-bold text-left m-5 text-red-800' >
						<u>Ajout des références devis</u><br />
					</div>
					<div class="flex flex-wrap">
					<div class='w-1/6 h-auto text-xl font-bold text-left m-5'>
						Réf. Produit :<br />
						<select id="ref_produit" name="ref_produit" onchange="document.getElementById('param').value='recup_article';recolter();" class='h-auto'>
							<option value="0">Réf. produit</option>
							<?php 
								$requete = "SELECT * FROM articles ORDER BY article_code;";
								$retours = $db->prepare($requete);
								$retours->execute();
								while($retour = $retours->fetch())
								{
									echo "<option value='".$retour["article_code"]."'>".$retour["article_designation"]."</option>";
								}							
							?>
						</select>
					</div>
					<div class=' w-1/6 h-5 text-lg font-bold text-left m-5'>
						Qté Unitaire :<br />
						<input type="text" id="qte" name="qte" disabled style="text-align:right;" />
					</div>
					<div class=' w-1/6 h-5 text-lg font-bold text-left m-5'>
								<label for="">Metrage:</label>
						<input type="text" id='ref_qt' name='ref_qt' disabled style='text-align:right;'/>
					</div>
					<div class=' w-5/12 h-5 text-lg font-bold text-left m-5'>
						Désignation du produit :<br />
						<input type="text" id="designation" name="designation" disabled />
					</div>
					<div class=' w-1/6 h-5 text-lg font-bold text-left m-5'>
						Prix unitaire HT :<br />
						<input type="text" id="puht" name="puht" disabled style="text-align:right;" />
					</div>		
					<div style="width:10%;height:75px;float:left;"></div>				

			</div>
				<div class='flex flex-wrap'>
					<div class=' w-1/6 h-5 text-lg font-bold text-left m-5'>
						Qté commandée :<br />
						<input type="text" id="qte_commande" name="qte_commande" />
					</div>
					<div class=' w-1/6 h-5 text-lg font-bold text-left m-5'>
						Total commande :<br />
						<input type="text" id="total_commande" name="total_commande" disabled />
					</div>
					<div class=' w-1/6 h-auto text-lg font-bold text-left m-10'>
						<input type="button" id="ajouter" name="ajouter" value="Ajouter" class="mt-1 text-white  " onclick='plus_com();' />
						<input type="text" id="param" name="param" style="visibility:hidden;" />
					</div>
					<div class=' w-1/6 h-auto text-lg font-bold text-left m-10 '>
						<input type="button" id="valider" name="valider" value="Valider"  class="mt-1 text-white bg-green-700" onclick="document.getElementById('param').value='facturer';recolter();"/><br />
                        <input type="text" id="chaine_com" name="chaine_com" style="visibility:hidden;" />
                        <input type="text" id="total_com" name="total_com" style="visibility:hidden;" />
					</div>	
				</div>			
			
									
								
			</form>
			</div>
			</div>

			<div class="div_saut_ligne" style="height:50px;">
			</div>						
			
			<div style="float:left;width:10%;height:25px;"></div>
			<div style="float:left;width:80%;height:auto;text-align:center;">
				<div  class='h-auto w-auto  border border-gray-600 flex flex-wrap align-center'>
				<div  class='w-1/12 h-3.5'></div>

					<div  class='w-1/12 h-2.5 text-lg font-bold text-center'>
						Réf.
					</div>
					<div class='w-1/12 h-2.5 text-lg font-bold text-center'>
						Qté
					</div>
					<div class='w-6/12 h-2.5 text-lg font-bold text-center'>
						Désignation du produit
					</div>
					<div class='w-1/12 h-2.5 text-lg font-bold text-center'>
						PUHT
					</div>
					<div class='w-1/12 h-2.5 text-lg font-bold text-center'>
						PTHT
					</div>
					<div style="float:left;width:5%;height:25px;"></div>
					
					<div class=' w-full h-auto flex flex-wrap' id='det_com'>
						<div class='w-1/12 h-3.5'></div>
						<div class="w-1/12 h-auto text-center">
							B001
						</div>
						<div class="w-1/12 h-auto text-center">
							125
						</div>
						<div class="w-6/12  h-auto text-center">
							Chaise roulante pour bureau d'entreprise
						</div>
						<div class="w-1/12 h-auto text-center">
							125.25
						</div>
						<div class="w-1/12 h-auto text-center font-bold" >
							1243.75
						</div>
						<div  class='w-1/12 h-3.5'></div>

						<div class='w-full h-auto' id="editer">
</div>	
						
					</div>				
					
				</div>
			</div>
			
			<div class="div_saut_ligne" style="height:30px;">
			</div>				
    </article>

</section>
<script language='javascript' type="text/javascript" >
    var tot_com=0;
    function plus_com(){
        if(ref_client.value!=0 && ref_produit.value!=0 ){
            var ref_p = ref_produit.value;
            var qte_p = qte_commande.value;
            var des_p = designation.value;
            var pht_p = puht.value;

            tot_com = tot_com + qte_p*pht_p;
            total_commande.value = tot_com.toFixed(2);
            total_com.value = total_commande.value;
            chaine_com.value += "|" + ref_p +";" + qte_p + ";" + des_p + ";" + pht_p;
            facture();
        }
    }

    function facture(){
        var tab_com = chaine_com.value.split('|');
        var nb_lignes = tab_com.length;
        document.getElementById("det_com").innerHTML = "";
        for (ligne=0; ligne<nb_lignes; ligne++)
        {
        if(tab_com[ligne]!="")
        {
        var ligne_com = tab_com[ligne].split(';');
        document.getElementById("det_com").innerHTML += "<div class='w-1/12 h-3.5'></div>";
        document.getElementById("det_com").innerHTML += "<div class='w-1/12 h-auto text-center'>" + ligne_com[0] + "</div>";
        document.getElementById("det_com").innerHTML += "<div class='w-1/12 h-auto text-center'>" + ligne_com[1] + "</div>";
        document.getElementById("det_com").innerHTML += "<div class='w-6/12  h-auto text-center'>" + ligne_com[2] + "</div>";
        document.getElementById("det_com").innerHTML += "<div class='w-1/12 h-auto text-center'>" + ligne_com[3] + "</div>";
        document.getElementById("det_com").innerHTML += "<div class='w-1/12 h-auto text-center font-bold'>" + (ligne_com[1]*ligne_com[3]).toFixed(2) +"</div>";
		
        document.getElementById("det_com").innerHTML += "<div class='bord'><input type='button' value='X' title='Supprimer le produit' style='height:20px;font-size:12px;' onclick='suppr(\""+tab_com[ligne]+"\");'/></div>";
        }
        }
    }
	function suppr(ligne_s){
		chaine_com.value = chaine_com.value.replace('|' + ligne_s, '');
		var tab_detail = ligne_s.split(";");

		total_commande.value = (total_commande.value - tab_detail[1]*tab_detail[3]).toFixed(2);
		total_com.value = total_commande.value;
		tot_com = total_com.value*1;

		facture();
	}
</script>
<?php include('src/pied_page.php')?>