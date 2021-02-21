<{if $smarty.const._CATADS_SHOW_TPL_NAME==1}>
    <div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<!-- liste des sous catégories -->
<table border="0">
  <tr> 
  <td width="<{$wcol}>%">
  <{foreach name = subcat item = scat from = $cat.subcat}>
	<{if $scat.newcol}>
	</td>
	<{if $scat.newline}>
	<tr></tr>
      <{/if}>
    <td width="<{$wcol}>%"> 
      <{/if}>
      <{$scat.img}>
      <b><{$scat.title}></b> 
      	<{$scat.nb}>
      <{if $scat.new > 0}>
			<span title="<{$titrealt}> <{$scat.title}>" alt="<{$xoops_sitename}>: <{$titrealt}> <{$cat.title}>: <{$scat.title}>">
				<{$smarty.const._MD_CATADS_NOUVEAU}>
			</span>
      <{/if}>
      <br />
	<{/foreach}>
	</td>
    </tr>
</table>