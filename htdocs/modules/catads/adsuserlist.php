<?php

include_once("../../mainfile.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/include/functions.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/ads.php");
include_once(XOOPS_ROOT_PATH."/class/pagenav.php");
//ajout CPascalWeb - 11 octobre 2010
include_once(XOOPS_ROOT_PATH."/class/userutility.php");
//fin
$xoopsOption['template_main'] = 'catads_adslist.tpl';
include_once(XOOPS_ROOT_PATH."/header.php");


global $xoopsDB, $xoopsUser, $xoopsModuleConfig ;
//$ads_handler =& xoops_getmodulehandler('ads');
$ads_handler = xoops_getmodulehandler('ads');

foreach ($_POST as $k => $v) {${$k} = $v;}
foreach ($_GET as $k => $v) {${$k} = $v;}

if(!isset($debut)) $debut= 0;

$show_ad_type = $xoopsModuleConfig['show_ad_type'] ;

//Rappel:a revoir
$affichage_titre = isset($_GET['affichage_titre']) ? $_GET['affichage_titre'] : '';
$affichage_prix = isset($_GET['affichage_prix']) ? $_GET['affichage_prix'] : '';
$affichage_option_prix = isset($_GET['affichage_option_prix']) ? $_GET['affichage_option_prix'] : '';
$affichage_localisation = isset($_GET['affichage_localisation']) ? $_GET['affichage_localisation'] : '';
$affichage_date = isset($_GET['affichage_date']) ? $_GET['affichage_date'] : '';

//mes annonces
$uid = !isset($_REQUEST['uid'])? NULL : $_REQUEST['uid'];
	
	if ($xoopsUser) {
        if ($xoopsUser->getVar('uid') != $uid) {
//ajout CPascalWeb - 4 mai 2011 - permettre a l'admin de voir la liste des annonces d'un annonceur		
		if ( !$xoopsUser->isAdmin($xoopsModule->mid()) ) { 
//fin		
        redirect_header(XOOPS_URL."/modules/catads/index.php",2,_NOPERM);
        }
	}
		
        if ($xoopsUser->getVar('uid') == $uid) {
       // $isauthor = true;
        $xoopsTpl->assign('lang_title', _MD_CATADS_MYADS);
        } elseif ($xoopsUser->isAdmin($xoopsModule->getVar('mid'))) {
//modif CPascalWeb - 11 octobre 2010		
       // $xoopsTpl->assign('lang_title', _MD_CATADS_ALLADS.xoops_getLinkedUnameFromId($uid));
	   $xoopsTpl->assign('lang_title', _MD_CATADS_ALLADS.XoopsUserUtility::getUnameFromId($uid));
//fin	   
    }
    }

        // comptage nombre annonces
        $criteria = new Criteria('uid', $uid);
        $nbads = $ads_handler->getCount($criteria);
        $start = $debut;
        //$start = '0';
        $limit = $xoopsModuleConfig['nb_perpage'];//pas vraiment utile je l'ai ajouter dans la fonction: showMyAds 
        //Probleme autrement avec le template catads_adssublist.tpl
        $topic_id = '';
//modif CPascalWeb - supp variables  
        // $arr_ads = showListAdsByUser($uid, $affichage_titre, $affichage_prix, $affichage_option_prix, $affichage_localisation, $affichage_date, $debut, $xoopsModuleConfig['nb_perpage']);
		$arr_ads = showMyAds('', $uid, $affichage_titre, $affichage_prix, $affichage_option_prix, $affichage_localisation, $affichage_date, $start, $debut, $limit, $xoopsModuleConfig['nb_perpage']);
		//$pagenav = new XoopsPageNav($nbads, $xoopsModuleConfig['nb_perpage'], $limit, $start, "start", "uid=".$uid);
		$pagenav = new XoopsPageNav($nbads, $xoopsModuleConfig['nb_perpage'], $debut, "debut", "uid=".$uid);
//fin	

//ajout fonction CPascalWeb - 18 octobre 2010 - boîte de sélection d'une autre catégorie 
	include_once XOOPS_ROOT_PATH.'/class/xoopstree.php';
	global $xoopsDB;
	$selec_cat = new XoopsTree($xoopsDB->prefix("catads_cat"),'topic_id','topic_pid');
	$url = XOOPS_URL."/modules/".$xoopsModule->dirname()."/adslist.php?topic_id=";
	ob_start();
	$selec_cat->makeMySelBox('topic_title','topic_title',0,1, 'topic_pid', "location=\"".$url."\"+this.options[this.selectedIndex].value");
	$xoopsTpl->assign('selecCat',ob_get_contents());
	ob_end_clean();

//ajout fonction CPascalWeb - boîte de sélection affichage par type d'annonce	
	include_once XOOPS_ROOT_PATH.'/class/xoopstree.php';
	include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/option.php");
	global $xoopsDB;
	
	$ads_type = '';
		//$urlType = XOOPS_URL."/modules/catads/adslist.php?option_type=".$sel_type;	
		//$urlType = XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/adslist.php?op=&amp;topic_id='.$topic_id.'&amp;option_type='.$sel_type;
		$urlType = XOOPS_URL . '/modules/'.$xoopsModule->dirname().'/adslist.php?search=1&words='.$ads_type;		
		$opt = new catadsOption();
        ob_start();
        $opt->makeMySelBox('option_order','', 1, 3, "location=\"".$urlType."\"+this.options[this.selectedIndex].value");//ajouter autres options de tris en modifiant ...,3,...
        $xoopsTpl->assign('afficher_par_type', ob_get_contents());
        ob_end_clean();
//fin de l'ajout	

//ajout option CPascalWeb - 24 novembre 2010 - afficher une bannières pub sur les pages principal du module
		$xoopsTpl->assign('aff_pub_general', $xoopsModuleConfig['aff_pub_general']);
		$xoopsTpl->assign('aff_pub_general_site', $xoopsModuleConfig['aff_pub_general_site']);
        if ( $xoopsModuleConfig['aff_pub_general'] == 1 ) {
            $xoopsTpl->assign('pub_general', $xoopsModuleConfig['aff_pub_general_code']);
        }
//fin

//ajout CPascalWeb   
		$xoopsTpl->assign('add_perm', true);
        $xoopsTpl->assign('topic_id', $topic_id);
		//fil rss
		$link=sprintf("<a href='%s' title='%s'><img src='%s' border='0' alt='%s' /></a>",XOOPS_URL."/modules/".$xoopsModule->dirname()."/backend.php?id=".$topic_id, _MD_CATADS_RSSFEED, XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/rss.gif",_MD_CATADS_RSSFEED);
		$xoopsTpl->assign('rssfeed_link',$link);	
//fin
	    $xoopsTpl->assign('nbads', $nbads);
        $xoopsTpl->assign('topic_id', 0);
        $xoopsTpl->assign('isauthor', true);
        $xoopsTpl->assign('uid', $uid);
        $xoopsTpl->assign('items', $arr_ads);
        $xoopsTpl->assign('nav_page', $pagenav->renderNav());
        $xoopsTpl->assign('show_ad_type', $show_ad_type);


$xoopsTpl->assign("xoops_module_header",'<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/style.css" /> <link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/highslide.css" /> <link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/highslide-ie6.css" />');

include(XOOPS_ROOT_PATH."/footer.php");
?>