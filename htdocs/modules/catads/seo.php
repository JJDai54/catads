<?php
//CPascalWeb - 24 février 2011 - correction seo
include_once("../../mainfile.php");

$seoOp = $_GET['seoOp'];
$seoArg = $_GET['seoArg'];
$seoOther = $_GET['seoOther'];

if (!empty($seoOther))
{
	$seoOther = explode("/",$seoOther);
}

$seoMap = array(
	'categorie' => 'adslist.php',
	'annonce' => 'adsitem.php'
);

if (! empty($seoOp) && ! empty($seoMap[$seoOp]))
{
//modif CPascalWeb - 24 février 2011 - correction seo
	//$newUrl = '/modules/'.$xoopsModule->dirname().'/' . $seoMap[$seoOp];
	$newUrl = XOOPS_URL.'/modules/catads/'. $seoMap[$seoOp];
//fin	
	$_ENV['PHP_SELF'] = $newUrl;
	$_SERVER['SCRIPT_NAME'] = $newUrl;
	$_SERVER['PHP_SELF'] = $newUrl;
	switch ($seoOp) {
		case 'categorie':
			$_SERVER['REQUEST_URI'] = $newUrl .'?topic_id='. $seoArg;
			$_GET['topic_id'] = $seoArg;

		break;
		
		case 'annonce':
			$_SERVER['REQUEST_URI'] = $newUrl .'?ads_id='. $seoArg;
			$_GET['ads_id'] = $seoArg;
		break;
	}
	include( $seoMap[$seoOp]);
}

exit;

?>