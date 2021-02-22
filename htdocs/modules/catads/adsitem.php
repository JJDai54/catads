<?php

include "header.php";
include("../../mainfile.php");
//ajout CPascalWeb - 11 octobre 2010
include_once(XOOPS_ROOT_PATH."/class/userutility.php");
include_once(XOOPS_ROOT_PATH."/include/functions.php");
//fin
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/include/functions.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/option.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/cat.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/class/permissions.php");

global $xoopsUser;

foreach ($_POST as $k => $v) {${$k} = $v;}
foreach ($_GET as $k => $v) {${$k} = $v;}

//if (isset($_GET['id'])) $ads_id = $id;
/*$ads_handler = & xoops_getmodulehandler('ads');
$ads = & $ads_handler->get($ads_id);*/
$ads_handler = xoops_getmodulehandler('ads');
$ads = $ads_handler->get($ads_id);

if (!is_object($ads)) {
        redirect_header(XOOPS_URL."/modules/catads/index.php",3,_MD_CATADS_NO_EXIST);
        exit();
}

//non publiée ou expirée, et admin ou auteur
$ads_exist = false;
$poster_id = $ads->getVar('uid');
if ($xoopsUser) {
        if ($xoopsUser->getVar('uid') == $poster_id) {
                $isAuthor = true;
                $ads_exist = true;
        } elseif ($xoopsUser->isAdmin($xoopsModule->getVar('mid'))) {
                $isAdmin = true;
                $ads_exist = true;
        }
	} else {
        $isAuthor = false;
        $isAdmin = false;
	}

//ajout de contrôle des autorisations catégories 
        $topic_id = $ads->getVar('cat_id');
        $permHandler = catadsPermHandler::getHandler();
        if(!$permHandler->isAllowed($xoopsUser, 'catads_access', $topic_id))
        {
            redirect_header(XOOPS_URL."/modules/catads/index.php", 3, _NOPERM);
            exit;
        }

if ($ads->getVar('waiting') == 0 && $ads->getVar('expired') > time())
        $ads_exist = true;

//annonce existe mais non disponible
$messagesent = _MD_CATADS_NO_ADS;

if($ads->getVar('expired') < time())
        $messagesent .= _MD_CATADS_NO_ADS_E;//(L'annonce est expirée)
elseif($ads->getVar('published') > time())
        $messagesent .= sprintf(_MD_CATADS_NO_ADS_P, formatTimestamp($ads->getVar('published'),'s'));//(L'annonce va être publié le %s)")
elseif ($ads->getVar('waiting') > 0)
        $messagesent .= _MD_CATADS_NO_ADS_W;//(L'annonce est en attente de validation)");

if (!$ads_exist) {
        redirect_header(XOOPS_URL."/modules/catads/index.php",4, $messagesent);
        exit();
}

//publier à nouveau une annonce 
function pubagain() {
        global $ads, $ads_handler, $xoopsModuleConfig, $duration, $isAuthor;

        $ads_id = $ads->getVar('ads_id');
        $ok =  isset($_POST['ok']) ? intval($_POST['ok']) : 0;
        //$option_handler = & xoops_getmodulehandler('option');
        $option_handler = xoops_getmodulehandler('option');		

        if ( $ok == 1 && $isAuthor) {
                if(!$option_handler->optionIsValid($duration, 4)) {
                        //rappel: en cas de tentative interdite
                        redirect_header(XOOPS_URL."/modules/catads/adsitem.php?ads_id=".$ads_id, 3, _MD_CATADS_PUB_INTERDIT);
                        exit;
                }
                // obtenir la valeur countpub 
                $countpub = $ads->getVar('countpub')- 1 ;
                $expired = time() + $duration*86400;
                $ads->setVar('expired', $expired);
                // mis en valeur de nouvelles countpub 
                $ads->setVar('countpub', $countpub);
                $update_ads_ok = $ads_handler->insert($ads);

                if ($update_ads_ok){
                        $messagesent = sprintf(_MD_CATADS_PUBAGAIN_OK, $duration);//Votre annonce a été prolongée de x jours
                } else {
                        $messagesent = _MD_CATADS_UPDATE_ERROR;
                }
                redirect_header(XOOPS_URL."/modules/catads/adsitem.php?ads_id=".$ads_id, 3, $messagesent);
        } else {
                xoops_confirm(array('op' => 'pubagain', 'ads_id' => $ads_id, 'duration' => $duration, 'ok' => 1), XOOPS_URL."/modules/catads/adsitem.php", _MD_CATADS_PUBAGAIN_CONF);//Voulez-vous publier à nouveau cette annonce ?
        }
}

