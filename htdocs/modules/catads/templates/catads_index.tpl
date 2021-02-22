<{if $smarty.const._CATADS_SHOW_TPL_NAME==1}>
    <div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/style.css" />
<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/highslide.css" />
<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/highslide-ie6.css" />
<script src="<{$xoops_url}>/modules/catads/js/highslide.js" language="javascript" type="text/javascript"></script>
<script language="javascript" type="text/javascript">AC_FL_RunContent = 0;</script>
<script src="<{$xoops_url}>/modules/catads/js/AC_RunActiveContent.js" language="javascript" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
	hs.graphicsDir = '<{$xoops_url}>/modules/catads/images/graphics/';
	hs.wrapperClassName = 'wide-border';
</script>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ affichage en mode sans carte -->	
<div id="catads_main" name="catads_main" >
<{if $show_card == 0}>
<table cellspacing="1" class="outer" style="width:100%;">
	<tr><!-- ajouter titre et alt -->
		<th><{$smarty.const._MD_CATADS_FROMSITE}>&nbsp;<{$xoops_sitename}></th>
	</tr>
	<tr>
	<td class="even" align="center">
<!-- ajout CPascalWeb - 23 mai 2011 option afficher ou non le bloc d'indication ($affiche_bloc_indic) -->	
	<{if $affiche_bloc_indic == 1}>
		<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					<table class="bloc_infoannonces">
					<tr>
					<td class="bloc_infoannoncestexte">
<!-- ajout CPascalWeb - 23 mai 2011 option afficher ou non le nombre total des annonces ($affiche_ads_visible) -->
						<{if $affiche_ads_visible == 1}>
							<{$smarty.const._MD_CATADS_ACTUALLEMENT}>
							<div style="clear: both;"></div>
						<!-- Bloc Nombre d'annonces en mode anonyme (non connecté) -->
							<{$total_annonces}>
						<{/if}>
							<div style="clear: both;"></div>
						 <{if $moderated}> 
							<!-- annonces en attente de validation -->
							<{if $xoops_isadmin}>
							<!-- en mode connecté (admin) -->
							<{$confirm_ads}>
							<{else}>
							<!-- sinon en mode anonyme (non connecté) -->
							<{$validation_ads}>
							<{/if}>
							<div style="clear: both;"></div>							
							<{if $xoops_isadmin}>
						<!-- ajout CPascalWeb - 7 octobre 2010 ajout fonction annonce suspendu par le site (administrateur) -->
							<!-- en mode connecté (admin) -->
							<{$confirm_suspendadmin}>
							<div style="clear: both;"></div>
							<{else}>
							<!-- sinon en mode anonyme (non connecté) -->
							<{if $aff_suspendadmin == 1}>
							<{$indicateur_suspendadmin}>
							<div style="clear: both;"></div>
							<{/if}><{/if}>	
							<{if $xoops_isadmin}>
						<!-- ajout CPascalWeb - 7 octobre 2010 ajout fonction annonce suspendu par l'annonceur -->
							<!-- en mode connecté (admin) -->
							<{$confirm_suspend}>
							<{else}>
							<!-- sinon en mode anonyme (non connecté) -->
							<{if $aff_suspend == 1}>							
							<{$indicateur_suspend}>
							<{/if}><{/if}>	
							<div style="clear: both;"></div>
						<!-- ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse -->							
							<{if $xoops_isadmin}>
							<{$confirm_signalementannonce}>
							<{/if}>								
							<{/if}>
							<div style="clear: both;"></div>
						<!-- ajout cpascalweb - le 12 octobre 2010 option afficher une pub dans le bloc informations annonces -->
							<{if $pub_bloc_info == 1}>
							<table class="pub_bloc">
							<tr>
							<td align="center" class="pub_bloc_infoannonces"><{$pub_bloc}></td>
							</tr>
							</table>
							<{/if}>							
					</td>
					</tr>
					</table>
				</td>
			</tr>
		</table>
<{/if}>			
		<!-- Affichage des dernieres annonces -->
<!-- ajout cpascalweb - le 24 mai 2011 - Choix d'afficher ou non le bloc les dernières petites annonces -->		
			<{if $bloc_dernieres_annonces == 1}>
			<br />
				<div class="odd"><{$smarty.const._MD_CATADS_LASTADD}></div>
					 <!-- Recuperer les annonces en fonction des categories -->
					 <{foreach item=item from=$items}>
						<div class="tutorial_recents_item">
							<div class="tutorial_sidebar_item_title" style="padding-left:5px; font-size:13px; padding-top:5px">
								<table width="100%" border="0">
								  <tr>
									<td width="20%" rowspan="4" align="left"><{$item.photo}></td>
