<?php
//formulaire de modification de l'annonce en ligne par l'annonceur
include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
include_once(XOOPS_ROOT_PATH."/class/xoopstree.php");
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/formSelectRegions.php";
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/formSelectDepartements.php";
//ajout CPascalWeb
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/catadsformbreak.php");
//fin
// Récupération options de liste type
        //$option_handler =& xoops_getmodulehandler('option');
        $option_handler = xoops_getmodulehandler('option');		
        $criteria = new Criteria('option_id', '0', '>');
        $criteria->setSort('option_type, option_order');
        $option = $option_handler->getObjects($criteria);
        $count = 0;
        foreach($option as $oneoption){
            $arr_option[$count]['id'] = $oneoption->getVar('option_id');
            $arr_option[$count]['type'] = $oneoption->getVar('option_type');
            $arr_option[$count]['desc'] = $oneoption->getVar('option_desc');
            $arr_option[$count]['order'] = $oneoption->getVar('option_order');
            $count++;
        }
		
//modif CPascalWeb - 24 avril 2011 finalement pas util ici !
        //$mytree = new XoopsTree($xoopsDB->prefix("catads_cat"),"topic_id","topic_pid");
       // $cat_path = $mytree->getpathFromId( $cat_id, 'topic_title');
       // $cat_path = substr($cat_path, 1);
//modif CPascalWeb - 9 octobre 2010 - chemin image + alt & titre + nom sous catégorie et site supposé aider au référencement naturel		
        //$cat_path = str_replace("/"," <img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/arrow.gif' border='0' title='". _MD_CATADS_NOM_REFERENCE .' '. $cat_path ."' alt='". _MD_CATADS_NOM_REFERENCE .' '. $cat_path .' '. $GLOBALS['xoopsConfig']['sitename'] ."' /> ",$cat_path);
//fin
        $cat = new catadsCategory($cat_id);
		
//modif CPascalWeb - 24 avril 2011 inutile mettre a la place option micropaiement2 (faire payer la modification de l'annonce ou pas)
		//contrôle des annonces avant leur parrution ?
        //if ($xoopsModuleConfig['moderated'] != 1) {

		
//correction CPascalWeb - 24 avril 2011
        //$adsform = new XoopsThemeForm(_MD_CATADS_MENUADD .'<b>'.$cat_path.'</b>', "adsform", $_SERVER['PHP_SELF'] ."?cat_id=$cat_id");
		$adsform = new XoopsThemeForm(_MD_CATADS_MODIFADS .' <b>'.$ads_title.'</b>', "adsform", xoops_getenv('PHP_SELF') ."?ads_id=$ads_id");        
		$adsform->setExtra( "enctype='multipart/form-data'" ) ;	


		//entête du formulaire condition de publication contrôle des annonces avant leur parrution ?
        if ($xoopsModuleConfig['moderated'] > 0) {
			$label_info = new XoopsFormLabel(_MD_CATADS_MSG_CONDMODTITLE, _MD_CATADS_MSG_CONDMOD);
			$adsform->addElement($label_info);
        }
			//titre de l'annonce
            //$title_tray = new XoopsFormElementTray(_MD_CATADS_TITLE.'*','');
			$title_tray = new XoopsFormElementTray(_MD_CATADS_TITLE.'<span style="color:#FF0000; padding-left: 2px; background-color: inherit; font-size: 12px; font-weight: bold;">*</span>','&nbsp;','title');				
//fin				
				//Affichage type d'annonce
                if ($xoopsModuleConfig['show_ad_type'] == 1) {
                $text_type = new XoopsFormSelect('', "ads_type", $ads_type);
                    for ( $i = 0; $i < $count; $i++ ) {
                    if ($arr_option[$i]['type'] == 3) $text_type->addOption($arr_option[$i]['desc'],$arr_option[$i]['desc']);
                }
                $title_tray->addElement($text_type, true);
                }

                $text_title = new XoopsFormText('', "ads_title", 52, 100, $ads_title);
                $title_tray->addElement($text_title, true);
                $adsform->addElement($title_tray, true);
				
