<?php

include_once(XOOPS_ROOT_PATH."/class/xoopstree.php");

class catadsCategory{

    var $db;
	var $table;
	var $topic_id;
	var $topic_pid;
	var $topic_title;	
	var $topic_desc;
	var $img;
	var $display_cat;
	var $weight;
	var $display_price;
	var $nb_photo;
	
	function __construct($topic_id=0){
    global $xoopsDB;
		//$this->db =& Database::getInstance();
		//$this->db = Database::getInstance();		
		$this->db = $xoopsDB;		
        $this->table = $this->db->prefix("catads_cat");

		if ( is_array($topic_id) ) {
			$this->makeCategory($topic_id);
		} elseif ( $topic_id != 0 ) {
			$this->loadCategory($topic_id);
		} else {
			$this->topic_id = $topic_id;
		}
	}

	function &getHandler()
	{
		static $catHandler;
		if(!isset($catHandler)) {
			$catHandler = new catadsCategory();
		}
		return $catHandler;
	}


// set
	function setTitle($value){
		$this->topic_title = $value;
	}
	
    function setDesc($value){
		$this->topic_desc = $value;
	}

	function setImg($value){
		$this->img = $value;
	}
	
    function setPid($value){
        $this->topic_pid = $value;
    }
	
	function setWeigth($value){
        $this->weight = $value;
    }
	
	function setDisplayCat($value){
        $this->display_cat = $value;
    }
	
	function setPrice($value){
        $this->display_price = $value;
    }
	
	function setPhoto($value){
        $this->nb_photo = $value;
    }

// base de donnée
	function loadCategory($topic_id){
		$sql = "SELECT * FROM ".$this->table." WHERE topic_id=".$topic_id."";
		$array = $this->db->fetchArray($this->db->query($sql));
		$this->makeCategory($array);
	}

	function makeCategory($array){
		foreach($array as $key=>$value){
			$this->$key = $value;
		}
	}

	function store(){
//		global $myts;
        //$myts =& MyTextSanitizer::getInstance();
        $myts = MyTextSanitizer::getInstance();		
        $title = "";
		$desc = "";
		$img = "";

		if ( isset($this->topic_title) && $this->topic_title != "" ) {
			$title = $myts->addSlashes($this->topic_title);
		}
		if ( isset($this->topic_desc) && $this->topic_desc != "" ) {
			$desc = $myts->addSlashes($this->topic_desc);
		}
        if ( isset($this->img) && $this->img != "" ) {
			$img = $myts->addSlashes($this->img);
		}
 		if ( !isset($this->topic_pid) || !is_numeric($this->topic_pid) ) {
			$this->topic_pid = 0;
		}
 		if ( !isset($this->display_price) || !is_numeric($this->display_price) ) {
			$this->display_price = 1;
		}

		if ( empty($this->topic_id) ) {
			$this->topic_id = $this->db->genId($this->table."_topic_id_seq");
			$sql = "INSERT INTO ".$this->table." (topic_id, topic_pid, topic_title, topic_desc, img, display_cat, weight, display_price, nb_photo) 
				VALUES (".$this->topic_id.", 
						".$this->topic_pid.", 
						'".$title."',
						'".$desc."',						
						'".$img."',
						'".$this->display_cat."', 
						'".$this->weight."',
						'".$this->display_price."', 
						'".$this->nb_photo."')";
		} else {
			$sql = "UPDATE ".$this->table." 
				SET topic_pid=".$this->topic_pid.", 
					img='".$img."', 
					topic_title='".$title."',
					topic_desc='".$desc."',
					display_cat='".$this->display_cat."', 
					weight='".$this->weight."',
					display_price='".$this->display_price."',
					nb_photo='".$this->nb_photo."' 
				WHERE topic_id=".$this->topic_id." ";
		}
//echo $sql;
		if ( !$result = $this->db->query($sql) ) {
			ErrorHandler::show('0022');
		}
		return true;
	}

	function delete(){
		$sql = "DELETE FROM ".$this->table." WHERE topic_id=".$this->topic_id."";
		$this->db->query($sql);
	}

// obtenir
	function topic_id(){
		return $this->topic_id;
	}

	function topic_pid(){
		return $this->topic_pid;
	}

	function topic_title($format="S"){
	 	if (!isset($this->topic_title)) return "";
			//$myts =& MyTextSanitizer::getInstance();
			$myts = MyTextSanitizer::getInstance();			
			switch($format){
			case "S":
				$title = $myts->htmlSpecialChars($this->topic_title);
				break;
			case "E":
				$title = $myts->htmlSpecialChars($this->topic_title);
				break;
			case "P":
				$title = $myts->htmlSpecialChars( $myts->stripSlashesGPC($this->topic_title) );
				break;
			case "F":
				$title = $myts->htmlSpecialChars( $myts->stripSlashesGPC($this->topic_title) );
				break;
			}
		return $title;
	}
	
