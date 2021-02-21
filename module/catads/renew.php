<?php
//lien de renouvellement de l'annonce par mail
include_once("../../mainfile.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/include/functions.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/ads.php");

	global $xoopsModuleConfig;
	$ads_id =  isset($_POST['ads_id']) ? intval($_POST['ads_id']) : intval($_GET['ads_id']);
	$uid =  isset($_POST['uid']) ? intval($_POST['uid']) : intval($_GET['uid']);
	$key =  isset($_POST['key']) ? intval($_POST['key']) : intval($_GET['key']);
	$expired =  isset($_POST['expired']) ? intval($_POST['expired']) : intval($_GET['expired']);
    //$ads_handler = & xoops_getmodulehandler('ads');
    $ads_handler = xoops_getmodulehandler('ads');	
    //$ads =& $ads_handler->get($ads_id);
    $ads = $ads_handler->get($ads_id);	
	//redirection: Cette annonce n'existe pas !
    if (!is_object($ads))
    {
        redirect_header(XOOPS_URL."/modules/catads/index.php",3,_MD_CATADS_NO_EXIST);//Cette annonce n'existe pas
        exit();
    }
    $countpub = $ads->getVar('countpub');
	//redirection: nombre de renouvellement atteint !	
	if($countpub == '0') {
        redirect_header(XOOPS_URL."/modules/catads/index.php",3,_MD_CATADS_RENEWALS_EXCEEDED);//Nombre de renouvellement atteint ! merci de soumettre une nouvelle annonce
        exit();
    }
    //Verification de l'uid et de la date de création de l'annonce
    if ( ($ads->getVar('uid') == $uid) && ($ads->getVar('created') == $key) )
    {
    $expired_date = time() + ($xoopsModuleConfig['renew_nb_days'] * 86400);//a modifier plus besoin de $xoopsModuleConfig['renew_nb_days'] réservé a l'admin maintenant	
																		  //mettre la boite de sélection sel_box 4 dans le mail puis supprimé ce fichier 

//modif CPascalWeb - 18 mai 2011 plus besoin envoi mail automatique			
    //if($countpub == '1') {
       // $ads->setVar('expired_mail_send', '0');
   // }
        $ads->setVar('published', time());
        $ads->setVar('expired', $expired_date);
        $ads->setVar('countpub', $countpub -1);
        $update_ads_ok = $ads_handler->insert($ads);
	//mis à jour reussi ou pas
    if ($update_ads_ok)
    {
        //$messagesent = sprintf(_MD_CATADS_PUBAGAIN_OK, $xoopsModuleConfig['renew_nb_days']);
		$messagesent = sprintf(_MD_CATADS_PUBAGAIN_OK, $duration);//Votre annonce a été prolongée de x jours
    }
    else
    {
        $messagesent = _MD_CATADS_UPDATE_ERROR;//Erreur ! mise à jour non effectuée
    }
    }
    redirect_header(XOOPS_URL."/modules/catads/adsitem.php?ads_id=".$ads_id, 2, $messagesent);
    exit();
	
?>