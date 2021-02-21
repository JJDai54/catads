<?php

class catadsOption extends XoopsObject {
    var $db;
	
	function __construct() {
    global $xoopsDB;
		//$this->XoopsObject();
		parent::__construct();
        
	    //$this -> db = & Database :: getInstance();
	    $this->db = $xoopsDB; //Database :: getInstance();		
		$this->initVar('option_id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('option_type', XOBJ_DTYPE_INT, null, false);
		$this->initVar('option_desc', XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar('option_order', XOBJ_DTYPE_INT, null, false);
	}
	
	function makeMySelBox($order="", $preset_value='', $none=0, $sel_type, $onchange="") {
		//$myts =& MyTextSanitizer::getInstance();
		$myts = MyTextSanitizer::getInstance();		
		echo "<select name='option".$sel_type."'";
		if ( $onchange != "" ) {
			echo " onchange='".$onchange."'";
		}
		echo ">\n";
		$sql = "SELECT option_desc FROM ".$this->db->prefix('catads_options')." WHERE option_type=".$sel_type;
		if ( $order != "" ) {
			$sql .= " ORDER BY $order";
		}
		$result = $this->db->query($sql);
		if ( $none ) {
			echo "<option value='0'>----</option>\n";
		}
		while ( list($name) = $this->db->fetchRow($result) ) {
			$sel = "";
			if ( $name == $preset_value ) {
				$sel = " selected='selected'";
			}
			echo "<option value='$name'$sel>$name</option>\n";
			$sel = "";
		}
		echo "</select>\n";
	}
}


class catadsOptionHandler
{
	var $db;

	function catadsOptionHandler(&$db)
	{
		//$this->db =& $db;
		$this->db = $db;		
	}

	function &getInstance(&$db)
	{
		static $instance;
		if (!isset($instance)) {
			$instance = new catadsOptionHandler($db);
		}
		return $instance;
	}

	function &create()
	{ 
		return new catadsOption();
		
	}

	function &get($id)
	{
		$id = intval($id);
		if ($id > 0) {
			$sql = 'SELECT * FROM '.$this->db->prefix('catads_options').' WHERE option_id='.$id;
			if (!$result = $this->db->query($sql)) {
				return false;
			}
			$numrows = $this->db->getRowsNum($result);
			if ($numrows == 1) {
				$option = new catadsOption();
				$option->assignVars($this->db->fetchArray($result));
				return $option;
			}
		}
		return false;
	}

	function insert(&$option)
	{
		if (strtolower(get_class($option)) != 'catadsoption') {
			return false;
		}
		if (!$option->cleanVars()) {
			return false;
		}
		foreach ($option->cleanVars as $k => $v) {
			${$k} = $v;
		}
		if (empty($option_id)) {
			$option_id = $this->db->genId('catads_option_option_id_seq');
			$sql = 'INSERT INTO '.$this->db->prefix('catads_options').' (option_id, option_type, option_desc, option_order) VALUES ('.$option_id.', '.$option_type.', '.$this->db->quoteString($option_desc).', '.$option_order.')';
		} else {
			$sql = 'UPDATE '.$this->db->prefix('catads_options').' SET option_type='.$option_type.', option_desc='.$this->db->quoteString($option_desc).', option_order='.$option_order.' WHERE option_id='.$option_id;
		}
		if (!$result = $this->db->queryF($sql)) {
			return false;
		}
		if (empty($option_id)) {
			$option_id = $this->db->getInsertId();
		}
		$option->assignVar('option_id', $option_id);
		return $option_id;
	}

	function delete(&$option){
        global $xoopsModule;
		if (strtolower(get_class($option)) != 'catadsoption') {
			return false;
		}
		$sql = sprintf("DELETE FROM %s WHERE option_id = %u", $this->db->prefix('catads_options'), $option->getVar('option_id'));
		if (!$result = $this->db->query($sql)) {
			return false;
		}
		return true;
	}
	
	function &getObjects($criteria = null)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->db->prefix('catads_options');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
            $sort = ($criteria->getSort() != '') ? $criteria->getSort() : 'option_id';
            $sql .= ' ORDER BY '.$sort.' '.$criteria->getOrder();
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}
		$result = $this->db->query($sql, $limit, $start);
		if (!$result) {
			return $ret;
		}
		while ($myrow = $this->db->fetchArray($result)) {
			$option = new catadsOption();
			$option->assignVars($myrow);
			//$ret[] =& $option;
			$ret[] = $option;			
			unset($option);
		}
		return $ret;
	}

	function optionIsValid($value, $type) {
		$ret = false;
		$sql = 'SELECT option_desc FROM '.$this->db->prefix('catads_options').' WHERE option_type = '.$type;
		if (!$result = $this->db->query($sql)) 
			return false;
		while ( list($name) = $this->db->fetchRow($result) ) {
			if($value == $name)
				$ret = true;
		}
		return $ret;
	}

}
?>