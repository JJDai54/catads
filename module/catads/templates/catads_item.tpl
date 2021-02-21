<{if $smarty.const._CATADS_SHOW_TPL_NAME==1}>
    <div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/style.css" />
<script src="<{$xoops_url}>/modules/catads/js/zoombox.js" language="javascript" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
function affichagePhotos() 
{ 
    var photos = document.getElementById('galerie_mini') ; 
    // On récupère l'élément ayant pour id galerie_mini 
    var liens = photos.getElementsByTagName('a') ; 
    // On récupère dans une variable tous les liens contenu dans galerie_mini 
    var big_photo = document.getElementById('grand_format') ; 
    // Ici c'est l'élément ayant pour id grand_format qui est récupéré, c'est notre photo en taille normale 
    var titre_photo = document.getElementById('photo').getElementsByTagName('dt')[0] ; 
    // Et enfin le titre de la photo de taille normale 
 
    //boucle parcourant l'ensemble des liens contenu dans galerie_mini 
    for (var i = 0 ; i < liens.length ; ++i) { 
        // clique sur les miniatures  
        //liens[i].onclick = function() { 
		//passage sur les miniatures 
        liens[i].onmouseover = function() { 		
            big_photo.src = this.href; // On change l'attribut src de l'image en le remplaçant par la valeur du lien 
            big_photo.alt = this.title; // On change son titre 
            titre_photo.firstChild.nodeValue = this.title; // On change le texte de titre de la photo 
            return false; // Et pour finir on inhibe l'action réelle du lien 
        }; 
    } 
} 
window.onload = affichagePhotos; 
// Il ne reste plus qu'à appeler notre fonction au chargement de la page
</script>
<!-- si aucune annonce  -->
<{if not $ad_exists and not $preview}>
	<{$smarty.const._MD_CATADS_NO_ADS}>
<{else}>

<!--rappel mettre boite de recherche////////////////////////////////////////-->
<br />
<!-- ajout CPascalWeb - 24 novembre 2010 - pub sur la page de l'annonce -->
<{if $aff_pub_annonce == 1}>
<div align="center">
<{if $aff_pub_annonce_site < 1}>
<{$pub}>
<{else}>
<{$xoops_banner}>
</div>
<div style="clear: both;"></div>
<br />
<{/if}>
<{/if}>
<!-- navigation interne -->
<{if not $preview}>
	<div align="left" style="font-size: 11px;"><{$link_cat}></div>
