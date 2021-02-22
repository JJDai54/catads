<?php
//formulaire de modification d'annonce administration
include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
include_once(XOOPS_ROOT_PATH."/class/xoopstree.php");
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/formSelectRegions.php";
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/formSelectDepartements.php";

$preview_name = !isset($_REQUEST['preview_name'])? NULL : $_REQUEST['preview_name'];

// modif annonce
		$cat = new catadsCategory($cat_id);
       // $adsform = new XoopsThemeForm(_AM_CATADS_FORMEDIT, "annonceform", xoops_getenv('PHP_SELF')."?ads_id=$ads_id");
		$adsform = new XoopsThemeForm(_AM_CATADS_FORMEDIT .' <b>'.$ads_title.'</b>', "adsform", xoops_getenv('PHP_SELF') ."?ads_id=$ads_id");        
		$adsform->setExtra( "enctype='multipart/form-data'" ) ;
        //affiche du statut (date de création, publiée depuis x jours)
        $msg1  = _AM_CATADS_DATE_CREA;
        $msg1 .= '<br /><br />'._AM_CATADS_STATUS;
        $msg2  = formatTimestamp($created,"m");
        //affiche date
        if ($waiting == 0 && $expired < time()) {
                $delay = (intval((time()-$expired)/86400) > 0) ? intval((time()-$expired)/86400)._AM_CATADS_DAYS : _AM_CATADS_TODAY;
                $msg2 .= '<br /><br />'._AM_CATADS_EXP2. $delay;//Expirée depuis
        } elseif ($waiting == 0 && $published < time()) {
                $delay = (intval((time()-$published)/86400) > 0) ? intval((time()-$published)/86400)._AM_CATADS_DAYS : _AM_CATADS_TODAY;
                $msg2 .= '<br /><br />'._AM_CATADS_PUB2. $delay;//Publiée depuis
        } elseif ($published > time()) {
                $delay = (intval(($published-time())/86400) > 0) ? _AM_CATADS_TO.intval(($published-time())/86400)._AM_CATADS_DAYS : _AM_CATADS_TODAY;
                $msg2 .= '<br /><br />'._AM_CATADS_DELAY_PUB. $delay;//cette annonce est programmée pour être publier
        } else  {
                $delay = (intval((time()-$created)/86400) > 0) ? intval((time()-$created)/86400)._AM_CATADS_DAYS : _AM_CATADS_TODAY;
                $msg2 .= '<br /><br />'._AM_CATADS_WAIT2. $delay;//En attente depuis
        }
        $adsform->addElement(new XoopsFormLabel($msg1,$msg2));
		$adsform->addElement(new XoopsFormDateTime(_AM_CATADS_DATE_PUB,'published',15, $published));
		$adsform->addElement(new XoopsFormDateTime(_AM_CATADS_DATE_EXP,'expired',15, $expired));

        //affiche annonce
        $title_tray = new XoopsFormElementTray(_AM_CATADS_TITLE_ADS,'');
        //affiche type d'annonce
        if ($xoopsModuleConfig['show_ad_type'] == 1){
         $type_text = new XoopsFormSelect('', "ads_type", $ads_type);
         for ( $i = 0; $i < $count; $i++ ) {
                if ($arr_option[$i]['type'] == 3) $type_text->addOption($arr_option[$i]['desc'],$arr_option[$i]['desc']);
         }
         $title_tray->addElement($type_text, true);
        }

        $title_text = new XoopsFormText('', "ads_title", 52, 100, $ads_title);
        $title_tray->addElement($title_text, true);
        $adsform->addElement($title_tray, true);

        //affichage du prix
       /* if ($cat->display_price)
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

                $price_tray = new XoopsFormElementTray(_AM_CATADS_PRICE,'&nbsp;','price');
                $price_tray->addElement(new XoopsFormText('', "price", 15, 15, $price));
                $price_tray->addElement($select_monnaie);
                $price_tray->addElement($select_price_option);
                $adsform->addElement($price_tray);
        }*/

        //catégories
        $xt = new XoopsTree($xoopsDB->prefix("catads_cat"),'topic_id','topic_pid');
        ob_start();
        $xt->makeMySelBox('topic_title','topic_title', $cat_id, 1);
        $cat_select = new XoopsFormLabel(_AM_CATADS_TITLE_CAT, ob_get_contents());
        ob_end_clean();
        $adsform->addElement($cat_select);
		
//modif CPascalWeb - 3 mai 2011 //a voir si vraiment utile
       /* if ($xoopsModuleConfig['bbcode'] == 1) {
            $annonce_text = new XoopsFormDhtmlTextArea(_AM_CATADS_DESCR, "ads_desc", $ads_desc);
        } else {
            $annonce_text = new XoopsFormTextArea(_AM_CATADS_DESCR, "ads_desc", $ads_desc);
        }
        $adsform->addElement($annonce_text, true);*/
