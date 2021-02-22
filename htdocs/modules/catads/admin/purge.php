<?php

include("admin_header.php");
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/admin/functions.php";

xoops_cp_header();
//ajout CPascalWeb - afiche lien active
            //appel du menu admin
			if ( !is_readable(XOOPS_ROOT_PATH . "/Frameworks/art/functions.admin.php"))	{
			catads_admin_menu(4, _AM_CATADS_PURGEMANAGE);
			} else {
			include_once XOOPS_ROOT_PATH.'/Frameworks/art/functions.admin.php';
//			loadModuleAdminMenu (4, _AM_CATADS_PURGEMANAGE);
			}
			//catads_admin_menu(4, _AM_CATADS_PURGEMANAGE);
//fin
//echo "<br />" ;

//Action dans switch
        if (isset($_GET['op']))
                $op = $_GET['op'];
        elseif (isset($_POST['op']))
                $op = $_POST['op'];
        else
                $op = 'show_purge';


        switch ($op)
        {
                case "purge_ads_all_user":
                purge_ads_all_user();
                break;

                case "purge_ads_expired":
                purge_ads_expired();
                break;

                case "purge_ads_user":
                purge_ads_user();
                break;

                case "show_purge":
                default:
                show_purge();
                break;
        }

xoops_cp_footer();
?>