//modif CPascalWeb - 3 mai 2011 //a voir si vraiment utile
				// Formulaire avec ou sans bbcodes
               /* if ($xoopsModuleConfig['bbcode'] == 1) {
                        $text_annonce = new XoopsFormDhtmlTextArea(_MD_CATADS_TEXTE_S.'<span style="color:#FF0000; padding-left: 2px; background-color: inherit; font-size: 12px; font-weight: bold;">*</span>', "ads_desc", $ads_desc);
                } else {
                        $text_annonce = new XoopsFormTextArea(_MD_CATADS_TEXTE_S.'<span style="color:#FF0000; padding-left: 2px; background-color: inherit; font-size: 12px; font-weight: bold;">*</span>', "ads_desc", $ads_desc);
                }
                $adsform->addElement($text_annonce, true);*/
//ajout option CPascalWeb - 3 mai 2011 - choix de l'éditeur et suppression bbcodes pas vraiment utile !	
//fonctionne pas prend pas en compte les changements !!!!
        $editor_configs=array();
        $editor_configs["name"] ="ads_desc";
		$editor_configs["value"] = $ads_desc;
        $editor_configs["rows"] = 20;
        $editor_configs["cols"] = 60;
        $editor_configs["width"] = "100%";
        $editor_configs["height"] = "400px";
        $editor_configs["editor"] = $xoopsModuleConfig['form_options'];
       
	    $adsform->addElement( new XoopsFormEditor(_MD_CATADS_TEXTE_S.'<span style="color:#FF0000; padding-left: 2px; background-color: inherit; font-size: 12px; font-weight: bold;">*</span>', "ads_desc", $editor_configs), true);	
//fin	

//modif CPascalWeb - 23 avril 2011
               /* if ( $xoopsModuleConfig['allow_custom_tags'] == 1) {
                $title_tags = new XoopsFormText(_MD_CATADS_TAGS, "ads_tags", 52, 100, $ads_tags);
                $adsform->addElement($title_tags);

                $lien_tags_help = new XoopsFormLabel('', "<small><strong>"._MD_CATADS_TAGS_HELP."</strong></small>");
                $adsform->addElement($lien_tags_help);
                }*/

               /* if ( $xoopsModuleConfig['show_video_field'] == 1) {
                $lien_video = new XoopsFormText(_MD_CATADS_VIDEO, "ads_video", 60, 100, $ads_video);
                $adsform->addElement($lien_video);

                $lien_video_help = new XoopsFormLabel('', "<small><strong>"._MD_CATADS_VIDEO_HELP."</strong></small>");
                $adsform->addElement($lien_video_help);
                }*/

                //$title_tags = new XoopsFormText(_MD_CATADS_TAGS, "ads_tags", 52, 100, $ads_tags);
                //$adsform->addElement($title_tags);
//fin
                //affichage du prix
                if ($cat->display_price)
                {
                    $select_monnaie = new XoopsFormSelect('', "monnaie", $monnaie);
                        for ( $i = 0; $i < $count; $i++ ) {
                            if ($arr_option[$i]['type'] == 1) $select_monnaie->addOption($arr_option[$i]['desc'],$arr_option[$i]['desc']);
                        }
                        $select_price_option = new XoopsFormSelect('', "price_option", $price_option);
                        $select_price_option->addOption('','');
                        for ( $i = 0; $i < $count; $i++ ) {
                            if ($arr_option[$i]['type'] == 2) $select_price_option->addOption($arr_option[$i]['desc'],$arr_option[$i]['desc']);
                        }
						//modif CPascalWeb - 4 mai 2011
                        //$price_tray = new XoopsFormElementTray(_MD_CATADS_PRICE_MOD,'');
						$price_tray = new XoopsFormElementTray(_MD_CATADS_PRICE_MOD,'&nbsp;','price');
                        $price_tray->addElement(new XoopsFormText('', "price", 15, 15, $price));
                        $price_tray->addElement($select_monnaie);
                        $price_tray->addElement($select_price_option);
                        $adsform->addElement($price_tray);
                }
