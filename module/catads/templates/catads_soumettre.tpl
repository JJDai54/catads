<{if $smarty.const._CATADS_SHOW_TPL_NAME==1}>
    <div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ fichier html ajouter le 24 novembre 2010 - CPascalWeb -->	
<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/style.css" />
<!-- appel du calendrier pour annonce programmée -->
<link rel="stylesheet" type="text/css" media="all" href="<{$xoops_url}>/include/calendrier.css" />
<script type="text/javascript" src="<{$xoops_url}>/include/calendar.js"></script>
<!-- ajout CPascalWeb - texte conseils pour pour bien rédiger une annonce avec slider -->
<script src="<{$xoops_url}>/modules/catads/js/slider.js" language="javascript" type="text/javascript"></script>
<table border="0" cellspacing="0" cellpadding="0" class="outer" style="width:100%;">
  <tr>
    <th title="<{$smarty.const._MD_CATADS_CONSEIL}> <{$xoops_sitename}>"><{$smarty.const._MD_CATADS_CONSEIL}></th>
  </tr>
  <tr>	
<td style="width:98.5%;" border="0" cellspacing="0" cellpadding="0" class="bloc_descripscat">	
	<!-- texte conseils pour pour bien rédiger une annonce avec slider -->  
<body onload="autoScroll('newsslider','newssection',5,true)">
<div class="newsslider">
    <div class="newsslidercontent" id="newsslider">
      <div id="newssection-1" class="newssection upper"><{$smarty.const._MD_CATADS_CONSEIL_1}></div>
      <div id="newssection-2" class="newssection upper"><{$smarty.const._MD_CATADS_CONSEIL_2}></div>
      <div id="newssection-3" class="newssection upper"><{$smarty.const._MD_CATADS_CONSEIL_3}></div>      
      <div id="newssection-4" class="newssection"><{$smarty.const._MD_CATADS_CONSEIL_4}></div> 	  
	</div>
</div>
	<div style="clear: both;"></div>
    <span class="pause" onmousedown="cancelAutoScroll('newsslider')"><{$smarty.const._MD_CATADS_PAUSE}></span><span class="separation">&nbsp;|&nbsp;</span><span class="lecture" onmousedown="autoScroll('newsslider','newssection',5,true)"><{$smarty.const._MD_CATADS_LECTURE}></span>
</body>	
<!-- afficher une bannières pub sur les pages principal du module -->
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
</td>
</tr>
</table>
<!-- texte sélectionnez une catégorie -->	
<table style="width:20%;" border="0" cellspacing="0" cellpadding="0" class="bloc_infoannonces">
<tr>
<td class="bloc_infoannoncestexte"><{$smarty.const._MD_CATADS_DEPOANNONC_SELEC}></td>
</tr>
</table>
<!-- navigation --> 
 <div style="padding: 1em; text-align:left">
<input type="button" title="<{$smarty.const._MD_CATADS_RETOUR}> <{$xoops_sitename}>" alt="<{$smarty.const._MD_CATADS_RETOUR}> <{$xoops_sitename}>" value="<{$smarty.const._MD_CATADS_RETOUR}>" onclick="location='index.php?'" />
</div>
<div style="clear: both;"></div>
	<!-- appel de la liste des catégories -->
		<{include file="db:catads_cat.tpl"}>
	<br />
		<!-- rss -->
		<{if $rssfeed_link != ""}>
			<div align="center"><{$rssfeed_link}></div>
		<{/if}> 
		<!-- infos automatique-->
		<br />
		<{include file='db:system_notification_select.html'}>
		<br />

