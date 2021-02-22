<?php

include_once( "admin_header.php" );
include_once '../include/functions.php';
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/admin/functions.php";
//Class
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/cat.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/ads.php");

xoops_cp_header();
//ajout CPascalWeb - afiche lien active
//appel du menu admin
if ( !is_readable(XOOPS_ROOT_PATH . "/Frameworks/art/functions.admin.php"))	{
    catads_admin_menu(2, _AM_CATADS_ADSMANAGE);
} else {
    include_once XOOPS_ROOT_PATH.'/Frameworks/art/functions.admin.php';
//    loadModuleAdminMenu (2, _AM_CATADS_ADSMANAGE);
}
//catads_admin_menu(1, _AM_CATADS_ADSMANAGE);
//echo "<br />" ;
//fin

//Action dans switch
        if (isset($_GET['op']))
                $op = $_GET['op'];
        elseif (isset($_POST['op']))
                $op = $_POST['op'];
        else
                $op = 'show_ads';

//Affichage des l'administration des annonces
        switch ($op)
        {
                case "approve_ads":
                approve_ads();
                break;

                case "wait_ads":
                wait_ads();
                break;

                case "renew_ads":
                renew_ads();
                break;

                case "delete_ads":
                delete_ads();
                break;

                case "show_ads":
                default:
                show_ads();
                break;
        }

xoops_cp_footer();

?>