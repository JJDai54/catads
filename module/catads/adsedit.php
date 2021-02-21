<?php

include("../../mainfile.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/header.php");

foreach ($_POST as $k => $v) {
        if(preg_match('/delimg_/', $k)){
                $n = explode('_',$k);
                $del_img[$n[1]] = $v;
        } elseif (preg_match('/previewname_/', $k)){
                $n = explode('_',$k);
                $preview_name[$n[1]] = $v;
        } else {
                ${$k} = $v;
        }
}
foreach ($_GET as $k => $v) {${$k} = $v;}

//$ads_handler =& xoops_getmodulehandler('ads');
$ads_handler = xoops_getmodulehandler('ads');
$ads = $ads_handler->get($ads_id);
$topic_pid = $ads->getVar('cat_id');

$cat = new catadsCategory($topic_pid);

//verification annonceur
$uid = $ads->getVar('uid');
if (!$xoopsUser || $xoopsUser->getVar('uid') != $uid) {
        redirect_header(XOOPS_URL."/modules/catads/index.php",2,_NOPERM);
}

$ads_id =  isset($_POST['ads_id']) ? intval($_POST['ads_id']) : intval($_GET['ads_id']);

if ( isset($_POST['delete'])) $op = 'delete';
elseif ( isset($_POST['edit']) ) $op = 'edit';
elseif ( isset($_POST['post'])) $op = 'save';
elseif (!isset($op)) $op = 'show';

    switch ($op) {
    case "save":
        global $xoopsModuleConfig;
		//autoriser la modification des annonces
        if ($xoopsModuleConfig['usercanedit'] != 1) {
        redirect_header(XOOPS_URL."/modules/catads/index.php",2,_NOPERM);
        }
		
//ajout CPascalWeb - 4 mai 2011 - correction et ajout pour prendre en compte les modifs de l'annonceur
		
        $ads_handler = xoops_getmodulehandler('ads');		
        $ads = $ads_handler->get($ads_id);

        $ads->setVar('cat_id', $topic_id);
        $ads->setVar('pays', $pays);
        $ads->setVar('cat_id', $cat_id);
        $ads->setVar('ads_title', $ads_title);
        $ads->setVar('ads_type', $ads_type);
        $ads->setVar('ads_desc', $ads_desc);
        $ads->setVar('phone', $phone);
		$ads->setVar('phoneportable', $phoneportable);	
        $ads->setVar('region', $region);
        $ads->setVar('departement', $departement);
        $ads->setVar('town', $town);
        $ads->setVar('ads_video', $ads_video);
		
		if (isset($price)) {
        $ads->setVar('price', $price);
        $ads->setVar('monnaie', $monnaie);
        $ads->setVar('price_option', $price_option);
        }
        
		if (isset($email)) $ads->setVar('email', $email);
        
		if (isset($codpost)) $ads->setVar('codpost', $codpost);
		$ads->setVar('contact_mode', $pref_contact + $mode_contact);

		$uid = $ads->getVar('uid');
        $contact_mode = $ads->getVar('contact_mode');
        $notify_pub = $ads->getVar('notify_pub');
//modif CPascalWeb - 18 mai 2011 plus besoin envoi mail automatique	
        // (0=non, 1=oui PM, 2=oui Email)
       //$expired_mail_send = $ads->getVar('expired_mail_send');
//fin		
		
        $msgstop = '';
		if (isset($email) && $email != '' && !checkEmail($email)) $msgstop .= _MD_CATADS_INVALIDMAIL.'<br />';
	    if (strlen(deleteCode($ads_desc)) > $xoopsModuleConfig['txt_maxlength'] ) $msgstop .= sprintf(_MD_CATADS_MAXLENGTH.'<br />',$xoopsModuleConfig['txt_maxlength']);
        if (isset($price) && $price != '' && !is_numeric(trim($price))) $msgstop.= _MD_CATADS_INVALIDPRICE.'<br />';
//ajout option CPascalWeb - 4 mai 2011 - autoriser l'annonceur de modifier son adresse Email
        //if ($mode_contact == 2 && $email == '' ) $msgstop .= _MD_CATADS_MAILREQ.'<br />';		
        if ($mode_contact == 2 && $email == '' && $xoopsModuleConfig['modifmail']) $msgstop .= _MD_CATADS_MAILREQ.'<br />';
//fin		
        if ($mode_contact == 3 && $phone == '') $msgstop .= _MD_CATADS_PHONEREQ.'<br />';

        $notify_pub = isset($notify_pub) ? intval($notify_pub) : 0;

        if (!isset($region)) { $region = '00'; }
        if (!isset($departement)) { $departement = '00'; }

        if( $codpost )
        {
                $pays = 'FRANCE';
        } else {
                $pays = 'OTHER';
        }

        $i = 0;
        while  ($i < $cat->nb_photo) {
                if ( !empty($_FILES['photo'.$i]['name'])) {
                        catads_upload($i);
                }
                $i++;
        }

        if ( !empty($msgstop) ) {
                include  XOOPS_ROOT_PATH.'/header.php';
                $xoopsOption['template_main'] = 'catads_adsform.tpl';
                $xoopsTpl->assign('preview', true);
                $xoopsTpl->assign('msgstop',$msgstop);
                $i = 0;
                while  ($i < $cat->nb_photo) {
                        if ($ads->getVar('photo'.$i)) {
                                $photo[$i]= $ads->getVar('photo'.$i);
                        }
                        $i++;
                }
                include_once "include/form_modif_ads.php";
                $adsform->assign($xoopsTpl);
                include XOOPS_ROOT_PATH."/footer.php";
                exit();
        }

       /* if ($xoopsModuleConfig['moderated'] != 1)
        {
                $ads->setVar('pays', $pays);
                $ads->setVar('cat_id', $cat_id);
                $ads->setVar('ads_title', $ads_title);
                $ads->setVar('ads_type', $ads_type);
                $ads->setVar('ads_desc', $ads_desc);
                $ads->setVar('phone', $phone);
//ajout CPascalWeb - 12 novembre 2010 - option tel portable
				$ads->setVar('phoneportable', $phoneportable);	
//fin					
                $ads->setVar('region', $region);
                $ads->setVar('departement', $departement);
                $ads->setVar('town', $town);
                $ads->setVar('ads_video', $ads_video);
                // $ads->setVar('ads_tags', $ads_tags);*/
//ajout CPascalWeb - 4 mai 2011 si l'annonceur n'a pas entré de tags...
                if(!isset($_REQUEST['ads_tags'])? NULL : $_REQUEST['ads_tags']); 
                if ($_REQUEST['ads_tags'] == '')
                {
                        //a revoir trouver autre solution !!!
                        $newtags = $ads->getVar('ads_title');
                        // Omit common letters and words from the tag list. NB spaces before and after are important.
                        $remplace = array(
                        ' of ', ' if ', ' to ', ' in ', ' at ', ' on ', ' by ', ' it ', ' is ', ' or ', ' are ', ' the ', ' for ', ' and ',
                        ' &amp; ', ' when ', ' with ',
//ajout CPascalWeb - liste en français						
                        ' de ', ' en ', ' pour ',  ' sur ', ' selon ', ' à ', ' a ',  ' sûr ', ' si ', ' te ', ' dans ', ' avec ', ' on ', ' par ', ' il ', ' si ', ' ou ', ' est ', ' ils ', ' ont ', ' tag ',
                        ' &amp; ', ' quand ', ' elle ', ' le ', ' ce ', ' la ', ' lui ', ' cela ', ' ça ', ' ceci ', ' et ', ' tags ', ' elles '						
//fin							
                        );
                        $par = '';
                        $newtags = str_replace($remplace, $par, $newtags);
                        $newtags = trim($newtags, ' ');
                        $ads->setVar('ads_tags', $newtags);
                } else {
                        $ads->setVar('ads_tags', $_REQUEST['ads_tags']);
                }

                $poster_ip = $_SERVER['REMOTE_ADDR'];
                $ads->setVar('poster_ip', $poster_ip);
//modif CPascalWeb - 18 mai 2011 plus besoin envoi mail automatique	
                //envoyer email ou mp quand annonce expirée NE FONCTIONNE PAS !// essayer $ads->setVar('contact_mode', $pref_contact + $mode_contact);
               // if ($expired_mail_send == 0)
                               // $ads->setVar('expired_mail_send', '0');
                      //  else
                               // $ads->setVar('expired_mail_send', '1' + $expired_by_mode);

               /* if (isset($price)) {
                        $ads->setVar('price', $price);
                        $ads->setVar('monnaie', $monnaie);
                        $ads->setVar('price_option', $price_option);
                }
                if (isset($email)) $ads->setVar('email', $email);
                if (isset($codpost)) $ads->setVar('codpost', $codpost);
					$ads->setVar('contact_mode', $pref_contact + $mode_contact);*/
        //}

        $waiting = ($xoopsModuleConfig['moderated']) ? 1 : 0;
        $ads->setVar('waiting', $waiting);
        //$ads->setVar('notify_pub', 1);
        $i = 0;
        while  ($i < $cat->nb_photo) {
                $photo = '';

                if(isset($del_img[$i])) {
                        $filename = XOOPS_ROOT_PATH.'/uploads/'.$xoopsModule->dirname().'/images/annonces/original/'.$ads->getVar('photo'.$i);
                        unlink($filename);
                        $ads->setVar('photo'.$i, '');
                        if ($i == 0)
                        {
                                $ads->setVar('thumb', '');
                        }
                } elseif ($preview_name[$i] != '') {
                        $photo = str_replace('tmp_', 'img_',$preview_name[$i]);
                        $photos_dir = XOOPS_ROOT_PATH . '/uploads/'.$xoopsModule->dirname().'/images/annonces/original/' ;
                        rename( $photos_dir.$preview_name[$i] , $photos_dir.$photo ) ;
                        if ( $i == 0 )
                        {
                                //Thumb (a revoir avec l'optimisation au-dessus)
                                $image = XOOPS_ROOT_PATH . "/uploads/".$xoopsModule->dirname()."/images/annonces/original/".$photo;
                                $thumb = str_replace('tmp_', 'thumb_',$preview_name[$i]);
                                $thumb_dir = XOOPS_ROOT_PATH . "/uploads/".$xoopsModule->dirname()."/images/annonces/thumb/".$thumb;
                                //echo "thumb = ".$thumb;

                                if (!file_exists($thumb_dir))
                                        if (!resize_image($image, $thumb_dir, $xoopsModuleConfig['thumb_width'], $xoopsModuleConfig['thumb_method']))
                                                return false;

                                $ads->setVar('thumb', $thumb);
                        }
                if ($preview_name[$i] != $ads->getVar('photo'.$i)) {
                        $filename = XOOPS_ROOT_PATH.'/uploads/'.$xoopsModule->dirname().'/images/annonces/original/'.$ads->getVar('photo'.$i);
                        unlink($filename);
                }
                $ads->setVar('photo'.$i, $photo);
                }
        $i++;
        }

        if (!$ads_handler->insert($ads)) {
                $msg = sprintf(_MD_CATADS_ERROR_UPDATE, $ads->getVar('ads_title'));//Erreur de mise à jour de votre annonce
                $msg .= '<br />'.$ads->getErrors();
                xoops_header();
                xoops_error($msg);
                xoops_footer();
                exit();
        }

//notification
        $ads_type = $ads->getVar('ads_type');
        $ads_title = $ads->getVar('ads_title');
        //$notification_handler =& xoops_gethandler('notification');
        $notification_handler = xoops_gethandler('notification');		
        $tags = array();
        $tags['ADS_TITLE'] = $ads_type.' '.$ads_title;
        //if ( $xoopsModuleConfig['moderated'] == 1)
        //{
		
                $tags['ADS_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/admin/index.php?sel_status=2';
				//triggerEvent = Envoie par email
                $notification_handler->triggerEvent('global', 0, 'ads_edit', $tags);
                //$notification_handler->triggerEvent('category', $cat_id, 'ads_edit', $tags);
                $notification_handler->triggerEvent('ads', $ads_id, 'ads_edit', $tags);

                if ($notify_pub) {
                        include_once XOOPS_ROOT_PATH . '/include/notification_constants.php';
                        //subscribe = s'inscrire dans les notifications
                        $notification_handler->subscribe('ads', $ads_id, 'approve', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE);
                }
        //}

        redirect_header(XOOPS_URL."/modules/catads/adsitem.php?ads_id=".$ads_id,2,_MD_CATADS_NOERROR_UPDATE);//Mise à jour effectuée
        exit();
        break;

    case "edit":
        default:
		////Autoriser la modification des annonces 
        if ($xoopsModuleConfig['usercanedit'] != 1) {
                redirect_header(XOOPS_URL."/modules/catads/index.php",2,_NOPERM);
        }
                $published = $ads->getVar('published');
                $expired = $ads->getVar('expired');
                $created = $ads->getVar('created');
                $cat_id = $ads->getVar('cat_id');
                $ads_type = $ads->getVar('ads_type');
                $ads_title = $ads->getVar('ads_title');
                $ads_desc = $ads->getVar('ads_desc');
                $ads_tags = $ads->getVar('ads_tags');
                $ads_video = $ads->getVar('ads_video');
                $price = ($ads->getVar('price') > 0) ? $ads->getVar('price') : '';
                $monnaie = $ads->getVar('monnaie');
                $price_option = $ads->getVar('price_option');
                $email = $ads->getVar('email');
                $phone = $ads->getVar('phone');
//ajout CPascalWeb - 12 novembre 2010 - option tel portable
                $phoneportable = $ads->getVar('phoneportable');
//fin					
                $town = $ads->getVar('town');
                $region = $ads->getVar('region');
                $departement = $ads->getVar('departement');
                $codpost = $ads->getVar('codpost');
                $uid = $ads->getVar('uid');
                $contact_mode = $ads->getVar('contact_mode');
                $notify_pub = $ads->getVar('notify_pub');
//modif CPascalWeb - 18 mai 2011 plus besoin envoi mail automatique	
                //(0=non, 1=oui PM, 2=oui Email)
               // $expired_mail_send = $ads->getVar('expired_mail_send');
		
		/*if ( $expired_mail_send == 0 )
		{
			$expired_mail_send = 0;
		} else {
			$expired_mail_send = 1;
		}*/

//modif CPascalWeb - 18 mai 2011 plus besoin envoi mail automatique	
//$expired_by_mode = //Être informer de l'expiration de l'annonce
//'0'=>//par message privé
//'1'=>//par email
              /*  if ($expired_mail_send == 1 ){
                        $expired_mail_send = 1 ;
                        $expired_by_mode = 0 ;
                } else if($expired_mail_send == 2){
                        $expired_mail_send = 1 ;
                        $expired_by_mode = 1 ;
                } else {
                        $expired_mail_send = 0 ;
                        $expired_by_mode = 0 ;
                }
*/


                if($contact_mode > 9){
                        $mode_contact = $contact_mode - 10;
                        $pref_contact = 10;
                } else {
                        $mode_contact = $contact_mode;
                        $pref_contact = 0;
                }

                $i = 0;
                while  ($i < 6) {
                        $preview_name[$i] = '';
                        if ($ads->getVar('photo'.$i)) {
                                $photo[$i]= $ads->getVar('photo'.$i);
                        }
                        $i++;
                }

                $xoopsOption['template_main'] = 'catads_adsform2.tpl';
                include_once(XOOPS_ROOT_PATH."/header.php");
                include "include/form_modif_ads.php";
                $adsform->assign($xoopsTpl);
                include XOOPS_ROOT_PATH."/footer.php";
    break;

				
    case "delete":
        if (!$xoopsModuleConfig['usercandelete']) {
               redirect_header(XOOPS_URL."/modules/catads/index.php",2,_NOPERM);
        }
        $ok =  isset($_POST['ok']) ? intval($_POST['ok']) : 0;
//ajout CPascalWeb - 29 avril 2011 - variable pour envoi Email de confirmation		
		$ads_title = $ads->getVar('ads_title');
		$uid = $ads->getVar('uid');
//fin
    if ( $ok == 1 ) {
                // cache
                include_once XOOPS_ROOT_PATH."/class/xoopsblock.php";
                include_once XOOPS_ROOT_PATH.'/class/template.php';
                xoops_template_clear_module_cache($xoopsModule->getVar('mid'));
                $i=0;
                while ($i < 6){
                        if ($ads->getVar('photo'.$i)) {
                                $filename = XOOPS_ROOT_PATH.'/uploads/'.$xoopsModule->dirname().'/images/annonces/original/'.$ads->getVar('photo'.$i);
                                unlink($filename);
                        }
                        $i++;
                }

                $del_ads_ok = $ads_handler->delete($ads);
                if ($del_ads_ok){
                        //supprime les commentaires
                        xoops_comment_delete($xoopsModule->getVar('mid'), $ads_id);
                        //supprime les notifications
                        xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'ads', $ads_id);
                        $messagesent = _MD_CATADS_ADSDELETED;
//ajout CPascalWeb - 29 avril 2011 - envoi Email d'information a l'annonceur lorsque une annonce est supprimé !!!RAPPEL BUG MINEUR ENVOI EMAIL AVANT DE VALIDER		
					global $xoopsDB, $xoopsConfig, $xoopsUser;
					//récupéré le nom de l'annonceur
					$sql2 = $xoopsDB->query("SELECT uname FROM ".$xoopsDB->prefix("users")." WHERE uid = ".$uid);
					list($uname) = $xoopsDB->fetchRow($sql2);					
					
						$mail_url_ads = "<a href='".XOOPS_URL."/modules/catads/adsitem.php?ads_id=".$ads_id."'>".$ads_title."</a>";
						
						$mail_msg_text =  str_replace("{X_UNAME}", $uname, _MD_CATADS_MAIL_UID_ADSSUPP_TEXT);
						$mail_msg_text2 = str_replace("{X_ADS_TITLE}", $ads_title, $mail_msg_text);
						$mail_msg_text3 = str_replace("{X_ADS}", $mail_url_ads, $mail_msg_text2);
						$mail_msg_text4 = str_replace("{X_SITEURL}", XOOPS_URL, $mail_msg_text3);
						$mail_msg_text5 = str_replace("{X_ADMINMAIL}", $xoopsConfig['adminmail'], $mail_msg_text4);
						$mail_msg_text6 = str_replace("{X_SITENAME}", $xoopsConfig['sitename'], $mail_msg_text5);
						$mail_msg = $mail_msg_text6;
						
						include_once XOOPS_ROOT_PATH."/class/xoopsmailer.php";
						$email= $ads->getVar("email", "E");

						$xoopsMailer = getMailer();
						$xoopsMailer->useMail();
						$xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
						$xoopsMailer->setFromName($xoopsConfig['sitename']);
						$xoopsMailer->setToEmails($email);
						$xoopsMailer->setSubject(_MD_CATADS_MAIL_UID_ADSSUPP_TITLE);
						$xoopsMailer->setBody($mail_msg);
						$xoopsMailer->usePM();
						$xoopsMailer->multimailer->isHTML(true);//encodage html
						$xoopsMailer->send();
						$xoopsMailer->getErrors();	
				
						//pour eviter que le mail soit a nouveau envoyer
						//$sql = "UPDATE ". $xoopsDB->prefix('catads_ads')." SET published = '0' WHERE ads_id = ".$ads_id;
				    	//$result = $xoopsDB->queryF($sql);							
                } else {
                        $messagesent = _MD_CATADS_ERRORDEL;
                }
                redirect_header(XOOPS_URL."/modules/catads/adsuserlist.php?uid=".$uid, 2, $messagesent);
        } else {
                include(XOOPS_ROOT_PATH."/header.php");
                xoops_confirm(array('op' => 'delete', 'ads_id' => $ads_id, 'uid' => $uid, 'ok' => 1), XOOPS_URL.'/modules/catads/adsedit.php', _MD_CATADS_CONF_DEL);
                include(XOOPS_ROOT_PATH."/footer.php");
        }
					
    break;
}

?>