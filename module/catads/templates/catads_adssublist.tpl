<{if $smarty.const._CATADS_SHOW_TPL_NAME==1}>
    <div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<!-- liste des annonces entiérement refait CPascalWeb 23 octobre 2010 -->
<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/style.css" />
<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/highslide.css" />
<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/highslide-ie6.css" />
<script src="<{$xoops_url}>/modules/catads/js/highslide.js" language="javascript" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
	hs.graphicsDir = '<{$xoops_url}>/modules/catads/images/graphics/';
	hs.wrapperClassName = 'wide-border';
</script>
<!-- ajout CPascalWeb - 8 octobre 2010 page à afficher si aucune annonce -->
<{if $nbads < 1}>
<!-- navigation -->  
<div style="padding: 1em; text-align:right"><{$cat_path}></div>
<div style="clear: both;"></div>
<table border="0" cellspacing="0" cellpadding="0" class="outer" style="width:100%;">
  <tr>
    <th title="<{$smarty.const._MD_CATADS_NOM_REFERENCE}> <{$xoops_sitename}>">
	<{$smarty.const._MD_CATADS_FROMSITE}>&nbsp;<{$xoops_sitename}>
    </th>
	<!-- pour ie -->  
    <th title="<{$smarty.const._MD_CATADS_NOM_REFERENCE}> <{$xoops_sitename}>">&nbsp;</th>	
  </tr>
  <tr>	
<td style="width:65%;" border="0" cellspacing="0" cellpadding="0" class="bloc_descripscat">	
	<!-- titre et description de la sous catégorie -->	
	<div class="bloc_descripscat_texte">
		<{$smarty.const._MD_CATADS_NOM_REFERENCE}> <{$lang_title}>
	<br />
		<{$lang_desc}>
	</div>
<!-- ajout option CPascalWeb - 24 novembre 2010 - afficher une bannières pub sur les pages principal du module -->
<div style="clear: both;"></div>
<{if $aff_pub_general == 1}>
<div align="center">
<{if $aff_pub_general_site < 1}>
<{$pub_general}>
<{else}>
<{$xoops_banner}>
</div>
<div style="clear: both;"></div>
<{/if}>
<{/if}>
<!-- fin -->	
</td>
<td style="width:30%;" border="0" cellspacing="0" cellpadding="0" class="bloc_recherchescat">
<!-- boîte de sélection -->	
	<div class="bloc_recherchescat_texte">
	<!-- boîte de sélection d'une autre catégorie -->
	<form name="selecCat" action="<{$xoops_url}>/modules/catads/adslist.php" method="get">
		<{$smarty.const._MD_CATADS_SELECT_CAT}><{$selecCat}>
	</form>
</td>
</tr>
</table>
<!-- affiche lien pour s'enregistré en mode anonyme -->
	<{if $add_perm}>
		<{if !$xoops_isuser}>
			<!-- en mode anonyme -->
			<table style="width:30%;" border="0" cellspacing="0" cellpadding="0" class="bloc_infoannonces">
				<tr>
				<td class="bloc_infoannoncestexte">
				<{$smarty.const._MD_CATADS_ADDANNONCE_ANONYM}>
				<a href="<{$xoops_url}>/register.php" title="<{$smarty.const._MD_CATADS_DEPOANNONCE_SITE}> <{$xoops_sitename}>" alt="<{$smarty.const._MD_CATADS_DEPOANNONCE_SITE}> <{$xoops_sitename}>"><{$smarty.const._MD_CATADS_ADDANNONCE_ANONYMINSC}></a>
			    </td>
				</tr>
			</table>
		<{else}>	  
			<!-- en mode connecté -->
			<div style="padding: 1em; text-align:right">
			<input type="button" title="<{$smarty.const._MD_CATADS_DEPOANNONCE_SITE}> <{$xoops_sitename}>" alt="<{$smarty.const._MD_CATADS_DEPOANNONCE_SITE}> <{$xoops_sitename}>" value="<{$smarty.const._MD_CATADS_ADDANNONCE}>" onclick="location='<{$xoops_url}>/modules/catads/submit.php?topic_id=<{$topic_id}>'" />
			</div>
		<{/if}>
	<{/if}>
	<!-- liste des sous catégories -->
	<table cellspacing="0" class="outer">
		<thead>
		<tr>
		<th title="<{$titrealt}> <{$scat.title}>" alt="<{$xoops_sitename}>: <{$titrealt}> <{$cat.title}>: <{$scat.title}>" align="left"><{$lang_title}></th>
		</tr>
		</thead>
	</table>
	<div align="center" style="margin-top:20px"><b><{$smarty.const._MD_CATADS_NOADSINCAT}></b></div>
 <{/if}>
