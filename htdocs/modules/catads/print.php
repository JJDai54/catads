<?php
//imprimer l'annonce - page refaite le 12 novembre 2010 - CPascalWeb
include("../../mainfile.php");
include(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/include/functions.php");

//$myts =& MyTextSanitizer::getInstance();
$myts = MyTextSanitizer::getInstance();

	foreach ($_POST as $k => $v) {${$k} = $v;}
	foreach ($_GET as $k => $v) {${$k} = $v;}
        /*$ads_handler = & xoops_getmodulehandler('ads');
        $ads = & $ads_handler->get($ads_id);*/
        $ads_handler = xoops_getmodulehandler('ads');
        $ads = $ads_handler->get($ads_id);		

    if (!is_object($ads)) {
        redirect_header(XOOPS_URL."/modules/catads/index.php",3,_MD_CATADS_NO_EXIST);
        exit();
    }

        $ads_exist = false;
    if ($ads->getVar('waiting') == 0 && $ads->getVar('expired') > time())
        $ads_exist = true;

    if (!$ads_exist) {
        redirect_header(XOOPS_URL."/modules/catads/index.php",3,_MD_CATADS_NO_ADS);
        exit();
    }

	function catads_get_ad($ads) {
        //$myts =& MyTextSanitizer::getInstance();
        $myts = MyTextSanitizer::getInstance();		
        $annonce['id'] = $ads_id = $ads->getVar('ads_id');
        $annonce['date_pub'] = ($ads->getVar('published') > 0) ? formatTimestamp($ads->getVar('published'),"s") : 0;
        $annonce['date_exp'] = ($ads->getVar('expired') > time()) ? formatTimestamp($ads->getVar('expired'),"s") : 0;
        $annonce['suspend'] = $ads->getVar('suspend');
//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce				
        $annonce['suspendadmin'] = $ads->getVar('suspendadmin');				
        $annonce['type'] = $ads->getVar('ads_type');
        $annonce['title'] = $ads->getVar('ads_title');
//modif CPascalWeb 16 avril 2011		
        /*$pk_desc = $myts->htmlSpecialChars($ads->getVar('ads_desc'));
        $annonce['description'] = $myts->displayTarea($pk_desc, 0, 1, 1);*/
        $annonce['description'] = $myts->undoHtmlSpecialChars($ads->getVar('ads_desc'), 0, 1, 1);	 		
//fin		
        $annonce['price'] = $ads->getVar('price');
    if ($ads->getVar('price') > 0){
        $annonce['price'] = $ads->getVar('price');
        $annonce['price'] .= ' '.$ads->getVar('monnaie');
        $annonce['price'] .= ' '.$ads->getVar('price_option');
    }
        $annonce['town'] = $ads->getVar('town');
        $annonce['codpost'] = $ads->getVar('codpost');
		$annonce['photo'] = $ads->getVar('photo0');
        return ($annonce);
	}

	function catads_print_head() {
        global $xoopsConfig;
        echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
        echo '<html><head>';
        echo '<meta http-equiv="Content-Type" content="text/html; charset='._CHARSET.'" />';
        echo '<title>'.$xoopsConfig['sitename'].'</title>';
        echo '<meta name="AUTHOR" content="'.$xoopsConfig['sitename'].'" />';
        echo '<meta name="COPYRIGHT" content="Copyright (c) 2010 by '.$xoopsConfig['sitename'].'" />';
        echo '<meta name="DESCRIPTION" content="'.$xoopsConfig['slogan'].'" />';
        echo '<body style="background-color: #FFF; color: #000000;" onload="window.print()">
			<table cellpadding="0" cellspacing="1"><tr><td>
            <table style="background-color: #FFF; color: #000000; border: 1px solid #000; width: 640;" cellpadding="20" cellspacing="1"><tr>';
        echo '<td align="center"><b>'._MD_CATADS_FROMSITE.' '.$xoopsConfig['sitename'].'</b></td>';
	}

	function catads_print_foot() {
        echo '<tr><td>
            <div align="center">'._MD_CATADS_VISIBLEIMPRIME.'&nbsp;<a href="'.XOOPS_URL.'/" target="blank">'.XOOPS_URL.'</a></div><br /></td></tr></table>
            </td></tr></table>';
        echo '</body></html>';
	}

	function catads_print_ad($annonce) {
        global $xoopsConfig, $xoopsModule, $xoopsModuleConfig;
			echo '<tr><td align="left">';
			$show_ad_type = $xoopsModuleConfig['show_ad_type'];
        if($show_ad_type =='1'){
			echo _MD_CATADS_TAGS_REFERENCE. ':&nbsp;'.$annonce['type'] . ' - ' . $annonce['title'].'<hr>';
        } else {
			echo _MD_CATADS_TAGS_REFERENCE. ':&nbsp;'. $annonce['title'].'<hr>';
        }
        if ($annonce['photo'] != '') {
            echo '<img src="'.XOOPS_URL.'/uploads/'.$xoopsModule->dirname().'/images/annonces/original/'.$annonce['photo'].'" class="imgContour" style="width: 100px; height: 100px;" align="right" alt="" />';
        } else {
//modif CPascalWeb - ajout  "images/annonces/original/pasphotos.png"
            echo '<img src="'.XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/images/annonces/original/pasphotos.png" class="imgContour" style=\"width: 100px; height: 100px;\" align="right" alt="" />';
        }
			echo $annonce['description'].'<br /><br />';
		if ($annonce['price'] != 0)
            echo '<div align="left">'._MD_CATADS_PRICE2.'&nbsp; '.$annonce['price'].'</div>';	
			echo _MD_CATADS_BLOC_VILLE.'&nbsp;'.$annonce['town'] . ' - ' . $annonce['codpost'].'<br/><br />';
//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce				
        if ($annonce['suspend'] != 1 & $annonce['suspendadmin'] != 1)	{	
		echo '<div align="center"><small>'._MD_CATADS_DATE_PUB1.'&nbsp;'.$annonce['date_pub'].'&nbsp;&nbsp;'._MD_CATADS_DATE_EXP.'&nbsp;'.$annonce['date_exp'].'</small>';			
		echo '</td></tr>';		
        }else{
		echo '<div align="center"><small>'._MD_CATADS_DATE_PUB1.'&nbsp;'.$annonce['date_pub'].'&nbsp;&nbsp;'._MD_CATADS_DATE_EXP.'&nbsp;'.$annonce['date_exp'].'</small>';			
        echo '<br /><br /><div align="center" style="background-color: #F04632;">'._MD_CATADS_PUB_SUSPIMPR.'<div>';			
		echo '</td></tr>';
		}
	}

		if (!isset($op)) $op = 'showone';
			switch ($op) {
			case "showone":
			default:
                catads_print_head();
                catads_print_ad(catads_get_ad($ads));
                catads_print_foot();
            break;
	}

?>