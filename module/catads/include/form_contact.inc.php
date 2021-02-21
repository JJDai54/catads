<?php

//ajout CPascalWeb
include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/include/functions.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/option.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/cat.php");

$form_contact = new XoopsThemeForm(_MD_CATADS_CONTACTAUTOR, "form_contact", "contact.php");
			
if ( isset($preview)) {
	$op = 'preview';
} elseif ( isset($post) ) {
	$op = 'post';
}

//obtenir les annonces
//$myts =& MyTextSanitizer::getInstance();
$myts = MyTextSanitizer::getInstance();
//obtenir l'annonce par son id
		//$annonce['id'] = $ads_id = $ads->getVar('ads_id');
//Ajout CPascalWeb - affiche les coordonnées de l'annonceur malgrés ces préférences mais continue d'afficher le mode de contact qu'il souhaite
		$annonce['phone'] = $phone;
//ajout CPascalWeb - 12 novembre 2010 - option tel portable		
		$annonce['phoneportable'] = $phoneportable;		
//$annonce['phone'] = $ads->getVar('phone');
//fin		
        //obtenir la date de publication		
		$annonce['date_pub'] = ($ads->getVar('published') > 0) ? formatTimestamp($ads->getVar('published'),"s") : 0;
        //obtenir la date d'expiration		
		$annonce['date_exp'] = ($ads->getVar('expired') > time()) ? formatTimestamp($ads->getVar('expired'),"s") : 0;
		$annonce['suspend'] = $ads->getVar('suspend');
//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce			
		$annonce['suspendadmin'] = $ads->getVar('suspendadmin');
//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse		
		$annonce['signalementannonce'] = $ads->getVar('signalementannonce');		
//fin		
    //obtenir la façon que l'annonceur souhaite être contacter   		
	$annonce['contact'] = '';
    switch($ads->getVar('contact_mode'))
    {
		//de préférence message privé
        case 1:
            $annonce['contact'] .=' '._MD_CATADS_CONTACT_PREF1.' '._MD_CATADS_BY.' '._MD_CATADS_CONTACT_MODE1;
        break;
		//de préférence par email
        case 2:
            $annonce['contact'] .='  '._MD_CATADS_CONTACT_PREF1.' '._MD_CATADS_BY.' '._MD_CATADS_CONTACT_MODE2;
        break;
		//de préférence téléphone
        case 3:
			$annonce['contact'] .=' '._MD_CATADS_CONTACT_PREF1.' '._MD_CATADS_BY.' '._MD_CATADS_CONTACT_MODE3;			
        break;
		//uniquement par email
        case 11:
            $annonce['contact'] .=' '._MD_CATADS_CONTACT_PREF2.' '._MD_CATADS_BY.' '._MD_CATADS_CONTACT_MODE2;
        break;
		//uniquement par message privé
        case 12:
            $annonce['contact'] .='  '._MD_CATADS_CONTACT_PREF2.' '._MD_CATADS_BY.' '._MD_CATADS_CONTACT_MODE1;
        break;
		//uniquement par téléphone
        case 13:
            $annonce['contact'] .=' '._MD_CATADS_CONTACT_PREF2.' '._MD_CATADS_BY.' '._MD_CATADS_CONTACT_MODE3;			
        break;
    }
  
//obtenir le type de l'annonce (vend, echange, loue, recherche etc...)
		$annonce['type'] = $ads->getVar('ads_type');
//obtenir le titre de l'annonce		
		$annonce['title'] = $ads->getVar('ads_title');
//obtenir la description de l'annonce		
        //modif CPascalWeb 16 avril 2011	
           /* $pk_desc = $myts->htmlSpecialChars($ads->getVar('ads_desc'));
            $annonce['description'] = $myts->displayTarea($pk_desc, 0, 1, 1);*/
	        $annonce['description'] = $myts->undoHtmlSpecialChars($ads->getVar('ads_desc'), 0, 1, 1);	 		
