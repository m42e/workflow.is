<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFNumberActionNumber
 * @author Matthias Bilger
 */

class WFNumberActionNumber extends WFParameter
{
	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'Number';
	}
	public function getInfo(){
		if($this->data != null && !is_array($this->data->getValue())){
			return parent::getInfo();
		}
		if($this->hasValueElement()){
			if($this->isStringValue()){
				return $this->label.': '.$this->decodeStringValue();
			}
		}
		return null;
	}

}
