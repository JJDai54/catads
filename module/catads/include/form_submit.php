<?php
//formulaire de soumission d'annonce
//a supprimer ne sert plus !!
/*
if (file_exists(XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/calendar.php')) {
        include_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/calendar.php';
} else {
        include_once XOOPS_ROOT_PATH.'/language/english/calendar.php';
}
*/
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
include_once(XOOPS_ROOT_PATH."/class/xoopstree.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/catadsformbreak.php");
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/formSelectRegions.php";
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/formSelectDepartements.php";

        $ads_video = !isset($_REQUEST['ads_video'])? NULL : $_REQUEST['ads_video'];//rappel a voir !
// Récupération options de liste
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

        $mytree = new XoopsTree($xoopsDB->prefix("catads_cat"),"topic_id","topic_pid");
        $cat_path = $mytree->getpathFromId( $topic_id, 'topic_title');
        $cat_path = substr($cat_path, 1);
//modif CPascalWeb - 9 octobre 2010 - chemin image + alt & titre + nom sous catégorie et site supposé aider au référencement naturel		
        $cat_path = str_replace("/"," <img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/arrow.gif' border='0' title='". _MD_CATADS_NOM_REFERENCE .' '. $cat_path ."' alt='". _MD_CATADS_NOM_REFERENCE .' '. $cat_path .' '. $GLOBALS['xoopsConfig']['sitename'] ."' /> ",$cat_path);

        $adsform = new XoopsThemeForm(_MD_CATADS_MENUADD .'<b>'.$cat_path.'</b>', "adsform", $_SERVER['PHP_SELF'] ."?topic_id=$topic_id");
        $adsform->setExtra( "enctype='multipart/form-data'" ) ;
		
		//entête du formulaire condition de publication contrôle des annonces avant leur parrution ?
        if ($xoopsModuleConfig['moderated'] > 0) {
            $label_info = new XoopsFormLabel(_MD_CATADS_MSG_CONDSOUMISTITLE, _MD_CATADS_MSG_CONDSOUMIS);	
            $adsform->addElement($label_info);
        } 

        $title_tray = new XoopsFormElementTray(_MD_CATADS_TITLE1.'<span style="color:#FF0000; padding-left: 2px; background-color: inherit; font-size: 12px; font-weight: bold;">*</span>','&nbsp;','title');
//fin
 
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

        //affichage du prix
        if ($display_price)
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
            $price_tray = new XoopsFormElementTray(_MD_CATADS_PRICE_S ,'&nbsp;','price');
            $price_tray->addElement(new XoopsFormText('', "price", 15, 15, $price));
            $price_tray->addElement($select_monnaie);
            $price_tray->addElement($select_price_option);
            $adsform->addElement($price_tray);
        }

        //option tags (mots clés)
        if ( $xoopsModuleConfig['allow_custom_tags'] == 1) {
//modif CPascalWeb - 23 avril 2011			
        /*$title_tags = new XoopsFormText(_MD_CATADS_TAGS, "ads_tags", 52, 100, $ads_tags);
        $adsform->addElement($title_tags);
        $lien_tags_help = new XoopsFormLabel('', "<small><strong>"._MD_CATADS_TAGS_HELP."</strong></small>");
        $adsform->addElement($lien_tags_help);*/
		$lien_tags = new XoopsFormElementTray(_MD_CATADS_TAGS,'<br />','ads_tags');
		$lien_tags->addElement (new XoopsFormText('', "ads_tags", 60, 100, $ads_tags));
		$lien_tags->addElement(new XoopsFormLabel('',"<small><strong>"._MD_CATADS_TAGS_HELP."</strong></small>"));
		$adsform->addElement($lien_tags);
//fin		
        }
        //option vidéo
    if ( $xoopsModuleConfig['show_video_field'] == 1) {
//modif CPascalWeb - 23 avril 2011		
       // $lien_video = new XoopsFormText(_MD_CATADS_VIDEO, "ads_video", 60, 100, $ads_video);
		//$adsform->addElement($lien_video);
       // $lien_video_help = new XoopsFormLabel('', "<small><strong>"._MD_CATADS_VIDEO_HELP."</strong></small>");
       // $adsform->addElement($lien_video_help);
		$lien_video = new XoopsFormElementTray(_MD_CATADS_VIDEO,'<br />','ads_video');
		$lien_video->addElement (new XoopsFormText('', "ads_video", 60, 100, $ads_video));
		$lien_video->addElement(new XoopsFormLabel('',"<small><strong>"._MD_CATADS_VIDEO_HELP."</strong></small>"));
		$adsform->addElement($lien_video);
//fin		
    }

        //télécharger les photos de l'annonce