//ajout CPascalWeb - 23 avril 2011				
				//option tags (mots clés)
				if ( $xoopsModuleConfig['allow_custom_tags'] == 1) {
						$lien_tags = new XoopsFormElementTray(_MD_CATADS_TAGS_MOD,'<br />','ads_tags');
						$lien_tags->addElement (new XoopsFormText('', "ads_tags", 60, 100, $ads_tags));
						$lien_tags->addElement(new XoopsFormLabel('',"<small><strong>"._MD_CATADS_TAGS_HELP."</strong></small>"));
						$adsform->addElement($lien_tags);
				}				
				//option vidéo
				if ( $xoopsModuleConfig['show_video_field'] == 1) {
						$lien_video = new XoopsFormElementTray(_MD_CATADS_VIDEO_MOD,'<br />','ads_video');
						$lien_video->addElement (new XoopsFormText('', "ads_video", 60, 100, $ads_video));
						$lien_video->addElement(new XoopsFormLabel('',"<small><strong>"._MD_CATADS_VIDEO_HELP."</strong></small>"));
						$adsform->addElement($lien_video);
				}				
//fin				
		//modif CPascalWeb - 24 avril 2011 inutile mettre a la place option micropaiement2 (faire payer la modification de l'annonce ou pas)		
        /*} else {
		//if ($xoopsModuleConfig['moderated'] != 1) {
        $adsform = new XoopsThemeForm(_MD_CATADS_MENUADD1.'&nbsp;'._MD_CATADS_PHOTO_CAUTION, "adsform", $_SERVER['PHP_SELF'] ."?cat_id=$cat_id");
        $adsform->setExtra( "enctype='multipart/form-data'" ) ;
		// }
        }*/
		//ajout séparation
		$adsform->addElement(new XoopsFormBreak(1, _MD_CATADS_PHOTO_MOD.'&nbsp;&nbsp;'._MD_CATADS_PHOTO_CAUTION ));	
		//modifier les photos de l'annonce
        if ($cat->nb_photo > 0) {
            $i = 0;
            while  ($i < $cat->nb_photo) {
                $file_tray = new XoopsFormElementTray(_MD_CATADS_IMG.' '.($i+1), '');
                    if (isset($photo[$i])){
                            $file_tray->addElement(new XoopsFormLabel('', "<img src='".XOOPS_URL."/uploads/".$xoopsModule->dirname()."/images/annonces/original/".$photo[$i]."' name='image' id='image' alt=''/><br />" ));
                            $check_del_img = new XoopsFormCheckBox('', 'delimg_'.$i);
                            $check_del_img->addOption(1,_MD_CATADS_DELIMG);//Effacer cette photo
                            $file_tray->addElement($check_del_img);
                            $file_img = new XoopsFormFile(_MD_CATADS_REPLACEIMG, 'photo'.$i, $xoopsModuleConfig['photo_maxsize']);//ou la remplacer par
                            $file_img->setExtra("size ='40'") ;
                            unset($check_del_img);
                    } else {
                            $file_img = new XoopsFormFile('', 'photo'.$i, $xoopsModuleConfig['photo_maxsize']);
                            $file_img->setExtra("size ='40'") ;
                    }
                        $file_tray->addElement($file_img);
                        $adsform->addElement($file_tray);
                        $adsform->addElement(new XoopsFormHidden('previewname_'.$i, $preview_name[$i]));
                        unset($file_img);
                        unset($file_tray);
                $i++;
            }
        }

            $adsform->addElement(new XoopsFormBreak(2,_MD_CATADS_CONTACTME_MOD));