//ajout option CPascalWeb - 23 mai 2011 - choix de l'éditeur pour l'admin et suppression bbcodes pas vraiment utile !	
        $editor_configs=array();
        $editor_configs["name"] ="ads_desc";
		$editor_configs["value"] = $ads_desc;
        $editor_configs["rows"] = 20;
        $editor_configs["cols"] = 60;
        $editor_configs["width"] = "100%";
        $editor_configs["height"] = "400px";
        //JJDai utilisation du meme editeur dans le BO et le FO
        //$editor_configs["editor"] = $xoopsModuleConfig['form_admin_options'];
        $editor_configs["editor"] = $xoopsModuleConfig['form_options'];
       
	   $adsform->addElement( new XoopsFormEditor(_AM_CATADS_DESCR, "ads_desc", $editor_configs), true);	
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

                $price_tray = new XoopsFormElementTray(_AM_CATADS_PRICE,'&nbsp;','price');
                $price_tray->addElement(new XoopsFormText('', "price", 15, 15, $price));
                $price_tray->addElement($select_monnaie);
                $price_tray->addElement($select_price_option);
                $adsform->addElement($price_tray);
        }
		
		//mots clés/tags
		$title_tags = new XoopsFormText(_AM_CATADS_TAGS, "ads_tags", 52, 100, $ads_tags);
		$adsform->addElement($title_tags);
		
		//vidéo
		$lien_video = new XoopsFormText(_AM_CATADS_VIDEO, "ads_video", 60, 100, $ads_video);
		$adsform->addElement($lien_video);

//ajout CPascalWeb - 24 avril 2011		
	$adsform->insertBreak("<div style=\"text-align: center; color:#454545;\">" . _AM_CATADS_IMGANNONCE . "</div>", "foot");	
