<?php

include '../../mainfile.php';
include_once XOOPS_ROOT_PATH.'/modules/catads/class/ads.php';

$com_itemid = isset($_GET['com_itemid']) ? intval($_GET['com_itemid']) : 0;

if ($com_itemid > 0) {
        $ads_handler = & xoops_getmodulehandler('ads');
        //$ads_handler = & xoops_getmodulehandler('ads', 'catads');
        //$ads = & $ads_handler->get($com_itemid);
        $ads = $ads_handler->get($com_itemid);		
        $com_replytitle = $ads->getVar('ads_title');
        include XOOPS_ROOT_PATH.'/include/comment_new.php';
}

?>