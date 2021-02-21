<{if $smarty.const._CATADS_SHOW_TPL_NAME==1}>
    <div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/style.css" />
<div class='catads_bg'>
<{if $add_tab != 0}>
<table border="0" cellspacing="0" cellpadding="0" class="outer" style="width:100%;">
  <tr>
<!-- affiche les sous catégories dans l'une des catégories sélectionnée  -->
<{if $sous_cat <> ''}>
<!-- ajout CPascalWeb --> 
<!-- navigation -->  
<div style="padding: 1em; text-align:right"><{$cat_path}></div>
<div style="clear: both;"></div>
<table border="0" cellspacing="0" cellpadding="0" class="outer">
  <tr>
    <th title="<{$smarty.const._MD_CATADS_NOM_REFERENCE}> <{$xoops_sitename}>">
	<{$smarty.const._MD_CATADS_FROMSITE}>&nbsp;<{$xoops_sitename}>
    </th>
	<!-- pour ie -->  
    <th title="<{$smarty.const._MD_CATADS_NOM_REFERENCE}> <{$xoops_sitename}>">&nbsp;</th>	
  </tr>
  <tr>	
<td style="width:65%;" class="bloc_descripscat">	
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

<td style="width:30%;" class="bloc_recherchescat">
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
		<{if !$xoops_isuser}>
			<!-- en mode anonyme -->
			<table style="width:30%; margin:.5em;" class="bloc_infoannonces">
				<tr>
				<td class="bloc_infoannoncestexte">
				<{$smarty.const._MD_CATADS_DEPOANNONC_SELEC_ANONYM}>
				<a href="<{$xoops_url}>/register.php" title="<{$smarty.const._MD_CATADS_DEPOANNONCE_SITE}> <{$xoops_sitename}>" alt="<{$smarty.const._MD_CATADS_DEPOANNONCE_SITE}> <{$xoops_sitename}>"><{$smarty.const._MD_CATADS_ADDANNONCE_ANONYMINSC}></a>
				</td>
				</tr>
			</table>
		<{else}>	  
			<!-- en mode connecté -->
			<table style="width:30%; margin:.5em;" cellspacing="0" cellpadding="0" class="bloc_infoannonces">
				<tr>
				<td class="bloc_infoannoncestexte">
				<{$smarty.const._MD_CATADS_DEPOANNONC_SELEC}>
			   </td>
				</tr>
			</table>			
		<{/if}>
	<!-- liste des sous catégories -->
	<table cellspacing="0" class="outer">
		<thead>
		<tr>
		<th title="<{$titrealt}> <{$scat.title}>" alt="<{$xoops_sitename}>: <{$titrealt}> <{$cat.title}>: <{$scat.title}>" align="left"><{$lang_title}></th>
		</tr>
		</thead>
	</table>
	<{$sous_cat}>
<{/if}>
<!-- fin de l'ajout -->
<{/if}>
<!-- affiche liste des sous catégories  -->
<{if $sous_cat == ''}>
	<{include file="db:catads_adssublist.tpl"}>
<{/if}>
<!-- navigation sur les pages d'annonces -->
<{if $sous_cat == ''}>
<div align="center">
<br />
<{$nav_page}>
<br />
</div>
<{/if}>
<!-- rss -->
<{if $sous_cat == '' & $nbads > '0' & $search == ''}>
  <{if $rssfeed_link != ""}>
    <div align = "center"><{$rssfeed_link}></div>
  <{/if}>
<{/if}>
<!-- infos automatique  -->
<{include file='db:system_notification_select.html'}>

</div>