<!-- ajout option affiche ou non le type de l'annonce -->
									<{if $show_ad_type == 1}>
									<td width="80%" align="left" style="padding-left:5px"><b><{$item.type}></b> : <a href="<{$xoops_url}>/modules/catads/adsitem.php?ads_id=<{$item.id}>"><{$item.title}></a></td>
									<{else}>									  
									<td width="80%" align="left" style="padding-left:5px"><a href="<{$xoops_url}>/modules/catads/adsitem.php?ads_id=<{$item.id}>"><b><{$item.title}></b></a></td>
									<{/if}>									  
<!-- fin ajout option affiche ou non le type de l'annonce -->					  
								  </tr>
								  <tr>
									<td align="left" style="padding-left:5px"><{$smarty.const._MD_CATADS_PRICE2}> <{$item.price}></td>
								  </tr>
								  <tr>
									<td align="left" style="padding-left:5px"><{$smarty.const._MD_CATADS_BLOC_VILLE}> <{$item.local}></td>
								  </tr>
								  <tr>
									<td align="left" style="padding-left:5px"><{$smarty.const._MD_CATADS_DATE_ANNO}> <{$item.date}> </td>
								  </tr>
								</table>
							</div>
						</div>		
					<{/foreach}>
			<{/if}>	
		<!-- Fin d'affichage des dernieres annonces -->		
	</td>
	</tr>
</table>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~sinon affichage en mode avec carte -->	
<{else}>
	<!-- carte -->
	<table width="100%" border="0" align="center">
		<tr>
			<td align="center">
			<script language="javascript" type="text/javascript">
			if (AC_FL_RunContent == 0) {
				alert("This page requires the file AC_RunActiveContent.js.");
			} else {
				AC_FL_RunContent(
					'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
					'width', '450',
					'height', '450',
					'src', 'france_map_3.0?mapChemin=./',
					'quality', 'high',
					'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
					'align', 'middle',
					'play', 'true',
					'loop', 'true',
					'scale', 'showall',
					'wmode', 'transparent',
					'devicefont', 'false',
					'id', 'france_map_3.0',
					'bgcolor', '#ffffff',
					'name', 'france_map_3.0',
					'menu', 'true',
					'allowFullScreen', 'false',
					'allowScriptAccess','sameDomain',
					'movie', './swf/france_map_3.0?mapChemin=./',
					'salign', ''
					); 
			}
			</script>
				<noscript>
				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="450" height="450" id="france_map_3.0" align="middle">
				<param name="allowScriptAccess" value="sameDomain" />
				<param name="allowFullScreen" value="false" />
				<param name="movie" value="<{$xoops_url}>/modules/catads/swf/france_map_3.0.swf?mapChemin=./" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />
				<embed src="<{$xoops_url}>/modules/catads/swf/france_map_3.0.swf?mapChemin=./" quality="high" bgcolor="#ffffff" width="450" height="450" name="france_map_3.0" align="middle" allowscriptaccess="sameDomain" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
				</object>
				</noscript>
			</td>
			<td class="colonnebloc" align="center">
	<!--//bloc Nombre d'annonces -->
<!-- ajout CPascalWeb - 23 mai 2011 option afficher ou non le bloc d'indication ($affiche_bloc_indic) -->	
	<{if $affiche_bloc_indic == 1}>	
		<div class="odd"><{$smarty.const._MD_CATADS_INFO_ADS}></div>
		<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					<table border="0" cellspacing="0" cellpadding="0" class="bloc_infoannonces">
					<tr>
					<td class="bloc_infoannoncestexte">