//fin	
if ($cat->nb_photo > 0) {
                $i = 0;
                while  ($i < $cat->nb_photo) {
                        $file_tray = new XoopsFormElementTray(_AM_CATADS_IMG.' '.($i+1), '');
                        if (isset($photo[$i])){
//modif CPascalWeb - 24 avril 2011 - réduction de l'affichage des images dans modifier l'annonce						
                            //$file_tray->addElement(new XoopsFormLabel('', "<img src='".XOOPS_URL."/uploads/".$xoopsModule->dirname()."/images/annonces/original/".$photo[$i]."' name='image' id='image' alt=''/><br /><br />" ));
							$file_tray->addElement(new XoopsFormLabel('', "<img src='".XOOPS_URL."/uploads/".$xoopsModule->dirname()."/images/annonces/original/".$photo[$i]."' name='image' id='image' alt='' width='120px' /><br />" ));
//fin
							$check_del_img = new XoopsFormCheckBox('', 'delimg_'.$i);
                            $check_del_img->addOption(1,_AM_CATADS_DELIMG);
                            $file_tray->addElement($check_del_img);
                            $file_img = new XoopsFormFile(_AM_CATADS_REPLACEIMG,'photo'.$i, $xoopsModuleConfig['photo_maxsize']);
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

        //Partie coordonnées de l'annonceur
//modif CPascalWeb - 24 avril 2011		
        //$adsform->insertBreak(_AM_CATADS_CONTACT,'foot');
		$adsform->insertBreak("<div style=\"text-align: center; color:#454545;\">" . _AM_CATADS_CONTACT . "</div>", "foot");	
//fin	
		//Annonce soumis par xx
        $msg1 = _AM_CATADS_ADS_FROM;
        $msg2 = $submitter;
        $adsform->addElement(new XoopsFormLabel($msg1,$msg2));

//modif CPascalWeb - 24 avril 2011
        //if ($xoopsModuleConfig['email_req'] > 0) {
       // if($xoopsModuleConfig['email_req'] == 0 || $contact_mode == 2)
        //if( $contact_mode == 2 )
            //$star = '*';
			$star = ($xoopsModuleConfig['email_req'] == 0) ? '*' : '';			
			$email_text = new XoopsFormText(_AM_CATADS_EMAIL, "email", 50, 100, $email);
            $adsform->addElement($email_text, $star);
//fin			
        //}
//modif CPascalWeb - 24 avril 2011
        /*$phone_text = new XoopsFormText(_AM_CATADS_PHONE, "phone", 20, 20,$phone);
        $adsform->addElement($phone_text, false);*/
		//téléphone facultatif
        if ($xoopsModuleConfig['phonefixe_req'] == 1) {
            $text_phone = new XoopsFormText(_AM_CATADS_PHONE, "phone", 20, 20, $phone);
            $adsform->addElement($text_phone, false);
		//téléphone obligatoire
	    }elseif ($xoopsModuleConfig['phonefixe_req'] == 2){
			$text_phone = new XoopsFormText(_AM_CATADS_PHONE.'', "phone", 20, 20, $phone);
			$adsform->addElement($text_phone, true);
		}
		
//fin
		
//ajout CPascalWeb - 12 novembre 2010 - option tel portable
		//téléphone portable facultatif
        if ($xoopsModuleConfig['phoneportable_req'] == 1) {
            $text_phoneportable = new XoopsFormText(_AM_CATADS_PHONEPORTABLE, "phoneportable", 20, 20, $phoneportable);
            $adsform->addElement($text_phoneportable, false);
		//téléphone portable obligatoire
	    }elseif ($xoopsModuleConfig['phoneportable_req'] == 2){
			$text_phoneportable = new XoopsFormText(_AM_CATADS_PHONEPORTABLE.'', "phoneportable", 20, 20, $phoneportable);
			$adsform->addElement($text_phoneportable, true);
		}			
//fin			
//modif CPascalWeb - 24 avril 2011
        /*$adress_text = new XoopsFormText(_AM_CATADS_TOWN, "town", 35, 50,$town);
        $adsform->addElement($adress_text,true);

        //Regions
        if ($xoopsModuleConfig['region_req'] > 0)
        {
            $adsform->addElement(new formSelectRegions(_AM_CATADS_REGION, "region", $region), true);
        }
        //Departements
        if ($xoopsModuleConfig['departement_req'] > 0)
        {
            $adsform->addElement(new formSelectDepartements(_AM_CATADS_DEPARTEMENT, "departement", $departement), true);
        }

        if ($xoopsModuleConfig['zipcode_req'] > 0)
        {
            //$star = ($xoopsModuleConfig['zipcode_req'] > 1) ? '*' : '';
            //$codpost_text = new XoopsFormText(_AM_CATADS_CODPOST, "codpost", 20, 20, $codpost);
            $adsform->addElement(new XoopsFormText(_AM_CATADS_CODPOST, "codpost", 20, 20, $codpost), true);
        }
	*/
//ajout & correction CPascalWeb - 23 avril 2011 - facultatif, obligatoire ou non demandé 		
//departement facultatif		
        if ($xoopsModuleConfig['departement_req'] == 1) {
            $departement = new formSelectDepartements(_AM_CATADS_DEPARTEMENT, "departement", $departement);
            $adsform->addElement($departement, false);
		//departement obligatoire
	    }elseif ($xoopsModuleConfig['departement_req'] == 2){
			$departement = new formSelectDepartements(_AM_CATADS_DEPARTEMENT, "departement", $departement);
			$adsform->addElement($departement, true);
		}
        //régions facultatif
        if ($xoopsModuleConfig['region_req'] == 1) {
            $region = new formSelectRegions(_AM_CATADS_REGION, "region", $region);
            $adsform->addElement($region, false);
		//régions obligatoire
	    }elseif ($xoopsModuleConfig['region_req'] == 2){
			$region = new formSelectRegions(_AM_CATADS_REGION, "region", $region);
			$adsform->addElement($region, true);
		}		

		//ville facultatif
        if ($xoopsModuleConfig['town_req'] == 1) {
            $text_town = new XoopsFormText(_AM_CATADS_TOWN, "town", 20, 20, $town);
            $adsform->addElement($text_town, false);
		//ville obligatoire
	    }elseif ($xoopsModuleConfig['town_req'] == 2){
			$text_town = new XoopsFormText(_AM_CATADS_TOWN, "town", 20, 20, $town);
			$adsform->addElement($text_town, true);
		}
		
		//code postal facultatif
        if ($xoopsModuleConfig['zipcode_req'] == 1) {
            $text_codpost = new XoopsFormText(_AM_CATADS_CODPOST, "codpost", 20, 20, $codpost);
            $adsform->addElement($text_codpost, false);
		//code postal obligatoire
	    }elseif ($xoopsModuleConfig['zipcode_req'] == 2){
			$text_codpost = new XoopsFormText(_AM_CATADS_CODPOST, "codpost", 20, 20, $codpost);
			$adsform->addElement($text_codpost, true);
		}	
//fin		

		//publier cette annonce
        $adsform->addElement(new XoopsFormRadioYN(_AM_CATADS_PUBADS, 'waiting', ($waiting > 0) ? 0 : 1));

        $button_tray = new XoopsFormElementTray('','');
        $button_tray->addElement(new XoopsFormHidden('op', 'modify' ));
        $button_tray->addElement(new XoopsFormButton('', 'save', _SEND, 'submit'));
        $button_tray->addElement(new XoopsFormButton('', 'delete', _DELETE, 'submit'));
        $adsform->addElement($button_tray);
        $adsform->display();
		
?>