<{/if}>
<br />
<{* ------------------------------------------------------------------------ *}>
<div id="catads_annonce" name="catads_annonce" >
<!-- Annonces -->
<!-- type et titre de l'annonce -->
<{if $show_ad_type == 1}>
<div id="centerCcolumn" class="blockTitle" style="line-height: 1.1em; font-size: .9em;" align="left" alt="<{$smarty.const._MD_CATADS_DESCANNONCE}> <{$annonce.type}>: <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_DESCANNONCE}> <{$annonce.type}>: <{$annonce.title}>"><h2><{$smarty.const._MD_CATADS_DESCANNONCE}> <{$annonce.type}>: <{$annonce.title}></h2></div>
<{else}>
<div id="centerCcolumn" class="blockTitle" style="line-height: 1.1em; font-size: .9em;" alt="<{$smarty.const._MD_CATADS_DESCANNONCE}> <{$annonce.type}>: <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_DESCANNONCE}> <{$annonce.type}>: <{$annonce.title}>"><h2><{$annonce.title}></h2></div>
<{/if}>
<table border="0" cellspacing="1" cellpadding="0">
<tr>
<td align="left">
<div class="odd">&nbsp;<{$annonce.type}>:&nbsp;<{$annonce.title}><{if $annonce.price > '0'}>&nbsp;<{$annonce.price}>&nbsp;<{$annonce.monnaie}><{else}>&nbsp;<{/if}></div>
<!-- texte de l'annonce -->
<div align="left" class="itemText"> 					
<{$annonce.description}>
</div> 
<!--//bloc colonne droite -->
<td class="colonnebloc" align="center">
<div class="odd" alt="<{$smarty.const._MD_CATADS_DESCANNONCE}> <{$annonce.type}>: <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_DESCANNONCE}> <{$annonce.type}>: <{$annonce.title}>"><{$smarty.const._MD_CATADS_BLOC_PHOTOVIDEO}></div>
<table border="0" cellspacing="0" cellpadding="0" class="bloc_infoannonces">
<tr>
<td class="bloc_infoannoncestexte">
<!--//bloc photos & vidéos de l'annonce -->
<table border="0" cellspacing="1" cellpadding="0">
<tr>
<td id="galerie" align="left">
<!--//vignettes annonce --> 
<{if $annonce.photo}>
<ul id="galerie_mini"> 
<table border="0" cellspacing="0" cellpadding="0">
<tr>
<td><{$annonce.photo0}></td>
<td><{$annonce.photo1}></td>
<td><{$annonce.photo2}></td>
</tr>
<tr>
<td><{$annonce.photo3}></td>
<td><{$annonce.photo4}></td>
<td><{$annonce.photo5}></td>
</tr>
</table>
</ul>
<{else}>
<div align='center'>
<{$annonce.photo0}>
<div style="clear: both;"></div>
<{$smarty.const._MD_CATADS_PAS_PHOTO}>
</div>
<{/if}>	
<!--// video -->
<{if $annonce.video}>
<table border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="video">
<{$annonce.video}>
</td>	
</tr>
</table>
<{else}>
<{/if}>	
</td>	
<td>
<!--//photos principal annonce -->
<dl id="photo">
<{$annonce.photo}>
</dl>
</td>				  
</tr>
</table>
<!-- ajout option cpascalweb - le 24 novembre 2010 afficher une pub dans le bloc Photos & vidéo de l'annonce -->
<{if $aff_pub_annonce_bloc == 1}>
<table border="0" cellspacing="0" cellpadding="0">
<tr>
<{if $aff_pub_annonce_bloc_site < 1}>
<td align="center" class="pub_bloc_infoannonces"><{$pub_bloc_photosvideo}></td>
<{else}>
<td align="center" class="pub_bloc_infoannonces"><{$xoops_banner}></td>
<{/if}>
</tr>
</table>
<{/if}>
<!-- fin -->
</td>
</tr>
</table>
</td>
</tr>
</table>
<!-- informations de l'annonce -->
<div style="clear: both;"></div>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
<!-- prix et conditions -->
<{if $annonce.price > '0'}> 
<h2 align="left" alt="<{$smarty.const._MD_CATADS_DESCANNONCE}> <{$annonce.type}> <{$annonce.title}> <{$annonce.price}> <{$annonce.monnaie}>" title="<{$smarty.const._MD_CATADS_DESCANNONCE}> <{$annonce.type}>: <{$annonce.title}> <{$annonce.price}> <{$annonce.monnaie}>"><{$smarty.const._MD_CATADS_PRICE2}>&nbsp;<{$annonce.price}>&nbsp;<{$annonce.monnaie}><{if $annonce.price_option}>&nbsp;-&nbsp;<{$smarty.const._MD_CATADS_BLOC_COND}>&nbsp;<{$annonce.price_option}></h2>
<{/if}>
<{else}>
&nbsp;
<{/if}>
<td>
<div style="clear: both;"></div>
<!-- infos de l'annonce -->
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
<!-- adresse de l'annonceur -->
<td width="70%" align="left">
<div id="centerCcolumn" class="blockTitle" style="line-height: 1.1em; font-size: .9em;" alt="<{$smarty.const._MD_CATADS_DESCANNONCE}> <{$annonce.type}> <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_BLOC_ADRESSE}> <{$smarty.const._MD_CATADS_DESCANNONCE}> <{$annonce.type}> <{$annonce.title}>"><{$smarty.const._MD_CATADS_BLOC_ADRESSE}></div>
<!-- département -->
<div class="annonce_adresseleft" alt="<{$smarty.const._MD_CATADS_BLOC_DEPARTEMENT}> <{$annonce.departement}> <{$annonce.type}> <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_BLOC_DEPARTEMENT}> <{$annonce.departement}> <{$annonce.type}> <{$annonce.title}>"><{$smarty.const._MD_CATADS_BLOC_DEPARTEMENT}>&nbsp;<{$annonce.departement}></div>
<!-- région -->
<div class="annonce_adresseright" alt="<{$smarty.const._MD_CATADS_BLOC_REGION}> <{$annonce.region}> <{$annonce.type}> <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_BLOC_REGION}> <{$annonce.region}> <{$annonce.type}> <{$annonce.title}>"><{$smarty.const._MD_CATADS_BLOC_REGION}>&nbsp;<{$annonce.region}></div>
<div style="clear: both;"></div>
<!-- ville -->
<div class="annonce_adresseleft" alt="<{$smarty.const._MD_CATADS_BLOC_VILLE}> <{$annonce.town}> <{$annonce.type}> <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_BLOC_VILLE}> <{$annonce.town}> <{$annonce.type}> <{$annonce.title}>"><{$smarty.const._MD_CATADS_BLOC_VILLE}>&nbsp;<{$annonce.town}></div>
<!-- code postal -->
<div class="annonce_adresseright" alt="<{$smarty.const._MD_CATADS_BLOC_CPOSTAL}> <{$annonce.codpost}> <{$annonce.type}> <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_BLOC_CPOSTAL}> <{$annonce.codpost}> <{$annonce.type}> <{$annonce.title}>"><{$smarty.const._MD_CATADS_BLOC_CPOSTAL}>&nbsp;<{$annonce.codpost}></div>
</td>
<td align="left"></td>
<!-- tags/mots clés + ajout rapide CPascalWeb type (rappel: ajouter région ville code postal département dans tags) --> 
<td align="left">
<div id="centerCcolumn" class="blockTitle" style="line-height: 1.1em; font-size: .9em;" align="center" alt="<{$smarty.const._MD_CATADS_DESCANNONCE}> <{$annonce.type}>: <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_BLOC_TAGS}> <{$smarty.const._MD_CATADS_DESCANNONCE}> <{$annonce.type}>: <{$annonce.title}>"><{$smarty.const._MD_CATADS_BLOC_TAGS}></div>
<{$link_tags}> - <a href="<{$xoops_url}>/modules/catads/adslist.php?search=1&words=<{$annonce.type}>" alt="<{$smarty.const._MD_CATADS_TAGS_REFERENCE}> <{$annonce.type}> <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_TAGS_REFERENCE}> <{$annonce.type}> <{$annonce.title}>"><{$annonce.type}></a>
</td>
</tr>
</table>	
<br />
<!-- liens utiles -->
<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center">
<tr>
<!-- mis en forme -->
<td width="5%" align="left">&nbsp;</td>
<!-- adresse de l'annonceur -->
<td width="40%" align="left">
<!-- imprimer l'annonce -->
<img src="<{$xoops_url}>/modules/catads/images/icon/imprimer.png" border="0" alt="<{$smarty.const._MD_CATADS_PRINT_TITRE}> <{$annonce.type}>: <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_PRINT_TITRE}>: <{$annonce.type}> <{$annonce.title}>" style="vertical-align: middle; padding: .2em;" />&nbsp;<a href="<{$xoops_url}>/modules/catads/print.php?op=showone&amp;ads_id=<{$annonce.id}>" rel="zoombox 670 600" alt="<{$smarty.const._MD_CATADS_PRINT_TITRE}> <{$annonce.type}> <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_PRINT_TITRE}> <{$annonce.type}> <{$annonce.title}>"><{$smarty.const._MD_CATADS_PRINT}></a>
<div style="clear: both;"></div>
<!-- Signaler une annonce suspecte -->
<{if $annonce.signalementannonce > 0}>
<img src="<{$xoops_url}>/modules/catads/images/icon/alerteabus.png" border="0" alt="<{$smarty.const._MD_CATADS_SIGNALFRAUDE}>: <{$annonce.type}> <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_SIGNALFRAUDE}>: <{$annonce.type}> <{$annonce.title}>" style="vertical-align: middle; padding: .2em;" />&nbsp;<a href="<{$xoops_url}>/modules/catads/adsitem.php?op=signalementannonce_faite&amp;ads_id=<{$annonce.id}>" alt="<{$smarty.const._MD_CATADS_SIGNALFRAUDE}> <{$annonce.type}>: <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_SIGNALFRAUDE}>: <{$annonce.type}> <{$annonce.title}>" rel="zoombox 650 100"><{$smarty.const._MD_CATADS_SIGNALFRAUDE}></a>
<{else}>
<img src="<{$xoops_url}>/modules/catads/images/icon/alerteabus.png" border="0" alt="<{$smarty.const._MD_CATADS_SIGNALFRAUDE}>: <{$annonce.type}> <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_SIGNALFRAUDE}>: <{$annonce.type}> <{$annonce.title}>" style="vertical-align: middle; padding: .2em;" />&nbsp;<a href="<{$xoops_url}>/modules/catads/adsitem.php?op=signalementannonce&amp;ads_id=<{$annonce.id}>" alt="<{$smarty.const._MD_CATADS_SIGNALFRAUDE}> <{$annonce.type}>: <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_SIGNALFRAUDE}>: <{$annonce.type}> <{$annonce.title}>"><{$smarty.const._MD_CATADS_SIGNALFRAUDE}></a> 
<{/if}>
</td>
<!-- mis en forme -->
<td width="5%" align="left">&nbsp;</td>
<td width="40%" align="left">
<!-- envoyer a un ami -->   
<img src="<{$xoops_url}>/modules/catads/images/icon/envoi_ami.png" border="0" alt="<{$smarty.const._MD_CATADS_ENVOIAMIE}> <{$annonce.type}>: <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_ENVOIAMIE}> <{$annonce.type}>: <{$annonce.title}>" style="vertical-align: middle; padding: .2em;" />&nbsp;<a href='<{$email_ami}>' rel="nofollow" target='_blank' alt="<{$smarty.const._MD_CATADS_ENVOIAMIE}> <{$annonce.type}>: <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_ENVOIAMIE}> <{$annonce.type}>: <{$annonce.title}>"><{$smarty.const._MD_CATADS_ENVOIAMIE}></a>
<div style="clear: both;"></div>
<!-- conseiller ce site -->
<img src="<{$xoops_url}>/modules/catads/images/icon/contacter.png" border="0" alt="<{$smarty.const._MD_CATADS_CONSEILSITE}> <{$annonce.type}>: <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_CONSEILSITE}> <{$annonce.type}>: <{$annonce.title}>" style="vertical-align: middle; padding: .2em;" />&nbsp;<a href="<{$xoops_url}>/misc.php?action=showpopups&type=friend&op=sendform&t=<{$annonce.title}>" rel="zoombox 500 150" alt="<{$smarty.const._MD_CATADS_CONSEILSITE}> <{$annonce.type}>: <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_CONSEILSITE}> <{$annonce.type}>: <{$annonce.title}>"><{$smarty.const._MD_CATADS_CONSEILSITE}></a>
</td>
</tr>
</table>
<div style="clear: both;"></div>
<!--//bloc colonne droite -->
<td class="colonnebloc" align="center">
<!--//bloc contact et infos -->
<div id="centerCcolumn" class="blockTitle" style="line-height: 1.1em; font-size: .9em;" alt="<{$smarty.const._MD_CATADS_DESCANNONCE}> <{$annonce.type}>: <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_DESCANNONCE}> <{$annonce.type}>: <{$annonce.title}>"><{$smarty.const._MD_CATADS_BLOC_CONTACTINFOS}></div>
<table border="0" cellspacing="0" cellpadding="0" class="bloc_infoannonces">
<tr>
<td class="bloc_infoannoncestexte">
<!-- message préférence contact de l'auteur -->	
<div class="contactinfos" style="vertical-align: middle; padding: .2em;"><{$smarty.const._MD_CATADS_BLOC_CONTACT}>&nbsp;<{$annonce.msg_contact}></div>
<{if $annonce.suspend > 0}>
<!-- annonce suspendu par l'annonceur -->		  
<fieldset class="contactstatus2">
<{$smarty.const._MD_CATADS_PUB_SUSP}>
</fieldset>
<{elseif $annonce.suspendadmin > 0}>
<!-- ajout fonction CPascalWeb - 17 septembre suspendu par le site -->			  
<fieldset class="contactstatus2">
<{$smarty.const._MD_CATADS_PUB_SUSPADMIN}>
</fieldset>
<{else}>
<{if $micropaiement1 == 1}>
<!-- ajout CPascalWeb option micropaiement1 le 18 août 2009 -->	
<{$annonce.rentabiliweb}>
<div style="clear: both;"></div>
<{elseif $micropaiement1 == 0}>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
<td width="40%">
<!-- email -->		
<{$annonce.maillink}><br />
<div style="clear: both;"></div>
<!-- messagerie privée -->		
<{$annonce.pmlink}>
</td>
<td width="60%">
<!-- téléphone fixe -->
<fieldset class="contactinfos">
<div style="clear: both;"></div>
<img src="<{$xoops_url}>/modules/catads/images/icon/tel_fixe.png" border="0" alt="<{$smarty.const._MD_CATADS_ENVOIAMIE}> <{$annonce.type}>: <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_ENVOIAMIE}> <{$annonce.type}>: <{$annonce.title}>" style="vertical-align: middle; padding: .2em;" />&nbsp;<{$annonce.phone}> 
</fieldset>
<!-- téléphone portable -->
<fieldset class="contactinfos">
<div style="clear: both;"></div>
<img src="<{$xoops_url}>/modules/catads/images/icon/tel_portable.png" border="0" alt="<{$smarty.const._MD_CATADS_ENVOIAMIE}> <{$annonce.type}>: <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_ENVOIAMIE}> <{$annonce.type}>: <{$annonce.title}>" style="vertical-align: middle; padding: .2em;" />&nbsp;<{$annonce.phoneportable}> 
</fieldset>
</td>
</tr>
</table>
<{/if}>	
<{/if}>						
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ status de l'annonce -->	
<!-- Annonce en attente de validation -->	
<{if $annonce.date_pub == 0}>
<br />
<fieldset class="contactstatus1">
<{$smarty.const._MD_CATADS_ADSWAIT}>
</fieldset>
<!-- Annonce expirée -->
<{elseif $annonce.date_exp == 0}>
<br />
<fieldset class="contactstatus2">
<{$smarty.const._MD_CATADS_ADSEXP}>
<{if $annonce.isauthor}>
<div style="clear: both;"></div>	
<!-- gestion ANNONCEUR: publier a nouveau votre annonce pendant x jours-->
<{if ($annonce.show_renewal > 0 || $annonce.date_exp < 0) and $annonce.countpub > 0 and $annonce.date_pub > 0}>
<{$smarty.const._MD_CATADS_PUB_AGAIN}>&nbsp;<{$sel_box}>&nbsp;<{$smarty.const._MD_CATADS_DAYS}>
<{elseif $annonce.date_pub > 0 and $annonce.date_exp > 0}>
<{/if}><{/if}>
</fieldset>
<{else}>
<!-- annonce publiée le -->	 
<div class="date_annonce">
<{$smarty.const._MD_CATADS_DATE_PUB1}>&nbsp;<{$annonce.date_pub}>
<{/if}>
<!-- annonce expire le -->	 
<{if $annonce.date_exp > 0 and $annonce.date_pub > 0}>
&nbsp;-&nbsp;&nbsp;<{$smarty.const._MD_CATADS_DATE_EXP}>&nbsp;<{$annonce.date_exp}>
</div>
<{/if}>
<!-- annonce suspect -->	
<{if $annonce.signalementannonce > 0}>
<fieldset class="misengarde">
<legend><{$smarty.const._MD_CATADS_ATTENTION}></legend>
<{$smarty.const._MD_CATADS_ADSSUSPECT}>
<br />
<div class="misengardeInfos"><{$smarty.const._MD_CATADS_ATTINFOS}></div>
</fieldset>
<{/if}>
</td>
</tr>
</table>	
</td>
</tr>
</table>
<div style="clear: both;"></div>
<!-- ajout CPascalWeb option micropaiement1 le 18 août 2009 -->	
<{if $micropaiement1 == 0}>
<div align="left"><{$annonce.submitter_ads}></div>
<{/if}> 
<!-- gestion de l'annonce -->
<div style="clear: both;"></div>
<!-- annonce à était vue x fois + ajout CPascalWeb option le 14 mai 2011 choix d'afficher ou non -->
<{if $annonce.affiche_vue == 1}>
<div id="centerCcolumn" class="blockTitle" style="line-height: 1.1em; font-size: .9em;" alt="<{$smarty.const._MD_CATADS_DESCANNONCE}> <{$annonce.type}>: <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_DESCANNONCE}> <{$annonce.type}>: <{$annonce.title}>"><div align="right"><{$smarty.const._MD_CATADS_VIEW}>&nbsp;<{$annonce.nbview}></div></div>
<{/if}> 
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
<td>
<{if $xoops_isadmin}>
<!-- gestion ADMIN -->
	<div id="centerCcolumn" class="blockTitle" style="line-height: 1.1em; font-size: .9em;" alt="<{$smarty.const._MD_CATADS_GESTIONADM}>" title="<{$smarty.const._MD_CATADS_GESTIONADM}>"><{$smarty.const._MD_CATADS_GESTIONADM}></div>
	<div style="clear: both;"></div>
	<!-- gestion ADMIN: toutes les annonces de l'annonceur modif CPascalWeb - ajout "annonce.submitter_name" -->
    <img src="<{$xoops_url}>/modules/catads/images/icon/annonceur.png" border="0" alt="<{$smarty.const._MD_CATADS_ALLADS}>&nbsp;<{$annonce.submitter_name}>: <{$annonce.type}> <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_ALLADS}>&nbsp;<{$annonce.submitter_name}>: <{$annonce.type}> <{$annonce.title}>" style="vertical-align: middle; padding: .2em;" />&nbsp;<a href="<{$xoops_url}>/modules/catads/adsuserlist.php?uid=<{$annonce.uid}>" alt="<{$smarty.const._MD_CATADS_ALLADS}>&nbsp;<{$annonce.submitter_name}>" title="<{$smarty.const._MD_CATADS_ALLADS}>&nbsp;<{$annonce.submitter_name}>"><{$smarty.const._MD_CATADS_ALLADS}>&nbsp;<{$annonce.submitter_name}></a> 
	<div style="clear: both;"></div>
    <!-- gestion ADMIN: modifier l'annonce -->
	<img src="<{$xoops_url}>/modules/catads/images/icon/modifier.png" border="0" alt="<{$smarty.const._MD_CATADS_EDITADS}>: <{$annonce.type}> <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_EDITADS}>: <{$annonce.type}> <{$annonce.title}>" style="vertical-align: middle; padding: .2em;" />&nbsp;<a href="<{$xoops_url}>/modules/catads/admin/adsmod.php?op=edit&amp;ads_id=<{$annonce.id}>" alt="<{$smarty.const._MD_CATADS_EDITADS}>" title="<{$smarty.const._MD_CATADS_EDITADS}>"><{$smarty.const._MD_CATADS_EDITADS}></a>             
	<div style="clear: both;"></div>