//suspendre et réactivé la publication de l'annonce par l'annonceur 
function stopandgo() {
        global $xoopsUser, $ads, $ads_handler, $xoopsConfig, $xoopsDB;

        $uid = $ads->getVar('uid');
        if (!$xoopsUser || $xoopsUser->getVar('uid') != $uid) {
                redirect_header(XOOPS_URL."/modules/catads/index.php",1,_NOPERM);
        }
        $ads_id = $ads->getVar('ads_id');
//ajout CPascalWeb - 29 avril 2011 - variable pour envoi Email de confirmation		
		$ads_title = $ads->getVar('ads_title');
//fin		
        $ok =  isset($_POST['ok']) ? intval($_POST['ok']) : 0;

    if ($ads->getVar('suspend') == 0) {
        //suspendre
            $msgconf = _MD_CATADS_PUBSTOP_CONF;
            $msgok = _MD_CATADS_PUBSTOP_OK;
            $suspend = 1;
    } else {
        //reprendre
                $msgconf = _MD_CATADS_PUBGO_CONF;
                $msgok = _MD_CATADS_PUBGO_OK;
                $suspend = 0;
    }
    if ( $ok == 1 ) {
                $ads->setVar('suspend', $suspend);
                $update_ads_ok = $ads_handler->insert($ads);
                if ($update_ads_ok){
                        $messagesent = $msgok;
//ajout CPascalWeb - 29 avril 2011 - envoi Email de confirmation lors de la suspension par l'annonceur	
	if ($suspend == 1) {
					
					//récupéré le nom de l'annonceur
					$sql2 = $xoopsDB->query("SELECT uname FROM ".$xoopsDB->prefix("users")." WHERE uid = ".$uid);
					list($uname) = $xoopsDB->fetchRow($sql2);
			
					//Envoie par email
						$mail_url_ads = "<a href='".XOOPS_URL."/modules/catads/adsitem.php?ads_id=".$ads_id."'>".$ads_title."</a>";
						
						$mail_msg_text =  str_replace("{X_UNAME}", $uname, _MD_CATADS_MAIL_SUSP_TEXT);
						$mail_msg_text2 = str_replace("{X_ADS_TITLE}", $ads_title, $mail_msg_text);
						$mail_msg_text3 = str_replace("{X_ADS}", $mail_url_ads, $mail_msg_text2);
						$mail_msg_text4 = str_replace("{X_SITEURL}", XOOPS_URL, $mail_msg_text3);
						$mail_msg_text5 = str_replace("{X_ADMINMAIL}", $xoopsConfig['adminmail'], $mail_msg_text4);
						$mail_msg_text6 = str_replace("{X_SITENAME}", $xoopsConfig['sitename'], $mail_msg_text5);
						$mail_msg = $mail_msg_text6;
						
						include_once XOOPS_ROOT_PATH."/class/xoopsmailer.php";
						$email= $ads->getVar("email", "E");

						//$xoopsMailer =& getMailer();
						//$xoopsMailer = xoops_getMailer();
						$xoopsMailer = getMailer();
						$xoopsMailer->useMail();
						$xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
						$xoopsMailer->setFromName($xoopsConfig['sitename']);
						$xoopsMailer->setToEmails($email);
						$xoopsMailer->setSubject(_MD_CATADS_MAIL_SUSP_TITLE);
						$xoopsMailer->setBody($mail_msg);
						$xoopsMailer->usePM();
						$xoopsMailer->multimailer->isHTML(true);//encodage html
						$xoopsMailer->send();
						$xoopsMailer->getErrors();	
				
						//chercher les annonces
						//$sql = "UPDATE ". $xoopsDB->prefix('catads_ads')." SET suspend = '0' WHERE ads_id = ".$ads_id;
						//$result = $xoopsDB->queryF($sql);			
	}
//ajout CPascalWeb - 29 avril 2011 - envoi Email de confirmation lorsque l'annonceur réactive son annonce				
	elseif ($suspend == 0) {
					//récupéré le nom de l'annonceur
					$sql2 = $xoopsDB->query("SELECT uname FROM ".$xoopsDB->prefix("users")." WHERE uid = ".$uid);
					list($uname) = $xoopsDB->fetchRow($sql2);
					
					//Envoie par email
						$mail_url_ads = "<a href='".XOOPS_URL."/modules/catads/adsitem.php?ads_id=".$ads_id."'>".$ads_title."</a>";
						
						$mail_msg_text =  str_replace("{X_UNAME}", $uname, _MD_CATADS_MAIL_REACT_TEXT);
						$mail_msg_text2 = str_replace("{X_ADS_TITLE}", $ads_title, $mail_msg_text);
						$mail_msg_text3 = str_replace("{X_ADS}", $mail_url_ads, $mail_msg_text2);
						$mail_msg_text4 = str_replace("{X_SITEURL}", XOOPS_URL, $mail_msg_text3);
						$mail_msg_text5 = str_replace("{X_ADMINMAIL}", $xoopsConfig['adminmail'], $mail_msg_text4);
						$mail_msg_text6 = str_replace("{X_SITENAME}", $xoopsConfig['sitename'], $mail_msg_text5);
						$mail_msg = $mail_msg_text6;
						
						include_once XOOPS_ROOT_PATH."/class/xoopsmailer.php";
						$email= $ads->getVar("email", "E");

						//$xoopsMailer =& getMailer();
						//$xoopsMailer = xoops_getMailer();
						$xoopsMailer = getMailer();
						$xoopsMailer->useMail();
						$xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
						$xoopsMailer->setFromName($xoopsConfig['sitename']);
						$xoopsMailer->setToEmails($email);
						$xoopsMailer->setSubject(_MD_CATADS_MAIL_REACT_TITLE);
						$xoopsMailer->setBody($mail_msg);
						$xoopsMailer->usePM();
						$xoopsMailer->multimailer->isHTML(true);//encodage html
						$xoopsMailer->send();
						$xoopsMailer->getErrors();	
				
						//chercher les annonces
						//$sql = "UPDATE ". $xoopsDB->prefix('catads_ads')." SET suspend = '1' WHERE ads_id = ".$ads_id;
						//$result = $xoopsDB->queryF($sql);			
	}				
//fin			
                } else {
                        $messagesent = _MD_CATADS_UPDATE_ERROR;
                }
                redirect_header(XOOPS_URL."/modules/catads/adsitem.php?ads_id=".$ads_id, 3, $messagesent);
    } else {
                xoops_confirm(array('op' => 'stopandgo', 'ads_id' => $ads_id, 'ok' => 1), XOOPS_URL.'/modules/catads/adsitem.php', $msgconf);
    }
}

