<?php
include 'header.php';
include("../../mainfile.php");

include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/header.php");


//paramètres
//$reduireTitle = 25; //Nb de caracteres
$reduireTitle = $xoopsModuleConfig['title_length'];
//modif CPascalWeb 24 mai 2011 - plus utile !!! ajout dans préférence module
//$afficherBlocNbAnnonces = 1; //1 = Affichage du bloc nb annonces, 0 = le contraire
//$afficherBlocDernieresAnnonces = 1; //1 =  Affichage du bloc derniere annonces, 0 = le contraire
//$afficherNbDernieresAnnonces = 4; //Nombre d'annonces à afficher dans le bloc "dernieres annonces"


$xoopsOption['template_main'] = 'catads_index.tpl';
include(XOOPS_ROOT_PATH."/header.php");

//Recuperer des infos affichage
$affichage_titre = isset($_GET['affichage_titre']) ? $_GET['affichage_titre'] : '';
$affichage_prix = isset($_GET['affichage_prix']) ? $_GET['affichage_prix'] : '';
$affichage_option_prix = isset($_GET['affichage_option_prix']) ? $_GET['affichage_option_prix'] : '';
$affichage_localisation = isset($_GET['affichage_localisation']) ? $_GET['affichage_localisation'] : '';
$affichage_date = isset($_GET['affichage_date']) ? $_GET['affichage_date'] : '';