//ajout CPascalWeb - 23 avril 2011			
		$adsform->addElement(new XoopsFormBreak(1, _MD_CATADS_PHOTO.'&nbsp;&nbsp;'));
//fin		
        $i = 0;
        while  ($i < $cat->nb_photo) {
            $file_tray = new XoopsFormElementTray(_MD_CATADS_ADDIMG ,'&nbsp;','photo'.$i);
            $file_img = new XoopsFormFile('', 'photo'.$i, $xoopsModuleConfig['photo_maxsize']);
            $file_img->setExtra( "size ='40'") ;
            $file_tray->addElement($file_img);
            $msg = sprintf(_MD_CATADS_IMG_CONFIG, intval($xoopsModuleConfig['photo_maxsize']/1000),$xoopsModuleConfig['photo_maxwidth'],$xoopsModuleConfig['photo_maxheight']);
            $file_label = new XoopsFormLabel('' ,'<br />'.$msg);
            $file_tray->addElement($file_label);
            $adsform->addElement($file_tray);
            $adsform->addElement(new XoopsFormHidden('previewname_'.$i, $preview_name[$i]));
            unset($file_img);
            unset($file_tray);
            $i++;
        }

        $adsform->addElement(new XoopsFormBreak(2,_MD_CATADS_CONTACTME));
//correction CPascalWeb - 23 avril 2011
        //if ($xoopsModuleConfig['email_req'] > 0) {
            //$star = ($xoopsModuleConfig['email_req'] > 1) ? '*' : '';
           /* $text_email = new XoopsFormText(_MD_CATADS_MAIL_S, "email", 50, 100, $email);
            $adsform->addElement($text_email, true);*/
        //}
		//email facultatif
        if ($xoopsModuleConfig['email_req'] == 1) {
            $text_email = new XoopsFormText(_MD_CATADS_MAIL_S, "email", 50, 100, $email);
            $adsform->addElement($text_email, false);
		//email obligatoire
	    }elseif ($xoopsModuleConfig['email_req'] == 0){
			$text_email = new XoopsFormText(_MD_CATADS_MAIL_S.'<span style="color:#FF0000; padding-left: 2px; background-color: inherit; font-size: 12px; font-weight: bold;">*</span>', "email", 50, 100, $email);
			$adsform->addElement($text_email, true);
		}		
//fin		
		
//modif CPascalWeb - 23 avril 2011 - ajout option
       // $text_phone = new XoopsFormText(_MD_CATADS_PHONE_S, "phone", 20, 20,$phone);
       // $adsform->addElement($text_phone, false);
//ajout option CPascalWeb - 23 avril 2011 - téléphone fixe facultatif, obligatoire ou non demandé 
		//téléphone facultatif
        if ($xoopsModuleConfig['phonefixe_req'] == 1) {
            $text_phone = new XoopsFormText(_MD_CATADS_PHONE_S, "phone", 20, 20, $phone);
            $adsform->addElement($text_phone, false);
		//téléphone obligatoire
	    }elseif ($xoopsModuleConfig['phonefixe_req'] == 2){
			$text_phone = new XoopsFormText(_MD_CATADS_PHONE_S.'<span style="color:#FF0000; padding-left: 2px; background-color: inherit; font-size: 12px; font-weight: bold;">*</span>', "phone", 20, 20, $phone);
			$adsform->addElement($text_phone, true);
		}

//fin
		