//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce par l'admin
function suspendrereactiver() {

        global $xoopsUser, $isAdmin, $ads, $ads_handler, $xoopsDB, $xoopsConfig;
//ajout CPascalWeb - 29 avril 2011 - variable pour envoi Email de confirmation		
		$ads_title = $ads->getVar('ads_title');
		$uid = $ads->getVar('uid');
//fin	
        $ads_id = $ads->getVar('ads_id');
        $ok =  isset($_POST['ok']) ? intval($_POST['ok']) : 0;

        if ($ads->getVar('suspendadmin') == 0) {
        //suspendre
                $msgconf = _MD_CATADS_PUBADMINSTOP_CONF;
                $msgok = _MD_CATADS_PUBADMINSTOP_OK;
                $suspendadmin = 1;
		} else {
        //reprendre
                $msgconf = _MD_CATADS_PUBADMINGO_CONF;
                $msgok = _MD_CATADS_PUBADMINGO_OK;
                $suspendadmin = 0;
        }
    if ( $ok == 1 ) {
                $ads->setVar('suspendadmin', $suspendadmin);
                $update_ads_ok = $ads_handler->insert($ads);

                if ($update_ads_ok){
                        $messagesent = $msgok;
//ajout CPascalWeb - 29 avril 2011 - envoi Email de confirmation lors de la suspension par l'administrateur/site
	if ($suspendadmin == 1) {

					//récupéré le nom de l'annonceur
					$sql2 = $xoopsDB->query("SELECT uname FROM ".$xoopsDB->prefix("users")." WHERE uid = ".$uid);
					list($uname) = $xoopsDB->fetchRow($sql2);					
					
						$mail_url_ads = "<a href='".XOOPS_URL."/modules/catads/adsitem.php?ads_id=".$ads_id."'>".$ads_title."</a>";
						
						$mail_msg_text =  str_replace("{X_UNAME}", $uname, _MD_CATADS_MAIL_SUSPADMIN_TEXT);
						$mail_msg_text2 = str_replace("{X_ADS_TITLE}", $ads_title, $mail_msg_text);
						$mail_msg_text3 = str_replace("{X_ADS}", $mail_url_ads, $mail_msg_text2);
						$mail_msg_text4 = str_replace("{X_SITEURL}", XOOPS_URL, $mail_msg_text3);
						$mail_msg_text5 = str_replace("{X_ADMINMAIL}", $xoopsConfig['adminmail'], $mail_msg_text4);
						$mail_msg_text6 = str_replace("{X_SITENAME}", $xoopsConfig['sitename'], $mail_msg_text5);
						$mail_msg = $mail_msg_text6;
						
						include_once XOOPS_ROOT_PATH."/class/xoopsmailer.php";
						$email= $ads->getVar("email", "E");

						//$xoopsMailer =& getMailer();
						//$xoopsMailer = xoops_getMailer();
						$xoopsMailer = getMailer();
						$xoopsMailer->useMail();
						$xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
						$xoopsMailer->setFromName($xoopsConfig['sitename']);
						$xoopsMailer->setToEmails($email);
						$xoopsMailer->setSubject(_MD_CATADS_MAIL_SUSPADMIN_TITLE);
						$xoopsMailer->setBody($mail_msg);
						$xoopsMailer->usePM();
						$xoopsMailer->multimailer->isHTML(true);//encodage html
						$xoopsMailer->send();
						$xoopsMailer->getErrors();	
				
						//chercher les annonces suspendu
						//$sql = "UPDATE ". $xoopsDB->prefix('catads_ads')." SET suspendadmin = '0' WHERE ads_id = ".$ads_id;
				    	//$result = $xoopsDB->queryF($sql);	
	}	
//ajout CPascalWeb - 29 avril 2011 - envoi Email de confirmation lors de la réactivation d'une annonce par l'administrateur/site
	elseif ($suspendadmin == 0) {

					//récupéré le nom de l'annonceur
					$sql2 = $xoopsDB->query("SELECT uname FROM ".$xoopsDB->prefix("users")." WHERE uid = ".$uid);
					list($uname) = $xoopsDB->fetchRow($sql2);
					
					//Envoie par email
						$mail_url_ads = "<a href='".XOOPS_URL."/modules/catads/adsitem.php?ads_id=".$ads_id."'>".$ads_title."</a>";
						
						$mail_msg_text =  str_replace("{X_UNAME}", $uname, _MD_CATADS_MAIL_REACTADMIN_TEXT);
						$mail_msg_text2 = str_replace("{X_ADS_TITLE}", $ads_title, $mail_msg_text);
						$mail_msg_text3 = str_replace("{X_ADS}", $mail_url_ads, $mail_msg_text2);
						$mail_msg_text4 = str_replace("{X_SITEURL}", XOOPS_URL, $mail_msg_text3);
						$mail_msg_text5 = str_replace("{X_ADMINMAIL}", $xoopsConfig['adminmail'], $mail_msg_text4);
						$mail_msg_text6 = str_replace("{X_SITENAME}", $xoopsConfig['sitename'], $mail_msg_text5);
						$mail_msg = $mail_msg_text6;
						
						include_once XOOPS_ROOT_PATH."/class/xoopsmailer.php";
						$email= $ads->getVar("email", "E");

						//$xoopsMailer =& getMailer();
						//$xoopsMailer = xoops_getMailer();
						$xoopsMailer = getMailer();
						$xoopsMailer->useMail();
						$xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
						$xoopsMailer->setFromName($xoopsConfig['sitename']);
						$xoopsMailer->setToEmails($email);
						$xoopsMailer->setSubject(_MD_CATADS_MAIL_REACTADMIN_TITLE);
						$xoopsMailer->setBody($mail_msg);
						$xoopsMailer->usePM();
						$xoopsMailer->multimailer->isHTML(true);//encodage html
						$xoopsMailer->send();
						$xoopsMailer->getErrors();	
				
						//chercher les annonces suspendu
						//$sql = "UPDATE ". $xoopsDB->prefix('catads_ads')." SET suspendadmin = '1' WHERE ads_id = ".$ads_id;
						//$result = $xoopsDB->queryF($sql);			
	}				
//fin							
                } else {
                        $messagesent = _MD_CATADS_UPDATE_ERROR;
                }
                redirect_header(XOOPS_URL."/modules/catads/adsitem.php?ads_id=".$ads_id, 3, $messagesent);
        } else {
                xoops_confirm(array('op' => 'suspendrereactiver', 'ads_id' => $ads_id, 'ok' => 1), XOOPS_URL."/modules/catads/adsitem.php", $msgconf);
        }
}
//fin de l'ajout