<!-- ajout option CPascalWeb - possibilité de suspendre ou de réactivé l'annonce -->			
	<{if $annonce.suspendadmin > 0}>
	<img src="<{$xoops_url}>/modules/catads/images/icon/reprendre.png" border="0" alt="<{$smarty.const._MD_CATADS_PUB_GO}>: <{$annonce.type}> <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_PUB_GO}>: <{$annonce.type}> <{$annonce.title}>" style="vertical-align: middle; padding: .2em;" />&nbsp;<a href="<{$xoops_url}>/modules/catads/adsitem.php?op=suspendrereactiver&amp;ads_id=<{$annonce.id}>" alt="<{$smarty.const._MD_CATADS_PUB_GO}>" title="<{$smarty.const._MD_CATADS_PUB_GO}>"><{$smarty.const._MD_CATADS_PUB_GO}></a>
	<{else}>
	<img src="<{$xoops_url}>/modules/catads/images/icon/suspendre.png" border="0" alt="<{$smarty.const._MD_CATADS_PUB_STOP}>: <{$annonce.type}> <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_PUB_STOP}>: <{$annonce.type}> <{$annonce.title}>" style="vertical-align: middle; padding: .2em;" />&nbsp;<a href="<{$xoops_url}>/modules/catads/adsitem.php?op=suspendrereactiver&amp;ads_id=<{$annonce.id}>" alt="<{$smarty.const._MD_CATADS_PUB_STOP}>" title="<{$smarty.const._MD_CATADS_PUB_STOP}>"><{$smarty.const._MD_CATADS_PUB_STOP}></a> 
	<{/if}>	
	<div style="clear: both;"></div>
	<!-- gestion ADMIN: valider l'annonce -->
	<{if $annonce.date_pub == 0}>
	<img src="<{$xoops_url}>/modules/catads/images/icon/publier.png" border="0" alt="<{$smarty.const._MD_CATADS_VALIDADS}>: <{$annonce.type}> <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_VALIDADS}>: <{$annonce.type}> <{$annonce.title}>" style="vertical-align: middle; padding: .2em;" />&nbsp;<a href="<{$xoops_url}>/modules/catads/admin/adsmod.php?op=approve&amp;ads_id=<{$annonce.id}>" alt="<{$smarty.const._MD_CATADS_VALIDADS}>" title="<{$smarty.const._MD_CATADS_VALIDADS}>"><{$smarty.const._MD_CATADS_VALIDADS}></a>
	<{/if}> 
	<div style="clear: both;"></div>	
