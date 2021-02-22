<?php
//include_once XOOPS_ROOT_PATH.'/modules/catads/include/functions.php';
include_once XOOPS_ROOT_PATH.'/class/xoopstree.php';

function b_catads_add() {
global $xoopsDB;
	$xt = new XoopsTree($xoopsDB->prefix("catads_cat"),'topic_id','topic_pid');
	$jump = XOOPS_URL."/modules/catads/submit.php?topic_id=";
	ob_start();
	$xt->makeMySelBox('topic_title','topic_title',0,1, 'topic_pid', "location=\"".$jump."\"+this.options[this.selectedIndex].value");
	$block['selectbox'] = ob_get_contents();
	ob_end_clean();
    return $block;
}
		
?>