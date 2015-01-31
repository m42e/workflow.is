<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFURLActionURL
 * @author Matthias Bilger
 */

class WFURLActionURL extends WFTextActionText
{
	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'URL';
	}
	public function getInfo(){
		if(is_array($this->data->getValue())){
			return parent::getInfo();
		}
		return $this->label.': '.$this->data->getValue();
	}

}
