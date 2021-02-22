<?php
//Ajout de la page rentabiliwebcontact.php CPascalWeb - 21 août 2009 
//Protection micropaiement Rentabiliweb

include("../../mainfile.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/include/functions.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/option.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/cat.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/ads.php");


//Debut de la premiere parti du code de Protection micropaiement Rentabiliweb
// correction CPascalWeb 22 août 2009
//session_start(); //BUG
if (!session_id()) session_start();
//fin 
// id de protection du document protégé
$idprotect = $xoopsModuleConfig['idsite'];

// PHP5 avec register_long_arrays désactivé?
if (!isset($HTTP_GET_VARS))
{
    $HTTP_SESSION_VARS    = $_SESSION;
    $HTTP_SERVER_VARS     = $_SERVER;
    $HTTP_GET_VARS        = $_GET; //RAPPEL CPascalWeb: $HTTP_GET_VARS est déprécié en PHP 5
}

//construction de la requête
if ($idprotect==$HTTP_GET_VARS['id'])
{
    $requete      = "http://secure.rentabiliweb.com/Micropaiement.php?act=ss&";
    $requete     .= $HTTP_SERVER_VARS['QUERY_STRING'];
    $requete     .= "&REMOTE_ADDR=".$HTTP_SERVER_VARS['REMOTE_ADDR'];
    $tabrep       = @file($requete);
} else {
    unset($tabrep);
}
if(trim($tabrep[0]) == "OUI")
{
    $HTTP_SESSION_VARS["RentaSess"]    = true;
//fin de la premiere parti du code de Protection micropaiement Rentabiliweb	

//formulaire contact email protégé
$op = 'form';
foreach ($_POST as $k => $v) {${$k} = $v;}
foreach ($_GET as $k => $v) {${$k} = $v;}

if ( isset($preview)) {
	$op = 'preview';
} elseif ( isset($post) ) {
	$op = 'post';
}

function displaypost($title, $content) {
	echo '<table cellpadding="4" cellspacing="1" width="98%" class="outer"><tr><td class="head">'.$title.'</td></tr><tr><td><br />'.$content.'<br /></td></tr></table>';
}

switch($op) {
case "post":
	global $xoopsConfig;
	include("../../mainfile.php");
	//$myts =& MyTextSanitizer::getInstance();
	$myts = MyTextSanitizer::getInstance();	
 
		$fullmsg = _MD_CATADS_FROMUSER." $name_user "._MD_CATADS_YOURADS." ".$xoopsConfig['sitename']." :\n\n";
		$fullmsg .= $title."\n";
		$fullmsg .= "-----------------------------------------------------------------\n";
		$fullmsg .= "$message\n\n";
		$fullmsg .= "-----------------------------------------------------------------\n\n";
		$fullmsg .= _MD_CATADS_CANJOINT." $email_user";
		if ($phone !='')
			$fullmsg .= '<br />'._MD_CATADS_ORAT." $phone";
//ajout CPascalWeb - 12 novembre 2010 - option tel portable
        if ($phoneportable !='')
            $fullmsg .= '&nbsp;'._MD_CATADS_ORATPORTABLE." $phoneportable";
//fin			

//ajout
include_once XOOPS_ROOT_PATH."/class/xoopsmailer.php";		
//fin
//modif CPascalWeb - 1 novembre 2010
        //$xoopsMailer =& getMailer();
		$xoopsMailer = xoops_getMailer();
		$xoopsMailer->useMail();
		$xoopsMailer->setFromEmail($email_user);
		$xoopsMailer->setFromName($xoopsConfig['sitename']);
		$xoopsMailer->setToEmails($email_author);
		$xoopsMailer->setSubject(_MD_CATADS_CONTACTAFTERADS);
		$xoopsMailer->setBody($fullmsg);
		$msgsend = "<div style='text-align:center;'><br /><br />";
		if ( !$xoopsMailer->send()) {
			$msgsend .= $xoopsMailer->getErrors();
		} else {
			$msgsend .= "<h4>"._MD_CATADS_MSGSEND."</h4>";
		}
		$msgsend .= "<br /><br /><a href=\"javascript:window.close();\">"._MD_CATADS_CLOSEF."</a></div>";
		echo $msgsend;
	break;
	
case "preview":
	include("../../mainfile.php");
	//$myts =& MyTextSanitizer::getInstance();
	$myts = MyTextSanitizer::getInstance();	
	xoops_header();
	$p_title = $title;
	$p_title = $myts->htmlSpecialChars($myts->stripSlashesGPC($p_title));
	$p_msg = _MD_CATADS_FROMUSER." $name_user "._MD_CATADS_YOURADS." ".$xoopsConfig['sitename']." :<br />";
	$p_msg .= $title.'<br />';
	$p_msg .= "-----------------------------------------------------------------<br />";
	$p_msg .= $message.'<br /><br />';
	$p_msg .= "-----------------------------------------------------------------<br />";
	$p_msg .= _MD_CATADS_CANJOINT." $email_user";
		if ($phone !='')
			$p_msg .= '<br />'._MD_CATADS_ORAT." $phone";
//ajout CPascalWeb - 12 novembre 2010 - option tel portable
        if ($phoneportable !='')
        $p_msg.= '&nbsp;'._MD_CATADS_ORATPORTABLE." $phoneportable";
//fin		
	$p_msg .= '<br />';
	displaypost($p_title, $p_msg);
	$title =  $myts->htmlSpecialChars($myts->stripSlashesGPC($title));
	$message =  $myts->htmlSpecialChars($myts->stripSlashesGPC($message));
	include "include/form_contact.inc.php";
	xoops_footer();
	break;
	
case "form":
default:
	include("../../mainfile.php");
	xoops_header();
	/*$ads_handler = & xoops_getmodulehandler('ads');
	$ads = & $ads_handler->get($ads_id);*/
	$ads_handler = xoops_getmodulehandler('ads');
	$ads = $ads_handler->get($ads_id);	
	$message = '';	
	$phone = '';
//ajout CPascalWeb - 12 novembre 2010 - option tel portable	
	$phoneportable = '';	
//fin	
	$name_user = '';	
	$email_user ='';
	$email_author = $ads->getVar('email');
	$title = $ads->getVar('ads_type'). ' : '.$ads->getVar('ads_title');
	if($xoopsUser) {
		$name_user = ($xoopsUser->getVar('name')!='')? $xoopsUser->getVar("name") : $xoopsUser->getVar("uname");
		$email_user = $xoopsUser->getVar("email", "E");
	}
	include "include/form_contact.inc.php";
	xoops_footer();
break;
}
//fin du formulaire contact

//Debut de la deuxième parti du code de Protection micropaiement Rentabiliweb
} else {
    $HTTP_SESSION_VARS["RentaSess"] = true;
	//rappel a surveiller parfois bug le (.$xoopsModule->dirname().) ????
	header("Location: http://".XOOPS_URL."/modules/".$xoopsModule->dirname()."/pageerreur.php");
    exit(0);
}

?>
	