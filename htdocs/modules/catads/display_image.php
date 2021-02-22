<?php

include("../../mainfile.php");
xoops_header();

$img_id = (isset($_GET['img_id'])) ? $_GET['img_id'] : 1;
$ads_id = $_GET['ads_id'];
$array_id = $_GET['array_id'];
$n = explode('_',$array_id);
$nb_img = count($n)-1;

include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/ads.php");
/*$ads_handler =& xoops_getmodulehandler('ads');
$ads = & $ads_handler->get($ads_id);*/
$ads_handler = xoops_getmodulehandler('ads');
$ads = $ads_handler->get($ads_id);
$photo = $ads->getVar('photo'.$n[$img_id]);

echo "<CENTER><IMG SRC=\"".XOOPS_ROOT_PATH."/uploads/".$xoopsModule->dirname()."/images/annonces/original/".$photo."\" BORDER='0' alt='' /></CENTER><br />";

echo "<center><table><tr><td>";
if ($img_id > 1) {
        echo "<a href=\"display_image.php?array_id=".$array_id."&img_id=".($img_id-1)."&ads_id=".$ads_id."\" target=\"_self\"><<&nbsp;</a>";
}
echo "<a href=#  onClick='window.close()'>"._MD_CATADS_CLOSEF."</a>";
if ($img_id < ($nb_img)) {
        echo "<a href=\"display_image.php?array_id=".$array_id."&img_id=".($img_id+1)."&ads_id=".$ads_id."\" target=\"_self\">&nbsp;>></a>";
}
echo "</td></tr></table></center>";

xoops_footer();
?>