//obtenir le prix	
		$annonce['price'] = $ads->getVar('price');
		if ($ads->getVar('price') > 0){
			$annonce['price'] = $ads->getVar('price');
			$annonce['price'] .= ' '.$ads->getVar('monnaie');
			$annonce['price'] .= ' '.$ads->getVar('price_option');
		}
//obtenir la ville		
		$annonce['town'] = $ads->getVar('town');
//obtenir le code postal		
		$annonce['codpost'] = $ads->getVar('codpost');
//obtenir les photos/images de l'annonce	
		$annonce['photo'] = $ads->getVar('photo0');
		$annonce['photo1'] = $ads->getVar('photo1');
		$annonce['photo2'] = $ads->getVar('photo2');
		$annonce['photo3'] = $ads->getVar('photo3');
		$annonce['photo4'] = $ads->getVar('photo4');
		$annonce['photo5'] = $ads->getVar('photo5');
		
//Ajout CPascalWeb - affiche les coordonnées de l'annonceur malgrés ces préférences mais continue d'afficher le mode de contact qu'il souhaite
		$annonce['phone'] .=' '._MD_CATADS_CONTACT_TELEPH.' '.$ads->getVar('phone');
		$annonce['phoneportable'] .=' '._MD_CATADS_CONTACT_TELEPHPORTABLE.' '.$ads->getVar('phoneportable');
		
//formulaire contact avec coordonnées et photos
$title_text = new XoopsFormText(_MD_CATADS_TITLE, "title", 52, 100, $title);
$title_text->setExtra("readonly = 'readonly'");
$form_contact->addElement($title_text, true);

$name_text = new XoopsFormText(_MD_CATADS_YOURNAME.'', "name_user", 50, 100, $name_user);
$form_contact->addElement($name_text, true);

$email_text = new XoopsFormText(_MD_CATADS_YOUREMAIL.'', "email_user", 50, 100, $email_user);
$form_contact->addElement($email_text,true);

$phone_text = new XoopsFormText(_MD_CATADS_YOURPHONE, "phone", 20, 20,$phone);
$form_contact->addElement($phone_text, false);

//ajout CPascalWeb - 12 novembre 2010 - option tel portable
$phoneportable_text = new XoopsFormText(_MD_CATADS_YOURPHONEPORTABLE, "phoneportable", 20, 20,$phoneportable);
$form_contact->addElement($phoneportable_text, false);
//fin	

$annonce_text = new XoopsFormTextArea(_MD_CATADS_YOURMESSAGE.'', "message", $message);
$form_contact->addElement($annonce_text, true);

$button_tray = new XoopsFormElementTray('' ,'');
//$button_tray->addElement(new XoopsFormButton('', 'preview', _PREVIEW, 'submit'));//BUG en mode preview
$button_tray->addElement(new XoopsFormButton('', 'post', _SEND, 'submit'));
$button_cancel = new XoopsFormButton('', 'cancel', _CANCEL, 'button');
$button_cancel->setExtra("'onclick='javascript:window.close();'");
$button_tray->addElement($button_cancel);

$form_contact->addElement($button_tray);
$form_contact->addElement(new XoopsFormHidden('email_author', $email_author));

//global $xoopsConfig, $xoopsModule; important sinon n'envois pas les emails
global $xoopsConfig, $xoopsModule, $xoopsModuleConfig;

//ajout CPascalWeb 12 novembre 2010 - affiche le prix si il en y a un
		if ($ads->getVar('price') != '0'){
            $annonce['price'] = ' - &nbsp;'._MD_CATADS_PRICE2.'&nbsp;'.$ads->getVar('price');
		} else { 
			$annonce['price'] = '&nbsp;';
		}

				echo '<table  width="100%" class="outer" cellspacing="1"><tr><th colspan="2"></th></tr>';
				echo "<tr><td class='head' align='center'>";
				echo '<h2><b>'.$annonce['type'] . ' - ' . $annonce['title'].'</b><b>'.$annonce['price'].'</b></h2><small><b>'._MD_CATADS_DATE_PUB1.'</b>&nbsp;'.$annonce['date_pub'].' - <b>'._MD_CATADS_DATE_EXP.'</b>&nbsp;'.$annonce['date_exp'].'</small></td></tr>';
				echo "<tr><td class='head' align='center'><b>".$annonce['description'] . "</b><br /><br />" ;
				
