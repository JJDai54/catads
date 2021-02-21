<?php

include_once(XOOPS_ROOT_PATH."/modules/catads/include/functions.php");
include_once(XOOPS_ROOT_PATH."/modules/catads/class/ads.php");
include_once(XOOPS_ROOT_PATH."/modules/catads/class/cat.php");
include_once(XOOPS_ROOT_PATH."/modules/catads/class/permissions.php");

function b_catads_show($options) {
        global $xoopsModule, $xoopsModuleConfig, $xoopsDB, $xoopsUser;

        if (empty($xoopsModule) || $xoopsModule->getVar('dirname') != 'catads') {
                /*$module_handler =& xoops_gethandler('module');
                $module =& $module_handler->getByDirname('catads');
                $config_handler =& xoops_gethandler('config');
                $config =& $config_handler->getConfigsByCat(0,$module->getVar('mid'));*/
                $module_handler = xoops_gethandler('module');
                $module = $module_handler->getByDirname('catads');
                $config_handler = xoops_gethandler('config');
                $config = $config_handler->getConfigsByCat(0,$module->getVar('mid'));				
        } else {
                /*$module =& $xoopsModule;
                $config =& $xoopsModuleConfig;*/
                $module = $xoopsModule;
                $config = $xoopsModuleConfig;				
        }

        $block = array();
        $block['title'] = _MB_CATADS_TITLE;

        $show_ad_type = $config['show_ad_type'] ;
        $block['show_ad_type'] = $show_ad_type ;


		if ( $options[1] != 0 ) {
			$block['full_view'] = true;
		} else {
			$block['full_view'] = false;
		}

        if ( $options[2] != 0 ) {
			$block['defil'] = true;
			$block['vitesse_defil'] = $options[3];
		} else {
			$block['defil'] = false;
		}

        //$ads_hnd =& xoops_getmodulehandler('ads', 'catads');
        $ads_hnd = xoops_getmodulehandler('ads', 'catads');		
        $permHandler = catadsPermHandler::getHandler();
        $criteria = new CriteriaCompo();
        $topic_id = !isset($_REQUEST['topic_id'])? NULL : $_REQUEST['topic_id'];
        $topic = $permHandler->listAds($xoopsUser, 'catads_access', $topic_id);

		$mytree = new XoopsTree($xoopsDB->prefix("catads_cat"),"topic_id","topic_pid");
        $criteria2 = new CriteriaCompo();
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
            $criteria2->add(new Criteria('cat_id', $show_topic_id[$j]), 'OR');
        }

        $criteria->add($criteria2);
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
        $criteria->setSort('published');
        $criteria->setOrder('DESC');
        $criteria->setLimit($options[0]);
        $nbads = $ads_hnd->getCount($criteria);
        $a_item = array();

        if ($nbads > 0) {
            $ads = $ads_hnd->getObjects($criteria);
            //$myts =& MyTextSanitizer::getInstance();
            $myts = MyTextSanitizer::getInstance();			

        foreach( $ads as $oneads ){
            $ads_id = $oneads->getVar('ads_id');
            $a_item['id'] = $ads_id;
            $a_item['type'] = $oneads->getVar('ads_type');
            $a_item['title'] = $oneads->getVar('ads_title');
        
		if (!XOOPS_USE_MULTIBYTES ) {
            $length1 = strlen($oneads->getVar('ads_type'));
            $length2 = strlen($oneads->getVar('ads_title'));
       
		if ( $length1 + $length2 >= $options[4]) {
            $a_item['title'] = substr($a_item['title'],0, $options[4] - $length1)."...";
        }
        }

		if ($oneads->getVar('price') > 0)
            $a_item['price'] = $oneads->getVar('price').' '.$oneads->getVar('monnaie');
            $a_item['date'] = ($oneads->getVar('published') > 0) ? formatTimestamp($oneads->getVar('published'),"s") : '';
            $a_item['local'] = $oneads->getVar('codpost');
            $a_item['local'] .= ' '.$oneads->getVar('town');

        if ($oneads->getVar('thumb') != '')
        {
//ajout CPascalWeb 15 octobre 2010 - title + alt supposé pour un meilleur référencement naturel
            $a_item['thumb'] = '<a href="'.XOOPS_URL.'/uploads/catads/images/annonces/original/'.$oneads->getVar('photo0').'" title="'. $oneads->getVar('ads_type') .':'.$oneads->getVar('ads_title').'" alt="'.$oneads->getVar('ads_desc').''.$GLOBALS['xoopsConfig']['sitename'].'" class="highslide" style="width: 250px;" onclick="return hs.expand(this)">
            <img class="miniature" src="'.XOOPS_URL.'/uploads/catads/images/annonces/thumb/'.$oneads->getVar('thumb').'" title="'.$oneads->getVar('ads_desc').'" alt="'.$GLOBALS['xoopsConfig']['sitename'].'" style="width: 60px;"/></a>';
        } else {
//modif CPascalWeb image pasphotos.png + chemin							
        //$a_item['thumb'] = "<img src=\"".XOOPS_URL."/modules/".$module->getVar('dirname')."/images/no_dispo_mini.gif\" border=\"0\" alt=\"\" />";
        $a_item['thumb'] = "<img src=\"".XOOPS_URL."/modules/".$module->getVar('dirname')."/images/annonces/thumb/pasphotos.png\" border=\"0\" alt=\"\" />";								
//fin								
        }
            $a_item['views'] = $oneads->getVar('view');
            $block['items'][] = $a_item;
            unset($a_item);
        }
        } else {
            $block['noads'] = true;
        }

    return $block;
}


function b_catads_edit($options) {
        $form = _MB_CATADS_NBADS."&nbsp;<input type='text' name='options[]' value='".$options[0]."' />";

    $form .= '<br />'._MB_CATADS_FULL."&nbsp;<input type='radio' name='options[1]' value='1'";
    if ( $options[1] == 1 ) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;"._YES."<input type='radio' name='options[1]' value='0'";
    if ( $options[1] == 0 ) {
        $form .= " checked='checked'";
    }
        $form .= " />&nbsp;"._NO;
        $form .= '<br />'._MB_CATADS_DEFIL."&nbsp;<input type='radio' name='options[2]' value='1'";
    if ( $options[2] == 1 ) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;"._YES."<input type='radio' name='options[2]' value='0'";
    if ( $options[2] == 0 ) {
        $form .= " checked='checked'";
    }
        $form .= " />&nbsp;"._NO;
        $form .= '<br />'._MB_CATADS_VITESSE_DEFIL."&nbsp;<input type='text' name='options[]' value='".$options[3]."' />";
        $form .= '<br />'._MB_CATADS_NBCHAR."&nbsp;<input type='text' name='options[]' value='".$options[4]."' />";

        return $form;
}

?>