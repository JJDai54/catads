<{if $smarty.const._CATADS_SHOW_TPL_NAME==1}>
    <div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/style.css" />
<!-- appel du calendrier pour annonce programmée -->
<link rel="stylesheet" type="text/css" media="all" href="<{$xoops_url}>/include/calendrier.css" />
<script type="text/javascript" src="<{$xoops_url}>/include/calendar.js"></script>
<!-- ajout CPascalWeb - texte conseils pour pour bien rédiger une annonce avec slider -->
<script src="<{$xoops_url}>/modules/catads/js/slider.js" language="javascript" type="text/javascript"></script>

<div class='catads_bg'>
<table border="0" cellspacing="0" cellpadding="0" class="outer" style="width:100%;">
  <tr>
    <th title="<{$smarty.const._MD_CATADS_CONSEIL}> <{$xoops_sitename}>"><{$smarty.const._MD_CATADS_CONSEIL}></th>
  </tr>
  <tr>	
<td style="width:98.5%;" border="0" cellspacing="0" cellpadding="0" class="bloc_descripscat">	
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
</td>
</tr>
</table>
<div style="clear: both;"></div>
<!-- message erreur en js dans submit.php -->
<{$adsform.javascript}>
<!-- message erreur dans submit.php -->
<div align="center"><font color="#FF0000"><strong><{$msgstop}></strong></font></div>
<!-- mode prévisualisé dans submit.php -->
<{if $preview and not $msgstop}>
	<{include file="db:catads_item.tpl"}>
<{/if}>
<form name="<{$adsform.name}>" action="<{$adsform.action}>" method="<{$adsform.method}>" <{$adsform.extra}>>
  <table class="annoncesCategoriesContourDiv" cellspacing="1">
    <tr>
    <th colspan="2"><{$adsform.title}></th>
    </tr>
    <{foreach item=element from=$adsform.elements}>
	<{if $element.name|truncate:6:"" != "_break"}>
      <{if $element.hidden != true}>
      <tr>
        <td class="head"><{$element.caption}></td>
        <td class="<{cycle values='even,odd'}>"><{$element.body}></td>
      </tr>
      <{else}>
      <{$element.body}>
      <{/if}>
      <{else}>
    <th colspan="2"><{$element.caption}></th>  
      <{/if}>
    <{/foreach}>
	<{$adsform.elements.uid.body}>
	<{$adsform.elements.display_price.body}>
	<{$adsform.elements.preview_name.body}>
	<{$adsform.elements.count_elt.body}>
  </table>
</form>
</div>