</td>			
<td>
<div id="centerCcolumn" class="blockTitle" style="line-height: 1.1em; font-size: .9em;">&nbsp;</div>
	<div style="clear: both;"></div>
	<!-- gestion ADMIN: adresse ip de l'annonceur -->
	<img src="<{$xoops_url}>/modules/catads/images/icon/IP.png" border="0" alt="<{$smarty.const._MD_CATADS_ADRESS_IP}>&nbsp;<{$annonce.poster_ip}>" title="<{$smarty.const._MD_CATADS_ADRESS_IP}>&nbsp;<{$annonce.poster_ip}>" style="vertical-align: middle; padding: .2em;" /><{$smarty.const._MD_CATADS_ADRESS_IP}>&nbsp;<{$annonce.submitter_name}>:&nbsp;<{$annonce.poster_ip}>
	<div style="clear: both;"></div>			
	<!-- gestion ADMIN: supprimer l'annonce -->
	<img src="<{$xoops_url}>/modules/catads/images/icon/supprimer.png" border="0" alt="<{$smarty.const._MD_CATADS_DELETEADS}>: <{$annonce.type}> <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_DELETEADS}>: <{$annonce.type}> <{$annonce.title}>" style="vertical-align: middle; padding: .2em;" />&nbsp;<a href="<{$xoops_url}>/modules/catads/admin/adsmod.php?op=delete&amp;ads_id=<{$annonce.id}>" alt="<{$smarty.const._MD_CATADS_DELETEADS}>" title="<{$smarty.const._MD_CATADS_DELETEADS}>"><{$smarty.const._MD_CATADS_DELETEADS}></a>  
	<div style="clear: both;"></div>			