//correction CPascalWeb - 24 avril 2011
               /* $text_email = new XoopsFormText(_MD_CATADS_MAIL_S.'*', "email", 50, 100, $email);
                $adsform->addElement($text_email, true);
                $text_phone = new XoopsFormText(_MD_CATADS_PHONE_S, "phone", 20, 20,$phone);
                $adsform->addElement($text_phone, false);

                //Regions
                if ($xoopsModuleConfig['region_req'] > 0)
                {
                        $adsform->addElement(new formSelectRegions(_MD_CATADS_REGION.'*', "region", $region), true);
                }
                //Departements
                if ($xoopsModuleConfig['departement_req'] > 0)
                {
                        $adsform->addElement(new formSelectDepartements(_MD_CATADS_DEPARTEMENT.'*', "departement", $departement), true);
                }

                $text_adress = new XoopsFormText(_MD_CATADS_CITY_S.'*', "town", 35, 50,$town);
                $adsform->addElement($text_adress,true);

                //Code postal
                if ($xoopsModuleConfig['zipcode_req'] > 0) {
                        $text_codpost = new XoopsFormText(_MD_CATADS_CODPOST_S.'*', "codpost", 20, 20, $codpost);
                        $adsform->addElement($text_codpost, ($xoopsModuleConfig['zipcode_req'] > 1));
                }
			*/

//ajout option CPascalWeb - 24 avril 2011 - facultatif, obligatoire ou non demandé 	+ ajout option CPascalWeb - 4 mai 2011 - autoriser l'annonceur de modifier son adresse Email
		//email facultatif mais non autorisé de modifier
        if (($xoopsModuleConfig['email_req'] == 1 && $xoopsModuleConfig['modifmail'] == 0) ){
	    	$text_email = new XoopsFormLabel(_MD_CATADS_MAIL_S, $email);
			$adsform->addElement($text_email, false);
		}
		//email facultatif est autorisé de modifier
        if (($xoopsModuleConfig['email_req'] == 1 && $xoopsModuleConfig['modifmail'] == 1) ){
            $text_email = new XoopsFormText(_MD_CATADS_MAIL_S, "email", 50, 100, $email);
            $adsform->addElement($text_email, false);
	    }		
		//email obligatoire mais non autorisé de modifier
		if ($xoopsModuleConfig['email_req'] == 0 && $xoopsModuleConfig['modifmail'] == 0){
			$text_email = new XoopsFormLabel(_MD_CATADS_MAIL_S, $email);
			$adsform->addElement($text_email, true);
		}	
		//email obligatoire est autorisé de modifier
	    if ($xoopsModuleConfig['email_req'] == 0 && $xoopsModuleConfig['modifmail'] == 1){
			$text_email = new XoopsFormText(_MD_CATADS_MAIL_S.'<span style="color:#FF0000; padding-left: 2px; background-color: inherit; font-size: 12px; font-weight: bold;">*</span>', "email", 50, 100, $email);
			$adsform->addElement($text_email, true);
		}
//fin		
		//téléphone facultatif
        if ($xoopsModuleConfig['phonefixe_req'] == 1) {
            $text_phone = new XoopsFormText(_MD_CATADS_PHONE_S, "phone", 20, 20, $phone);
            $adsform->addElement($text_phone, false);
		//téléphone obligatoire
	    }elseif ($xoopsModuleConfig['phonefixe_req'] == 2){
			$text_phone = new XoopsFormText(_MD_CATADS_PHONE_S.'<span style="color:#FF0000; padding-left: 2px; background-color: inherit; font-size: 12px; font-weight: bold;">*</span>', "phone", 20, 20, $phone);
			$adsform->addElement($text_phone, true);
		}				