	function topic_desc($format="S"){
	 	if (!isset($this->topic_desc)) return "";
			//$myts =& MyTextSanitizer::getInstance();
			$myts = MyTextSanitizer::getInstance();			
			switch($format){
			case "S":
				$desc = $myts->htmlSpecialChars($this->topic_desc);
				break;
			case "E":
				$desc = $myts->htmlSpecialChars($this->topic_desc);
				break;
			case "P":
				$desc = $myts->htmlSpecialChars( $myts->stripSlashesGPC($this->topic_desc) );
				break;
			case "F":
				$desc = $myts->htmlSpecialChars( $myts->stripSlashesGPC($this->topic_desc) );
				break;
			}
		return $desc;
	}

	function img($format="S"){
		//$myts =& MyTextSanitizer::getInstance();
		$myts = MyTextSanitizer::getInstance();		
		switch($format){
			case "S":
				$img= $myts->htmlSpecialChars($this->img);
				break;
			case "E":
				$img = $myts->htmlSpecialChars($this->img);
				break;
			case "P":
				$img = $myts->htmlSpecialChars( $myts->stripSlashesGPC($this->img) );
				break;
			case "F":
				$img = $myts->htmlSpecialChars( $myts->stripSlashesGPC($this->img) );
				break;
			}
		return $img;
	}

	function weight(){
		return $this->weight;
	}

	function display_price(){
		return $this->display_price;
	}
	

    function countCat($main = 0){
    	//$db =& Database::getInstance();
    	//$db = Database::getInstance();		
         $sql = "SELECT COUNT(*) FROM ". $this->db->prefix("catads_cat")."";
         if ( $main!= 0 ) {
             $sql .= " WHERE topic_pid = 0";
         }
         $result = $this->db->query($sql);
         list($count) = $this->db->fetchRow($result);
         return $count;
     }

    function getCatWithPid($sel_pid = 0){
		//$db =& Database::getInstance();
		//$db = Database::getInstance();		
		$sql ="SELECT topic_id, topic_title, topic_desc, img FROM ". $this->db->prefix('catads_cat')." WHERE topic_pid = ".$sel_pid." ORDER BY weight";
		$result = $this->db->query($sql);		
		$ret = array();
		while ($myrow = $this->db->fetchArray($result)) {
			$ret[] = new catadsCategory($myrow);
		}
		return $ret;
     }

	function getAllChild(){
		$ret = array();
		$xt = new XoopsTree($this->table, "topic_id", "topic_pid");
		$category_arr = $xt->getAllChild($this->topic_id);
		if ( is_array($category_arr) && count($category_arr) ) {
			foreach($category_arr as $category){
				$ret[] = new catadsCategory($category);
			}
		}
		return $ret;
	}

	function getFirstChildArr($sel_id, $order=""){
		//$db =& Database::getInstance();
		//$db = Database::getInstance();		
		$arr =array();
		$sql = "SELECT * FROM ". $this->db->prefix("catads_cat")." WHERE topic_pid =".$sel_id." AND display_cat = 1 ";
		if ( $order != "" ) {
			$sql .= " ORDER BY $order";
		}
		$result = $this->db->query($sql);
		$count = $this->db->getRowsNum($result);
		if ( $count==0 ) {
			return $arr;
		}
		while ( $myrow=$this->db->fetchArray($result) ) {
			array_push($arr, $myrow);
		}
		return $arr;
	}
	
	function getFirstChildArr2($sel_id, $order=""){
		//$db =& Database::getInstance();
		//$db = Database::getInstance();		
		$arr =array();
		$sql = "SELECT * FROM ". $this->db->prefix("catads_cat")." WHERE topic_pid =".$sel_id."";
		if ( $order != "" ) {
			$sql .= " ORDER BY $order";
		}
		$result = $this->db->query($sql);
		$count = $this->db->getRowsNum($result);
		if ( $count==0 ) {
			return $arr;
		}
		while ( $myrow=$this->db->fetchArray($result) ) {
			array_push($arr, $myrow);
		}
		return $arr;
	}

// array des cid dernier enfant
	function getAllLastChild(){
	    //$db =& Database::getInstance();
	    //$db = Database::getInstance();		
        $sql = "SELECT topic_id, topic_pid FROM ". $this->db->prefix("catads_cat");
		$result = $this->db->query($sql);
        $i = 0;
		while($myrow = $this->db->fetchArray($result)) {
			$arr1_cat[$i]['cid'] = $myrow['topic_id'];
			$arr1_cat[$i]['pid'] = $myrow['topic_pid'];
			$arr1_cat[$i]['last'] = true;
			$i++;
		}
		for ( $j = 0; $j < $i; $j++ ) {
			$cat = $arr1_cat[$j]['cid'];
			for ( $k = 0; $k < $i; $k++ ) {
				if ($cat == $arr1_cat[$k]['pid']) $arr1_cat[$j]['last'] = false;
			}
		}
		$arr2_cat = array();
		for ( $j = 0; $j < $i; $j++ ) {
		if ($arr1_cat[$j]['last']) $arr2_cat[]=$arr1_cat[$j]['cid'];
		}
		return $arr2_cat;
	}

//toutes catégories
	function getAllCat(){
	    //$db =& Database::getInstance();
	    //$db = Database::getInstance();	
        	
        $sql = "SELECT * FROM ". $this->db->prefix("catads_cat")." ORDER BY weight";
		$result = $this->db->query($sql);		
		$arr = array();
		while($myrow = $this->db->fetchArray($result)) {
			array_push($arr, $myrow);
			}
		return $arr;
	}
	


}
?>