<!-- fin de l'ajout -->
 
<!-- sinon affiche la liste des annonces --> 
<{if $nbads > 0}>
<div style="padding: 1em; text-align:right"><{$cat_path}></div>
<div style="clear: both;"></div>
<table border="0" cellspacing="0" cellpadding="0" class="outer" style="width:100%;">
  <tr>
    <th title="<{$smarty.const._MD_CATADS_NOM_REFERENCE}> <{$xoops_sitename}>">
	<{$smarty.const._MD_CATADS_FROMSITE}>&nbsp;<{$xoops_sitename}>
    </th>
	<!-- pour ie -->  
    <th title="<{$smarty.const._MD_CATADS_NOM_REFERENCE}> <{$xoops_sitename}>">&nbsp;</th>	
  </tr>
  <tr>	
<td style="width:64%;" border="0" cellspacing="0" cellpadding="0" class="bloc_descripscat">	
	<!-- titre et description de la sous catégorie -->	
	<div class="bloc_descripscat_texte">
		<{$smarty.const._MD_CATADS_NOM_REFERENCE}> <{$lang_title}>
	<br />
		<{$lang_desc}>
	</div>
<!-- ajout option CPascalWeb - 24 novembre 2010 - afficher une bannières pub sur les pages principal du module -->
<div style="clear: both;"></div>
<{if $aff_pub_general == 1}>
<div align="center">
<{if $aff_pub_general_site < 1}>
<{$pub_general}>
<{else}>
<{$xoops_banner}>
</div>
<{/if}>
<div style="clear: both;"></div>
<{/if}>
<!-- fin -->	
</td>

<td style="width:34%;" border="0" cellspacing="0" cellpadding="0" class="bloc_recherchescat">
<!-- ajout CPascalWeb - boîte de sélection -->	
	<div class="bloc_recherchescat_texte">
	<!-- ajout CPascalWeb - boîte de sélection d'une autre catégorie -->
	<form name="selecCat" action="<{$xoops_url}>/modules/catads/adslist.php" method="get">
		<{$smarty.const._MD_CATADS_SELECT_CAT}><{$selecCat}>
	</form>
	<br />	
	<!-- ajout CPascalWeb - boîte de sélection tris par type d'annonce  -->	
	<form name="selecType" action="<{$xoops_url}>/modules/catads/adslist.php" method="get">
		<{$smarty.const._MD_CATADS_AFF_PAR_TYPE}><{$afficher_par_type}>
		&nbsp;<{$smarty.const._MD_CATADS_SELECT_SORT}>
			<a href="<{$xoops_url}>/modules/catads/adslist.php?<{if $topic_id != ''}>topic_id=<{$topic_id}>&amp;<{else}><{$topic_id}><{/if}><{if $uid != ''}>uid=<{$uid}>&amp;<{else}><{$uid}><{/if}><{if $search != ''}>search=<{$search}>&amp;<{else}><{$search}><{/if}>affichage_titre=ASC">
			<img src="<{$xoops_url}>/modules/catads/images/icon/trier_haut.png" border="0" alt="<{$smarty.const._MD_CATADS_SORT_ASC}>" title="<{$smarty.const._MD_CATADS_SORT_ASC}>"/></a>  
			<a href="<{$xoops_url}>/modules/catads/adslist.php?<{if $topic_id != ''}>topic_id=<{$topic_id}>&amp;<{else}><{$topic_id}><{/if}><{if $uid != ''}>uid=<{$uid}>&amp;<{else}><{$uid}><{/if}><{if $search != ''}>search=<{$search}>&amp;<{else}><{$search}><{/if}>affichage_titre=DESC">
			<img src="<{$xoops_url}>/modules/catads/images/icon/trier_bas.png" border="0" alt="<{$smarty.const._MD_CATADS_SORT_DESC}>" title="<{$smarty.const._MD_CATADS_SORT_DESC}>"/></a>	
		&nbsp;
	</form>
