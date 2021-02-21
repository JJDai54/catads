<?php

include "header.php";
include_once("../../mainfile.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/include/functions.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/ads.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/cat.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/option.php");
include_once(XOOPS_ROOT_PATH."/class/pagenav.php");
include_once XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/class/permissions.php';


$affichage_titre = isset($_GET['affichage_titre']) ? $_GET['affichage_titre'] : '';
$affichage_prix = isset($_GET['affichage_prix']) ? $_GET['affichage_prix'] : '';
$affichage_option_prix = isset($_GET['affichage_option_prix']) ? $_GET['affichage_option_prix'] : '';
$affichage_localisation = isset($_GET['affichage_localisation']) ? $_GET['affichage_localisation'] : '';
$affichage_date = isset($_GET['affichage_date']) ? $_GET['affichage_date'] : '';

global $pk_topic_id, $xoTheme;
//Titre du sujet 
$topic_title = isset($_GET['topic_title']) ? $_GET['topic_title'] : '';
//obtenir les résultats de recherche
$search = isset($_GET['search']) ? $_GET['search'] : '';
//obtenir le nombre d'annonce + indic nouveau !  
$nbads = isset($_GET['nbads']) ? $_GET['nbads'] : '0';
$arr_ads = isset($_GET['arr_ads']) ? $_GET['arr_ads'] : '';
$newads = isset($_REQUEST['newads']) ? $_REQUEST['newads'] : ''; 
//$ads_handler =& xoops_getmodulehandler('ads');
$ads_handler = xoops_getmodulehandler('ads');
$myts = MyTextSanitizer::getInstance();

foreach ($_POST as $k => $v) {${$k} = $v;}
foreach ($_GET as $k => $v) {${$k} = $v;}
if(!isset($debut)) $debut= 0;

//id sujet (topic)
$topic_id = isset($_GET['topic_id']) ? intval($_GET['topic_id']) : 0;

//annonceur
$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
//$myts =& MyTextSanitizer::getInstance();
$myts = MyTextSanitizer::getInstance();
//config nombre colonnes
$nbcolonnes = $xoopsModuleConfig['nbcol'];
//obtenir les préférence du module
$show_ad_type = $xoopsModuleConfig['show_ad_type'] ;
//template par défaut
$xoopsOption['template_main'] = 'catads_adslist.tpl';
include_once(XOOPS_ROOT_PATH."/header.php");