//ajout CPascalWeb - 12 novembre 2010 - option tel portable + ajout 24 avril 2011 - téléphone fixe facultatif, obligatoire ou non demandé 
        if ($xoopsModuleConfig['phoneportable_req'] == 1) {
            $text_phoneportable = new XoopsFormText(_MD_CATADS_PHONE_SPORTABLE, "phoneportable", 20, 20, $phoneportable);
            $adsform->addElement($text_phoneportable, false);
		//téléphone obligatoire
	    }elseif ($xoopsModuleConfig['phoneportable_req'] == 2){
			$text_phoneportable = new XoopsFormText(_MD_CATADS_PHONE_SPORTABLE.'<span style="color:#FF0000; padding-left: 2px; background-color: inherit; font-size: 12px; font-weight: bold;">*</span>', "phoneportable", 20, 20, $phoneportable);
			$adsform->addElement($text_phoneportable, true);
		}		
				
		//departement facultatif		
        if ($xoopsModuleConfig['departement_req'] == 1) {
            $departement = new formSelectDepartements(_MD_CATADS_DEPARTEMENT, "departement", $departement);
            $adsform->addElement($departement, false);
		//departement obligatoire
	    }elseif ($xoopsModuleConfig['departement_req'] == 2){
			$departement = new formSelectDepartements(_MD_CATADS_DEPARTEMENT.'<span style="color:#FF0000; padding-left: 2px; background-color: inherit; font-size: 12px; font-weight: bold;">*</span>', "departement", $departement);
			$adsform->addElement($departement, true);
		}
        //régions facultatif
        if ($xoopsModuleConfig['region_req'] == 1) {
            $region = new formSelectRegions(_MD_CATADS_REGION, "region", $region);
            $adsform->addElement($region, false);
		//régions obligatoire
	    }elseif ($xoopsModuleConfig['region_req'] == 2){
			$region = new formSelectRegions(_MD_CATADS_REGION.'<span style="color:#FF0000; padding-left: 2px; background-color: inherit; font-size: 12px; font-weight: bold;">*</span>', "region", $region);
			$adsform->addElement($region, true);
		}
		//ville facultatif
        if ($xoopsModuleConfig['town_req'] == 1) {
            $text_town = new XoopsFormText(_MD_CATADS_TWON, "town", 20, 20, $town);
            $adsform->addElement($text_town, false);
		//ville obligatoire
	    }elseif ($xoopsModuleConfig['town_req'] == 2){
			$text_town = new XoopsFormText(_MD_CATADS_TWON.'<span style="color:#FF0000; padding-left: 2px; background-color: inherit; font-size: 12px; font-weight: bold;">*</span>', "town", 20, 20, $town);
			$adsform->addElement($text_town, true);
		}
		
		//code postal facultatif
        if ($xoopsModuleConfig['zipcode_req'] == 1) {
            $text_codpost = new XoopsFormText(_MD_CATADS_ZIPCOD, "codpost", 20, 20, $codpost);
            $adsform->addElement($text_codpost, false);
		//code postal obligatoire
	    }elseif ($xoopsModuleConfig['zipcode_req'] == 2){
			$text_codpost = new XoopsFormText(_MD_CATADS_ZIPCOD.'<span style="color:#FF0000; padding-left: 2px; background-color: inherit; font-size: 12px; font-weight: bold;">*</span>', "codpost", 20, 20, $codpost);
			$adsform->addElement($text_codpost, true);
		}	
