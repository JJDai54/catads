<{if $smarty.const._CATADS_SHOW_TPL_NAME==1}>
    <div style="text-align: center; background-color: black;"><span style="color: yellow;">Template : <{$smarty.template}></span></div>
<{/if}>

<!-- Page des catégories principal -->
<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/style.css" />

<div id="catads_cat" name="catads_cat">
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ affichage des categories en mode lignes -->		
	<{if $tpltype == 1}>
		<div class="odd" align="left" title="<{$xoops_sitename}>: <{$titrealtcat}>" alt="<{$xoops_sitename}>: <{$titrealtcat}>" style="vertical-align: middle"><h4><{$smarty.const._MD_CATADS_CAT}></h4></div>
			<table border="0" cellspacing="0" cellpadding="0" align="center">
			 	<tr colspan="<{$nb_col_or_row}>">
				<{foreach item = cat from = $categories}>
				<td class="<{cycle values='odd,even'}>">
					<!-- images des catégories + ajout CPascalWeb 12 octobre 2010 - lien images + titre et alt -->
					<a href="<{$xoops_url}>/modules/catads/adslist.php?topic_id=<{$cat.id}>" title="<{$titrealt}> <{$cat.title}>" alt="<{$xoops_sitename}>: <{$titrealt}> <{$cat.title}>"><{$cat.image}></a>
						<!-- titre des catégories + ajout CPascalWeb 12 octobre 2010 - lien images + titre et alt -->
						<{if $cat.link}>
							<a href="<{$xoops_url}>/modules/catads/adslist.php?topic_id=<{$cat.id}>" class="listecat" title="<{$titrealt}> <{$cat.title}>" alt="<{$xoops_sitename}>: <{$titrealt}> <{$cat.title}>"><{$cat.title}></a>
									<!-- nombre de catégorie et nouveau ! -->
									<{$cat.nb}>
									<{if $cat.new > 0}>
										<!-- ajout CPascalWeb 12 octobre 2010 - define + titre et alt -->
										<span  title="<{$titrealt}> <{$scat.title}>" alt="<{$xoops_sitename}>: <{$titrealt}> <{$cat.title}>: <{$scat.title}>">
											<{$smarty.const._MD_CATADS_NOUVEAU}>
										</span>
									<{/if}>
										<{elseif $cat.submit}>
											<!-- ajout CPascalWeb 12 octobre 2010 - lien images + titre et alt -->
											<a href="<{$cat.submit}>" title="<{$titrealt}> <{$cat.title}>" alt="<{$xoops_sitename}>: <{$titrealt}> <{$cat.title}>"><{$cat.title}></a>
										<{$cat.nb}>
									<{if $cat.new > 0}>
										<!-- ajout CPascalWeb 12 octobre 2010 - define + titre et alt -->
										<span title="<{$titrealt}> <{$scat.title}>" alt="<{$xoops_sitename}>: <{$titrealt}> <{$cat.title}>: <{$scat.title}>">
											<{$smarty.const._MD_CATADS_NOUVEAU}>
										</span>
									<{/if}>
									<{else}>
									<{$cat.title}>
						<{/if}>
						<!-- appel des sous catégories -->
						<div class="annoncesCategoriesSub"><{include file="db:catads_subcat.tpl" type = $tpltype}></div>
						<{if $cat.newline}>
							<{else}>
							</td>
					</tr>
						<{/if}>
                <{/foreach}>
			</table>
		
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ affichage des categories en mode colonnes -->			
		<{else}>
		<!-- ajout CPascalWeb 12 octobre 2010 - titre et alt -->
		<div class="odd" align="left" title="<{$xoops_sitename}>: <{$titrealtcat}>" alt="<{$xoops_sitename}>: <{$titrealtcat}>" valign="middle"><h4><{$smarty.const._MD_CATADS_CAT}></h4></div>
			<table width="<{$wcol}>%" border="0" cellspacing="0" cellpadding="0" align="center">
			 	<tr colspan="<{$nb_col_or_row}>">
				<{foreach item = cat from = $categories}>
					<td class="annoncesCategoriesContourDiv">
						<{if $cat.link}>
						<!-- images des catégories + ajout CPascalWeb 12 octobre 2010 - lien images + titre et alt -->
						<a href="<{$xoops_url}>/modules/catads/adslist.php?topic_id=<{$cat.id}>" class="listescat_images" title="<{$titrealt}> <{$cat.title}>" alt="<{$xoops_sitename}>: <{$titrealt}> <{$cat.title}>"><{$cat.image}></a><a href="<{$xoops_url}>/modules/catads/adslist.php?topic_id=<{$cat.id}>" class="listecat" title="<{$titrealt}> <{$cat.title}>" alt="<{$xoops_sitename}>: <{$titrealt}> <{$cat.title}>"><{$cat.title}></a>
									<!-- nombre de catégorie et nouveau ! rappel CPascalWeb pas utile a voir !!! -->
									<{$cat.nb}>
									<{if $cat.new > 0}>
										<!-- ajout CPascalWeb 12 octobre 2010 - define + titre et alt -->
										<span title="<{$titrealt}> <{$scat.title}>" alt="<{$xoops_sitename}>: <{$titrealt}> <{$cat.title}>: <{$scat.title}>">
											<{$smarty.const._MD_CATADS_NOUVEAU}>
										</span>
									<{/if}>
										<{elseif $cat.submit}>
											<!-- ajout CPascalWeb 12 octobre 2010 - lien images + titre et alt -->
											<a href="<{$cat.submit}>" title="<{$titrealt}> <{$cat.title}>" alt="<{$xoops_sitename}>: <{$titrealt}> <{$cat.title}>"><{$cat.title}></a>
										<{$cat.nb}>
									<{if $cat.new > 0}>
										<!-- ajout CPascalWeb 12 octobre 2010 - define + titre et alt -->
										<span title="<{$titrealt}> <{$scat.title}>" alt="<{$xoops_sitename}>: <{$titrealt}> <{$cat.title}>: <{$scat.title}>">
											<{$smarty.const._MD_CATADS_NOUVEAU}>
										</span>
									<{/if}>
									<{else}>
									<{$cat.title}>
						<{/if}>
						<!-- appel des sous catégories -->
						<div class="annoncesCategoriesSub"><{include file="db:catads_subcat.tpl" type = $tpltype}></div>
						<{if $cat.newline}>
					</td>
					</tr>
						<{else}>
						<{/if}>
                <{/foreach}>
			</table>
	<{/if}>
</div>