</div>
<!-- fin de l'ajout -->
</td>
</tr>
</table>
	<{if $add_perm}>
<!-- ajout CPascalWeb - affiche lien pour s'enregistré en mode anonyme -->
		<{if !$xoops_isuser}>
			<!-- en mode anonyme -->
			<table style="width:30%; margin:.5em;" border="0" cellspacing="0" cellpadding="0" class="bloc_infoannonces">
				<tr>
				<td class="bloc_infoannoncestexte">
				<{$smarty.const._MD_CATADS_ADDANNONCE_ANONYM}>
				<a href="<{$xoops_url}>/register.php" title="<{$smarty.const._MD_CATADS_DEPOANNONCE_SITE}> <{$xoops_sitename}>" alt="<{$smarty.const._MD_CATADS_DEPOANNONCE_SITE}> <{$xoops_sitename}>"><{$smarty.const._MD_CATADS_ADDANNONCE_ANONYMINSC}></a>
			    </td>
				</tr>
			</table>
		<{else}>	  
			<!-- en mode connecté -->
			<div style="padding: 1em; text-align:right">
			<{if $isauthor}>
			<!-- retour a l'accueil -->  
			<input type="button" title="<{$smarty.const._MD_CATADS_RETOUR}> <{$xoops_sitename}>" alt="<{$smarty.const._MD_CATADS_RETOUR}> <{$xoops_sitename}>" value="<{$smarty.const._MD_CATADS_RETOUR}>" onclick="location='<{$xoops_url}>/modules/catads/'" />
			<{/if}>
			<!-- déposer une annonce --> 
			<input type="button" title="<{$smarty.const._MD_CATADS_DEPOANNONCE_SITE}> <{$xoops_sitename}>" alt="<{$smarty.const._MD_CATADS_DEPOANNONCE_SITE}> <{$xoops_sitename}>" value="<{$smarty.const._MD_CATADS_ADDANNONCE}>" onclick="location='<{$xoops_url}>/modules/catads/submit.php?topic_id=<{$topic_id}>'" />
			</div>
		<{/if}>
	<{/if}>
<!-- fin de l'ajout -->
<!--- liste mes annonces & liste des annonces -->
<table cellspacing="1" class="outer">
    <thead>
	<tr>	
	<{if $isauthor}>
	<th align="center"><{$smarty.const._MD_CATADS_STATUS}></th>
	<{/if}>
		<th align="center"><{$smarty.const._MD_CATADS_IMGANNONCE}></th>
        <th align="center"><{$smarty.const._MD_CATADS_ANNONCES}></th>
        <th align="center"><{$smarty.const._MD_CATADS_PRICE}></th>
		<th align="center"><{$smarty.const._MD_CATADS_OPTION_PRICE}></th>
		<th align="center"><{$smarty.const._MD_CATADS_LOCAL2}></th>
        <th align="center"><{$smarty.const._MD_CATADS_DATE}></th>
	</tr>
	</thead>
	<tbody>
    <{foreach item=item from=$items}>
		<tr class="<{cycle values='odd,even'}>" valign='middle'>
			<{if $isauthor}>
			<td align="center"><{$item.status}></td>
			<{/if}>
				<td align="center"><{$item.photo}></td>
				<td align="left">
			<{if $show_ad_type == 1}>
				<{$item.type}>:&nbsp;
			<{/if}>
				<a href="<{$xoops_url}>/modules/catads/adsitem.php?ads_id=<{$item.id}>" title="<{$xoops_sitename}>: <{$item.type}> <{$item.price}> <{$item.title}> <{$item.desc}>" alt="<{$item.title}> <{$item.desc}>"><{$item.title}></a>
				<br />
				<{$item.desc}>
				</td>
				<td align="center"><{$item.price}></td>
				<td align="center"><{$item.price_option}></td>
				<td align="center"><{$item.local|capitalize}></td>
				<td align="center"><{$item.date}></td>
		</tr>
	<{/foreach}>
	</tbody>
</table>
<{/if}>