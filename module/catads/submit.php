<?php

//rappel: fichier fonctionne avec include/form_submit.php et catads_adsform.tpl
include("../../mainfile.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/header.php");

//autorisé les visiteurs a soummettre une annonce ou non //sert a rien puisque aprés les anonymes ne peuvent pas modifié leurs annonces ou ajouter code adsitem.php $isAuthor trop risquer !
/*if (!$xoopsModuleConfig['anoncanpost'] && !$xoopsUser){
        redirect_header(XOOPS_URL."/user.php",3,_MD_CATADS_ONLY_MEMBERS);
        exit();
}
*/
$adsCatHandler = new catadsCategory();

$op = 'form';
foreach ($_GET as $k => $v) {${$k} = $v;}

foreach ($_POST as $k => $v) {
        if(preg_match('/previewname_/', $k)){
                $n = explode('_',$k);
                $preview_name[$n[1]] = $v;
        } else {
                ${$k} = $v;
        }
}

if ( isset($preview)) $op = 'preview';
elseif ( isset($cancel) ) $op = 'cancel';
elseif ( isset($post) ) $op = 'post';

$topic_id =  isset($_GET['topic_id']) ? intval($_GET['topic_id']) : 0;
$notify_pub = !isset($_REQUEST['notify_pub'])? 0 : $_REQUEST['notify_pub'];
$ads_type = !isset($_REQUEST['ads_type'])? NULL : $_REQUEST['ads_type'];
$ads_video = !isset($_REQUEST['ads_video'])? NULL : $_REQUEST['ads_video'];
$published = !isset($_REQUEST['published'])? 0 : $_REQUEST['published'];


//sous-catégories 'enfant' d'une catégorie
function getFirstChild($topic_id = 0) {
        global $allcat;
        $firstChild = array();
        if (isset($allcat)) {
                foreach($allcat as $onechild)         {
                        if( $onechild['topic_pid'] == $topic_id) {
                                array_push($firstChild, $onechild);
                        }
                }
        }
        return $firstChild;
}

//afficher les sous catégories
function showsubcat($categorys, $level = 0, $topic_id = 0, $pid) {
        global $xoopsModule, $myts, $lastchildren, $arr_subcat, $cptsubcat, $tpltype, $xoopsModuleConfig;

        foreach($categorys as $onecat)         {
                $title = $myts->htmlSpecialChars($onecat['topic_title']);
                $arr_scat['id'] = $onecat['topic_id'];
                if (in_array($onecat['topic_id'], $lastchildren)) {
                    $arr_scat['submit'] = XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/submit.php?topic_id=' . $onecat['topic_id'];
                }
                $arr_scat['title'] = $title;
                $arr_scat['level'] = $level;
                if ($level == 0 && $tpltype == 1) {
                    $arr_scat['newcol'] = ($cptsubcat > 0) ? true : false;
                    $cptsubcat++;
                    $arr_scat['newline'] = ($cptsubcat % $xoopsModuleConfig['nbcol'] == 1) ? true : false;
                }
                array_push($arr_subcat, $arr_scat);
                $childcats =  getFirstChild($onecat['topic_id']);
                    if (count($childcats) > 0) {
                            showsubcat($childcats, $level + 1, $onecat['topic_id'], $pid);
                    }
                }
        return;
    }

