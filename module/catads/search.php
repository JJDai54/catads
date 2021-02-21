<?php

include("../../mainfile.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/header.php");
include_once(XOOPS_ROOT_PATH."/class/pagenav.php");
//$xoopsOption['template_main'] = 'catads_adslist.tpl';
include(XOOPS_ROOT_PATH."/header.php");

global $xoopsDB, $xoopsModule, $xoopsModuleConfig;
//$myts =& MyTextSanitizer::getInstance();
        //Formulaire de la recherche avancée
        if ($adsCatHandler->countCat() > 0)
        {
            $xt = new XoopsTree($xoopsDB->prefix("catads_cat"),'topic_id','topic_pid');
            $search_form = new XoopsThemeForm(_MD_CATADS_SEARCH, "advanced_search", "adslist.php?search=1");
            // mots-clés réduire la longueur - mots-clés requis = true
            $search_form->addElement(new XoopsFormText(_MD_CATADS_SEARCH_WORDS, "words", 30, 100),true);
            //catégories
            ob_start();
            $xt->makeMySelBox('topic_title','topic_title ASC', 0, '-', 'topic_title');
            $search_form->addElement(new XoopsFormLabel(_MD_CATADS_SEARCH_CATEGORY, ob_get_contents()));
            ob_end_clean();
            //Prix
            $price_tray = new XoopsFormElementTray(_MD_CATADS_SEARCH_PRICE ,'');
            $price_tray->addElement(new XoopsFormText('', "price_start", 10, 10), false);
            $price_tray->addElement(new XoopsFormText(_MD_CATADS_SEARCH_PRICE_A, "price_end", 10, 10), false);
            $search_form->addElement($price_tray);
        //Région
        if ($xoopsModuleConfig['region_req'] > 0)
        {
            $search_form->addElement(new formSelectRegions(_MD_CATADS_SEARCH_REGIONS, "region"), false);
        }
        //Départements
        if ($xoopsModuleConfig['departement_req'] > 0)
        {
            $search_form->addElement(new formSelectDepartements(_MD_CATADS_SEARCH_DEPARTEMENTS, "departement"), false);
        }
            //ville
            $search_form->addElement(new XoopsFormText(_MD_CATADS_SEARCH_CITY, "town", 30, 100), false);
        //code Postal
        if ($xoopsModuleConfig['zipcode_req'] > 0)
        {
            $search_form->addElement(new XoopsFormText(_MD_CATADS_SEARCH_ZIPCOD, "zipcod", 10, 10), false);
        }
            $search_form->addElement(new XoopsFormHidden("op", "traitement_search"), true);
            $search_form->addElement(new XoopsFormButton("", "submit", _SEARCH, "submit"), true);
            //$search_form->setExtra('onsubmit="javascript:return xoopsFormValidate_search_block();"');
            $search_form->display();
        }

include(XOOPS_ROOT_PATH."/footer.php");

?>