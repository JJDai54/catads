<?php

if (!defined("XOOPS_ROOT_PATH")) {
	die("XOOPS root path not defined");
}

class catadsPermHandler {

	function &getHandler()
	{
		static $permHandler;
		if(!isset($permHandler)) {
			$permHandler = new catadsPermHandler();
		}
		return $permHandler;
	}

	function _getUserGroup(&$user) {
		if(is_a($user,'XoopsUser')) {
			return $user->getGroups();
		} else {
			return XOOPS_GROUP_ANONYMOUS;
		}
	}

	function getAuthorizedPublicCat(&$user, $perm) {
		static $authorizedCat;
		$userId = ($user) ? $user->getVar('uid') : 0;
		if(!isset($authorizedCat[$perm][$userId])) {
			/*$groupPermHandler =& xoops_gethandler('groupperm');
			$moduleHandler =& xoops_gethandler('module');*/
			$groupPermHandler = xoops_gethandler('groupperm');
			$moduleHandler = xoops_gethandler('module');			
			$module = $moduleHandler->getByDirname('catads');
			$authorizedCat[$perm][$userId] = $groupPermHandler->getItemIds($perm, $this->_getUserGroup($user), $module->getVar("mid"));
		}
		return $authorizedCat[$perm][$userId];
	}
	
	function isAllowed(&$user, $perm, $catId) {
		$autorizedCat = $this->getAuthorizedPublicCat($user, $perm);
		return in_array($catId, $autorizedCat);
	}
	
//Affichage liste en fonction des droits de l'internaute
	function listAds(&$user, $perm) {
		$autorizedCat = $this->getAuthorizedPublicCat($user, $perm);
		return $autorizedCat;
	}

}

?>