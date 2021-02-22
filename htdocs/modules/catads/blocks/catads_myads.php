<?php

function b_catads_myads($options) {
global $xoopsModule, $xoopsModuleConfig, $xoopsUser;

         $show_ad_type = $xoopsModuleConfig['show_ad_type'];

        if (empty($xoopsModule) || $xoopsModule->getVar('dirname') != 'catads') {
               /* $module_handler =& xoops_gethandler('module');
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


        // pk get module pref and add to block array. NB use config VAR
        $show_ad_type = $config['show_ad_type'] ;
        $block['show_ad_type'] = $show_ad_type ;


    if ( $options[1] != 0 ) {
        $block['full_view'] = true;
    } else {
        $block['full_view'] = false;
    }

        if ($xoopsUser) {
                //$ads_hnd =& xoops_getmodulehandler('ads', 'catads');
                $ads_hnd = xoops_getmodulehandler('ads', 'catads');				
                $criteria = new Criteria('uid', $xoopsUser->getVar('uid'));
                $criteria->setSort('published');
                $criteria->setOrder('DESC');
                $nbads = $ads_hnd->getCount($criteria);
                $item = array();
        } else {
                $nbads = 0;
        }

        if ($nbads > 0) {
                $ads = $ads_hnd->getObjects($criteria);
                //$myts =& MyTextSanitizer::getInstance();
                $myts = MyTextSanitizer::getInstance();				
                foreach( $ads as $oneads ){
                        $ads_id = $oneads->getVar('ads_id');
                        $item['id'] = $ads_id;
                        $item['type'] = $oneads->getVar('ads_type');
                        $item['title'] = $oneads->getVar('ads_title');
                        if ($oneads->getVar('price') > 0)
                            $item['price'] = $oneads->getVar('price').' '.$oneads->getVar('monnaie');
							$item['date'] = ($oneads->getVar('published') > 0) ? formatTimestamp($oneads->getVar('published'),"s") : '';
                            $item['local'] = $oneads->getVar('codpost');
                            $item['local'] .= ' '.$oneads->getVar('town');
                        $i = 0;
                        $strid ='';
                        while ($i < 6){
                                if ($oneads->getVar('photo'.$i)) {
                                        $strid .= '_'.$i;
                                }
                                $i++;
                        }
                        if ($strid != ''){
                                $width         = $config['photo_maxwidth'] + 40;
                                $height        = $config['photo_maxheight'] + 80;
                                $item['photo'] = "<a href=\"javascript:openWithSelfMain('".XOOPS_URL."/modules/".$module->getVar('dirname')."/display_image.php?array_id=".$strid."&ads_id=".$ads_id."','Photo',".$width.",".$height.");\"><img src=\"".XOOPS_URL."/modules/".$module->getVar('dirname')."/images/icon/photo.gif\" border=0 width=15 height=11 ></a>";
                        }

                        $item['views'] = $oneads->getVar('view');
//modif CPascalWeb - 23 octobre 2010 - nom images + url + titre et alt
                        //if ($oneads->getVar('published') == 0){
                        if ($oneads->getVar('published')){						
                                $item['status'] = "<img src='".XOOPS_URL."/modules/".$module->getVar('dirname')."/images/icon/avertissement.gif' width='12px' style='position: relative; top: .3em;' title='"._MB_CATADS_VAEXPIREE."'>";
					    }else {
                                $item['status'] = "<img src='".XOOPS_URL."/modules/".$module->getVar('dirname')."/images/icon/enligne.png' width='11px' style='position: relative; top: .1em;' title='"._MB_CATADS_ANNONCE.' '.$oneads->getVar('ads_type').' '.$oneads->getVar('ads_title').' - '._MB_CATADS_ENLIGNE."'>";
						}

						if ($oneads->getVar('expired') < time()){
                                $item['status'] = "<img src='".XOOPS_URL."/modules/".$module->getVar('dirname')."/images/icon/attention_pf.gif' width='12px' style='position: relative; top: .3em;' title='"._MB_CATADS_EXPIREE."'>";
					    }else {
                                $item['status'] = "<img src='".XOOPS_URL."/modules/".$module->getVar('dirname')."/images/icon/enligne.png' width='11px' style='position: relative; top: .1em;' title='"._MB_CATADS_ANNONCE.' '.$oneads->getVar('ads_type').' '.$oneads->getVar('ads_title').' - '._MB_CATADS_ENLIGNE."'>";
						}

						if ($oneads->getVar('suspend')){
                                $item['status'] = "<img src='".XOOPS_URL."/modules/".$module->getVar('dirname')."/images/icon/suspenduannonceur.png' width='12px' style='position: relative; top: .3em;' title='"._MB_CATADS_SUSPARANNOCEUR."'>";
                        }else {
								$item['status'] = "<img src='".XOOPS_URL."/modules/".$module->getVar('dirname')."/images/icon/enligne.png' width='11px' style='position: relative; top: .1em;' title='"._MB_CATADS_ANNONCE.' '.$oneads->getVar('ads_type').' '.$oneads->getVar('ads_title').' - '._MB_CATADS_ENLIGNE."'>";
						}
//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce
					    if ($oneads->getVar('suspendadmin')){
                               $item['status'] = "<img src='".XOOPS_URL."/modules/".$module->getVar('dirname')."/images/icon/suspendu.png' width='12px' style='position: relative; top: .3em;' title='"._MB_CATADS_SUSPARADMIN."'>";
					    }else {
                                $item['status'] = "<img src='".XOOPS_URL."/modules/".$module->getVar('dirname')."/images/icon/enligne.png' width='11px' style='position: relative; top: .1em;' title='"._MB_CATADS_ANNONCE.' '.$oneads->getVar('ads_type').' '.$oneads->getVar('ads_title').' - '._MB_CATADS_ENLIGNE."'>";
						}
//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse
					    if ($oneads->getVar('signalementannonce')){
                               $item['status'] = "<img src='".XOOPS_URL."/modules/".$module->getVar('dirname')."/images/icon/suspect.png' width='12px' style='position: relative; top: .1em;' title='"._MB_CATADS_ANNONCESUSPECT."'>";
					    }else {
                                $item['status'] = "<img src='".XOOPS_URL."/modules/".$module->getVar('dirname')."/images/icon/enligne.png' width='11px' style='position: relative; top: .1em;' title='"._MB_CATADS_ANNONCE.' '.$oneads->getVar('ads_type').' '.$oneads->getVar('ads_title').' - '._MB_CATADS_ENLIGNE."'>";
						}
//fin

 // pk pass show ad type pref to template
                        $item['show_ad_type'] = $show_ad_type ;
                        $block['items'][] = $item;
                        unset($item);
                }

        } else {
            $block['noads'] = true;
        }
    return $block;
}

function b_catads_myads_edit($options) {
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
        $form .= '<br />'._MB_CATADS_NBCHAR."&nbsp;<input type='text' name='options[]' value='".$options[2]."' />";

        return $form;
}

?>