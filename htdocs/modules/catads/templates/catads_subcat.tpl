<{if $smarty.const._CATADS_SHOW_TPL_NAME==1}>
    <div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/style.css" />
<!-- liste des sous catégories page d'accueil en mode d'affichage lignes  -->
<{if $type == 1}>
<table border="0" style="background-color: #bde9ba;">
    <tr>
        <td width="<{$wcol}>%">
<{foreach name = subcat item = scat from = $cat.subcat}>
		<div class="listescat_images" title="<{$titrealt}> <{$scat.title}>" alt="<{$xoops_sitename}>: <{$titrealt}> <{$cat.title}>: <{$scat.title}>"><{$scat.img}></div>
	<{if $scat.newcol}>
	    </td>
			<{if $scat.newline}>
	    <tr></tr>
        <{/if}>
        <td class="listescat_titre" width="<{$wcol}>%">
        <{/if}>
        <{$scat.img}>
      <{if $scat.link}>
	  <ul><li>
          <a href="<{$xoops_url}>/modules/catads/adslist.php?topic_id=<{$scat.id}>" title="<{$titrealt}> <{$scat.title}>" alt="<{$xoops_sitename}>: <{$titrealt}> <{$cat.title}>: <{$scat.title}>"><{$scat.title}></a>
	  <{elseif $scat.submit}>
          <a href="<{$scat.submit}>" title="<{$titrealt}> <{$scat.title}>" alt="<{$xoops_sitename}>: <{$titrealt}> <{$cat.title}>: <{$scat.title}>"><{$scat.title}></a>
	  <{else}>
	  <{$scat.title}>
		</li></ul>	  
        <{/if}>
      	<{$scat.nb}>
	   <{if $scat.new > 0}>
			<span title="<{$titrealt}> <{$scat.title}>" alt="<{$xoops_sitename}>: <{$titrealt}> <{$cat.title}>: <{$scat.title}>">
				<{$smarty.const._MD_CATADS_NOUVEAU}>
			</span>
    <{/if}>
<{/foreach}>
</td>
  </tr>
</table>

<!-- ou liste des sous catégories page d'accueil en mode d'affichage colonnes  -->
<{else}>
	<{foreach name = subcat item = scat from = $cat.subcat}>
		<div class="listescat_titre" width="<{$wcol}>%" >     
		<{if $scat.link}>
			<ul><li>
			<a href="<{$xoops_url}>/modules/catads/adslist.php?topic_id=<{$scat.id}>" title="<{$titrealt}> <{$scat.title}>" alt="<{$xoops_sitename}>: <{$titrealt}> <{$cat.title}>: <{$scat.title}>"><{$scat.img}> <{$scat.title}></a>
			<{elseif $scat.submit}>
				<a href="<{$scat.submit}>" title="<{$xoops_sitename}>:<{$titrealt}>" alt="<{$xoops_sitename}>: <{$titrealt}>"><{$scat.title}></a>
			<{else}>
			<{$scat.title}>
			</li></ul>
		<{/if}>
		<{$scat.nb}>
		<{if $scat.new > 0}>
				<span  title="<{$titrealt}> <{$scat.title}>" alt="<{$xoops_sitename}>: <{$titrealt}> <{$cat.title}>: <{$scat.title}>">
					<{$smarty.const._MD_CATADS_NOUVEAU}>
				</span>
			</a>
		<{/if}>
		</div>
	<{/foreach}>
<{/if}>