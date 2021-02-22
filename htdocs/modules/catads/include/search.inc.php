<?php

global $xoopsModule;
function catads_search($queryarray, $andor, $limit, $offset, $userid){
	global $xoopsDB;
	
	$sql = "SELECT ads_id, uid, ads_title, published FROM ".$xoopsDB->prefix("catads_ads")." WHERE published >0  AND expired >".time()."";
	if ( $userid != 0 ) {
		$sql .= " AND uid=".$userid." ";
	} 
	
	// parce que count() retourne 1 même si une variable fournie
	// n'est pas une table, vérifier si $querryarray est vraiment une table
	if ( is_array($queryarray) && $count = count($queryarray) ) {
		$sql .= " AND ((ads_desc LIKE '%$queryarray[0]%' OR ads_title LIKE '%$queryarray[0]%' OR ads_tags LIKE '%$queryarray[0]%')";
		for($i=1;$i<$count;$i++){
			$sql .= " $andor ";
			$sql .= "(ads_desc LIKE '%$queryarray[$i]%' OR ads_title LIKE '%$queryarray[$i]%' OR ads_tags LIKE '%$queryarray[0]%')";
		}
		$sql .= ") ";
	}
	$sql .= "ORDER BY published DESC";
	$result = $xoopsDB->query($sql,$limit,$offset);
	$ret = array();
	$i = 0;
 	while($myrow = $xoopsDB->fetchArray($result)){
		$ret[$i]['image'] = "images/annonces.png";
		$ret[$i]['link'] = "adsitem.php?ads_id=".$myrow['ads_id']."";
		$ret[$i]['title'] = $myrow['ads_title'];
		$ret[$i]['time'] = $myrow['published'];
		$ret[$i]['uid'] = $myrow['uid'];
		$i++;
	}
	return $ret;
}
?>