<!-- ajout CPascalWeb - 23 mai 2011 option afficher ou non le nombre d'annonces visible ($affiche_ads_visible) -->					
						<{if $affiche_ads_visible == 1}>
							<{$smarty.const._MD_CATADS_ACTUALLEMENT}>
							<div style="clear: both;"></div>
						<!-- Bloc Nombre d'annonces en mode anonyme (non connecté) -->
							<{$total_annonces}>
						<{/if}>
							<div style="clear: both;"></div>
						<{if $moderated}>
							<!-- annonces en attente de validation -->
							<{if $xoops_isadmin}>
							<!-- en mode connecté (admin) -->
							<{$confirm_ads}>
							<{else}>
							<!-- sinon en mode anonyme (non connecté) -->
							<{$validation_ads}>
							<{/if}>
							<div style="clear: both;"></div>						
							<{if $xoops_isadmin}>
						<!-- ajout CPascalWeb - 7 octobre 2010 ajout fonction annonce suspendu par le site (administrateur) -->
							<!-- en mode connecté (admin) -->
							<{$confirm_suspendadmin}>
							<div style="clear: both;"></div>
							<{else}>
							<!-- sinon en mode anonyme (non connecté) -->
							<{if $aff_suspendadmin == 1}>
							<{$indicateur_suspendadmin}>
							<div style="clear: both;"></div>
							<{/if}><{/if}>	
							<{if $xoops_isadmin}>
						<!-- ajout CPascalWeb - 7 octobre 2010 ajout fonction annonce suspendu par l'annonceur -->
							<!-- en mode connecté (admin) -->
							<{$confirm_suspend}>
							<{else}>
							<!-- sinon en mode anonyme (non connecté) -->
							<{if $aff_suspend == 1}>							
							<{$indicateur_suspend}>
							<{/if}><{/if}>
							<div style="clear: both;"></div>
							<!-- ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse -->
							<{if $xoops_isadmin}>
							<{$confirm_signalementannonce}>
							<{/if}><{/if}>
							<div style="clear: both;"></div>
						<!-- ajout cpascalweb - le 12 octobre 2010 afficher une pub dans le bloc informations annonces -->
							<{if $pub_bloc_info == 1}>
							<table border="0" cellspacing="0" cellpadding="0">
							<tr>
							<td align="center" class="pub_bloc_infoannonces"><{$pub_bloc}></td>
							</tr>
							</table>
							<{/if}>
					</td>
					</tr>
					</table>
				</td>
			</tr>
		</table>
		<br />
	<{/if}>
		<!-- Affichage des dernieres annonces -->
<!-- ajout cpascalweb - le 24 mai 2011 - Choix d'afficher ou non le bloc les dernières petites annonces -->		
			<{if $bloc_dernieres_annonces == 1}>
				<div class="odd"><{$smarty.const._MD_CATADS_LASTADD}></div>
					 <{foreach item=item from=$items}>
						<div class="tutorial_recents_item">
							<div class="tutorial_sidebar_item_title" style="padding-left:5px; font-size:13px; padding-top:5px">
								<table width="100%" border="0">
								  <tr>
									<td width="20%" rowspan="4" align="left"><{$item.photo}></td>
<!-- ajout option affiche ou non le type de l'annonce -->
									<{if $show_ad_type == 1}>
									<td width="80%" align="left" style="padding-left:5px"><b><{$item.type}></b> : <a href="<{$xoops_url}>/modules/catads/adsitem.php?ads_id=<{$item.id}>"><{$item.title}></a></td>
									<{else}>									  
									<td width="80%" align="left" style="padding-left:5px"><a href="<{$xoops_url}>/modules/catads/adsitem.php?ads_id=<{$item.id}>"><b><{$item.title}></b></a></td>
									<{/if}>									  
<!-- fin ajout option affiche ou non le type de l'annonce -->								 
								 </tr>
								  <tr>
									<td align="left" style="padding-left:5px"><{$smarty.const._MD_CATADS_PRICE2}> <{$item.price}></td>
								  </tr>
								  <tr>
									<td align="left" style="padding-left:5px"><{$smarty.const._MD_CATADS_BLOC_VILLE}> <{$item.local}></td>
								  </tr>
								  <tr>
									<td align="left" style="padding-left:5px"><{$smarty.const._MD_CATADS_DATE_ANNO}> <{$item.date}> </td>
								  </tr>
								</table>
							</div>
						</div>		
					<{/foreach}>
			<{/if}>		
		<!-- Fin d'affichage des dernieres annonces -->
			</td>
		</tr>
	</table>
<{/if}>
</div>

<br />
	<!-- appel de la liste des catégories -->
		<{include file="db:catads_cat.tpl"}>
	<br />
    
	<{if not $addads}>
<div id="catads_notification" name="catads_notification" >
		<!-- rss -->
		<{if $rssfeed_link != ""}>
			<div align="center"><{$rssfeed_link}></div>
		<{/if}> 
		<!-- infos automatique-->
		<br />
		<{include file='db:system_notification_select.html'}>
		<br />
</div>
	<{/if}>