$link=sprintf("<a href='%s' title='%s'><img src='%s' border='0' alt='%s' /></a>",XOOPS_URL."/modules/".$xoopsModule->dirname()."/backend.php", _MD_CATADS_RSSFEED, XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/rss.gif",_MD_CATADS_RSSFEED);
$xoopsTpl->assign('rssfeed_link',$link);

//obtenir préférence du module
/*$ads_handler =& xoops_getmodulehandler('ads');
$myts =& MyTextSanitizer::getInstance();*/
$ads_handler = xoops_getmodulehandler('ads');
$myts = MyTextSanitizer::getInstance();
//ajout CPascalWeb - 14 mai 2011 - fonction envoi email lorsque l'annonce arrive a expiration 
catads_expired_ads();
//fin
//affiche type d'annonce
$show_ad_type = $xoopsModuleConfig['show_ad_type'];
	
	//sous-catégories 'enfant' d'une catégorie
    function getFirstChild($topic_id = 0) {
        global $allcat;
            $firstChild = array();
                foreach($allcat as $onechild)
				{
                    if( $onechild['topic_pid'] == $topic_id) {
                        array_push($firstChild, $onechild);
                    }
                }
                return $firstChild;
    }

    function showsubcat($categorys, $level = 0, $topic_id = 0, $topic_pid) {
//modif CPascalWeb - 7 octobre 2010 - ajout variables	
       //global $xoopsModule, $myts, $lastchildren, $nbadspercat, $newads, $arr_subcat, $cptsubcat, $nbcol, $tpltype, $xoTheme;
		global $xoopsModule, $xoopsModuleConfig, $myts, $lastchildren, $nbadspercat, $newads, $arr_subcat, $cptsubcat, $nbcol, $tpltype, $xoTheme, $show_topic_id, $ads_wait, $suspendadmin, $suspend, $signalementannonce;		
//fin de la modif
        foreach($categorys as $onecat) 
		{
            $link = XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/adslist.php?topic_id=' . $onecat['topic_id'];
            $title = $myts->htmlSpecialChars($onecat['topic_title']);
            $desc = $myts->htmlSpecialChars($onecat['topic_desc']);
        if (in_array($onecat['topic_id'], $lastchildren)) {
		    //nombre d'annonce dans chaque catégorie
            $arr_scat['nb'] = (array_key_exists($onecat['topic_id'], $nbadspercat)) ?  "(".$nbadspercat[$onecat['topic_id']].")": '';
			//affichage annonce nouveau !
            $arr_scat['new'] = (array_key_exists($onecat['topic_id'], $newads)) ? $newads[$onecat['topic_id']]: '';
        }
            $arr_scat['link'] = XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/adslist.php?topic_id=' . $onecat['topic_id'];
            $arr_scat['id'] = $onecat['topic_id'];
            $arr_scat['title'] = $title;
            $arr_scat['desc'] = $desc;

        //image catégorie + ajout CPascalWeb - 30 octobre 2010 - choix largeur depuis préférence
        if($onecat['img'] != '') {
            $arr_scat['img'] = "<img src='".XOOPS_URL."/uploads/".$xoopsModule->dirname()."/images/categories/".$onecat['img']."' style=\"width: ".$xoopsModuleConfig['scat_width']."px; \" align='middle' alt='' />";
        }else{
            $arr_scat['img'] = '' ;
        }
        if ($level == 0 && $tpltype == 1) {
            $arr_scat['newcol'] = ($cptsubcat > 0) ? true : false;
            $cptsubcat++;
            $arr_scat['newline'] = ($cptsubcat % $nbcol == 1) ? true : false;
        }
            array_push($arr_subcat, $arr_scat);
            $childcats =  getFirstChild($onecat['topic_id']);
        if (count($childcats) > 0) {
            showsubcat($childcats, $level + 1, $onecat['topic_id'], $topic_pid);
        }
        }
        return;
    }
	
//~~~~~~~~~~Bloc Nombre d'annonces en mode connecté (admin)
		//annonces en attente de validation - si Modération des annonces choisi dans préférences du module
        if ($xoopsModuleConfig['moderated'] == '1') {
            $ads_wait = $ads_handler->getCount(new Criteria('waiting', '1'));
//ajout CPascalWeb - 7 octobre 2010 ajout fonction affichage annonces suspendu	
		//annonce suspendu par le site administrateur	
		$suspendadmin = $ads_handler->getCount(new Criteria('suspendadmin', '1'));	
		//annonce suspendu par l'annonceur	
		$suspend = $ads_handler->getCount(new Criteria('suspend', '1'));
		//annonces signalées suspectes	
		$signalementannonce = $ads_handler->getCount(new Criteria('signalementannonce', '1'));			
//fin de l'ajout annonces suspendu	
            $xoopsTpl->assign('moderated', true);
			
        //si administrateur 
        if ($xoopsUser && $xoopsUser->isAdmin($xoopsModule->getVar('mid'))) {
            //$xoopsTpl->assign('admin_block', _MD_CATADS_ADM_WAIT);//Annonces en attente supprimer ne sert plus
			
//modif CPascalWeb - 7 octobre 2010 ajout fonction affichage define suivant le nombre	      
		/*if($ads_wait == 0) {
           $xoopsTpl->assign('confirm_ads', _MD_CATADS_NO_WAIT);
        } else {
           $xoopsTpl->assign('confirm_ads', sprintf(_MD_CATADS_NBWAIT, $ads_wait)."<br /><a href=\"admin/ads.php?sel_status=1&amp;sel_order=ASC\">"._MD_CATADS_SEEWAIT."</a>");
        }*/
		if($ads_wait < 1)
		{
			//si aucune annonce en attente de validation
			$xoopsTpl->assign('confirm_ads', _MD_CATADS_NO_WAIT);
		}
		elseif($ads_wait > 1)
		{
			//si plusieurs annonces en attente de validation
			$xoopsTpl->assign('confirm_ads', sprintf(_MD_CATADS_NBWAIT, $ads_wait)."<a href=\"admin/ads.php?sel_status=1&amp;sel_order=ASC\"> <img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/viewmag.png' width='13px' border='0' title="._MD_CATADS_SEEWAIT." style='vertical-align: middle;' alt='' /></a>");
		}
		else
		{
			//si une seule annonce
			$xoopsTpl->assign('confirm_ads', sprintf(_MD_CATADS_NBWAITUNE, $ads_wait)."<a href=\"admin/ads.php?sel_status=1&amp;sel_order=ASC\"> <img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/viewmag.png' width='13px' title="._MD_CATADS_SEEWAITUNE." style='vertical-align: middle;' alt='' /></a>");
		}
//fin de la modif		
//ajout CPascalWeb - 7 octobre 2010 ajout fonction affichage annonces suspendu et signalées
	//annonce suspendu par le site administrateur
		if($suspendadmin < 1)
		{
			//$xoopsTpl->assign('confirm_suspendadmin', _MD_CATADS_NO_SUSPADMIN);
		}
		elseif($suspendadmin > 1)
		{
			$xoopsTpl->assign('confirm_suspendadmin', sprintf(_MD_CATADS_SUSPADMIN, $suspendadmin)."<a href=\"admin/ads.php?sel_status=5&amp;sel_order=ASC\"> <img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/viewmag.png' width='13px' title="._MD_CATADS_VOIRSUSPADMIN." style='vertical-align: middle;' alt="._MD_CATADS_VOIRSUSPADMIN." /></a>");
		}
		else
		{
			$xoopsTpl->assign('confirm_suspendadmin', sprintf(_MD_CATADS_SUSPADMINUNE, $suspendadmin)."<a href=\"admin/ads.php?sel_status=5&amp;sel_order=DESC\"> <img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/viewmag.png' width='13px' title="._MD_CATADS_VOIRSUSPADMINUNE." style='vertical-align: middle;' alt="._MD_CATADS_VOIRSUSPADMINUNE." /></a>");
		}
	//annonce suspendu par l'annonceur
		if($suspend < 1)
		{
			//$xoopsTpl->assign('confirm_suspend', _MD_CATADS_NO_SUSPUSER);
		}
		elseif($suspend > 1)
		{
			$xoopsTpl->assign('confirm_suspend', sprintf(_MD_CATADS_SUSPUSER, $suspend)."<a href=\"admin/ads.php?sel_status=4&amp;sel_order=ASC\"><img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/viewmag.png' width='13px' title="._MD_CATADS_VOIRSUSPUSER." style='vertical-align: middle;' alt="._MD_CATADS_VOIRSUSPUSER." /></a>");
		}
		else
		{
			$xoopsTpl->assign('confirm_suspend', sprintf(_MD_CATADS_SUSPUSERUNE, $suspend)."<a href=\"admin/ads.php?sel_status=4&amp;sel_order=DESC\"><img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/viewmag.png' width='13px' title="._MD_CATADS_VOIRSUSPUSERUNE." style='vertical-align: middle;' alt="._MD_CATADS_VOIRSUSPUSERUNE." /></a>");
		}
	//annonce signaler	
		if($signalementannonce < 1)
		{
			//$xoopsTpl->assign('confirm_suspend', _MD_CATADS_NO_SUSPUSER);
		}
		elseif($signalementannonce > 1)
		{
			$xoopsTpl->assign('confirm_signalementannonce', sprintf(_MD_CATADS_SIGNALSUSPECT, $signalementannonce)."<a href=\"admin/ads.php?sel_status=6&amp;sel_order=ASC\"> <img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/viewmag.png' width='13px' title="._MD_CATADS_VOIRSIGNALSUSPECT." style='vertical-align: middle;' alt="._MD_CATADS_VOIRSIGNALSUSPECT." /></a>");
		}
		else
		{
			$xoopsTpl->assign('confirm_signalementannonce', sprintf(_MD_CATADS_SIGNALSUSPECTUNE, $signalementannonce)."<a href=\"admin/ads.php?sel_status=6&amp;sel_order=DESC\"> <img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/viewmag.png' width='13px' title="._MD_CATADS_VOIRSIGNALSUSPECTUNE." style='vertical-align: middle;' alt="._MD_CATADS_VOIRSIGNALSUSPECTUNE." /></a>");
		}
//fin
		}
        }	
            $tpltype = $xoopsModuleConfig['tpltype'];// 1 en lignes, 2 en colonnes
            $xoopsTpl->assign('tpltype', $tpltype);
            $nbcol = $xoopsModuleConfig['nbcol'];
            $wcol = 100/$nbcol;
            $xoopsTpl->assign('wcol', $wcol);

            //nombre annonces actives par catégorie
            $criteria = new CriteriaCompo(new Criteria('waiting', '0'));
            $criteria->add(new Criteria('suspend', '0'));
//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce					
			$criteria->add(new Criteria('suspendadmin', '0'));
//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse
        if($xoopsModuleConfig['active_suspect'] < '1'){
            $criteria->add(new Criteria('signalementannonce', '0'));	
        } 
//fin
            $criteria->add(new Criteria('published', time(), '<'));
            $criteria->add(new Criteria('expired', time(),'>'));
            $nbadspercat = $ads_handler->getCountAdsByCat($criteria);

            //nombre annonces nouvelles par catégorie
            $criteria = new CriteriaCompo(new Criteria('published', time()- $xoopsModuleConfig['nb_days_new']*86400, '>'));
            $criteria->add(new Criteria('waiting', '0'));
            $criteria->add(new Criteria('suspend', '0'));
//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce					
			$criteria->add(new Criteria('suspendadmin', '0'));				
//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse
        if($xoopsModuleConfig['active_suspect'] < '1'){
            $criteria->add(new Criteria('signalementannonce', '0'));	
        } 
//fin		
            $criteria->add(new Criteria('expired', time(),'>'));
//ajout CPascalWeb - 10 novembre 2010 - critére décompte des annonces a parution programmé 
            $criteria->add(new Criteria('published', time(),'<'));
//fin			
            $newads = $ads_handler->getCountAdsByCat($criteria);
 
            $allcat =  $adsCatHandler->getAllCat(); //toutes les catégories
            $lastchildren = $adsCatHandler->getAllLastChild(); //toutes les sous catégories
            $parray = $adsCatHandler->getCatWithPid(); //catégories pid
            $pcount = count($parray);
            $ptitle = '';
			$pdesc = '';

        //catégories principales
        for ( $i = 0; $i < $pcount; $i++ ) {
            $arr_cat = array();
            $arr_scat = array();
            $arr_subcat = array();
            $cptsubcat = 0;
            $topic_id = $parray[$i]->topic_id();

            $title = $myts->htmlSpecialChars($parray[$i]->topic_title());
            $ptitle .= $title.' -';

            $desc = $myts->htmlSpecialChars($parray[$i]->topic_desc());
            $pdesc .= $desc.' -';

        if ( $parray[$i]->img() != '')
        {
		//modif CPascalWeb - 30 octobre 2010 - images catégories + ajout option choix de la largeur
            //$arr_cat[$i]['image'] = "<img id=\"photo".$i."\" alt=\"photo".$i."\" src=\"".XOOPS_URL."/uploads/".$xoopsModule->dirname()."/images/categories/".$parray[$i]->img()."\" class=\"PopBoxImageSmall\" onclick=\"Pop(this,50,'PopBoxImageLarge');\" />";
        $arr_cat[$i]['image'] = "<img id=\"photo".$i."\" alt=\"photo".$i."\" src=\"".XOOPS_URL."/uploads/".$xoopsModule->dirname()."/images/categories/".$parray[$i]->img()."\" style=\"width: ".$xoopsModuleConfig['cat_width']."px; \" />";
		}
	   else
        {
//modif CPascalWeb - 7 octobre 2010 - chemin							
            //$arr_cat[$i]['image'] = "<img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/no_dispo_mini.gif' align='middle' alt='' />";
			$arr_cat['image'] = '' ;
			//fin
		}
            $arr_cat[$i]['link'] = XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/adslist.php?topic_id=' . $topic_id;
            $arr_cat[$i]['id'] = $topic_id;
            $arr_cat[$i]['title'] = $title;
            $arr_cat[$i]['desc'] = $desc;

        if (in_array($topic_id, $lastchildren)) {
            $arr_cat[$i]['nb'] = (array_key_exists($topic_id, $nbadspercat)) ?  "(".$nbadspercat[$topic_id].")": '';//fonctionne pas
            $arr_cat[$i]['new'] = (array_key_exists($topic_id, $newads)) ? $newads[$topic_id]: '';
        }
            $level = 0;
            $childcats =  $adsCatHandler->getFirstChildArr($topic_id, 'weight');
            unset($arr_scat);

            showsubcat($childcats, 0, $topic_id, $topic_id);
        if ($tpltype == 1) {
            //blocs vides si template en lignes
            $mod = count($childcats) % $nbcol;
            $adjust = ($mod > 0) ? $nbcol - $mod : 0;
        for ( $j = 0; $j < $adjust; $j++ ) {
            $cptsubcat++;
            $arr_scat['newcol']=1;
            array_push($arr_subcat, $arr_scat);
        }
        } else {
			//calcul saut de ligne si template en colonnes
            $mod = ($i+1) % $nbcol;
            $arr_cat[$i]['newline'] = ($mod == 0) ? true : false;
        }
            $arr_cat[$i]['subcat'] = $arr_subcat;
            $xoopsTpl->append('categories', $arr_cat[$i]);
        }
        if ($tpltype == 2) {
            //blocs vides si template en colonnes
            unset($arr_cat);
            $mod = $pcount % $nbcol;
            $adjust = ($mod > 0) ? $nbcol - $mod : 0;
        for ( $j = 0; $j < $adjust; $j++ ) {
            $arr_cat[$j]['title'] = "";
            $xoopsTpl->append('categories', $arr_cat[$j]);
        }
        }
            $xoopsTpl->assign('nb_col_or_row', $nbcol);
            $xoopsTpl->assign('xoops_pagetitle', $xoopsModule->name());
//ajout CPascalWeb - 12 octobre 2010 ajout titre et alt dans les liens des titres et images des catégories susposé aider au référencement naturel			
			$xoopsTpl->assign('titrealt', _MD_CATADS_CAT_TITREALT);
			$xoopsTpl->assign('titrealtcat', _MD_CATADS_CAT_TITREALTCAT);			
//fin			
            //ajout meta description à partir de la liste des catégories principales
            $catlistclean = '';
        for ( $i = 0; $i < $pcount; $i++ ) {
            $title = $myts->htmlSpecialChars($parray[$i]->topic_title());
            $catlistclean .= $title.', ';
        }
            $xoTheme->addMeta('meta', 'description', substr($catlistclean, 0, 140));

            //nombre annonces actives
            $criteria = new CriteriaCompo(new Criteria('waiting', '0'));
            $criteria->add(new Criteria('suspend', '0'));
//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce					
			$criteria->add(new Criteria('suspendadmin', '0'));				
//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse
        if($xoopsModuleConfig['active_suspect'] < '1'){
            $criteria->add(new Criteria('signalementannonce', '0'));	
        } 
//fin
            $criteria->add(new Criteria('published', time(),'<'));
            $criteria->add(new Criteria('expired', time(),'>'));

//~~~~~~~~~~Bloc Nombre d'annonces en mode anonyme (non connecté)

            $nbads = $ads_handler->getCount($criteria);
            $xoopsTpl->assign('nbads', $nbads);
//modif CPascalWeb - 7 octobre 2010 ajout fonction affichage define suivant le nombre			
		if($nbads < 1)
		{
			$xoopsTpl->assign('total_annonces', _MD_CATADS_NO_WAIT);
		}
		elseif($nbads > 1)
		{
			$xoopsTpl->assign('total_annonces',sprintf( _MD_CATADS_ACTUALY, $nbads));
		}
		else
		{
			$xoopsTpl->assign('total_annonces',sprintf(_MD_CATADS_ACTUALYUNE, $nbads));
		}			
//fin	

//ajout CPascalWeb - 7 octobre 2010 annonce en attente de validation
		if($ads_wait < 1 )
		{
			//$xoopsTpl->assign('validation_ads', _MD_CATADS_NO_WAIT);
		}
		elseif($ads_wait > 1 )
		{
			$xoopsTpl->assign('validation_ads', sprintf(_MD_CATADS_NBWAIT, $ads_wait));
		}
		else
		{
			$xoopsTpl->assign('validation_ads', sprintf(_MD_CATADS_NBWAITUNE, $ads_wait));
		}	

//ajout CPascalWeb - 7 octobre 2010 ajout fonction affichage annonces suspendu par le site (administrateur)
	$xoopsTpl->assign('aff_suspendadmin', $xoopsModuleConfig['aff_suspendadmin']);	
if ( $xoopsModuleConfig['aff_suspendadmin'] == '1' )
	{	
		if($suspendadmin < 1)
		{
			//$xoopsTpl->assign('indicateur_suspendadmin', _MD_CATADS_NO_SUSPADMIN);
		}
		elseif($suspendadmin > 1)
		{
			$xoopsTpl->assign('indicateur_suspendadmin', sprintf(_MD_CATADS_SUSPADMIN, $suspendadmin));
		}
		else
		{
			$xoopsTpl->assign('indicateur_suspendadmin', sprintf(_MD_CATADS_SUSPADMINUNE, $suspendadmin));
		}
	}
	
//ajout CPascalWeb - 7 octobre 2010 ajout fonction affichage annonces suspendu par l'annonceur
	$xoopsTpl->assign('aff_suspend', $xoopsModuleConfig['aff_suspend']);		
	if ( $xoopsModuleConfig['aff_suspend'] == '1' )
	{		
		if($suspend < 1)
		{
			//$xoopsTpl->assign('indicateur_suspend', _MD_CATADS_NO_SUSPUSER);
		}
		elseif($suspend > 1)
		{
			$xoopsTpl->assign('indicateur_suspend', sprintf(_MD_CATADS_SUSPUSER, $suspend));
		}
		else
		{
			$xoopsTpl->assign('indicateur_suspend', sprintf(_MD_CATADS_SUSPUSERUNE, $suspend));
		}
	}	

//fin de l'ajout

//ajout cpascalweb - le 12 octobre 2010 afficher une pub dans le bloc informations annonces
$xoopsTpl->assign('pub_bloc_info', $xoopsModuleConfig['pub_bloc_info']);
        if ( $xoopsModuleConfig['pub_bloc_info'] == '1' ) {
                $xoopsTpl->assign('pub_bloc', $xoopsModuleConfig['pub_bloc_info_script']);
        }
//fin de l'ajout affichage pub dans le bloc informations annonces

//suprimer ne sert plus maintenant a vérifier aprés test !
		/*if ($xoopsModuleConfig['moderated'] == '1') {
            $xoopsTpl->assign('total_confirm', sprintf(_MD_CATADS_ANDWAIT, $ads_wait));//et %s annonce(s) en attente de validation
        }*/

		//affichage carte
        $xoopsTpl->assign('show_card', $xoopsModuleConfig['show_card']);
		if ( $xoopsModuleConfig['show_card'] == '0' )
		{
            // dernières annonces
            if ($xoopsModuleConfig['nb_news'] > 0 )
            {
                if ($nbads > 0)
                {
                    $xoopsTpl->assign('lang_title', _MD_CATADS_LASTADD);

                    //Recuperer les annonces en fonction des categories
                    //$permHandler = catadsPermHandler::getHandler();
                    $permHandler = $adsPermHandler->getHandler();
                        if( $permHandler->listAds($xoopsUser, 'catads_access') )
                        {
                            $show_topic_id = $permHandler->listAds($xoopsUser, 'catads_access');
                        }
//correction CPascalWeb - 24 mai 2011						
                            //$arr_lastads = showListAds($show_topic_id, 0, $affichage_titre, $affichage_prix, $affichage_option_prix, $affichage_localisation, $affichage_date, 0, $xoopsModuleConfig['nb_news']);
							$arr_lastads = showListLastAds($show_topic_id, $reduireTitle, 0, 0, $limit = '');
//fin							
							$xoopsTpl->assign('items', $arr_lastads);
                        }
            }
		}
		else
		{
//modif CPascalWeb - 7 octobre 2010 ajout fonction affichage define suivant le nombre 		
            //$xoopsTpl->assign('total_annonces',sprintf( _MD_CATADS_ACTUALY, $nbads));
		if($nbads < 1)
		{
			$xoopsTpl->assign('total_annonces', _MD_CATADS_PAS_ANNONCE);
		}
		elseif($nbads > 1)
		{
			$xoopsTpl->assign('total_annonces',sprintf( _MD_CATADS_ACTUALY, $nbads));
		}
		else
		{
			$xoopsTpl->assign('total_annonces',sprintf(_MD_CATADS_ACTUALYUNE, $nbads));
		}			
//fin
//modif CPascalWeb 24 mai 2011 - plus utile !!! ajout dans préférence module 				
                //$xoopsTpl->assign('afficherBlocNbAnnonces', $afficherBlocNbAnnonces);
                //$xoopsTpl->assign('afficherBlocDernieresAnnonces', $afficherBlocDernieresAnnonces);
                //permissions
                $permHandler = catadsPermHandler::getHandler();
                if( $permHandler->listAds($xoopsUser, 'catads_access') )
                {
                    $show_topic_id = $permHandler->listAds($xoopsUser, 'catads_access');
                }
//modif CPascalWeb 24 mai 2011 - plus utile !!! ajout dans préférence module				
                //$arr_lastads = showListLastAds($show_topic_id, $reduireTitle, 0, 0, $afficherNbDernieresAnnonces);
				$arr_lastads = showListLastAds($show_topic_id, $reduireTitle, 0, 0, $limit = '');
                $xoopsTpl->assign('items', $arr_lastads);
		}
//ajout cpascalweb - le 23 mai 2011 - Choix d'afficher ou non le bloc actuellement				
				$xoopsTpl->assign('affiche_bloc_indic', $xoopsModuleConfig['affiche_bloc_indic']);
//ajout cpascalweb - le 23 mai 2011 - Choix d'afficher ou non le total des annonces visibles				
				$xoopsTpl->assign('affiche_ads_visible', $xoopsModuleConfig['affiche_ads_visible']);
//ajout cpascalweb - le 24 mai 2011 - Choix d'afficher ou non le bloc les dernières petites annonces	
				$xoopsTpl->assign('bloc_dernieres_annonces', $xoopsModuleConfig['bloc_dernieres_annonces']);
//fin				
				$xoopsTpl->assign('show_ad_type', $show_ad_type);
				$xoopsTpl->assign("xoops_module_header",'<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/style.css" /> <link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/highslide.css" /> <link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/highslide-ie6.css" />');
			
include(XOOPS_ROOT_PATH."/footer.php");


?>