<!-- ajout option CPascalWeb - 5 novembre 2010 - signaler une annonce suspecte -->
	<{if $annonce.signalementannonce > 0}>
	<img src="<{$xoops_url}>/modules/catads/images/icon/alerteabus.png" border="0" alt="<{$smarty.const._MD_CATADS_SIGNALNOFRAUDE}>: <{$annonce.type}> <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_SIGNALNOFRAUDE}>: <{$annonce.type}> <{$annonce.title}>" style="vertical-align: middle; padding: .2em;" />&nbsp;<a href="<{$xoops_url}>/modules/catads/adsitem.php?op=signalementannonce&amp;ads_id=<{$annonce.id}>" alt="<{$smarty.const._MD_CATADS_SIGNALNOFRAUDE}>" title="<{$smarty.const._MD_CATADS_SIGNALNOFRAUDE}>"><{$smarty.const._MD_CATADS_SIGNALNOFRAUDE}></a>
	<{else}>
	<img src="<{$xoops_url}>/modules/catads/images/icon/alerteabus.png" border="0" alt="<{$smarty.const._MD_CATADS_SIGNALFRAUDEADM}>: <{$annonce.type}> <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_SIGNALFRAUDEADM}>: <{$annonce.type}> <{$annonce.title}>" style="vertical-align: middle; padding: .2em;" />&nbsp;<a href="<{$xoops_url}>/modules/catads/adsitem.php?op=signalementannonce&amp;ads_id=<{$annonce.id}>" alt="<{$smarty.const._MD_CATADS_SIGNALFRAUDEADM}>" title="<{$smarty.const._MD_CATADS_SIGNALFRAUDEADM}>"><{$smarty.const._MD_CATADS_SIGNALFRAUDEADM}></a> 
	<{/if}>
	<div style="clear: both;"></div>			
