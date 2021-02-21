<?php
include "../../mainfile.php";
global $xoopsModuleConfig, $xoopsModule, $xoopsDB;//ajout $xoopsDB
if ( $xoopsModuleConfig['show_seo'] == 1 )
{
	include "seo_url.php";
}

include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
include_once XOOPS_ROOT_PATH.'/class/xoopstree.php';
include_once(XOOPS_ROOT_PATH."/class/xoopstree.php");

include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/cat.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/include/functions.php");
include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/ads.php");
include_once XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->dirname().'/class/permissions.php';
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/formSelectRegions.php";
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/formSelectDepartements.php";









//$adsCatHandler = new catadsCategory();
$adsCatHandler = catadsCategory::getHandler();
$adsPermHandler = catadsPermHandler::getHandler();

define('_CATADS_SHOW_TPL_NAME', $xoopsModuleConfig['displayTemplateName'] );

?>