<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFVariable
 * @author Matthias Bilger
 */

class WFVariable extends WFParameter
{
	public function getInfo(){
		if($this->getValueElementType() != 'Variable'){
			return '';
		}
		return 'Variable Name: '. $this->getValueElement()->get('VariableName')->getValue();
	}
}
