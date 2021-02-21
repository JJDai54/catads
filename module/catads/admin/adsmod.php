<?php
//rappel: formulaire est afficher avec l'aide de 'include/form_modif_ads_admin.php'

include("admin_header.php");
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/admin/functions.php";
include_once '../include/functions.php';
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/cat.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/ads.php");

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

if ( isset($_POST['purge_ads_expired'] )) $op = 'purge_ads_expired';
elseif ( isset($_POST['delete'])) $op = 'delete';
elseif ( isset($_POST['edit']) ) $op = 'edit';
elseif ( isset($_POST['save'])) $op = 'save';
//ajout fonction CPascalWeb - 17 septembre 2010 posibilité de suspendre ou de réactivé une annonce	
elseif ( isset($_POST['suspendrereactiver'])) $op = 'suspendrereactiver';
//fin
//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse	
elseif ( isset($_POST['signalementannonce'])) $op = 'signalementannonce';
//fin
elseif (!isset($op)) $op = 'show';

if (!isset($action)) $action = 'all';
if ( isset($_GET['start']) )
        $start = intval($_GET['start']);
else $start = 0;

switch ($op) {
        //enregistrer
        case "save":
        //$ads_handler =& xoops_getmodulehandler('ads');
        $ads_handler = xoops_getmodulehandler('ads');		
        $ads = $ads_handler->get($ads_id);

        $ads->setVar('cat_id', $topic_id);
        $ads->setVar('ads_title', $ads_title);
        $ads->setVar('ads_type', $ads_type);
        $ads->setVar('ads_desc', $ads_desc);

                //si l'utilisateur n'a pas entré de tags...
                if(!isset($_REQUEST['ads_tags'])? NULL : $_REQUEST['ads_tags']);                 
                if ($_REQUEST['ads_tags'] == '')
                {
                        // Créer tags à partir de son titre.
                        $newtags = $ads->getVar('ads_title');
                        // Omettre lettres commune et des mots de la liste des étiquettes. RAPPEL: espaces avant et après sont importantes.
                        $remplace = array(
                        ' of ', ' if ', ' to ', ' in ', ' at ', ' on ', ' by ', ' it ', ' is ', ' or ', ' are ', ' the ', ' for ', ' and ',
                        ' &amp; ', ' when ', ' with ',
//ajout CPascalWeb - liste en français voir pour autre ajouter option avec texterea dans préférence						
                        ' de ', ' en ', ' pour ',  ' sur ', ' selon ', ' à ', ' a ',  ' sûr ', ' si ', ' te ', ' dans ', ' avec ', ' on ', ' par ', ' il ', ' si ', ' ou ', ' est ', ' ils ', ' ont ', ' tag ',
                        ' &amp; ', ' quand ', ' elle ', ' le ', ' ce ', ' la ', ' lui ', ' cela ', ' ça ', ' ceci ', ' et ', ' tags ', ' elles '						
//fin						
                        );
                        $par = ' ';// Remplacez-les par un espace
                        $newtags = str_replace($remplace, $par, $newtags);
                        // Trim espace de la liste tag et l'enregistre dans un VAR
                        $newtags = trim($newtags, ' ');
                        $ads->setVar('ads_tags', $newtags);
                } else {
                        $ads->setVar('ads_tags', $_REQUEST['ads_tags']);
                }

        $ads->setVar('ads_video', $ads_video);
        $ads->setVar('phone', $phone);
//ajout CPascalWeb - 12 novembre 2010 - option tel portable
        $ads->setVar('phoneportable', $phoneportable);	
//fin		
        $ads->setVar('town', $town);
        $ads->setVar('region', $region);
        $ads->setVar('departement', $departement);
        $ads->setVar('waiting', ($waiting > 0)? 0 : 1);
        if(isset($price)) {
                $ads->setVar('price', $price);
                $ads->setVar('monnaie', $monnaie);
                $ads->setVar('price_option', $price_option);
        }
        if(isset($email)) $ads->setVar('email', $email);
        if(isset($codpost)) $ads->setVar('codpost', $codpost);
        if ($waiting ){
                $ads->setVar('published', strtotime($published['date']) + $published['time']);
                $ads->setVar('expired', strtotime($expired['date']) + $expired['time']);
        }

        $cat = new catadsCategory($topic_id);
        $i = 0;
        while  ($i < $cat->nb_photo) {
                if ( !empty($_FILES['photo'.$i]['name'])) {
                        catads_upload($i);
                }
                $i++;
        }

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
                $msg = sprintf(_AM_CATADS_ERROR_UPDATE, $ads->getVar('ads_title'));
                $msg .= '<br />'.$ads->getErrors();
                xoops_header();
                //echo "<h4>"._AM_CATADS_TITLE."</h4>";
                xoops_error($msg);
                xoops_footer();
                exit();
        } elseif ($waiting) {
                // cache
                include_once XOOPS_ROOT_PATH."/class/xoopsblock.php";
                include_once XOOPS_ROOT_PATH.'/class/template.php';
                xoops_template_clear_module_cache($xoopsModule->getVar('mid'));
                // Notification
                //$notification_handler =& xoops_gethandler('notification');
                $notification_handler = xoops_gethandler('notification');				
                $tags = array();
                $tags['ADS_TITLE'] = $ads->getVar('ads_type').' : '.$ads->getVar('ads_title');
                $tags['ADS_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/adsitem.php?ads_id=' . $ads_id;

                $notification_handler->triggerEvent('global', 0, 'new_ads', $tags);
                $notification_handler->triggerEvent('category', $topic_id, 'new_ads', $tags);
                $notification_handler->triggerEvent('ads', $ads_id, 'approve', $tags);
                /*
                $notification_handler->triggerEvent('global', 0, 'ads_edit', $tags);
                $notification_handler->triggerEvent('category', $topic_id, 'ads_edit', $tags);
                $notification_handler->triggerEvent('ads', $ads_id, 'approve', $tags);*/
        }
        redirect_header("ads.php",2,_AM_CATADS_NOERROR_UPDATE);
        exit();
        break;

        //modifier
        case "edit":
        xoops_cp_header();
//ajout CPascalWeb - afiche lien active
//appel du menu admin
if ( !is_readable(XOOPS_ROOT_PATH . "/Frameworks/art/functions.admin.php"))	{
    catads_admin_menu(2);
} else {
    include_once XOOPS_ROOT_PATH.'/Frameworks/art/functions.admin.php';
//    loadModuleAdminMenu (2);
}
//catads_admin_menu(0);
//echo "<br />" ;
//fin		
        //$option_handler =& xoops_getmodulehandler('option');
        $option_handler = xoops_getmodulehandler('option');		
        $criteria = new Criteria('option_id', '0', '>');
        $criteria->setSort('option_type');
        $option = $option_handler->getObjects($criteria);
        $count = 0;
        foreach($option as $oneoption){
            $arr_option[$count]['id'] = $oneoption->getVar('option_id');
            $arr_option[$count]['type'] = $oneoption->getVar('option_type');
            $arr_option[$count]['desc'] = $oneoption->getVar('option_desc');
            $arr_option[$count]['order'] = $oneoption->getVar('option_order');
            $count++;
        }

    /*$ads_handler = & xoops_getmodulehandler('ads');
    $ads = & $ads_handler->get($ads_id);*/
    $ads_handler = xoops_getmodulehandler('ads');
    $ads = $ads_handler->get($ads_id);	
    $published = $ads->getVar('published');
    $expired = $ads->getVar('expired');
    $created = $ads->getVar('created');
    $cat_id = $ads->getVar('cat_id');
    $ads_type = $ads->getVar('ads_type');
    $ads_title = $ads->getVar('ads_title');
    $ads_desc = $ads->getVar('ads_desc');
    $ads_tags = $ads->getVar('ads_tags');
    $ads_video = $ads->getVar('ads_video');
    $price = $ads->getVar('price');
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
    $submitter = XoopsUser::getUnameFromId($ads->getVar('uid'));
    $contact_mode = $ads->getVar('contact_mode') % 10;
    //echo 'contact '.$contact_mode;
        $i = 0;
        while ($i < 6){
                if ($ads->getVar('photo'.$i)) {
                        $photo[$i]= $ads->getVar('photo'.$i);
                }
                $i++;
        }
        $waiting = $ads->getVar('waiting');
        //formulaire est construit à l'aide 'include/form_modif_ads_admin.php'
        include "../include/form_modif_ads_admin.php";
        xoops_cp_footer();
        break;

        case "approve":
        approve($ads_id);
        break;

        case "delete":
        delete($ads_id);
        break;
		
//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce par l'admin					
    case "suspendrereactiver":
	xoops_cp_header();	
        global $xoopsUser, $isAdmin, $ads, $ads_handler;
        //$ads_handler =& xoops_getmodulehandler('ads');
        $ads_handler = xoops_getmodulehandler('ads');		
        $ads = $ads_handler->get($ads_id);
        $ads_id = $ads->getVar('ads_id');
        $ok =  isset($_POST['ok']) ? intval($_POST['ok']) : 0;

        if ($ads->getVar('suspendadmin') == 0) {
        //suspendre
                $msgconf = _AM_CATADS_PUBADMINSTOP_CONF;
                $msgok = _AM_CATADS_PUBADMINSTOP_OK;
                $suspendadmin = 1;
        } else {
        //reprendre
                $msgconf = _AM_CATADS_PUBADMINGO_CONF;
                $msgok = _AM_CATADS_PUBADMINGO_OK;
                $suspendadmin = 0;
        }
    if ( $ok == 1 ) {
                $ads->setVar('suspendadmin', $suspendadmin);
                $update_ads_ok = $ads_handler->insert($ads);
                if ($update_ads_ok){
                        $messagesent = $msgok;
                } else {
                        $messagesent = _AM_CATADS_UPDATE_ERROR;
                }
                redirect_header("ads.php?ads_id=".$ads_id, 3, $messagesent);

        } else {
                xoops_confirm(array('op' => 'suspendrereactiver', 'ads_id' => $ads_id, 'ok' => 1), 'adsmod.php', $msgconf);
        }				
   	xoops_cp_footer();
	break;				
//fin			

//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse						
    case "signalementannonce":
	xoops_cp_header();	
        global $xoopsUser, $isAdmin, $ads, $ads_handler;
        //$ads_handler =& xoops_getmodulehandler('ads');
        $ads_handler = xoops_getmodulehandler('ads');		
        $ads = $ads_handler->get($ads_id);
        $ads_id = $ads->getVar('ads_id');
        $ok =  isset($_POST['ok']) ? intval($_POST['ok']) : 0;

        if ($ads->getVar('signalementannonce') == 0) {
        //suspendre
                $msgconf = _AM_CATADS_DECLARFRAUDE_CONF;
                $msgok = _AM_CATADS_DECLARFRAUDE_OK;
                $signalementannonce = 1;
        } else {
        //reprendre
                $msgconf = _AM_CATADS_DECLARNOFRAUDE_CONF;
                $msgok = _AM_CATADS_DECLARNOFRAUDE_OK;
                $signalementannonce = 0;
        }
    if ( $ok == 1 ) {
                $ads->setVar('signalementannonce', $signalementannonce);
                $update_ads_ok = $ads_handler->insert($ads);
                if ($update_ads_ok){
                        $messagesent = $msgok;
                } else {
                        $messagesent = _AM_CATADS_UPDATE_ERROR;
                }
                redirect_header("ads.php?ads_id=".$ads_id, 3, $messagesent);

        } else {
                xoops_confirm(array('op' => 'signalementannonce', 'ads_id' => $ads_id, 'ok' => 1), 'adsmod.php', $msgconf);
        }	
	
   	xoops_cp_footer();
	break;				
//fin

}

?>