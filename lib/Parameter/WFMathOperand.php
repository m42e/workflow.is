<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFMathOperand
 * @author Matthias Bilger
 */

class WFMathOperand extends WFParameter
{

	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'Operand';
	}
	public function getInfo(){
		if(!is_array($this->data->getValue())){
			return parent::getInfo();
		}
		if($this->hasValueElement()){
			$type = $this->getValueElementType();
			if($type == 'Variable'){
				return $this->label.': '.$this->getValueElement()->get('VariableName')->getValue();
			}
		}
		return null;
	}
}
