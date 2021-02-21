<{if $smarty.const._CATADS_SHOW_TPL_NAME==1}>
    <div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<!-- message erreur en js dans submit.php -->
<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/style.css" />
<{$adsform.javascript}>
<!-- message erreur dans submit.php -->
<div align="center"><font color="#FF0000"><strong><{$msgstop}></strong> </font></div>
<!-- mode prévisualisé dans submit.php -->
<{if $preview and not $msgstop}>
	<{include file="db:catads_item.tpl"}>
<{/if}>

<div class='catads_bg'>
<form name="<{$adsform.name}>" action="<{$adsform.action}>" method="<{$adsform.method}>" <{$adsform.extra}>>
  <table class="outer" cellspacing="1">
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