//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse RAPPEL AJOUTER UN COMPTAGE + ENREGISTREMENT IP
function signalementannonce() {

        global $xoopsUser, $isAdmin, $ads, $ads_handler, $xoopsDB, $xoopsConfig;
//ajout CPascalWeb - 29 avril 2011 - variable pour envoi Email de confirmation		
		$ads_title = $ads->getVar('ads_title');
		$uid = $ads->getVar('uid');
//fin
        $ads_id = $ads->getVar('ads_id');
        $ok =  isset($_POST['ok']) ? intval($_POST['ok']) : 0;

        if ($ads->getVar('signalementannonce') == 0) {
        //signalé cette annonce comme suspecte
                $msgconf = _MD_CATADS_DECLARFRAUDE_CONF;
                $msgok = _MD_CATADS_DECLARFRAUDE_OK;
                $signalementannonce = 1;
	   } else {
        //déclarer cette annonce non suspecte
                $msgconf = _MD_CATADS_DECLARNOFRAUDE_CONF;
                $msgok = _MD_CATADS_DECLARNOFRAUDE_OK;
                $signalementannonce = 0;
        }
    if ( $ok == 1 ) {
                $ads->setVar('signalementannonce', $signalementannonce);
                $update_ads_ok = $ads_handler->insert($ads);
            if ($update_ads_ok){
                    $messagesent = $msgok;
//ajout CPascalWeb - 29 avril 2011 - envoi Email d'information a l'annonceur lorsque une annonce est signaler suspect
	if ($signalementannonce == 1) {

					//global $xoopsDB, $xoopsConfig, $xoopsUser;
					//récupéré le nom de l'annonceur
					$sql2 = $xoopsDB->query("SELECT uname FROM ".$xoopsDB->prefix("users")." WHERE uid = ".$uid);
					list($uname) = $xoopsDB->fetchRow($sql2);					
					
						$mail_url_ads = "<a href='".XOOPS_URL."/modules/catads/adsitem.php?ads_id=".$ads_id."'>".$ads_title."</a>";
						
						$mail_msg_text =  str_replace("{X_UNAME}", $uname, _MD_CATADS_MAIL_ADSSUSPECT_TEXT);
						$mail_msg_text2 = str_replace("{X_ADS_TITLE}", $ads_title, $mail_msg_text);
						$mail_msg_text3 = str_replace("{X_ADS}", $mail_url_ads, $mail_msg_text2);
						$mail_msg_text4 = str_replace("{X_SITEURL}", XOOPS_URL, $mail_msg_text3);
						$mail_msg_text5 = str_replace("{X_ADMINMAIL}", $xoopsConfig['adminmail'], $mail_msg_text4);
						$mail_msg_text6 = str_replace("{X_SITENAME}", $xoopsConfig['sitename'], $mail_msg_text5);
						$mail_msg = $mail_msg_text6;
						
						include_once XOOPS_ROOT_PATH."/class/xoopsmailer.php";
						$email= $ads->getVar("email", "E");

						//$xoopsMailer =& getMailer();
						//$xoopsMailer = xoops_getMailer();
						$xoopsMailer = getMailer();
						$xoopsMailer->useMail();
						$xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
						$xoopsMailer->setFromName($xoopsConfig['sitename']);
						$xoopsMailer->setToEmails($email);
						$xoopsMailer->setSubject(_MD_CATADS_MAIL_ADSSUSPECT_TITLE);
						$xoopsMailer->setBody($mail_msg);
						$xoopsMailer->usePM();
						$xoopsMailer->multimailer->isHTML(true);//encodage html
						$xoopsMailer->send();
						$xoopsMailer->getErrors();	
				
						//chercher les annonces signaler
						//$sql = "UPDATE ". $xoopsDB->prefix('catads_ads')." SET signalementannonce = '0' WHERE ads_id = ".$ads_id;
				    	//$result = $xoopsDB->queryF($sql);						
	}

//ajout CPascalWeb - 29 avril 2011 - envoi Email d'information a l'administrateur/site lorsque une annonce est signaler suspect
	if ($signalementannonce == 1) {

					//global $xoopsDB, $xoopsConfig, $xoopsUser;
					
						$mail_admin_url_ads = "<a href='".XOOPS_URL."/modules/catads/adsitem.php?ads_id=".$ads_id."'>".$ads_title."</a>";
						
						$mail_admin_msg_text =  str_replace("{X_UNAME}", "{X_SITENAME}", _MD_CATADS_MAIL_ADNIM_ADSSUSPECT_TEXT);
						$mail_admin_msg_text2 = str_replace("{X_ADS_TITLE}", $ads_title, $mail_admin_msg_text);
						$mail_admin_msg_text3 = str_replace("{X_ADS}", $mail_admin_url_ads, $mail_admin_msg_text2);
						$mail_admin_msg_text4 = str_replace("{X_SITEURL}", XOOPS_URL, $mail_admin_msg_text3);
						$mail_admin_msg_text5 = str_replace("{X_ADMINMAIL}", $xoopsConfig['adminmail'], $mail_admin_msg_text4);
						$mail_admin_msg_text6 = str_replace("{X_SITENAME}", $xoopsConfig['sitename'], $mail_admin_msg_text5);
						$mail_admin_msg = $mail_admin_msg_text6;
						
						include_once XOOPS_ROOT_PATH."/class/xoopsmailer.php";

						$xoopsMailer = getMailer();
						$xoopsMailer->useMail();
						$xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
						$xoopsMailer->setFromName($xoopsConfig['sitename']);
						$xoopsMailer->setToEmails($xoopsConfig['adminmail']);
						$xoopsMailer->setSubject(_MD_CATADS_MAIL_ADNIM_ADSSUSPECT_TITLE);
						$xoopsMailer->setBody($mail_admin_msg);
						$xoopsMailer->usePM();
						$xoopsMailer->multimailer->isHTML(true);//encodage html
						$xoopsMailer->send();
						$xoopsMailer->getErrors();	
				
						//chercher les annonces signaler
						//$sql = "UPDATE ". $xoopsDB->prefix('catads_ads')." SET signalementannonce = '0' WHERE ads_id = ".$ads_id;
				    	//$result = $xoopsDB->queryF($sql);						
	}	
//ajout CPascalWeb - 29 avril 2011 - envoi Email d'information lorsque une annonce n'est plus signaler suspect		
	elseif ($signalementannonce == 0) {
					//global $xoopsDB, $xoopsConfig, $xoopsUser;
					//récupéré le nom de l'annonceur
					$sql2 = $xoopsDB->query("SELECT uname FROM ".$xoopsDB->prefix("users")." WHERE uid = ".$uid);
					list($uname) = $xoopsDB->fetchRow($sql2);
					
					//Envoie par email
						$mail_url_ads = "<a href='".XOOPS_URL."/modules/catads/adsitem.php?ads_id=".$ads_id."'>".$ads_title."</a>";
						
						$mail_msg_text =  str_replace("{X_UNAME}", $uname, _MD_CATADS_MAIL_ADSNOSUSPECT_TEXT);
						$mail_msg_text2 = str_replace("{X_ADS_TITLE}", $ads_title, $mail_msg_text);
						$mail_msg_text3 = str_replace("{X_ADS}", $mail_url_ads, $mail_msg_text2);
						$mail_msg_text4 = str_replace("{X_SITEURL}", XOOPS_URL, $mail_msg_text3);
						$mail_msg_text5 = str_replace("{X_ADMINMAIL}", $xoopsConfig['adminmail'], $mail_msg_text4);
						$mail_msg_text6 = str_replace("{X_SITENAME}", $xoopsConfig['sitename'], $mail_msg_text5);
						$mail_msg = $mail_msg_text6;
						
						include_once XOOPS_ROOT_PATH."/class/xoopsmailer.php";
						$email= $ads->getVar("email", "E");

						//$xoopsMailer =& getMailer();
						//$xoopsMailer = xoops_getMailer();
						$xoopsMailer = getMailer();
						$xoopsMailer->useMail();
						$xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
						$xoopsMailer->setFromName($xoopsConfig['sitename']);
						$xoopsMailer->setToEmails($email);
						$xoopsMailer->setSubject(_MD_CATADS_MAIL_ADSNOSUSPECT_TITLE);
						$xoopsMailer->setBody($mail_msg);
						$xoopsMailer->usePM();
						$xoopsMailer->multimailer->isHTML(true);//encodage html
						$xoopsMailer->send();
						$xoopsMailer->getErrors();	
				
						//pour eviter que l'annonce soit a nouveau envoyer
						//$sql = "UPDATE ". $xoopsDB->prefix('catads_ads')." SET signalementannonce = '1' WHERE ads_id = ".$ads_id;
						//$result = $xoopsDB->queryF($sql);			
	}				
//fin		
                } else {
                    $messagesent = _MD_CATADS_UPDATE_ERROR;
                }
                redirect_header(XOOPS_URL."/modules/catads/adsitem.php?ads_id=".$ads_id, 3, $messagesent);

        } else {
                xoops_confirm(array('op' => 'signalementannonce', 'ads_id' => $ads_id, 'ok' => 1), XOOPS_URL.'/modules/catads/adsitem.php', $msgconf);
        }
}

//une fois l'annonce signaler (provisoir à inclure dans fonction au dessus)
function signalementannonce_faite() {
		echo '<p style="color: #fff;">'. _MD_CATADS_DECLARFRAUDE_FAITE.'</p>';
}
//fin de l'ajout