//fin				
				
		//être contacter de préférence par:				
            $contact_tray = new XoopsFormElementTray(_MD_CATADS_CONTACT_MODE,'&nbsp;','contact_mode');
            $select_prefcontact = new XoopsFormSelect('', "pref_contact", $pref_contact);
            $select_prefcontact->addOptionArray(array('0'=>_MD_CATADS_CONTACT_PREF1,'10'=>_MD_CATADS_CONTACT_PREF2));
            $contact_tray->addElement($select_prefcontact, true);
            $contact_tray->addElement(new XoopsFormLabel('',_MD_CATADS_BY));
            $select_modecontact = new XoopsFormSelect('', "mode_contact", $mode_contact);

            $select_modecontact->addOption(2,_MD_CATADS_CONTACT_MODE2);//email
		    if ($uid > 0)// activer uniquement si membre
            $select_modecontact->addOption(1,_MD_CATADS_CONTACT_MODE1);//message privé
            $select_modecontact->addOption(3,_MD_CATADS_CONTACT_MODE3);//téléphone
            $contact_tray->addElement($select_modecontact, true);
            $adsform->addElement($contact_tray);

//modif CPascalWeb - 18 mai 2011 plus besoin envoi mail automatique	
               // $expired_tray = new XoopsFormElementTray(_MD_CATADS_CHOICE_MAIL_EXP ,'&nbsp;','expired');//Être informer de l'expiration de l'annonce ?
               // $expired_tray->addElement(new XoopsFormRadioYN('', 'expired_mail_send', $expired_mail_send), true);
                //$expired_tray->addElement(new XoopsFormLabel('',_MD_CATADS_BY));

               // $select_prefcontact1 = new XoopsFormSelect('', "expired_by_mode", $expired_by_mode);
               // $select_prefcontact1->addOptionArray(array('0'=>_MD_CATADS_CONTACT_MODE1,'1'=>_MD_CATADS_CONTACT_MODE2));

                //$expired_tray->addElement($select_prefcontact1);
               // $adsform->addElement($expired_tray);
         //RAPPEL Ajouter nb_days_expired' peut être la raison pour laquel il ne fonctionne pas 
           // $adsform->addElement(new XoopsFormHidden('expired_mail_send', '1')); //oui
             //$adsform->addElement(new XoopsFormHidden('expired_by_mode', '1'));   //par email

		
//ajout CPascalWeb - 24 avril 2011 - Être informer par mail de la validation ?
            //$check_advert = new XoopsFormCheckBox(_MD_CATADS_ADVERT, 'notify_pub', $notify_pub);	
            //$check_advert->addOption(1,_MD_CATADS_ADVERTPUBLI);				
            //$adsform->addElement($check_advert);
//fin			  
//ajout CPascalWeb - 21 avril 2011 - sécurité anti spam	pas vraiment utile ici mais bon !		
	    if ( $xoopsModuleConfig['captcha'] == 1) {
		//global $xoopsCaptcha, $xoopsModuleConfig;
		//include_once XOOPS_ROOT_PATH."/class/captcha/xoopscaptcha.php"; 
        $adsform->addElement(new XoopsFormCaptcha(), true);
		}
//fin 
        $adsform->addElement(new XoopsFormHidden('ads_id', $ads_id));
        $adsform->addElement(new XoopsFormHidden('cat_id', $cat_id));
        $adsform->addElement(new XoopsFormHidden('uid', $uid));
        $adsform->addElement(new XoopsFormHidden('display_price', $cat->display_price));
		
		
        $button_tray = new XoopsFormElementTray('','');
//ajout CPascalWeb - 4 mai 2011 - correction et ajout pour prendre en compte les modifs de l'annonceur 		
		//$button_tray->addElement(new XoopsFormButton('', 'post', _SEND, 'submit'));
        $button_tray->addElement(new XoopsFormHidden('op', 'save' ));		
		$button_tray->addElement(new XoopsFormButton('', 'save', _SEND, 'submit'));	
//fin		
        $button_cancel = new XoopsFormButton('', 'cancel', _CANCEL, 'button');
        $button_cancel->setExtra("onclick='location=\"adsitem.php?ads_id=".$ads_id."\";'");
        if ($xoopsModuleConfig['usercandelete']) {
            $button_tray->addElement(new XoopsFormButton('', 'delete', _DELETE, 'submit'));
        }
        $button_tray->addElement($button_cancel);
        $adsform->addElement($button_tray);



?>