<{/if}>
</td>
<!-- gestion ANNONCEUR -->
<{if not $preview}>
<{if $annonce.isauthor}>
<td>
	<div id="centerCcolumn" class="blockTitle" style="line-height: 1.1em; font-size: .9em;" alt="<{$smarty.const._MD_CATADS_GESTIONAUTEUR}>" title="<{$smarty.const._MD_CATADS_GESTIONAUTEUR}>"><{$smarty.const._MD_CATADS_GESTIONAUTEUR}></div>
	<div style="clear: both;"></div>
	<!-- gestion ANNONCEUR: modifier votre annonce -->	
	<{if $annonce.canedit}>
	<img src="<{$xoops_url}>/modules/catads/images/icon/modifier.png" border="0" alt="<{$smarty.const._MD_CATADS_MODIFIER_ANNCEUR}>: <{$annonce.type}> <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_MODIFIER_ANNCEUR}>: <{$annonce.type}> <{$annonce.title}>" style="vertical-align: middle; padding: .2em;" />&nbsp;<a href="<{$xoops_url}>/modules/catads/adsedit.php?op=edit&amp;ads_id=<{$annonce.id}>" alt="<{$smarty.const._MD_CATADS_MODIFIER_ANNCEUR}>" title="<{$smarty.const._MD_CATADS_MODIFIER_ANNCEUR}>"><{$smarty.const._MD_CATADS_MODIFIER_ANNCEUR}></a>
	<{/if}>
	<div style="clear: both;"></div>
	<!-- gestion ANNONCEUR: suspendre et réactivé l'annonce -->
	<{if $annonce.suspend > 0}>
	<img src="<{$xoops_url}>/modules/catads/images/icon/reprendre.png" border="0" alt="<{$smarty.const._MD_CATADS_NOSUSP_ANNCEUR}>: <{$annonce.type}> <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_NOSUSP_ANNCEUR}>: <{$annonce.type}> <{$annonce.title}>" style="vertical-align: middle; padding: .2em;" />&nbsp;<a href="<{$xoops_url}>/modules/catads/adsitem.php?op=stopandgo&amp;ads_id=<{$annonce.id}>" alt="<{$smarty.const._MD_CATADS_NOSUSP_ANNCEUR}>" title="<{$smarty.const._MD_CATADS_NOSUSP_ANNCEUR}>"><{$smarty.const._MD_CATADS_NOSUSP_ANNCEUR}></a>
	<{else}>
	<img src="<{$xoops_url}>/modules/catads/images/icon/suspendreproprio.png" border="0" alt="<{$smarty.const._MD_CATADS_SUSP_ANNCEUR}>: <{$annonce.type}> <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_SUSP_ANNCEUR}>: <{$annonce.type}> <{$annonce.title}>" style="vertical-align: middle; padding: .2em;" />&nbsp;<a href="<{$xoops_url}>/modules/catads/adsitem.php?op=stopandgo&amp;ads_id=<{$annonce.id}>" alt="<{$smarty.const._MD_CATADS_SUSP_ANNCEUR}>" title="<{$smarty.const._MD_CATADS_SUSP_ANNCEUR}>"><{$smarty.const._MD_CATADS_SUSP_ANNCEUR}></a> 
	<{/if}>		