function showAds() {
        global $xoopsUser, $ads, $ads_handler, $xoopsTpl, $xoopsModule, $xoopsConfig, $poster_id, $isAuthor, $isAdmin, $xoopsModuleConfig, $xoopsDB, $xoTheme;

        //$myts =& MyTextSanitizer::getInstance();
        $myts = MyTextSanitizer::getInstance();
		
        $xoopsTpl->assign('ad_exists', true);
        $annonce['id'] = $ads_id = $ads->getVar('ads_id');
        $annonce['date_pub'] = ($ads->getVar('waiting') == 0) ? formatTimestamp($ads->getVar('published'),"s") : 0;
        $annonce['date_exp'] = ($ads->getVar('expired') > time()) ? formatTimestamp($ads->getVar('expired'),"s") : 0;
        $annonce['countpub'] = $ads->getVar('countpub');
        $annonce['waiting'] = $ads->getVar('waiting');
        $annonce['suspend'] = $ads->getVar('suspend');
//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce		
        $annonce['suspendadmin'] = $ads->getVar('suspendadmin');
//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse
        $annonce['signalementannonce'] = $ads->getVar('signalementannonce');		
//fin
        $annonce['uid'] =  $poster_id;
        $annonce['submitter_name'] =  XoopsUser::getUnameFromId($poster_id);
        $annonce['poster_ip'] =  $ads->getVar('poster_ip');
        $annonce['isauthor'] = $isAuthor;
        $annonce['nbview'] = sprintf(_MD_CATADS_NBVIEW, $ads->getVar('view'));
//ajout CPascalWeb - 14 mai 2011 - option choix d'afficher ou non
		$annonce['affiche_vue'] = ($xoopsModuleConfig['affiche_vue']) ? 1 : 0;
//fin
        $annonce['type'] = $ads->getVar('ads_type');
        $annonce['title'] = $ads->getVar('ads_title');
	
		//fixer les caractères accentués
		//$mots_tags = $ads->getVar('ads_tags');
		$mots_tags = $myts->htmlSpecialChars($ads->getVar('ads_tags'));
		//On decoupe la chaine délimitée par des virgules avec explode
		$mots_tags = explode(' ', $mots_tags);
		//On traite la chaine pour supprimer les doublons
		$mots_tags = array_unique($mots_tags);
		//Soit $max est = à l'ensemble du contenu du tableau
		$max = count($mots_tags); // count renvoi le nombre total d'éléments
		//$font_mini = 9;
		$font_maxi = 16;
		//Puis on affiche le nuage avec la boucle
		$nuage_tags = '';

   for ( $i=0; $i< $max ; $i++ )
   {
//modif CPascalWeb - 31 octobre 2010 - ajout define a la place de l'image + title et alt + url pour mode seo 
   $nuage_tags .= _MD_CATADS_SEPAR_TAGS.'&nbsp;<a href="'.XOOPS_URL.'/modules/catads/adslist.php?search=1&amp;words='.$mots_tags[$i].'" title="'.$mots_tags[$i].'" alt="'.$mots_tags[$i].'">'.$mots_tags[$i].'</a>&nbsp;';
   }
   //Appel sur le template
   $xoopsTpl->assign('link_tags', $nuage_tags);
    //video de l'annonce
//modif CPascalWeb - 31 octobre 2010 - ajout java zoombox et image a la place de la vidéo + title et alt 	
    $donneesvideo = $ads->getVar('ads_video');
    if ( strpos($donneesvideo, 'youtube') ) {
//ajout CPascalWeb 16 avril 2011 - $capturevideo pour capture écran vidéo
	$capturevideo = str_replace('http://www.youtube.com/watch?v=', 'http://i1.ytimg.com/vi/', $donneesvideo);
    $annonce['video'] = "<p style='text-transform: uppercase; font-size: 0.6em;'>"._MD_CATADS_NOM_REFERENCE_VIDEO_CAPTURE." ".$annonce['title']."</p><a href='".$donneesvideo."' title='"._MD_CATADS_NOM_REFERENCE_VIDEO." ".$annonce['title']."' alt='"._MD_CATADS_NOM_REFERENCE_VIDEO." ".$annonce['title']."' rel='zoombox 750 590' target='blank'>						
    <img src='".$capturevideo."/default.jpg' /></a>";
	} elseif ( strpos($donneesvideo, 'dailymotion') ) {
//ajout CPascalWeb 16 avril 2011 - $capturevideo pour capture écran vidéo	
					$capturevideo = str_replace('http://www.dailymotion.com/video/', 'http://www.dailymotion.com/thumbnail/160x120/video/', $donneesvideo);
					$annonce['video'] = "<p style='text-transform: uppercase; font-size: 0.6em;'>"._MD_CATADS_NOM_REFERENCE_VIDEO_CAPTURE." ".$annonce['title']."</p><a href='".$donneesvideo."' title='"._MD_CATADS_NOM_REFERENCE_VIDEO." ".$annonce['title']."' alt='"._MD_CATADS_NOM_REFERENCE_VIDEO." ".$annonce['title']."' rel='zoombox 750 590'>						
					<img src='".$capturevideo."' style='width: 120px;' /></a>";						
	}
//fin
        //modif CPascalWeb 16 avril 2011
       // $pk_desc = $myts->htmlSpecialChars($ads->getVar('ads_desc'));
       // $annonce['description'] = $myts->displayTarea($pk_desc, 0, 1, 1);
        $annonce['description'] = $myts->undoHtmlSpecialChars($ads->getVar('ads_desc'), 0, 1, 1);	   

        // ajouter - obtenir 'display_price' preference de la table categorie (n'est pas utilisé actuellement)
        // $annonce['display_price'] = $ads->getVar('display_price');

        $annonce['price'] = $ads->getVar('price');
        $annonce['monnaie'] = $ads->getVar('monnaie');
        $annonce['price_option'] = $ads->getVar('price_option');
        //Region
        $sql1 = $xoopsDB->query("SELECT region_nom FROM ".$xoopsDB->prefix("catads_regions")." WHERE region_numero = ".$ads->getVar('region'));
        list($region) = $xoopsDB->fetchRow($sql1);
        $annonce['region'] = $region;

        //Departement
        $sql2 = $xoopsDB->query("SELECT departement_nom FROM ".$xoopsDB->prefix("catads_departements")." WHERE departement_numero = ".$ads->getVar('departement'));
        list($departement) = $xoopsDB->fetchRow($sql2);
        $annonce['departement'] = $departement;

        $annonce['town'] = $ads->getVar('town');//ville
        $annonce['codpost'] = $ads->getVar('codpost');//code postal
        $annonce['candelete'] = $xoopsModuleConfig['usercandelete'];
        //$annonce['canedit'] = ($xoopsModuleConfig['moderated'] < 1) && $xoopsModuleConfig['usercanedit'];
        $annonce['canedit'] = $xoopsModuleConfig['usercanedit'];

        if(!$isAdmin && !$isAuthor) $ads_handler->incView($ads_id);
        // contact mode - correction dans DB - (Corrigé) - 3 =téléphone, 2=email, 1=PM, 13=uniquement par téléphone, 12=uniquement par email, 11=uniquement par PM
        // si mode contact = uniquement
        // 10 OFF la valeur DB si plus de 9, si '2' e-mail doit être (12 moins 10), pas Message Privée.
        if ($ads->getVar('contact_mode') > 9) {
                $contact_mode = $ads->getVar('contact_mode') -10;
                if ($contact_mode == 1)
                        $annonce['pmlink'] = "<a href='#' onclick='javascript:openWithSelfMain(\"".XOOPS_URL."/pmlite.php?send2=1&amp;to_userid=".$poster_id."\",\"pmlite\",450,380);'><img src='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/icon/mp_deco.png' alt='"._MD_CATADS_BYPM."' /></a><div style='clear: both;'></div>";
                if ($contact_mode == 2)
                        $annonce['maillink'] = "<a href='#' onclick='javascript:openWithSelfMain(\"".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/contact.php?ads_id=".$ads_id."\",\"contact\",600,450);'><img src='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/icon/email_deco.png' alt='"._MD_CATADS_BYMAIL."' /></a><div style='clear: both;'></div>";
                if ($contact_mode == 3)
                    $annonce['phone'] = '<b>'._MD_CATADS_PHONE_P.'</b> '.$ads->getVar('phone').' '.$ads->getVar('phoneportable');
    } else {
				//indication: Merci de me contacter de préférence par: + le mode de contact
                $contact_mode = $ads->getVar('contact_mode');
                $annonce['msg_contact'] = _MD_CATADS_CONTACT_PREF1.'&nbsp;'._MD_CATADS_BY.'';
//correction CPascalWeb - activer uniquement si membre		
		//if ($uid > 0)	a voir !			
                if ($contact_mode == 1) $annonce['msg_contact'] .= '&nbsp;'._MD_CATADS_CONTACT_MODE1.'';//message privé
                if ($contact_mode == 2) $annonce['msg_contact'] .= '&nbsp;'._MD_CATADS_CONTACT_MODE2. '';//email
                if ($contact_mode == 3) $annonce['msg_contact'] .= '&nbsp;'._MD_CATADS_CONTACT_MODE3. '';//téléphone
	
                if ($ads->getVar('email')!= '')
//ajout cpascalweb - 31 octobre 2010 - option choix javascript pop up contact zoombox ou non + title et alt + bouton css				
				if ($xoopsModuleConfig['pop_up_zoombox'] > 0){
				    $annonce['maillink'] = "
					<div class='boutons tooltip'><a href='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/contact.php?ads_id=".$ads_id."\"' rel='zoombox 750 590[maillink]' title='"._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."' alt='"._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."'>
					<img src='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/icon/email_deco.png' title='"._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."' alt='"._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."' />
					"._MD_CATADS_CONTACT_EMAIL."</a></div><div style='clear: both;'></div>";
				} else {              
					$annonce['maillink'] = "<div class='boutons'><a href='#' onclick='javascript:openWithSelfMain(\"".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/contact.php?ads_id=".$ads_id."\",\"contact\",750,590);' title='"._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."' alt='"._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."'>
					<img src='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/icon/email_deco.png' title='"._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."' alt='"._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."' />
					"._MD_CATADS_CONTACT_EMAIL."</a></div><div style='clear: both;'></div>";
				}				
//fin		
				if ($poster_id > 0)
//ajout cpascalweb - 31 octobre 2010 - option choix javascript pop up contact zoombox ou non + title et alt + bouton css						
				if ($xoopsModuleConfig['pop_up_zoombox'] > 0){                   
                    $annonce['pmlink'] = "<div class='boutons'><a href='".XOOPS_URL."/pmlite.php?send2=1&amp;to_userid=".$poster_id."\"' rel='zoombox 650 400[pmlite]' title='"._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."' alt='"._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."'>
					<img src='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/icon/mp_deco.png' title='"._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."' alt='"._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."' />
					"._MD_CATADS_CONTACT_MESSPRIV."</a></div>";
				} else { 
				if ($poster_id > 0)
					$annonce['pmlink'] = "<div class='boutons'><a href='#' onclick='javascript:openWithSelfMain(\"".XOOPS_URL."/pmlite.php?send2=1&amp;to_userid=".$poster_id."\",\"pmlite\",650,400);' title='"._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."' alt='"._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."'>
					<img src='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/icon/mp_deco.png' title='"._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."' alt='"._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."' />
					"._MD_CATADS_CONTACT_MESSPRIV."</a></div>";
				}				
//fin	
//ajout cpascalweb option micropaiement1 le 18 août 2009	
		//if ($poster_id > 0) 
		if ($ads->getVar('email')!= '')
//ajout cpascalweb - 31 octobre 2010 - option choix javascript pop up contact zoombox ou non + title et alt + bouton css	
			if ($xoopsModuleConfig['pop_up_zoombox'] > 0){  
				$annonce['rentabiliweb'] = "<div class='boutons'><a href='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/formulairecontact.php?ads_id=".$ads_id."\"' rel='zoombox 650 600[rentabiliweb]' title='"._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."' alt='"._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."'>
				<img src='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/icon/email_deco_rentabiliweb.png' title='"._MD_CATADS_VOIR_RENTABI_CONTACT.": "._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."' alt='"._MD_CATADS_VOIR_RENTABI_CONTACT.": "._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."' />
				"._MD_CATADS_CONTACT_MOI."</a></div><div style='clear: both;'></div>";	
			} else { 			
				$annonce['rentabiliweb'] = "<div class='boutons'><a href='#' onclick='javascript:openWithSelfMain(\"".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/formulairecontact.php?ads_id=".$ads_id."\",\"rentabiliweb\",650,600);'>
				<img src='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/icon/email_deco_rentabiliweb.png' title='"._MD_CATADS_VOIR_RENTABI_CONTACT.": "._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."' alt='"._MD_CATADS_VOIR_RENTABI_CONTACT.": "._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."' />
				"._MD_CATADS_CONTACT_MOI."</a></div><div style='clear: both;'></div>";			
			}	
		$xoopsTpl->assign('micropaiement1', $xoopsModuleConfig['micropaiement1']);
//fin de l'ajout			
		//coordonnée téléphonique + modif si aucun numéro juste pour la présentation
		if ($poster_id > 0)
		if ($ads->getVar('phone') != ''){
            $annonce['phone'] = ''._MD_CATADS_PHONE.': '.$ads->getVar('phone');
		} else { 
			$annonce['phone'] = ''._MD_CATADS_PHONE.': '._MD_CATADS_NOPHONE;
		}			
			
//ajout CPascalWeb - 12 novembre 2010 - option tel portable
		if ($poster_id > 0)
		if ($ads->getVar('phoneportable') != ''){
            $annonce['phoneportable'] = ''._MD_CATADS_PHONEPORTABLE.': '.$ads->getVar('phoneportable');
		} else { 
			$annonce['phoneportable'] = ''._MD_CATADS_PHONEPORTABLE.': '._MD_CATADS_NOPHONE;
		}

	} 
//fin
        // pour affichage pseudo et lien vers ses annonces
        if ($xoopsModuleConfig['display_pseudo'] && $poster_id > 0){
//modif CPascalWeb - 11 octobre 2010               
				//$annonce['submitter_link'] =  xoops_getLinkedUnameFromId($poster_id);
 				$annonce['submitter_link'] =  XoopsUserUtility::getUnameFromId($poster_id);              
//fin
			    $criteria = new CriteriaCompo(new Criteria('waiting', '0'));
                $criteria->add(new Criteria('published', time(),'<'));
                $criteria->add(new Criteria('expired', time(),'>'));
                $criteria->add(new Criteria('uid', $poster_id));
                $nbads = $ads_handler->getCount($criteria);
                if ($nbads > 1)
                    $annonce['submitter_ads'] = sprintf(_MD_CATADS_SEE_OTHER_ADS, "<a href='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/adslist.php?uid=".$poster_id."'>".$nbads."</a>", $annonce['submitter_link']);
                else
                    $annonce['submitter_ads'] = sprintf(_MD_CATADS_NO_OTHER_ADS, $annonce['submitter_link']);
				}
        //$cat = new catadsCategory($ads->getVar('cat_id'));
//modif CPascalWeb - 29 octobre 2010 - ajout zoombox.js + hauteur = largeur pour meilleur présentation
        if ( $ads->getVar('photo0') != '' )
        {
			$i = 0;
            while  ($i < 6)
            {
                if ($ads->getVar('photo'.$i))
                {
                  //$annonce['photo'.$i] = "<img src=\"".XOOPS_URL."/uploads/catads/images/annonces/original/".$ads->getVar('photo'.$i)."\"  id=\"photo".$i."\" alt=\"".$i."\" style=\"width: ".$xoopsModuleConfig['click_image_width']."px; height: *;\" class=\"PopBoxImageSmall\" onclick=\"Pop(this,50,'PopBoxImageLarge');\" />";
                    $annonce['photo'.$i] = "
					<li><a href=\"".XOOPS_URL."/uploads/".$xoopsModule->getVar('dirname')."/images/annonces/original/".$ads->getVar('photo'.$i)."\"  id=\"photo".$i."\" title='".$annonce['title']."' alt='"._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."' rel=\"zoombox[photo]\">";						
                    $annonce['photo'.$i] .= "
					<img src=\"".XOOPS_URL."/uploads/".$xoopsModule->getVar('dirname')."/images/annonces/original/".$ads->getVar('photo'.$i)."\"  id=\"photo".$i."\" title='".$annonce['title']."' alt='"._MD_CATADS_NOM_REFERENCE." ".$annonce['title']."' style=\"width: ".$xoopsModuleConfig['thumb_width']."px; height: ".$xoopsModuleConfig['thumb_width']."px;\" /></a></li>";						
				}
                $i++;
            }
        } else {
			$annonce['photo0'] = "<img id=\"no_image\" alt=\"no_image\" src=\"".XOOPS_URL."/uploads/".$xoopsModule->getVar('dirname')."/images/annonces/original/pasphotos.png\" class=\"contour\" style=\"width: 100px; height: 90px;\" />";
		}
	//affichage photo grand format par défault avec java affichage Photos 			
        if ( $ads->getVar('photo0') != '' )
        {			
			$annonce['photo'] = "
			<dd><img src=\"".XOOPS_URL."/uploads/".$xoopsModule->getVar('dirname')."/images/annonces/original/".$ads->getVar('photo0')."\" id=\"grand_format\" alt=\"".$ads->getVar('ads_title')."\" title=\"".$ads->getVar('ads_type') .": ". $ads->getVar('ads_title')."\" style=\"width: ".$xoopsModuleConfig['click_image_width']."px; height: ".$xoopsModuleConfig['click_image_width']."px;\" /></dd> 
			<div style='clear: both;'></div><dt>".$ads->getVar('ads_type') .": ". $ads->getVar('ads_title')."</dt>";
        } else {
			$annonce['photo0'] = "<img id=\"no_image\" alt=\"no_image\" src=\"".XOOPS_URL."/uploads/".$xoopsModule->getVar('dirname')."/images/annonces/original/pasphotos.png\" class=\"contour\" style=\"width: 100px; height: 90px;\" />";
		}
//fin modif et ajout

        //template afficher/cacher preference type d'annonces
        $xoopsTpl->assign('show_ad_type', $xoopsModuleConfig['show_ad_type']);
        $annonce['nbcols'] = 2;

        // option renouvellement
        $reminder_days = $xoopsModuleConfig['nb_days_expired'];//nombre de jours avant l'envoie d'un message indiquant l'expiration de l'annonce
        $reminder_timestamp = $reminder_days*86400 ;
        $expires_timestamp = $ads->getVar('expired');
        $reminder_time = $expires_timestamp - $reminder_timestamp;
        if(time() > $reminder_time){
        $annonce['show_renewal'] = '1' ;
        }
//ajout option cpascalweb - le 24 novembre 2010 afficher une pub dans le bloc Photos & vidéo de l'annonce
		$xoopsTpl->assign('aff_pub_annonce_bloc', $xoopsModuleConfig['aff_pub_annonce_bloc']);
		$xoopsTpl->assign('aff_pub_annonce_bloc_site', $xoopsModuleConfig['aff_pub_annonce_bloc_site']);
        if ( $xoopsModuleConfig['aff_pub_annonce_bloc'] == 1 ) {
            $xoopsTpl->assign('pub_bloc_photosvideo', $xoopsModuleConfig['aff_pub_annonce_bloc_code']);
        }
//fin

        $xoopsTpl->assign('annonce', $annonce);

        //ajout boite de selection renouveler l'annonce
		//correction CPascalWeb bug
        //$jump = XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/adslist.php?op=pubagain&amp;ads_id=".$ads_id."&amp;duration="; //bug
        $jump = XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/adsitem.php?op=pubagain&amp;ads_id=".$ads_id."&amp;duration=";        
		$opt = new catadsOption();
        ob_start();
        $opt->makeMySelBox('option_order','', 1, 4, "location=\"".$jump."\"+this.options[this.selectedIndex].value");
        $xoopsTpl->assign('sel_box', ob_get_contents());
        ob_end_clean();

        $mytree = new XoopsTree($xoopsDB->prefix("catads_cat"),"topic_id","topic_pid");
//modif CPascalWeb - 9 octobre 2010 - alt & titre + nom sous catégorie et site supposé aider au référencement naturel        
		$pathstring = "<a href='" . XOOPS_URL ."/modules/".$xoopsModule->getVar('dirname')."/index.php' title='". _MD_CATADS_NOM_REFERENCE .' '. $GLOBALS['xoopsConfig']['sitename'] ."' alt='". _MD_CATADS_NOM_REFERENCE .' '. $ads->getVar('ads_type') .' '. $ads->getVar('ads_title') ."'>"._MD_CATADS_MAIN."</a>&nbsp;<img src='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/icon/arrow.gif' border='0' title='". _MD_CATADS_NOM_REFERENCE .' '. $ads->getVar('ads_type') .' '. $ads->getVar('ads_title') ."' alt='". _MD_CATADS_NOM_REFERENCE .' '. $ads->getVar('ads_type') .' '. $ads->getVar('ads_title') .' '. $GLOBALS['xoopsConfig']['sitename'] ."' />&nbsp;";
        $pathstring .= $mytree->getNicePathFromId($ads->getVar('cat_id'), "topic_title", XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/adslist.php?z=z");
         //$pathstring = substr($pathstring, 0, -7);       
		//$pathstring = str_replace(":"," <img src='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/icon/arrow.gif' border='0' title='". _MD_CATADS_NOM_REFERENCE .' '. $ads->getVar('ads_type') .' '. $ads->getVar('ads_title') ."' alt='". _MD_CATADS_NOM_REFERENCE .' '. $ads->getVar('ads_type') .' '. $ads->getVar('ads_title') .' '. $GLOBALS['xoopsConfig']['sitename'] ."' /> ",$pathstring);
//fin       
		$xoopsTpl->assign('link_cat', $pathstring);
//ajout CPascalWeb - 5 novembre 2010 - envoyer cette annonce à une personne	
        $myts = MyTextSanitizer::getInstance();		
		//$desc = $myts->undoHtmlSpecialChars($ads->getVar('ads_desc'), ENT_QUOTES);
		//$desc = utf8_encode(htmlspecialchars($ads->getVar('ads_desc'), ENT_QUOTES));	
		$desc = $myts->undoHtmlSpecialChars($ads->getVar('ads_desc'), 0, 1, 1);
		$url = XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/adsitem.php?ads_id='.$ads_id;	
		$xoopsTpl->assign('email_ami', 'mailto:?subject='.sprintf(_MD_CATADS_ENVOIAMIE_OBJET,$GLOBALS['xoopsConfig']['sitename']).'&amp;body='.sprintf( _MD_CATADS_ENVOIAMIE_INTRO1,'%0D%0A'._MD_CATADS_ENVOIAMIE_INTRO2.'%0D%0A'.$ads->getVar('ads_type').': '.$ads->getVar('ads_title').'%0D%0A'.$desc.'%0D%0A%0D%0A'._MD_CATADS_ENVOIAMIE_INTRO3).':%0D%0A'.$url);
//fin
        //bannières pub 468x60 ou + 
		$xoopsTpl->assign('aff_pub_annonce', $xoopsModuleConfig['aff_pub_annonce']);
//ajout CPascalWeb - 24 novembre 2010 - option choix afficher une bannière pub du site			
		$xoopsTpl->assign('aff_pub_annonce_site', $xoopsModuleConfig['aff_pub_annonce_site']);
//fin		
        if ( $xoopsModuleConfig['aff_pub_annonce'] == 1) {
            $xoopsTpl->assign('pub', $xoopsModuleConfig['aff_pub_annonce_code']);
		} 
		
        // style css dans head
        $xoopsTpl->assign("xoops_module_header", '<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/catads/css/style.css" />');
		
        // aff titre de la page suivant pref 
        if($xoopsModuleConfig['show_ad_type'] == '1'){
        $xoopsTpl->assign('xoops_pagetitle', $ads->getVar('ads_type').' '.$ads->getVar('ads_title').' - ' .$xoopsModule->name());
        } else {
        $xoopsTpl->assign('xoops_pagetitle', $ads->getVar('ads_title').' - ' .$xoopsModule->name());
        }

        // ajout des mots clés et les balises meta description pour les annonces
        $keyword_tags = '' ;  
        $desctextclean = strip_tags($annonce['description']);
//modif CPascalWeb		
		//$xoTheme->addMeta('meta', 'description', substr($desctextclean, 0, 140));
		$GLOBALS["xoTheme"]->addMeta('meta', 'description', substr($desctextclean, 0, 140));
//fin		
        for ( $i=0; $i< $max ; $i++ ) {
        $keyword_tags .= $mots_tags[$i].", " ;
        }
//modif CPascalWeb		
        //$xoTheme->addMeta('meta', 'keywords', $keyword_tags);
        $GLOBALS["xoTheme"]->addMeta('meta', 'keywords', $keyword_tags);		
//fin	
//ajout CPascalWeb - 7 octobre 2010 jquery	         
		$GLOBALS["xoTheme"]->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/js/jquery.js');
//fin
}

if ( isset($_POST['pubagain'] )) $op = 'pubagain';
elseif ( isset($_POST['stopandgo'])) $op = 'stopandgo';
//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce	
elseif ( isset($_POST['suspendrereactiver'])) $op = 'suspendrereactiver';
//fin
elseif (!isset($op)) $op = 'showAds';

switch ($op) {
        case "pubagain":
                include(XOOPS_ROOT_PATH."/header.php");
                pubagain();
                include(XOOPS_ROOT_PATH."/footer.php");
                break;
        case "stopandgo":
                include(XOOPS_ROOT_PATH."/header.php");
                stopandgo();
                include(XOOPS_ROOT_PATH."/footer.php");
                break;
//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce					
        case "suspendrereactiver":
                include(XOOPS_ROOT_PATH."/header.php");
                suspendrereactiver();
                include(XOOPS_ROOT_PATH."/footer.php");
                break;				
//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse						
        case "signalementannonce":
                include(XOOPS_ROOT_PATH."/header.php");
                signalementannonce();
                include(XOOPS_ROOT_PATH."/footer.php");
                break;
        case "signalementannonce_faite":
				signalementannonce_faite();
                break;				
//fin			
        case "showAds":
        default:
                include_once(XOOPS_ROOT_PATH."/class/xoopstree.php");
                $xoopsOption['template_main'] = 'catads_item.tpl';
                include(XOOPS_ROOT_PATH."/header.php");
                showAds();
                include XOOPS_ROOT_PATH.'/include/comment_view.php';
                include(XOOPS_ROOT_PATH."/footer.php");
                break;
}

?>