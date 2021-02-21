<?php

function catads_notify_iteminfo($category, $item_id)
{
        /*$module_handler =& xoops_gethandler('module');
        $module =& $module_handler->getByDirname('catads');*/
        $module_handler = xoops_gethandler('module');
        $module = $module_handler->getByDirname('catads');		

        if ($category=='global') {
                $item['name'] = '';
                $item['url'] = '';
                return $item;
        }

        global $xoopsDB;

        if ($category=='ads')
        {
        $sql = 'SELECT ads_title FROM ' . $xoopsDB->prefix("catads_ads").  ' WHERE ads_id = ' . $item_id . ' LIMIT 1';
        $result = $xoopsDB->query($sql); // TODO: error check
        $result_array = $xoopsDB->fetchArray($result);
        $item['name'] = $result_array['ads_title'];
        $item['url'] = XOOPS_URL . '/modules/catads/adsitem.php?ads_id=' . intval($item_id);

        return $item;
        } else {
        return null;
        }
}
?>