</td>
<td>
	<!-- mise en forme -->	
	<div id="centerCcolumn" class="blockTitle" style="line-height: 1.1em; font-size: .9em;">&nbsp;</div>
	<div style="clear: both;"></div>
	<!-- gestion ANNONCEUR: supprimé votre annonce -->
	<{if $annonce.candelete}>
	<img src="<{$xoops_url}>/modules/catads/images/icon/supprimer.png" border="0" alt="<{$smarty.const._MD_CATADS_SUPPRIMER_ANNCEUR}>: <{$annonce.type}> <{$annonce.title}>" title="<{$smarty.const._MD_CATADS_SUPPRIMER_ANNCEUR}>: <{$annonce.type}> <{$annonce.title}>" style="vertical-align: middle; padding: .2em;" />&nbsp;<a href="<{$xoops_url}>/modules/catads/adsedit.php?op=delete&ads_id=<{$annonce.id}>" alt="<{$smarty.const._MD_CATADS_SUPPRIMER_ANNCEUR}>"  title="<{$smarty.const._MD_CATADS_SUPPRIMER_ANNCEUR}>"><{$smarty.const._MD_CATADS_SUPPRIMER_ANNCEUR}></a> 
	<{/if}>
	<div style="clear: both;"></div>
	<!-- gestion ANNONCEUR: voir toutes vos annonces -->
    <{if $annonce.uid > 0}>
    <img src="<{$xoops_url}>/modules/catads/images/icon/annonceur.png" border="0" alt="<{$smarty.const._MD_CATADS_VOIRTOUT_ANNCEUR}>" title="<{$smarty.const._MD_CATADS_VOIRTOUT_ANNCEUR}>" style="vertical-align: middle; padding: .2em;" />&nbsp;<a href="<{$xoops_url}>/modules/catads/adsuserlist.php?uid=<{$annonce.uid}>" alt="<{$smarty.const._MD_CATADS_VOIRTOUT_ANNCEUR}>" title="<{$smarty.const._MD_CATADS_VOIRTOUT_ANNCEUR}>"><{$smarty.const._MD_CATADS_VOIRTOUT_ANNCEUR}></a> 
    <{/if}> 
<{/if}>
<{/if}>
</td>
</tr>
</table>
<div style="clear: both;"></div>
<br />
<{/if}>
<{if not $preview}>
	<div style="text-align: center; padding: 3px; margin:3px;">
	<{$commentsnav}>
	<{$lang_notice}>
	</div>
	<div style="margin:3px; padding: 3px;">
	<!-- start comments loop -->
	<{if $comment_mode == "flat"}>
		<{include file="db:system_comments_flat.html"}>
	<{elseif $comment_mode == "thread"}>
		<{include file="db:system_comments_thread.html"}>
	<{elseif $comment_mode == "nest"}>
		<{include file="db:system_comments_nest.html"}>
	<{/if}>
<{/if}>
</div>
</div>