//fil rss A REVOIR FONCTIONNE PAS
$link=sprintf("<a href='%s' title='%s'><img src='%s' border='0' alt='%s' /></a>",XOOPS_URL."/modules/".$xoopsModule->dirname()."/backend.php?id=".$topic_id, _MD_CATADS_RSSFEED, XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/rss.gif",_MD_CATADS_RSSFEED);
$xoopsTpl->assign('rssfeed_link',$link);

//ajout option CPascalWeb - 24 novembre 2010 - afficher une bannières pub sur les pages principal du module
		$xoopsTpl->assign('aff_pub_general', $xoopsModuleConfig['aff_pub_general']);
		$xoopsTpl->assign('aff_pub_general_site', $xoopsModuleConfig['aff_pub_general_site']);
        if ( $xoopsModuleConfig['aff_pub_general'] == 1 ) {
            $xoopsTpl->assign('pub_general', $xoopsModuleConfig['aff_pub_general_code']);
        }
//fin

        function getFirstChild($topic_id = 0) {
                global $allcat;
                $firstChild = array();
                        foreach($allcat as $onechild)         {
                                if( $onechild['topic_pid'] == $topic_id) {
                                        array_push($firstChild, $onechild);
                                }
                        }
                return $firstChild;
        }

        function showsubcat($categorys, $level = 0, $topic_id = 0, $topic_pid) {
                global $xoopsModule, $myts, $lastchildren, $nbadspercat, $newads, $arr_subcat, $cptsubcat, $nbcol, $tpltype;


                foreach($categorys as $onecat) {

                        $link = XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/adslist.php?topic_id=' . $onecat['topic_id'];
						$title = $myts->htmlSpecialChars($onecat['topic_title']);
//modif CPascalWeb 16 avril 2011						
                       // $desc = $myts->htmlSpecialChars($onecat['topic_desc']);
						$desc = $myts->undoHtmlSpecialChars($onecat['topic_desc']);	
//fin						
                        if (in_array($onecat['topic_id'], $lastchildren)) {
                                $arr_scat['nb'] = (array_key_exists($onecat['topic_id'], $nbadspercat)) ?  "(".$nbadspercat[$onecat['topic_id']].")": '';
                                $arr_scat['new'] = (array_key_exists($onecat['topic_id'], $newads)) ? $newads[$onecat['topic_id']]: '';
                        }
                        $arr_scat['link'] = XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/adslist.php?topic_id=' . $onecat['topic_id'];
                        $arr_scat['title'] = $title;
                        $arr_scat['desc'] = $desc;
                        $arr_scat['img'] = "<img src='".XOOPS_URL."/uploads/".$xoopsModule->dirname()."/images/categories/".$onecat['img']."' style='vertical-align: middle;' />";
                        if ($level == 0 && $tpltype == 1) {
                                $arr_scat['newcol'] = ($cptsubcat > 0) ? true : false;
                                $cptsubcat++;
                                $arr_scat['newline'] = ($cptsubcat % $nbcol == 1) ? true : false;
                        }
                        array_push($arr_subcat, $arr_scat);
                        $childcats =  getFirstChild($onecat['topic_id']);
                                if (count($childcats) > 0) {
                                    showsubcat($childcats, $level + 1, $onecat['topic_id'], $pid);
                                }
                        }
                return;
        }

         //critéres global
         $criteria = new CriteriaCompo();
		 
	//si une catégorie est sélectionnée
	if ($topic_id > 0)
	{
        // critères supplémentaires
        $criteria->add(new Criteria('waiting','0'), 'AND');
        $criteria->add(new Criteria('suspend','0'), 'AND');
//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce		
		$criteria->add(new Criteria('suspendadmin','0'), 'AND');
//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse
		if($xoopsModuleConfig['active_suspect'] < '1'){
		$criteria->add(new Criteria('signalementannonce','0'), 'AND');
		} 		
//fin		
        $criteria->add(new Criteria('published', time(),'<'), 'AND');
        $criteria->add(new Criteria('expired', time(),'>'), 'AND');

        //Permissions
        $permHandler = catadsPermHandler::getHandler();
        if(!$permHandler->isAllowed($xoopsUser, 'catads_access', $topic_id))
        {
            redirect_header(XOOPS_URL."/modules/catads/index.php",3,_NOPERM);
            exit;
        }
        include_once(XOOPS_ROOT_PATH."/class/xoopstree.php");
        include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/cat.php");
       
	    //verification existence catégorie
        $cat = new catadsCategory($topic_id);
        if ($cat->topic_id != $topic_id)
        {
            redirect_header(XOOPS_URL."/modules/catads/index.php",3,_MD_CATADS_CAT_NOEXIST);
        }

        //obtenir toutes les sous catégories
        $lastchildren = $adsCatHandler->getAllLastChild();
        $lastChild = false;
        foreach($lastchildren as $onechild)
        {
            if( $onechild == $topic_id)
            {
                $lastChild = true;
            }
        }

        $mytree = new XoopsTree($xoopsDB->prefix("catads_cat"),"topic_id","topic_pid");

        if ($lastChild) {
            $criteria->add(new Criteria('cat_id', $topic_id));
            $nbads = $ads_handler->getCount($criteria);
            $arr_ads = showListAds($topic_id, 0, $affichage_titre, $affichage_prix, $affichage_option_prix, $affichage_localisation, $affichage_date, $debut, $xoopsModuleConfig['nb_perpage']);
            $xoopsTpl->assign('add_perm', true);
        } else {
            $criteria2 = new CriteriaCompo();
            $allcat = $mytree->getAllChildId($topic_id);
		
		//afficher les sous catégories
        //$sous_cat = catadsCategory::getFirstChildArr2($topic_id, 'weight');
        $sous_cat = $adsCatHandler->getFirstChildArr2($topic_id, 'weight');
//modif CPascalWeb - 26 octobre 2010 - voir catads_adslist.tpl		
		$show_sous_cat = '<table cellspacing="1" class="outer"><tr>';
//fin		
		$countcat = 1;
        echo $newads;

        //choix de la largeur des colonnes (TD)
        if($nbcolonnes == '1') {
        $td_width = "100%";
        } else if($nbcolonnes == '2') {
        $td_width = "50%";
        } else if($nbcolonnes == '3') {
        $td_width = "33%";
        } else if($nbcolonnes == '4') {
        $td_width = "25%";
        } else if($nbcolonnes == '5') {
        $td_width = "20%";
        }
        //page des sous catégories d'une catégorie principal
        foreach($sous_cat as $onecat)
        {
		
//ajout CPascalWeb - 25 octobre 2010 - affichage des descriptions + title et alt + images des sous catégories avec lien avec option ajouter choix largeur depuis préférence		
        //$desc = $myts->htmlSpecialChars($onecat['topic_desc']);		
		$desc = $myts->undoHtmlSpecialChars($onecat['topic_desc']);		    
	 	
	if($onecat['img'] == 1)
	{
		//si image sous catégorie(pour ie)
		$img = "<a href=".XOOPS_URL. '/modules/'.$xoopsModule->dirname().'/adslist.php?topic_id='.$onecat['topic_id'].">
		<img src='".XOOPS_URL."/uploads/".$xoopsModule->dirname()."/images/categories/".$onecat['img']."' style=\"width: ".$xoopsModuleConfig['scat_width']."px; \" class='listescat_images' style='vertical-align: middle;' title='". _MD_CATADS_NOM_REFERENCE .' '. $onecat['topic_title'] .' '.$onecat['topic_desc'] ."' title='". _MD_CATADS_NOM_REFERENCE .' '. $GLOBALS['xoopsConfig']['sitename'] .' '.$onecat['topic_title'] ."' />
		</a>";
	}
	else
	{
		//si aucune image(pour ie)
		$img = "<a href=".XOOPS_URL. '/modules/'.$xoopsModule->dirname().'/adslist.php?topic_id='.$onecat['topic_id']."></a>";
	}		
//fin		
//ajout CPascalWeb - 25 octobre 2010 - affichage des descriptions(desc) + title et alt + images des sous catégories($img) + présentation
				$show_sous_cat .= '<td class="even" width="'.$td_width.'">
				<a href="'.XOOPS_URL. '/modules/'.$xoopsModule->dirname().'/adslist.php?topic_id='.$onecat['topic_id'].'" class="listescat_images" title="'. _MD_CATADS_NOM_REFERENCE .' '. $onecat['topic_title'] .' '.$onecat['topic_desc'] .'" title="'. _MD_CATADS_NOM_REFERENCE .' '. $GLOBALS['xoopsConfig']['sitename'] .' '.$onecat['topic_title'] .'">'.$img.'</a>
				<a href="'.XOOPS_URL. '/modules/'.$xoopsModule->dirname().'/adslist.php?topic_id='.$onecat['topic_id'].'" class="listescat_titre" title="'. _MD_CATADS_NOM_REFERENCE .' '. $onecat['topic_title'] .' '.$onecat['topic_desc'] .'" title="'. _MD_CATADS_NOM_REFERENCE .' '. $GLOBALS['xoopsConfig']['sitename'] .' '.$onecat['topic_title'] .'">'.$myts->htmlSpecialChars($onecat['topic_title']).'</a>
				<br />'.$desc.'';

				$countcat++;
				$new_col = ($countcat % $nbcolonnes == 1) ? true : false;
			if ($new_col == true )
			{
            $show_sous_cat .= '</tr><tr>';
			}
        }
			$show_sous_cat .= '</tr></tbody></table>';
		
			$xoopsTpl->assign('sous_cat', $show_sous_cat);
            $nbads = $ads_handler->getCount($criteria);
            $arr_ads = showListAds($topic_id, 0, $affichage_titre, $affichage_prix, $affichage_option_prix, $affichage_localisation, $affichage_date, $debut, $xoopsModuleConfig['nb_perpage']);
            $xoopsTpl->assign('add_perm', false);

        }

			$pagenav = new XoopsPageNav($nbads, $xoopsModuleConfig['nb_perpage'], $debut, "debut", "topic_id=".$topic_id);
			$xoopsTpl->assign('topic_id', $topic_id);
			
			$sql = $xoopsDB->query("SELECT topic_desc FROM ".$xoopsDB->prefix("catads_cat")." WHERE topic_id = ".$topic_id);
			list($topic_desc) = $xoopsDB->fetchRow($sql);

			//navigation/chemin
//modif CPascalWeb - 9 octobre 2010 - alt & titre + description sous catégorie et nom du site supposé aider au référencement naturel + ajout lien pour mode SEO + ajout arrow.gif 			
			$cat_path = $mytree->getpathFromId( $topic_id, 'topic_title');
			$cat_desc = $mytree->getpathFromId( $topic_id, 'topic_desc');			
			$pathstring = "<a href='" . XOOPS_URL ."/modules/".$xoopsModule->getVar('dirname')."/index.php' title='". _MD_CATADS_NOM_REFERENCE .' '. $GLOBALS['xoopsConfig']['sitename'] ."' alt='". _MD_CATADS_NOM_REFERENCE .' '. $GLOBALS['xoopsConfig']['sitename'] ."'>"._MD_CATADS_MAIN."</a>&nbsp;<img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/arrow.gif' border='0' title='". _MD_CATADS_NOM_REFERENCE .' '.$cat_desc."' alt='". _MD_CATADS_NOM_REFERENCE .' '. $GLOBALS['xoopsConfig']['sitename'] ."' />&nbsp;";
			$pathstring .= $mytree->getNicePathFromId($topic_id, "topic_title",  XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/adslist.php");
 		//$pathstring .= str_replace(":"," <img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/arrow.gif' border='0' title='". _MD_CATADS_NOM_REFERENCE .' '. $topic_desc ."' alt='". _MD_CATADS_NOM_REFERENCE .' '. $GLOBALS['xoopsConfig']['sitename'] ."' /> ",$pathstring);     
//fin 			

			$xoopsTpl->assign('cat_path', $pathstring);
			//déplacer plus haut
			//$cat_path = $mytree->getpathFromId( $topic_id, 'topic_title');//placer plus haut
			//$cat_desc = $mytree->getpathFromId( $topic_id, 'topic_desc');

			// titre page pour aide aux référencements
			$cat_path2 = str_replace("/"," - ",$cat_path);
			$cat_path3 = str_replace("/",":",$cat_desc);
			$xoopsTpl->assign('lang_title', substr($cat_path2, 2));
        if ( $xoopsModuleConfig['show_cat_desc'] > 0 )
        {
            $xoopsTpl->assign('lang_desc', $topic_desc);
        }
		
			$xoopsTpl->assign('xoops_pagetitle', $xoopsModule->name() . '' . $cat_path2);
			$cat_path = str_replace(":"," <img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/arrow.gif' border='0' alt='' /> ",$cat_path);
			$xoopsTpl->assign('add_tab', 1);

			//ajout pour les metas keywords et descriptions des categories
			$desctextclean = strip_tags($topic_desc, '<font><img><b><i><u>');
			$xoTheme->addMeta('meta', 'description', substr($desctextclean, 0, 140));
			$cat_path_for_keywords =  str_replace(":", "", $cat_path2);
			$cat_path_for_keywords =  trim($cat_path_for_keywords);
			$keyword_tags = $cat_path_for_keywords;
			$xoTheme->addMeta('meta', 'keywords', $keyword_tags);
			//fin ajout
	}
	//annonceur
	elseif ($uid > 0)
	{
        global $xoopsUser;
        //$ads_hnd =& xoops_getmodulehandler('ads', 'catads');
        $ads_hnd = xoops_getmodulehandler('ads', 'catads');		
        $permHandler = catadsPermHandler::getHandler();
        $criteria = new CriteriaCompo();
        $topic_id = !isset($_REQUEST['topic_id'])? NULL : $_REQUEST['topic_id'];
        $topic = $permHandler->listAds($xoopsUser, 'catads_access', $topic_id);
        include_once(XOOPS_ROOT_PATH."/class/xoopstree.php");
        $mytree = new XoopsTree($xoopsDB->prefix("catads_cat"),"topic_id","topic_pid");
        $criteria5 = new CriteriaCompo();
        $allcat = $mytree->getAllChildId($topic_id);
        $i = 0;
    foreach($topic as $valeur)
    {
        foreach($allcat as $valeur1)
        {
            if ($valeur == $valeur1)
            {
                $show_topic_id[$i] = $valeur1;
                $i++;
            }
        }
    }

    for($j=0; $j<$i; $j++)
    {
        $criteria5->add(new Criteria('cat_id',$show_topic_id[$j]), 'OR');
    }

        $criteria->add($criteria5);
        //critères supplémentaires
        $criteria->add(new Criteria('waiting','0'), 'AND');
        $criteria->add(new Criteria('suspend','0'), 'AND');
//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce			
        $criteria->add(new Criteria('suspendadmin','0'), 'AND');
//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse
		$criteria->add(new Criteria('signalementannonce','0'), 'AND');
//fin		
        $criteria->add(new Criteria('published', time(),'<'), 'AND');
        $criteria->add(new Criteria('expired', time(),'>'), 'AND');
        $criteria->add(new Criteria('uid', $uid));

        $nbads = $ads_handler->getCount($criteria);
        $start = $debut;
        // $start = '0';
		$limit = $xoopsModuleConfig['nb_perpage'];
        $arr_ads = showListAdsByUser('', $uid, $affichage_titre, $affichage_prix, $affichage_option_prix, $affichage_localisation, $affichage_date, $debut, $limit);
        $pagenav = new XoopsPageNav($nbads, $limit, $debut, "debut", "uid=".$uid);
        
		$xoopsTpl->assign('uid', $uid);
        $xoopsTpl->assign('lang_title', _MD_CATADS_ALLADS.XoopsUser::getUnameFromId($uid));
	}

	//recherche en mode d'affiche par défaut DESC 
	elseif ($search == '1')
	{
        //session
//modif CPascalWeb - 7 octobre 2010 - affichage bug session deja commencer	
        //session_start();
		if (!session_id()) session_start();
//fin		
		//les sessions
        unset($_SESSION["pk_words"]);
        unset($pk_words);
        unset($_SESSION["pk_topic_id"]);
        unset($pk_topic_id);
        unset($_SESSION["pk_town"]);
        unset($pk_town);
        unset($_SESSION["pk_zipcod"]);
        unset($pk_zipcod);
        unset($_SESSION["pk_price_start"]);
        unset($pk_price_start);
        unset($_SESSION["pk_price_end"]);
        unset($pk_price_end);
        unset($_SESSION["pk_region"]);
        unset($pk_region);
        unset($_SESSION["pk_departement"]);
        unset($pk_departement);
//ajout CPascalWeb - 4 novembre 2010 - résultat des recherches par type 	
        unset($_SESSION["ads_type"]);
        unset($ads_type);		
//fin	
		//choix global des critéres
        $criteria = new CriteriaCompo();

    if ( isset($_REQUEST['words']) && trim($_REQUEST['words']) != '' )
    {
//modif CPascalWeb - 4 novembre 2010 - mis a jour php 5+	
        //$words = split(' ', $myts->addSlashes($_REQUEST['words']));
        $words = preg_split('/ /', $myts->addSlashes($_REQUEST['words']));        
//fin		
		$nb_words = count($words);
        $criteria4 = new CriteriaCompo();
            for ( $i = 0; $i < $nb_words; $i++ )
            {
                $criteria4->add(new Criteria('ads_title', '%'.$words[$i].'%', 'LIKE'), 'OR');
                $criteria4->add(new Criteria('ads_desc', '%'.$words[$i].'%','LIKE'), 'OR');
                $criteria4->add(new Criteria('ads_tags', '%'.$words[$i].'%','LIKE'), 'OR');
//ajout CPascalWeb - 4 novembre 2010 - résultat des recherches par type 			
				$criteria4->add(new Criteria('ads_type', '%'.$words[$i].'%', 'LIKE'), 'OR');
//fin		
            $_SESSION["pk_words"] = $words[$i];
            }
            $criteria->add($criteria4);
    }

        //obtenir topic_id à partir de topic_title
//modif CPascalWeb - 9 octobre 2010		
        //$topic_id = $topic_title['topic_id'];//bug
		$topic_id = isset($topic_title['topic_id']) ? $topic_title['topic_id'] : 0 ;
//fin
    if( isset( $topic_title ) && !empty( $topic_title ) )
    {
        $criteria->add(new Criteria('cat_id', $topic_id,'='));
        $_SESSION["pk_topic_id"] = $topic_id;
    }

	//ville
    if( isset( $town ) && !empty( $town ) )
    {
        $town = $myts->addSlashes($town);
        $criteria->add(new Criteria('town', '%'.$town.'%','LIKE'), 'AND');
        $_SESSION["pk_town"] = $town;
        }

	//code postal	
    if( isset( $zipcod ) && !empty( $zipcod ) )
    {
        $zipcod = $myts->addSlashes($zipcod);
        $criteria->add(new Criteria('codpost', '%'.$zipcod.'%','LIKE'), 'AND');
        $_SESSION["pk_zipcod"] = $zipcod;
    }

	//prix
    if( isset( $price_start ) && !empty( $price_start ) )
    {
        if(is_numeric($price_start)){
            $criteria->add(new Criteria('price', $price_start,'>='), 'AND');
            $_SESSION["pk_price_start"] = $price_start;
        } else {
            redirect_header(XOOPS_URL."/modules/catads/index.php",3,_MD_CATADS_INVALIDPRICE);
        }
    }

	//prix
    if( isset( $price_end ) && !empty( $price_end ) )
    {
        if(is_numeric($price_end)){
            $criteria->add(new Criteria('price', $price_end,'<='), 'AND');
            $_SESSION["pk_price_end"] = $price_end;
        } else {
            redirect_header(XOOPS_URL."/modules/catads/index.php",3,_MD_CATADS_INVALIDPRICE);
        }
    }

	//régions
    if( !empty( $region ) && !empty( $region ) )
    {
        $region = intval($region);
        $criteria->add(new Criteria('region', $region,'='), 'AND');
        $_SESSION["pk_region"] = $region;
    }

	//départements
    if( !empty( $departement ) && !empty( $departement ) &&  $departement != "other" )
    {
        $departement = intval($departement);
        // pk departement is exact match - but selected from menu so not a problem
        $criteria->add(new Criteria('departement', $departement,'='), 'AND');
        $_SESSION["pk_departement"] = $departement;
    }
//ajout fonction CPascalWeb - 4 novembre 2010 - résultat des recherches par type 
	//ads_type
    if( !empty( $ads_type ) && !empty( $ads_type ) &&  $ads_type != "other" )
    {
        $ads_type = intval($ads_type);
        $criteria->add(new Criteria('ads_type', $ads_type,'='), 'AND');
        $_SESSION["ads_type"] = $ads_type;
    }
//fin
        global $xoopsUser;
        //$ads_hnd =& xoops_getmodulehandler('ads', 'catads');
        $ads_hnd = xoops_getmodulehandler('ads', 'catads');		
        $permHandler = catadsPermHandler::getHandler();
		
        $topic_id = !isset($_REQUEST['topic_id'])? NULL : $_REQUEST['topic_id'];
        $topic = $permHandler->listAds($xoopsUser, 'catads_access');
		
        include_once(XOOPS_ROOT_PATH."/class/xoopstree.php");
        $mytree = new XoopsTree($xoopsDB->prefix("catads_cat"),"topic_id","topic_pid");
        $criteria5 = new CriteriaCompo();
		
        $allcat = $mytree->getAllChildId($topic_id);
        $i = 0;
		
    foreach($topic as $valeur)
    {
        foreach($allcat as $valeur1)
        {
            if ($valeur == $valeur1)
            {
                $show_topic_id[$i] = $valeur1;
                $i++;
            }
        }
    }

            for($j=0; $j<$i; $j++)
            {
                $criteria5->add(new Criteria('cat_id',$show_topic_id[$j]), 'OR');
            }

        $criteria->add($criteria5);
        $criteria->add(new Criteria('waiting','0'), 'AND');
        $criteria->add(new Criteria('suspend','0'), 'AND');
//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce		
        $criteria->add(new Criteria('suspendadmin','0'), 'AND');		
//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse
		$criteria->add(new Criteria('signalementannonce','0'), 'AND');
//fin	
        $criteria->add(new Criteria('published', time(),'<'), 'AND');
        $criteria->add(new Criteria('expired', time(),'>'), 'AND');

        $nbads = $ads_handler->getCount($criteria);
//ajout fonction CPascalWeb - 4 novembre 2010 - résultat des recherches par type 		
		$ads_type = '';
//fin
        $search = '2';
        $start = '0';
        $limit = $xoopsModuleConfig['nb_perpage'];
        $arr_ads = showListSearchAds($search, $affichage_titre, $ads_type, $affichage_prix, $affichage_option_prix, $affichage_localisation, $affichage_date, $criteria, $start, $limit);

        $xoopsTpl->assign('search', $search);
        $pagenav = new XoopsPageNav($nbads, $limit, $debut, "debut", "search=".$search);
//ajout fonction CPascalWeb - 7 octobre 2010 affichage define suivant nombre	        
		//$xoopsTpl->assign('lang_title', sprintf(_MD_CATADS_SEARCH_NB, $nbads));
	if($nbads < 1)
	{
		//si aucune annonce
		//sur page
		//$xoopsTpl->assign('lang_title', sprintf(_MD_CATADS_SEARCH_NB_NOA, $nbads));
		//en redirection header
		redirect_header($_SERVER['HTTP_REFERER'], 3, sprintf(_MD_CATADS_SEARCH_NB_NOA, $nbads));
	}
	elseif($nbads > 1)
	{
		//si plusieurs annonces
        $xoopsTpl->assign('lang_title', sprintf(_MD_CATADS_SEARCH_NB, $nbads));
	}
	else
	{
		//si une seule annonce
        $xoopsTpl->assign('lang_title', sprintf(_MD_CATADS_SEARCH_NB_1A, $nbads));
	}
//fin de l'ajout	
		$xoopsTpl->assign('add_tab', 0);
		
//ajout CPascalWeb - 28 octobre 2010 - affiche bouton déposé une annonce		
		$xoopsTpl->assign('add_perm', true);
//fin		
	}

	//résultats de recherche en mode d'affichage ASC
	elseif ($search == '2')
	{
		$search_criteria = new CriteriaCompo();

    if( isset($_SESSION['pk_words']) && !empty($_SESSION['pk_words']) )
    {
//modif CPascalWeb - 4 novembre 2010 - mis a jour php 5+	
        //$words = split(' ', $myts->addSlashes($_SESSION['pk_words']));
        $words = preg_split('/ /', $myts->addSlashes($_SESSION['pk_words']));		
//fin		
        $nb_words = count($words);

        //groupes multiple ou états
        $criteria4 = new CriteriaCompo();

        for ( $i = 0; $i < $nb_words; $i++ )
        {
            //dernière condition fixe '=' (correspondance exacte) ou 'LIKE' correspondance similaire
            $criteria4->add(new Criteria('ads_title', '%'.$words[$i].'%', 'LIKE'), 'OR');
            $criteria4->add(new Criteria('ads_desc', '%'.$words[$i].'%','LIKE'), 'OR');
            //ajout ads_tags pour rechercher champ d'application (nécessaire si les tags personnalisées sont autorisés)
            $criteria4->add(new Criteria('ads_tags', '%'.$words[$i].'%','LIKE'), 'OR');
//ajout fonction CPascalWeb - 4 novembre 2010 - résultat des recherches par type 		
		$criteria4->add(new Criteria('ads_type', '%'.$words[$i].'%', 'LIKE'), 'OR');	
//fin			
        }
            $search_criteria->add($criteria4);
    }

        if( isset($_SESSION['pk_topic_id']) && !empty($_SESSION['pk_topic_id']) ){
        $pk_topic_id = $_SESSION['pk_topic_id'] ;
        $search_criteria->add(new Criteria('cat_id', $pk_topic_id), 'AND'); }

		//villes
        if( isset($_SESSION['pk_town']) && !empty($_SESSION['pk_town']) ){
        $pk_town = $_SESSION['pk_town'] ;
        $search_criteria->add(new Criteria('town', '%'.$pk_town.'%','LIKE'), 'AND');
        }
		//code postal
        if( isset($_SESSION['pk_zipcod']) && !empty($_SESSION['pk_zipcod']) ){
        $pk_zipcod = $_SESSION['pk_zipcod'] ;
        $search_criteria->add(new Criteria('codpost', '%'.$pk_zipcod.'%','LIKE'), 'AND');
        }
		//prix
        if( isset($_SESSION['pk_price_start']) && !empty($_SESSION['pk_price_start']) ){
        $pk_price_start = $_SESSION['pk_price_start'] ;
        $search_criteria->add(new Criteria('price', $pk_price_start,'>='), 'AND');
        }
		//prix
        if( isset($_SESSION['pk_price_end']) && !empty($_SESSION['pk_price_end']) ){
        $pk_price_end = $_SESSION['pk_price_end'] ;
        $search_criteria->add(new Criteria('price', $pk_price_end,'<='), 'AND');
        }
		//régions
        if( isset($_SESSION['pk_region']) && !empty($_SESSION['pk_region']) ){
        $pk_region = $_SESSION['pk_region'] ;
        $search_criteria->add(new Criteria('region', $pk_region), 'AND');
        }
		//départements
        if( isset($_SESSION['pk_departement']) && !empty($_SESSION['pk_departement']) ){
        $pk_departement = $_SESSION['pk_departement'] ;
        $search_criteria->add(new Criteria('departement', $pk_departement), 'AND');
        }
//ajout fonction CPascalWeb - 4 novembre 2010 - résultat des recherches par type 
	//ads_type
    if( !empty( $ads_type ) && !empty( $ads_type ) &&  $ads_type != "other" )
    {
        $ads_type = intval($ads_type);
        $criteria->add(new Criteria('ads_type', $ads_type,'='), 'AND');
        $_SESSION["ads_type"] = $ads_type;
    }
//fin
        $search_criteria->add(new Criteria('waiting','0'));
        $search_criteria->add(new Criteria('suspend','0'));
//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce		
        $search_criteria->add(new Criteria('suspendadmin','0'));		
//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse
//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse
		if($xoopsModuleConfig['active_suspect'] < '1'){
		$search_criteria->add(new Criteria('signalementannonce','0'));
		} 		
//fin			
        $search_criteria->add(new Criteria('published', time(),'<'));
        $search_criteria->add(new Criteria('expired', time(),'>'));

        $nbads = $ads_handler->getCount($search_criteria);
        $search = '2';
        // $start = '0';
        $start = $debut ;
        $limit = $xoopsModuleConfig['nb_perpage'];
        $arr_ads = showListSearchAds($search, $affichage_titre, $ads_type, $affichage_prix, $affichage_option_prix, $affichage_localisation, $affichage_date, $search_criteria, $start, $limit);
        $xoopsTpl->assign('search', $search);
        $pagenav = new XoopsPageNav($nbads, $limit, $debut, "debut", "search=".$search);
//ajout fonction CPascalWeb - 7 octobre 2010 affichage define suivant nombre	        
	if($nbads < 1)
	{
		//si aucune annonce
		//sur page
		//$xoopsTpl->assign('lang_title', sprintf(_MD_CATADS_SEARCH_NB, $nbads));
		//en redirection header
		redirect_header($_SERVER['HTTP_REFERER'], 3, sprintf(_MD_CATADS_SEARCH_NB_NOA, $nbads));
	
	}
	elseif($nbads > 1)
	{
		//si plusieurs annonces
        $xoopsTpl->assign('lang_title', sprintf(_MD_CATADS_SEARCH_NB, $nbads));
	}
	else
	{
		//si une seule annonce
        $xoopsTpl->assign('lang_title', sprintf(_MD_CATADS_SEARCH_NB_1A, $nbads));
	}
//ajout CPascalWeb - 27 octobre 2010 - bouton déposer une annonce ou inscrivez-vous	
	    $xoopsTpl->assign('add_perm', true);
//fin de l'ajout
	}
	
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
		//$urlType = XOOPS_URL . '/modules/'.$xoopsModule->dirname().'/adslist.php?op=&amp;topic_id='.$topic_id.'&amp;option_type='.$sel_type;
		$urlType = XOOPS_URL . '/modules/'.$xoopsModule->dirname().'/adslist.php?search=1&words='.$ads_type;		
		$opt = new catadsOption();
        ob_start();
        $opt->makeMySelBox('option_order','', 1, 3, "location=\"".$urlType."\"+this.options[this.selectedIndex].value");//ajouter autres options de tris en modifiant ...,3,...
        $xoopsTpl->assign('afficher_par_type', ob_get_contents());
        ob_end_clean();
//fin de l'ajout			
//ajout CPascalWeb - 25 avril 2011 
$pagenav = new XoopsPageNav($nbads, $xoopsModuleConfig['nb_perpage'], $debut, "debut", "topic_id=".$topic_id);
//fin de l'ajout
			
//templates affectation global
$xoopsTpl->assign('nbads', $nbads);
$xoopsTpl->assign('items', $arr_ads);
$xoopsTpl->assign('nav_page', $pagenav->renderNav());
$xoopsTpl->assign('show_ad_type', $show_ad_type);
$xoopsTpl->assign("xoops_module_header",'<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/style.css" />  <link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/highslide.css" /> <link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/highslide-ie6.css" />');

include(XOOPS_ROOT_PATH."/footer.php");

?>