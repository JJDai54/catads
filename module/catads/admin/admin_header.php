<?php
include_once("../../../mainfile.php");
include_once "../../../include/cp_header.php";
include_once '../include/cp_functions.php';


//include_once(XOOPS_ROOT_PATH."/class/xoopsmodule.php");
include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";
include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
include_once XOOPS_ROOT_PATH . "/class/tree.php";
include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";


//---------------------------------------------------------------
include_once XOOPS_ROOT_PATH . '/Frameworks/moduleclasses/moduleadmin/moduleadmin.php';

$dirname = 'catads';    
include_once(XOOPS_ROOT_PATH . "/modules/{$dirname}/class/cat.php");
include_once(XOOPS_ROOT_PATH . "/modules/{$dirname}/include/functions.php");
include_once(XOOPS_ROOT_PATH . "/modules/{$dirname}/class/ads.php");
include_once XOOPS_ROOT_PATH . "/modules/{$dirname}/class/permissions.php";
include_once XOOPS_ROOT_PATH . "/modules/{$dirname}/class/formSelectRegions.php";
include_once XOOPS_ROOT_PATH . "/modules/{$dirname}/class/formSelectDepartements.php";



global $isFwModuleAdmin;
$adminObject = \Xmf\Module\Admin::getInstance();
//  $moduleAdmin = new ModuleAdmin();
  $isFwModuleAdmin = 1;



if ( $xoopsUser ) {
	$xoopsModule = XoopsModule::getByDirname("catads");
	if ( !$xoopsUser->isAdmin($xoopsModule->mid()) ) { 
		redirect_header(XOOPS_URL."/",3,_NOPERM);
		exit();
	}
} else {
	redirect_header(XOOPS_URL."/",3,_NOPERM);
	exit();
}
//modif CPascalWeb - pris en charge des langues
/*
if ( file_exists("../language/".$xoopsConfig['language']."/admin.php") ) {
	include_once("../language/".$xoopsConfig['language']."/admin.php");
} else {
	include_once("../language/english/admin.php");
}
*/

// xoops_loadLanguage('admin', 'system');
// xoops_loadLanguage('admin', $xoopsModule->getVar('dirname', 'e'));
// xoops_loadLanguage('modinfo', $xoopsModule->getVar('dirname', 'e'));
//fin

//$myts =& MyTextSanitizer::getInstance();
$myts = MyTextSanitizer::getInstance();

if (!isset($GLOBALS['xoopsTpl']) || !($GLOBALS['xoopsTpl'] instanceof XoopsTpl)) {
    require_once $GLOBALS['xoops']->path('class/template.php');
    $xoopsTpl = new \XoopsTpl();
}



$pathIcon32 = XOOPS_URL . '/modules/catads/' . 'images/icons/32/';
$adsCatHandler = new catadsCategory();

?>