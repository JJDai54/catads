<?php

include("admin_header.php");
include_once XOOPS_ROOT_PATH . '/class/xoopstopic.php';
include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/admin/functions.php";

xoops_cp_header();
//ajout CPascalWeb - afiche lien active
            //appel du menu admin
			if ( !is_readable(XOOPS_ROOT_PATH . "/Frameworks/art/functions.admin.php"))	{
			catads_admin_menu(5, _AM_CATADS_PERMISSIONSMANAGE);
			} else {
			include_once XOOPS_ROOT_PATH.'/Frameworks/art/functions.admin.php';
//			loadModuleAdminMenu (5, _AM_CATADS_PERMISSIONSMANAGE);
			}
			//catads_admin_menu(5, _AM_CATADS_PERMISSIONSMANAGE);
//fin

        $permtoset= isset($_POST['permtoset']) ? intval($_POST['permtoset']) : 1;
        $selected=array('','','');
        $selected[$permtoset-1]=' selected';

echo "<br />
<form method='post' name='fselperm' action='permissions.php'>
        <table border=0>
                <tr>
                        <td><select name='permtoset' onChange='javascript: document.fselperm.submit()'><option value='1'".$selected[0].">"._AM_CATADS_ACCESS."</option><option value='2'".$selected[1].">"._AM_CATADS_SUBMIT."</option></select></td>
                        <td>
                </tr>
        </table>
</form>";

        $module_id = $xoopsModule->getVar('mid');

        switch($permtoset)
        {
                case 1:
                        $title_of_form = _AM_CATADS_ACCESSCAT;
                        $perm_name = 'catads_access';
                        $perm_desc = '';
                        break;
                case 2:
                        $title_of_form = _AM_CATADS_SUBMITCAT;
                        $perm_name = 'catads_submit';
                        $perm_desc = '';
                        break;
        }

        $permform = new XoopsGroupPermForm($title_of_form, $module_id, $perm_name, $perm_desc, 'admin/permissions.php');
        $xt = new XoopsTopic( $xoopsDB -> prefix( 'catads_cat' ) );
        //$alltopics =& $xt->getTopicsList();
        $alltopics = $xt->getTopicsList();
		
        foreach ($alltopics as $topic_id => $topic)
        {
            $permform->addItem($topic_id, $topic['title'], $topic['pid']);
        }
        echo $permform->render();
        echo "<br /><br /><br /><br />\n";
        unset ($permform);

xoops_cp_footer();
?>