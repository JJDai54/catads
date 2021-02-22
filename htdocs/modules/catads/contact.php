<?php

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
        global $xoopsConfig, $xoopsModuleConfig, $xoopsDB;
        include("../../mainfile.php");
//ajout CPascalWeb - 1 novembre 2010		
		//include_once XOOPS_ROOT_PATH."/include/functions.php";
//fin		
        //$myts =& MyTextSanitizer::getInstance();
        $myts = MyTextSanitizer::getInstance();
		
		$fullmsg = _MD_CATADS_HELLOFROMUSER."<br />";
                $fullmsg .= _MD_CATADS_FROMUSER." $name_user "._MD_CATADS_YOURADS." ".$title." "._MD_CATADS_SUR." ".$xoopsConfig['sitename']."<br /><br />";//Message de       suite à votre annonce sur
                $fullmsg .= _MD_CATADS_MESSDE." $name_user:<br /><br />";
                $fullmsg .= $message.'<br /><br />';
                $fullmsg .= _MD_CATADS_CANJOINT." $email_user";
			    if ($phone !='')
                    $fullmsg .= "<br />"._MD_CATADS_ORAT." $phone";
//ajout CPascalWeb - 12 novembre 2010 - option tel portable
                if ($phoneportable !='')
                    $fullmsg .= "&nbsp;"._MD_CATADS_ORATPORTABLE." $phoneportable";
//fin	
				$fullmsg .= "<br /><br />";
				$fullmsg .= _MD_CATADS_FINMESS."<br />";		
	$fullmsg .= _MD_CATADS_MAIL_UID_ADSSUPP_TEXT."<br /><br />";			
	
//ajout CPascalWeb - 1 novembre 2010
include_once XOOPS_ROOT_PATH."/class/xoopsmailer.php";				
//fin
//modif CPascalWeb - 1 novembre 2010
                //$xoopsMailer =& getMailer();
				//$xoopsMailer =& xoops_getMailer();
				$xoopsMailer = xoops_getMailer();				
                $xoopsMailer->useMail();
                $xoopsMailer->setFromEmail($email_user);
                $xoopsMailer->setFromName($xoopsConfig['sitename']);
                $xoopsMailer->setToEmails($email_author);
                $xoopsMailer->setSubject(_MD_CATADS_CONTACTAFTERADS);//Contact suite a votre annonce
                $xoopsMailer->setBody($fullmsg);
//ajout CPascalWeb - 1 novembre 2010				
				$xoopsMailer->multimailer->isHTML(true);//encodage html
//fin				
                $msgsend = "<div style='text-align:center;'><br /><br />";
                if ( !$xoopsMailer->send()) {
					$msgsend .= "<a href='#'>";	
					$msgsend .= $xoopsMailer->getErrors();
					$msgsend .= "</a>";					
                } else {
//ajout CPascalWeb - ajout pub + xoops_header et xoops_footer
				xoops_header();					
                $msgsend .= "<h4>"._MD_CATADS_MSGSEND."</h4>";//Votre message a été envoyé
				//$msgsend .=  $xoopsModuleConfig['aff_pub_annonce_code'];"";						
                }
//ajout cpascalweb - 31 octobre 2010 - define suivant option choix javascript pop up contact zoombox ou non				
				if ($xoopsModuleConfig['pop_up_zoombox'] > 0){
					$msgsend .= "<br /><br /><a href=\"#\">"._MD_CATADS_ZOOMBOX_CLOSEF."</a></div>";
				} else {              
					$msgsend .= "<br /><br /><a href=\"javascript:window.close();\">"._MD_CATADS_CLOSEF."</a></div>";
				}				
//fin					
                echo $msgsend;
				xoops_footer();				
        break;
//fin
case "preview":
        include("../../mainfile.php");
        //$myts =& MyTextSanitizer::getInstance();
        $myts = MyTextSanitizer::getInstance();		
        xoops_header();

        $p_title = $title;
        //$p_title = $myts->makeTboxData4Preview($p_title);
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
                    $p_msg .= '&nbsp;'._MD_CATADS_ORATPORTABLE." $phoneportable";
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
        global $xoopsModuleConfig;
        include("../../mainfile.php");
//ajout CPascalWeb systéme anti-fraude		
	if ($xoopsModuleConfig['micropaiement1'] !== 1) {
//fin		
        xoops_header();
        /*$ads_handler = & xoops_getmodulehandler('ads');
        $ads = & $ads_handler->get($ads_id);*/
        $ads_handler = xoops_getmodulehandler('ads');
        $ads = $ads_handler->get($ads_id);		

        // initialisation variables
        $message = '';
        $phone = '';
//ajout CPascalWeb - 12 novembre 2010 - option tel portable
        $phoneportable = '';
//fin		
        $name_user = '';
        $email_user ='';
        $email_author = $ads->getVar('email');

        //obtenir afficher/cacher type suivant préference module
        $show_ad_type = $xoopsModuleConfig['show_ad_type'];

        if($show_ad_type == '1'){
        $title = $ads->getVar('ads_type'). ' : '.$ads->getVar('ads_title');
        } else {
        $title = $ads->getVar('ads_title');
        }

        if($xoopsUser) {
                $name_user = ($xoopsUser->getVar('name')!='')? $xoopsUser->getVar("name") : $xoopsUser->getVar("uname");
                $email_user = $xoopsUser->getVar("email", "E");
        }
        include "include/form_contact.inc.php";
        xoops_footer();
		
//ajout CPascalWeb systéme anti-fraude 
//page de fraude si des petit malin saisis:
//http://127.0.0.1/nom du site/modules/catads/contact.php?ads_id=4
//dans
//http://127.0.0.1/nom du site/modules/catads/adsitem.php?ads_id=4
//remplace adsitem.php par contact.php? directement dans barre de navigation du navigateur		
		
	}
	if ($xoopsModuleConfig['micropaiement1'] !== 0) {
        include("../../mainfile.php");
		xoops_header();
		global $xoopsModuleConfig, $ads_id;
			echo "<div class='errorMsg'><h2>"._MD_CATADS_TITRE_RENTABI_FRAUDE."</h2></div>";
			echo '<table  width="100%" class="outer" cellspacing="1"><tr><th colspan="2"></th></tr>';
			echo "<tr><td class='head'align='center'>\n";
			echo _MD_CATADS_MESS_FRAUDE."</td><td class='even'></td></tr>
			<tr><td class='head' align='center'>
			<button name=\"buttonName\" type=\"button\" onclick=\"document.location.href='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/adsitem.php?ads_id=".$ads_id."';\">"._CLOSE."</button>
			</td><td class='even'></td></tr>
			</table></form>\n";
		xoops_footer();
		//ou alors redirection 
		//redirect_header( 'index.php', 2, _MD_CATADS_TITRE_RENTABI_FRAUDE );
}	
//fin de l'ajout CPascalWeb systéme anti-fraude		
break;
}

?>