//ajout CPascalWeb - 12 novembre 2010 - option tel portable + ajout 23 avril 2011 - téléphone fixe facultatif, obligatoire ou non demandé 
		//téléphone facultatif
        if ($xoopsModuleConfig['phoneportable_req'] == 1) {
            $text_phoneportable = new XoopsFormText(_MD_CATADS_PHONE_SPORTABLE, "phoneportable", 20, 20, $phoneportable);
            $adsform->addElement($text_phoneportable, false);
		//téléphone obligatoire
	    }elseif ($xoopsModuleConfig['phoneportable_req'] == 2){
			$text_phoneportable = new XoopsFormText(_MD_CATADS_PHONE_SPORTABLE.'<span style="color:#FF0000; padding-left: 2px; background-color: inherit; font-size: 12px; font-weight: bold;">*</span>', "phoneportable", 20, 20, $phoneportable);
			$adsform->addElement($text_phoneportable, true);
		}		
//fin
		
//correction CPascalWeb - 23 avril 2011
        //Regions/Departemens
      /*  if ( $xoopsModuleConfig['region_req'] > 0 || $xoopsModuleConfig['departement_req'] > 0 )
        {
            //Regions
            if ($xoopsModuleConfig['region_req'] > 0)
            {
                $region = new formSelectRegions(_MD_CATADS_REGION, "region", $region);
                $adsform->addElement($region, true);
            }
            //Departements
            if ($xoopsModuleConfig['departement_req'] > 0)
            {
                $departement = new formSelectDepartements(_MD_CATADS_DEPARTEMENT, "departement", $departement);
                $adsform->addElement($departement, true);
            }
        }*/
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
//fin

//ajout CPascalWeb - 23 avril 2011 - facultatif, obligatoire ou non demandé 
        //ville
       /* $text_town = new XoopsFormText(_MD_CATADS_TWON, "town", 50, 100, $town);
        $adsform->addElement($text_town, true);*/
		//ville facultatif
        if ($xoopsModuleConfig['town_req'] == 1) {
            $text_town = new XoopsFormText(_MD_CATADS_TWON, "town", 20, 20, $town);
            $adsform->addElement($text_town, false);
		//ville obligatoire
	    }elseif ($xoopsModuleConfig['town_req'] == 2){
			$text_town = new XoopsFormText(_MD_CATADS_TWON.'<span style="color:#FF0000; padding-left: 2px; background-color: inherit; font-size: 12px; font-weight: bold;">*</span>', "town", 20, 20, $town);
			$adsform->addElement($text_town, true);
		}
//fin		
		
//correction CPascalWeb - 23 avril 2011		
        //Code postal
       /* if ($xoopsModuleConfig['zipcode_req'] > 0)
        {
            $text_codpost = new XoopsFormText(_MD_CATADS_ZIPCOD, "codpost", 20, 20, $codpost);
            $adsform->addElement($text_codpost, true);
        }*/		
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

        //if ($xoopsModuleConfig['email_req'] > 0)
        $select_modecontact->addOption(2,_MD_CATADS_CONTACT_MODE2);//email
//correction CPascalWeb - activer uniquement si membre		
		if ($uid > 0)
        $select_modecontact->addOption(1,_MD_CATADS_CONTACT_MODE1);//message privé
        $select_modecontact->addOption(3,_MD_CATADS_CONTACT_MODE3);//téléphone
        $contact_tray->addElement($select_modecontact, true);
        $adsform->addElement($contact_tray);
		
		//Délai maximum avant la parution de l'annonce
        // if ($xoopsModuleConfig['nb_days_before'] > 0 ) {
//modif CPascalWeb - 18 avril 2011 - correction bug annonces programmées	
		//Autorisé l'annonceur à choisir une date de publication
        if ($xoopsModuleConfig['allow_publish_date'] == 1 ) {
        if ($xoopsModuleConfig['nb_days_before'] > 0 ) {		
       // include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/catadsformtextdateselect.php");
       // $date_pub = new catadsFormTextDateSelect(_MD_CATADS_DATE_PUB,'published',15, $published);
//JJDai
//include_once XOOPS_ROOT_PATH.'/include/calendarjs.php'; //pas vraiment utile la class suffis mais bon ! 
	    $date_pub = new XoopsFormTextDateSelect(_MD_CATADS_DATE_PUB,'published',15, $published);
//fin		
		$date_pub->setExtra("readonly = 'readonly'");
        $adsform->addElement($date_pub);
        }
		}