//affichage des photos/images de l'annonce		
	if ($annonce['photo'] != '') {
		echo '<img src="'.XOOPS_URL.'/uploads/'.$xoopsModule->dirname().'/images/annonces/original/'.$annonce['photo'].'" class="imgContour" style="width: 100px; height: 100px;" />';
	} else {
		echo '<img src="'.XOOPS_URL.'/uploads/'.$xoopsModule->dirname().'/images/annonces/original/pasphotos.png" class="imgContour" style=\"width: 100px; height: 90px;\" align="right">';
	}
		if ($annonce['photo1'] != '') {
		echo '<img src="'.XOOPS_URL.'/uploads/'.$xoopsModule->dirname().'/images/annonces/original/'.$annonce['photo1'].'" class="imgContour" style="width: 100px; height: 100px;" />';
	} 
			if ($annonce['photo2'] != '') {
		echo '<img src="'.XOOPS_URL.'/uploads/'.$xoopsModule->dirname().'/images/annonces/original/'.$annonce['photo2'].'" class="imgContour" style="width: 100px; height: 100px;" />';
	} 
			if ($annonce['photo3'] != '') {
		echo '<img src="'.XOOPS_URL.'/uploads/'.$xoopsModule->dirname().'/images/annonces/original/'.$annonce['photo3'].'" class="imgContour" style="width: 100px; height: 100px;" />';
	} 
			if ($annonce['photo4'] != '') {
		echo '<img src="'.XOOPS_URL.'/uploads/'.$xoopsModule->dirname().'/images/annonces/original/'.$annonce['photo4'].'" class="imgContour" style="width: 100px; height: 100px;" />';
	} 
			if ($annonce['photo5'] != '') {
		echo '<img src="'.XOOPS_URL.'/uploads/'.$xoopsModule->dirname().'/images/annonces/original/'.$annonce['photo5'].'" class="imgContour" style="width: 100px; height: 100px;" />';
	} 
//ajout CPascalWeb - coordonnées téléphonique + modif si aucun numéro juste pour la présentation
		if ($ads->getVar('phone') != ''){
            $annonce['phone'] = ''._MD_CATADS_PHONE.': '.$ads->getVar('phone');
		} else { 
			$annonce['phone'] = ''._MD_CATADS_PHONE.': '._MD_CATADS_NOPHONE;
		}			
			
		//portable
		if ($ads->getVar('phoneportable') != ''){
            $annonce['phoneportable'] = ''._MD_CATADS_PHONEPORTABLE.': '.$ads->getVar('phoneportable');
		} else { 
			$annonce['phoneportable'] = ''._MD_CATADS_PHONEPORTABLE.': '._MD_CATADS_NOPHONE;
		}

//Ajout CPascalWeb 12 novembre 2010 affiche le mode de contact que souhaite l'annonceur + affiche les coordonnées téléphonique
		echo "<tr><td class='odd' align='center'><h2>"._MD_CATADS_BLOC_CONTACT."".$annonce['contact']."</h2>
			<div class='head' align='left'>"._MD_CATADS_BLOC_CONTACTTEL."<br />
			<img src='images/icon/tel_fixe.png' border='0' style='vertical-align: middle; padding: .2em;' />&nbsp;".$annonce['phone']."
			<br />
			<img src='images/icon/tel_portable.png' border='0' style='vertical-align: middle; padding: .2em;' />&nbsp;".$annonce['phoneportable']."
			</td></tr>";
		
		$form_contact->display();
		echo "<tr><td class='head' align='center'></td></tr></table>";
//fin de l'ajout

?>