switch($op) {
	case "cancel":
        $photos_dir = XOOPS_ROOT_PATH . "/uploads/".$xoopsModule->dirname()."/images/annonces/original" ;
        $nb_removed_tmp = catads_clear_tmp_files( $photos_dir ) ;
        redirect_header(XOOPS_URL."/modules/catads/adslist.php?topic_id=".$topic_id, 0);
    break;

	case "post":
        $msgstop = '';
        if (isset($email) && $email != '' && !checkEmail($email) ) $msgstop .= _MD_CATADS_INVALIDMAIL.'<br />';
        if (strlen(deleteCode($ads_desc)) > $xoopsModuleConfig['txt_maxlength'] ) $msgstop .= sprintf(_MD_CATADS_MAXLENGTH.'<br />', $xoopsModuleConfig['txt_maxlength']);
        if (isset($price) && $price != '' && !is_numeric(trim($price))) $msgstop.= _MD_CATADS_INVALIDPRICE.'<br />';
        if ($mode_contact == 2 && $email == '') $msgstop .= _MD_CATADS_MAILREQ.'<br />';
        if ($mode_contact == 3 && $phone == '') $msgstop .= _MD_CATADS_PHONEREQ.'<br />';

        //echo $departement;
        if (!isset($region)) { $region = '00'; }
        if (!isset($departement)) { $departement = '00'; }

        //ignorer pour l'instant utilisé par France map.
        if( $region != '00' || $departement != '00' )
        {
            $pays = 'FRANCE';
        } else {
            $pays = 'OTHER';
        }

        //sécurité Captcha A VERIFIER
       /* include_once(XOOPS_ROOT_PATH . "/class/xoopsformloader.php");
        if ( defined('SECURITYIMAGE_INCLUDED') && !SecurityImage::CheckSecurityImage() ) {
            redirect_header( 'index.php', 2, _SECURITYIMAGE_ERROR ) ;
        exit();
        }*/
//ajout CPascalWeb - 21 avril 2011 - sécurité anti spam	RAPPEL NE FONCTIONNE QUE EN MODE ANONYME VOIR POUR MEMBRE AU CAS OU !		
    if ( $xoopsModuleConfig['captcha'] == 1) {
		//global $xoopsCaptcha, $xoopsModuleConfig;
		//include_once XOOPS_ROOT_PATH."/class/captcha/xoopscaptcha.php"; 
		xoops_load('XoopsCaptcha');
		$xoopsCaptcha = XoopsCaptcha::getInstance();
			if (!$xoopsCaptcha->verify()) {
				redirect_header(XOOPS_URL.'/modules/catads/submit.php?topic_id='.$topic_id, 2, $xoopsCaptcha -> getMessage() );//rappel CPascalWeb voir pour eviter redirect afin de ne pas être obliger de ré remplir formulaire
			}	
    }			
//fin
        $cat = new catadsCategory($topic_id);
        $i = 0;
        while  ($i < $cat->nb_photo) {
                if ( !empty($_FILES['photo'.$i]['name'])) {
                    catads_upload($i);
                }
                $i++;
        }
        if ( !empty($msgstop) ) {
//modif CPascalWeb - xoopsOption[template_main] doit être définis avant l'appel du header.php 		
                $xoopsOption['template_main'] = 'catads_adsform.tpl';		
                include  XOOPS_ROOT_PATH.'/header.php';
//fin				
                $xoopsTpl->assign('preview', true);
                $xoopsTpl->assign('msgstop',$msgstop);
                $xoopsTpl->assign('nb_days_before', $xoopsModuleConfig['nb_days_before']);
                include_once "include/form_submit.php";
                $adsform->assign($xoopsTpl);
                include XOOPS_ROOT_PATH."/footer.php";
                exit();
        }

        //$ads_handler =& xoops_getmodulehandler('ads');
        $ads_handler = xoops_getmodulehandler('ads');		
        $ads = $ads_handler->create();
        $photos_dir = XOOPS_ROOT_PATH . "/uploads/".$xoopsModule->dirname()."/images/annonces/original" ;
        //optimiser, faire 6 boucles, si il n'y a qu'une photo
        $i = 0;
        while  ($i < 6)
        {
                if (isset($preview_name[$i]) && $preview_name[$i] != '')
                {
                        $photo = str_replace('tmp_', 'img_',$preview_name[$i]);//revoir n'affiche pas toute l'annonce
                        rename( "$photos_dir/$preview_name[$i]" , "$photos_dir/$photo" ) ;
                        $ads->setVar('photo'.$i, $photo);
                        //  create thumbs for all images, not just the first? no, just image0 for the listing page
                        if ( $i == 0 )
                        // if ( $i >= 0 )
                        {
                                //Thumb (a revoir avec l'optimisation au-dessus)
                                $image = XOOPS_ROOT_PATH . "/uploads/".$xoopsModule->dirname()."/images/annonces/original/".$photo;
                                $thumb = str_replace('tmp_', 'thumb_',$preview_name[$i]);
                                $thumb_dir = XOOPS_ROOT_PATH . "/uploads/".$xoopsModule->dirname()."/images/annonces/thumb/".$thumb;
                                //echo "thumb = ".$thumb;

                                if (!file_exists($thumb_dir))
                                        if (!resize_image($image, $thumb_dir, $xoopsModuleConfig['thumb_width'], $xoopsModuleConfig['thumb_method']))
                                                return false;
                        }

                } else
                {
                        $ads->setVar('photo'.$i, '');
                }
                $i++;
        }

        //$photo = str_replace('tmp_', 'thumb_',$preview_name[0]);
        $ads->setVar('thumb', $thumb);
        $ads->setVar('pays', $pays);

                include_once XOOPS_ROOT_PATH."/class/xoopsblock.php";
                include_once XOOPS_ROOT_PATH.'/class/template.php';
                xoops_template_clear_module_cache($xoopsModule->getVar('mid'));

                $notify_pub = isset($notify_pub) ? intval($notify_pub) : 0;
                //$notify_pub = intval($notify_pub);
                $waiting = ($xoopsModuleConfig['moderated']) ? 1 : 0;
                $poster_ip = $_SERVER['REMOTE_ADDR'];

                $ads->setVar('cat_id', $topic_id);
                $ads->setVar('ads_title', $ads_title);
                $ads->setVar('ads_type', $ads_type);
                $ads->setVar('ads_desc', $ads_desc);

                //si l'annonceur n'a pas entrer de tags
                if ($_REQUEST['ads_tags'] == '')
                {
                        //Créer des tags avec le titre de l'annonce
                        $newtags = $ads->getVar('ads_title');
                        // supprimer les lettres et les mots commun de la liste des tags rappel: les espaces avant et après sont importants.
                        $remplace = array(
                        ' of ', ' if ', ' to ', ' in ', ' at ', ' on ', ' by ', ' it ', ' is ', ' or ', ' are ', ' the ', ' for ', ' and ',
                        ' &amp; ', ' when ', ' with ',
 //ajout CPascalWeb - liste en français						
                        ' de ', ' en ', ' pour ',  ' sur ', ' selon ', ' à ', ' a ',  ' sûr ', ' si ', ' te ', ' dans ', ' avec ', ' on ', ' par ', ' il ', ' si ', ' ou ', ' est ', ' ils ', ' ont ', ' tag ',
                        ' &amp; ', ' quand ', ' elle ', ' le ', ' ce ', ' la ', ' lui ', ' cela ', ' ça ', ' ceci ', ' et ', ' tags ', ' elles '						
//fin							
                        );
                        $par = ' ';//les remplacer par un espace
                        $newtags = str_replace($remplace, $par, $newtags);
                        //espace de la liste des nouveaux tags + enregistrer
                        $newtags = trim($newtags, ' ');
                        $ads->setVar('ads_tags', $newtags);
                } else {
                        $ads->setVar('ads_tags', $_REQUEST['ads_tags']);
                }

                $ads->setVar('ads_video', $ads_video);
                $ads->setVar('uid', $uid);
                $ads->setVar('phone', $phone);
//ajout CPascalWeb - 12 novembre 2010 - option tel portable				
                $ads->setVar('phoneportable', $phoneportable);				
//fin				
                $ads->setVar('region', $region);
                $ads->setVar('departement', $departement);
                $ads->setVar('town', $town);
                if (isset($price)) {
                        $ads->setVar('price', $price);
                        $ads->setVar('monnaie', $monnaie);
                        $ads->setVar('price_option', $price_option);
                } else {
                        $ads->setVar('price', 0);
                        $ads->setVar('monnaie', '');
                        $ads->setVar('price_option', '');
                }
                if (isset($email))
                        $ads->setVar('email', $email);
                else
                        $ads->setVar('email', '');

                if (isset($codpost))
                        $ads->setVar('codpost', $codpost);
                else
                        $ads->setVar('codpost', '');
//modif CPascalWeb - 18 avril 2011 - correction bug annonces programmées
                //if ($xoopsModuleConfig['nb_days_before'] > 0 ) {
				if ($xoopsModuleConfig['allow_publish_date'] == 1 && $xoopsModuleConfig['nb_days_before'] > 0) {
                //ajout CPascalWeb - 18 avril 2011
				include_once XOOPS_ROOT_PATH.'/include/calendar.js';
				include_once XOOPS_ROOT_PATH.'/include/calendarjs.php';
//fin
                $now = getdate();
                $published = strtotime($published) + mktime($now['hours'], $now['minutes'], $now['seconds'], 1, 1, 1970);	
				} else {
                $published = time();
                }
                $ads->setVar('created', time());
                $ads->setVar('published', $published);
                $ads->setVar('expired', $published + $duration*86400);
                /*
                0 -> rien recevoir
                1 -> recevoir + message prive
                2 -> recevoir + email
                */
//modif CPascalWeb - 18 mai 2011 plus besoin envoi mail automatique	
                //envoyer email ou mp quand annonce expirée NE FONCTIONNE PAS !
                //if ($expired_mail_send == 0)
                  //      $ads->setVar('expired_mail_send', '0');
                //else
                  //      $ads->setVar('expired_mail_send', '1' + $expired_by_mode);
						
//////
				//if ( $ads->setVar('expired_mail_send') == 1 ){

				//}
/////										

                $ads->setVar('notify_pub', $notify_pub);
                $ads->setVar('poster_ip', $poster_ip);
                $ads->setVar('contact_mode', $mode_contact + $pref_contact);
                $ads->setVar('countpub', $xoopsModuleConfig['nb_pub_again']);
                $ads->setVar('waiting', $waiting);

                $nb_removed_tmp = catads_clear_tmp_files( $photos_dir ) ;
                if (!$ads_handler->insert($ads)) {
                        $msg = sprintf(_MD_CATADS_ERROR_INSERT, $ads->getVar('ads_title'));
                        $msg .= '<br />'.$ads->getErrors();
                        xoops_header();
                        echo "<h4>"._MD_CATADS_MODULE_NAME."</h4>";
                        xoops_error($msg);
                        xoops_footer();
                        exit();
                }
                // Notification
                $ads_id = $xoopsDB->getInsertId();
                //$notification_handler =& xoops_gethandler('notification');
                $notification_handler = xoops_gethandler('notification');	
				
                $tags = array();
                $tags['ADS_TITLE'] = $ads_type.' '.$ads_title;
				
				//contrôle ou non les annonces avant leurs parrutions	
                if ( $xoopsModuleConfig['moderated'] == 1) {

                        $tags['ADS_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/admin/ads.php?sel_status=1';
                        $notification_handler->triggerEvent('global', 0, 'ads_submit', $tags);
                        $notification_handler->triggerEvent('category', $topic_id, 'ads_submit', $tags);

                        if ($notify_pub) {
                            include_once XOOPS_ROOT_PATH . '/include/notification_constants.php';
                            //subscribe = inscrire dans les notifications
                            $notification_handler->subscribe('ads', $ads_id, 'approve', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE);
                        }
                        $messagesent ="<br />"._MD_CATADS_AFTER_MODERATE;

                } else {
                        //triggerEvent = Envoie par email
                        $tags['ADS_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/adslist.php?topic_id=' . $topic_id;
                        $notification_handler->triggerEvent('global', 0, 'new_ads', $tags);
                        $notification_handler->triggerEvent('category', $topic_id, 'new_ads', $tags);
                        $messagesent ="<br />"._MD_CATADS_NO_MODERATE;
                }
                redirect_header(XOOPS_URL."/modules/catads/index.php",2,$messagesent);
        break;

case "preview":
        $msgstop = '';
        $cat = new catadsCategory($topic_id);
        $photos_preview_dir = XOOPS_URL . "/uploads/".$xoopsModule->dirname()."/images/annonces/original" ;
        $thumb_preview_dir = XOOPS_URL . "/uploads/".$xoopsModule->dirname()."/images/annonces/thumb" ;

        $i = $j = 0;
        while  ($i < 6) {

                   if (!empty($_FILES['photo'.$i]['name'])) {
                        catads_upload($i);
                   }
                       if ($preview_name[$i] != '') {
                             $photo = $preview_name[$i] ;
                             $ads['photo'.$j] = "<img src=\"".$photos_preview_dir."/".$photo."\" width=\"125\" height=\"90\" alt=\"\" />" ;//a voir les dim
                             $j++;
                       } else {
                             $ads['photo'.$j] = '' ;
                             $j++;
                       }

                $i++;

        }

        if (strlen(deleteCode($ads_desc)) > $xoopsModuleConfig['txt_maxlength'] )
                $msgstop .= sprintf(_MD_CATADS_MAXLENGTH, $xoopsModuleConfig['txt_maxlength']).'<br />';
        if (isset($email) && $email != '' && !checkEmail($email) )
                $msgstop .= _MD_CATADS_INVALIDMAIL.'<br />';
        if (isset($price) && $price != '' && !is_numeric(trim($price) )) {
                $msgstop.= _MD_CATADS_INVALIDPRICE.'<br />';
                $price = '';
        }
        if ($mode_contact == 2 && $email == '')
                $msgstop .= _MD_CATADS_MAILREQ.'<br />';
        if ($mode_contact == 3 && $phone == '')
                $msgstop .= _MD_CATADS_PHONEREQ.'<br />';
	
        //$myts =& MyTextSanitizer::getInstance();
        $myts = MyTextSanitizer::getInstance();
		
        $ads_title= $myts->htmlSpecialChars($myts->stripSlashesGPC($ads_title));
        $ads_desc= $myts->HtmlSpecialChars($myts->stripSlashesGPC($ads_desc));
//si sa déconne mettre -> $ads_desc = $myts->undoHtmlSpecialChars($myts->stripSlashesGPC($ads_desc));
                if(!$ads_tags)
                {
                    //Créer des tags avec le titre de l'annonce
                    $newtags = $ads_title;
                    // supprimer les lettres et les mots commun de la liste des tags rappel: les espaces avant et après sont importants.
                    $remplace = array(
                    ' of ', ' if ', ' to ', ' in ', ' at ', ' on ', ' by ', ' it ', ' is ', ' or ', ' are ', ' the ', ' for ', ' and ',
                    ' &amp; ', ' when ', ' with ',
 //ajout CPascalWeb - liste en français						
                    ' de ', ' en ', ' pour ',  ' sur ', ' selon ', ' à ', ' a ',  ' sûr ', ' si ', ' te ', ' dans ', ' avec ', ' on ', ' par ', ' il ', ' si ', ' ou ', ' est ', ' ils ', ' ont ', ' tag ',
                    ' &amp; ', ' quand ', ' elle ', ' le ', ' ce ', ' la ', ' lui ', ' cela ', ' ça ', ' ceci ', ' et ', ' tags ', ' elles '						
//fin	                      
					   );
                        $par = ' ';//les remplacer par un espace
                        $newtags = str_replace($remplace, $par, $newtags);
                        //espace de la liste des nouveaux tags + enregistrer
                        $newtags = trim($newtags, ' ');
                        $ads_tags = $newtags;
                } else {
                        $ads_tags = $ads_tags;
                }

        $ads_tags = $myts->htmlSpecialChars($myts->stripSlashesGPC($ads_tags));
        $phone = $myts->htmlSpecialChars($myts->stripSlashesGPC($phone));
//ajout CPascalWeb - 12 novembre 2010 - option tel portable		
        $phoneportable = $myts->htmlSpecialChars($myts->stripSlashesGPC($phoneportable));		
//fin		
        //$region= $myts->htmlSpecialChars($myts->stripSlashesGPC($region));
        //$departement= $myts->htmlSpecialChars($myts->stripSlashesGPC($departement));
        $town= $myts->htmlSpecialChars($myts->stripSlashesGPC($town));
        if (isset($codpost)) {
            $codpost= $myts->htmlSpecialChars($myts->stripSlashesGPC($codpost));
            $ads['codpost']= $codpost;
        }

        $ads['type']= $ads_type;
        $ads['title']= $ads_title;
        $ads['description']= $myts->previewTarea($ads_desc);
        //$ads['region']= $region;

        //obtenir le nom de la région dans la base de données
        $region_number = $region;
        $sql1 = $xoopsDB->query("SELECT region_nom FROM ".$xoopsDB->prefix("catads_regions")." WHERE region_numero = ".$region_number);
        list($region_name) = $xoopsDB->fetchRow($sql1);
        $ads['region'] = $region_name;
        //$ads['departement']= $departement;

        //obtenir le nom du department dans la base de données
        $departement_number = $departement;
        $sql1 = $xoopsDB->query("SELECT departement_nom FROM ".$xoopsDB->prefix("catads_departements")." WHERE departement_numero = ".$departement_number);
        list($departement_name) = $xoopsDB->fetchRow($sql1);
        $ads['departement'] = $departement_name;

        $ads['town']= $town;
        //$ads['photo']= $photo;
        //$ads['photo'.$i]= $photo[$i]; - no effect
        $ads['video']= $ads_video;
        $ads['notify_pub'] = $notify_pub;

        if ($xoopsModuleConfig['nb_days_before'] > 0 ) {
            $ads['date_pub']= formatTimestamp(strtotime($published),"s");
            $ads['date_exp']= formatTimestamp(strtotime($published)+ $duration*86400,"s");
            $published = strtotime($published);
            $expired = strtotime($published) + $duration*86400;
        }
        $ads['nbview'] = sprintf(_MD_CATADS_NBVIEW, 0);

        if ($display_price){
            $ads['price']= $price;
            $ads['monnaie']= $monnaie;
            $ads['price_option']= $price_option;
        }

        if($pref_contact > 9){
            if ($mode_contact == 1)
                $ads['pmlink'] = "<br /><img src=\"".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/icon/mp_deco.png\" alt=\""._MD_CATADS_BYPM."\" /></a>";
            if ($mode_contact == 2)
                $ads['maillink'] = "<br /><img src=\"".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/icon/contacter.png\" alt=\""._MD_CATADS_BYMAIL."\" /></a>";
            if ($mode_contact == 3)
                $ads['phone'] = '<br /><b>'._MD_CATADS_PHONE.'</b>.<br /> '.$phone;
        } else {
                $ads['msg_contact'] = _MD_CATADS_CONTACT_PREF1.' '._MD_CATADS_BY.' ';
			//correction CPascalWeb - activer uniquement si membre		
		//if ($uid > 0)	//a voir !
            if ($mode_contact == 1) $ads['msg_contact'] .= _MD_CATADS_CONTACT_MODE1;//message privé
            if ($mode_contact == 2) $ads['msg_contact'] .= _MD_CATADS_CONTACT_MODE2;//email
            if ($mode_contact == 3) $ads['msg_contact'] .= _MD_CATADS_CONTACT_MODE3;//téléphone
                $ads['msg_contact'] .= '<br /><br />';
				
            if (isset($email) && $email !='')
                $ads['maillink'] = "<img src=\"".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/icon/contacter.png\" alt=\""._MD_CATADS_BYMAIL."\" /></a>&nbsp;";
            if ($xoopsUser)
                $ads['pmlink'] = "<img src=\"".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/icon/mp_deco.png\" alt=\""._MD_CATADS_BYPM."\" /></a><br /><br />";
            if ($phone!= '')
                $ads['phone'] = '<br /><b>'._MD_CATADS_PHONE.'</b><br /> '.$phone;
//ajout CPascalWeb - 12 novembre 2010 - option tel portable				
            if ($phoneportable!= '')
                $ads['phoneportable'] = '<br /><b>'._MD_CATADS_PHONEPORTABLE.'</b><br /> '.$phoneportable;				
//fin				
        }
        //nombre de colonne (ne fontionne pas) correction plus tard.
        // $ads['nbcols'] = $xoopsModuleConfig['nb_cols_img'];

		
//modif CPascalWeb - xoopsOption[template_main] doit être définis avant l'appel du header.php 		
        $xoopsOption['template_main'] = 'catads_adsform.tpl';		
        include  XOOPS_ROOT_PATH.'/header.php';
//fin	
        $xoopsTpl->assign('preview', true);
        $xoopsTpl->assign('msgstop',$msgstop);
        $xoopsTpl->assign('annonce', $ads);
        $xoopsTpl->assign('link_tags', $ads_tags);
        include_once "include/form_submit.php";
        $xoopsTpl->assign('nb_days_before', $xoopsModuleConfig['nb_days_before']);
        $adsform->assign($xoopsTpl);
        include XOOPS_ROOT_PATH."/footer.php";
        break;

case "form":
default:
        //$myts =& MyTextSanitizer::getInstance();
        $myts = MyTextSanitizer::getInstance();		
        $topic_id = (isset($topic_id)) ? intval($topic_id) : 0;
        //$cat = new catadsCategory($topic_id);
        //$lastchildren = catadsCategory::getAllLastChild();
        $lastchildren = $adsCatHandler->getAllLastChild();
   /* if ( $xoopsUser ) {
	if ( !$xoopsUser->isAdmin($xoopsModule->mid()) ) { 
	}
	} else {
	redirect_header(XOOPS_URL."/",3,_MD_CATADS_ONLY_MEMBERS);
	exit();
	}*/

		
		//permissions
        if (in_array($topic_id, $lastchildren)) {
        $permHandler = catadsPermHandler::getHandler();
        if(!$permHandler->isAllowed($xoopsUser, 'catads_submit', $topic_id))
        {
            redirect_header(XOOPS_URL."/modules/catads/index.php", 3, _MD_CATADS_ONLY_MEMBERS);//Désolé ! seuls les membres enregistrés peuvent déposer une annonce
            exit;
        }

//modif CPascalWeb - xoopsOption[template_main] doit être définis avant l'appel du header.php 		
                $xoopsOption['template_main'] = 'catads_adsform.tpl';	
                include XOOPS_ROOT_PATH."/header.php";
//fin			
                $xoopsTpl->assign('jstime', time());
                $xoopsTpl->assign('nb_days_before', $xoopsModuleConfig['nb_days_before']);

                include_once(XOOPS_ROOT_PATH."/class/xoopstree.php");
                $mytree = new XoopsTree($xoopsDB->prefix("catads_cat "),"topic_id","topic_pid");
                $display_price = $adsCatHandler->display_price;
                $uid = !empty($xoopsUser) ? $xoopsUser->getVar('uid') : 0;
                $email = !empty($xoopsUser) ? $xoopsUser->getVar("email", "E") : "";
                $ads_type = '';
                $ads_title = '';
                $ads_desc = '';
                $ads_tags = '';
                $monnaie = '';
                $price = '';
                $price_option = '';
                $phone = '';
//ajout CPascalWeb - 12 novembre 2010 - option tel portable				
                $phoneportable = '';				
//fin				
                $region = '';
                $departement = '';
                $town = '';
                $codpost = '';
                $notify_pub = 0 ;
                $pref_contact = 0;
//modif CPascalWeb - 18 mai 2011 plus besoin envoi mail automatique					
                //$expired_mail_send = 1 ;
                //$expired_by_mode = 1 ;
                /*if ($xoopsModuleConfig['email_req'] > 0) {
                        $mode_contact = 2;
                } elseif($uid > 0){
                        $mode_contact = 1;
                } else {
                        $mode_contact = 3;
                }*/
				
				// 0 => email obligatoire - 1 => email facultatif  
                if ($xoopsModuleConfig['email_req'] == 0) {
                        $mode_contact = 2;
                } elseif($uid > 0){
                        $mode_contact = 1;
                } else {
                        $mode_contact = 3;
                }
				
                $published = time();

                $duration =0;
                $i = 0;

                while  ($i < 6) {
                    $preview_name[$i] = '';
                    $i++;
                }

                include "include/form_submit.php";
                $adsform->assign($xoopsTpl);
                include XOOPS_ROOT_PATH."/footer.php";
                break;
        }else {
//modif CPascalWeb - xoopsOption[template_main] doit être définis avant l'appel du header.php + nouvelle page html		
                //$xoopsOption['template_main'] = 'catads_index.tpl';
				$xoopsOption['template_main'] = 'catads_soumettre.tpl';				
                include_once(XOOPS_ROOT_PATH."/header.php");
//fin			
                $tpltype = $xoopsModuleConfig['tpltype'];// 1 en lignes, 2 en colonnes
                $wcol = 100/$xoopsModuleConfig['nbcol'];
                //$show_card = 0;
                $nbcol = $xoopsModuleConfig['nbcol'];
                $xoopsTpl->assign('wcol', $wcol);
                $xoopsTpl->assign('tpltype', $tpltype);
                $xoopsTpl->assign('addads', true);
                //$xoopsTpl->assign('show_card', $show_card);
                $xoopsTpl->assign('nb_col_or_row', $nbcol);
                //$myts =& MyTextSanitizer::getInstance();
                $myts = MyTextSanitizer::getInstance();				
                if ($topic_id == 0) {
                    //$allcat =  catadsCategory::getAllCat(); // toutes les catégories
                    $allcat =  $adsCatHandler->getAllCat(); // toutes les catégories
                } else {
                    $mytree = new XoopsTree($xoopsDB->prefix("catads_cat "),"topic_id","topic_pid");
                    $cat_path = $mytree->getpathFromId( $topic_id, 'topic_title');
                    $cat_path = substr($cat_path, 1);
//modif CPascalWeb - 9 octobre 2010 - chemin image + alt & titre + nom sous catégorie et site supposé aider au référencement naturel		
					$cat_path = str_replace("/"," <img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/arrow.gif' border='0' title='". _MD_CATADS_NOM_REFERENCE .' '. $cat_path ."' alt='". _MD_CATADS_NOM_REFERENCE .' '. $cat_path .' '. $GLOBALS['xoopsConfig']['sitename'] ."' /> ",$cat_path);
//fin
                    $xoopsTpl->assign('cat_path', $cat_path);
				}
                //$parray = catadsCategory::getCatWithPid($topic_id); //array des objets catégories principales
                $parray = $adsCatHandler->getCatWithPid($topic_id); //array des objets catégories principales
                $pcount = count($parray);

                for ( $i = 0; $i < $pcount; $i++ ) {
                    $arr_cat = array();
                    $arr_scat = array();
                    $arr_subcat = array();
                    $cptsubcat = 0;
                    $topic_id = $parray[$i]->topic_id();
                    $title = $myts->htmlSpecialChars($parray[$i]->topic_title());
                    $arr_cat[$i]['title'] = $title;
                    $arr_cat[$i]['id'] = $topic_id;
                if (in_array($topic_id, $lastchildren)) {
                    $arr_cat[$i]['submit'] = XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/submit.php?topic_id=' . $topic_id;
                }
                if ( $parray[$i]->img() != 'blank.gif')
                {
                    $arr_cat[$i]['image'] = "<img src='".XOOPS_URL."/uploads/".$xoopsModule->dirname()."/images/categories/".$parray[$i]->img()."' style='vertical-align: middle;' alt='' />";
                }
                else
                {
//modif CPascalWeb image pasphotos.png + chemin							
                    //$arr_cat[$i]['image'] = "<img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/no_dispo_mini.gif' align='middle' alt='' />";
                    $arr_cat[$i]['image'] = "<img src='".XOOPS_URL."/uploads/".$xoopsModule->dirname()."/images/categories/pasphotos.png' style='vertical-align: middle;' alt='' />";
//fin
				}
                    $arr_cat[$i]['title'] = $title;
                    $arr_cat[$i]['i'] = $i;
                    $level = 0;
                    //$childcats =  catadsCategory::getFirstChildArr($topic_id, 'weight');
                    $childcats =  $adsCatHandler->getFirstChildArr($topic_id, 'weight');
                    unset($arr_scat);
                    showsubcat($childcats, 0, $topic_id, $topic_id);
                if ($tpltype == 1) {
                // ajout blocks vides si template en lignes
                    $mod = count($childcats) % $xoopsModuleConfig['nbcol'];
                    $adjust = ($mod > 0) ? $xoopsModuleConfig['nbcol'] - $mod : 0;
                for ( $j = 0; $j < $adjust; $j++ ) {
                    $cptsubcat++;
                    $arr_scat['newcol']=1;
                    array_push($arr_subcat, $arr_scat);
                    }
                } else {
                // calcul saut de ligne si template en colonnes
                    $mod = ($i+1) % $xoopsModuleConfig['nbcol'];
                    $arr_cat[$i]['newline'] = ($mod == 0) ? true : false;
                }
                //saut de ligne nombre de colonnes
					$arr_cat[$i]['subcat'] = $arr_subcat;
					$xoopsTpl->append('categories', $arr_cat[$i]);

                }
                unset($arr_cat);
                $mod = $pcount % $xoopsModuleConfig['nbcol'];
                $adjust = ($mod > 0) ? $xoopsModuleConfig['nbcol'] - $mod : 0;
                for ( $j = 0; $j < $adjust; $j++ ) {
                    $arr_cat[$j]['title'] = "";
                    $xoopsTpl->append('categories', $arr_cat[$j]);
                }
        }
		
//ajout option CPascalWeb - 24 novembre 2010 - afficher une bannières pub sur les pages principal du module
		$xoopsTpl->assign('aff_pub_general', $xoopsModuleConfig['aff_pub_general']);
		$xoopsTpl->assign('aff_pub_general_site', $xoopsModuleConfig['aff_pub_general_site']);
        if ( $xoopsModuleConfig['aff_pub_general'] == 1 ) {
            $xoopsTpl->assign('pub_general', $xoopsModuleConfig['aff_pub_general_code']);
        }
		//fil rss
		$link=sprintf("<a href='%s' title='%s'><img src='%s' border='0' alt='%s' /></a>",XOOPS_URL."/modules/".$xoopsModule->dirname()."/backend.php", _MD_CATADS_RSSFEED, XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/rss.gif",_MD_CATADS_RSSFEED);
		$xoopsTpl->assign('rssfeed_link',$link);
//fin		
        $xoopsTpl->assign("xoops_module_header", '<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/style.css" />');
        include XOOPS_ROOT_PATH."/footer.php";
        break;
}

?>