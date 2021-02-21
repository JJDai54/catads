<{if $block.noads}>
	<{$smarty.const._MB_CATADS_NOADS}>
<{elseif $block.full_view}>
<table cellspacing="1" class="outer" style="width:100%;">
  <tr>
    <td style="padding:0;">
   	  <table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
        <tr>
		  <td class="head"></td>
          <td class="head"><{$smarty.const._MB_CATADS_TITLEADS}></td>
          <td align="left" class="head"><{$smarty.const._MB_CATADS_PRICE}></td>
          <td align="center" class="head"><{$smarty.const._MB_CATADS_DATE}></td>
          <td class="head"><{$smarty.const._MB_CATADS_LOCAL}></td>
          <td align="center" class="head"></td>
          <td align="center" class="head"><{$smarty.const._MB_CATADS_VIEW}></td>
        </tr>
        <{foreach item=ads from=$block.items}>
		<tr class="<{cycle values='odd,even'}>">
		    <td>
			<{$ads.status}>
		  </td>
          <td align="left">
          <{if $block.show_ad_type == 1}>
          <b><{$ads.type}>: </b><{/if}><a href="<{$xoops_url}>/modules/catads/adsitem.php?ads_id=<{$ads.id}>" title="<{$smarty.const._MB_CATADS_ANNONCE}>: <{$ads.type}> <{$ads.title}>" alt="<{$xoops_sitename}>: <{$smarty.const._MB_CATADS_ANNONCE}> <{$ads.type}> <{$ads.title}>"><{$ads.title}></a>
		  </td>
          <td align="left"><{$ads.price}></td>
          <td align="center"><{$ads.date}></td>
          <td><{$ads.local|capitalize}></td>
          <td><{$ads.photo}></td>
		  <td align="center"><{$ads.views}></td>
        </tr>
		<{/foreach}>
      </table>
	</td>
  </tr>
</table>
<{else}>
	<ul>
	<{foreach item=item from=$block.items}>
         <li>
           <a href="<{$xoops_url}>/modules/catads/adsitem.php?ads_id=<{$item.id}>" title="<{$smarty.const._MB_CATADS_ANNONCE}>: <{$item.type}> <{$item.title}>" alt="<{$xoops_sitename}>: <{$smarty.const._MB_CATADS_ANNONCE}> <{$item.type}> <{$item.title}>"><{$item.title}></a> <{$item.status}>
        </li>
	<{/foreach}>
	</ul>
<{/if}>