//modif CPascalWeb - 18 mai 2011 plus besoin envoi mail automatique			
		//Être informer de l'expiration de l'annonce ?
				//$expired_tray = new XoopsFormElementTray(_MD_CATADS_CHOICE_MAIL_EXP ,'&nbsp;','expired');//Être informer de l'expiration de l'annonce ?
               // $expired_tray->addElement(new XoopsFormRadioYN('', 'expired_mail_send', $expired_mail_send), true);
               // $expired_tray->addElement(new XoopsFormLabel('',_MD_CATADS_BY));

               // $select_prefcontact1 = new XoopsFormSelect('', "expired_by_mode", $expired_by_mode);
                //$select_prefcontact1->addOptionArray(array('0'=>_MD_CATADS_CONTACT_MODE1,'1'=>_MD_CATADS_CONTACT_MODE2));

               // $expired_tray->addElement($select_prefcontact1);
               // $adsform->addElement($expired_tray);

		//RAPPEL Ajouter nb_days_expired' peut être la raison pour laquel il ne fonctionne pas

            // $adsform->addElement(new XoopsFormHidden('expired_mail_send', '1')); //oui
             //$adsform->addElement(new XoopsFormHidden('expired_by_mode', '1'));   //par email


		//Durée dde la publication de l'annonce
        $duration_tray = new XoopsFormElementTray(_MD_CATADS_DURATION_PUB,'&nbsp;');
        $select_duration_option = new XoopsFormSelect('', "duration", $duration);
        for ( $i = 0; $i < $count; $i++ ) {
                if ($arr_option[$i]['type'] == 4) $select_duration_option->addOption($arr_option[$i]['desc'],$arr_option[$i]['desc']);
        }
        $duration_tray->addElement($select_duration_option, true);
        $duration_tray->addElement(new XoopsFormLabel('',_MD_CATADS_DAYS));
        $adsform->addElement($duration_tray);
//modif CPascalWeb - 16 octobre 2010 - + ajout define
//re-modif CPascalWeb - 18 mai 2011 plus besoin envoi mail automatique		
        //if ($xoopsModuleConfig['moderated'] == 1) {
			//$check_advert = new XoopsFormCheckBox('', 'notify_pub', $notify_pub);
            //$check_advert = new XoopsFormCheckBox(_MD_CATADS_ADVERT, 'notify_pub', $notify_pub);	
            //$check_advert->addOption(1,_MD_CATADS_ADVERTPUBLI);				
            //$adsform->addElement($check_advert);
       // }
//fin
//ajout CPascalWeb - 21 avril 2011 - sécurité anti spam			
	//sécurité anti spam captcha
	    if ( $xoopsModuleConfig['captcha'] == 1) {
		//global $xoopsCaptcha, $xoopsModuleConfig;
		//include_once XOOPS_ROOT_PATH."/class/captcha/xoopscaptcha.php"; 
        $adsform->addElement(new XoopsFormCaptcha(), true);
		}
//fin 

        $button_tray = new XoopsFormElementTray(_MD_CATADS_PREVIEW_TEXT,'&nbsp;','button');
        $button_tray->addElement(new XoopsFormButton('', 'preview', _PREVIEW, 'submit'));
        $button_tray->addElement(new XoopsFormButton(_MD_CATADS_SUBMIT_AD, 'post', _SEND, 'submit'));
        $button_cancel = new XoopsFormButton('', 'cancel', _CANCEL, 'button');
        $button_cancel->setExtra("onclick='location=\"submit.php?topic_id=".$topic_id."&op=cancel\";'");
        $button_tray->addElement($button_cancel);
        $adsform->addElement($button_tray);

        $adsform->addElement(new XoopsFormHidden('uid', $uid));
        $adsform->addElement(new XoopsFormHidden('display_price', $display_price));

?>