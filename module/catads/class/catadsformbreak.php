<?php

class XoopsFormBreak extends XoopsFormElement {

	/**
     * Text
	 * @var	string	
	 * @access	private
	 */
	var $_value;

	/**
	 * Constructor
	 * 
	 * @param	string	$caption	Caption
	 * @param	string	$value		Text
	 */
	function __construct($ind=0,$caption="", $value=""){
		$this->setName('_break'.$ind);
		$this->setCaption($caption);
		$this->_value = $value;
	}

	/**
	 * Get the text
	 * 
	 * @return	string
	 */
	function getValue(){
		return $this->_value;
	}

	/**
	 * Prepare HTML for output
	 * 
	 * @return	string
	 */
	function render(){
		return $this->getValue();
	}
}
?>