<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFTextSeparator
 * @author Matthias Bilger
 */

class WFTextSeparator extends WFParameter
{

	public function getInfo(){
		if($this->getValue() != 'Custom'){
			if($this->hasValueElement())
				return 'Seperator: '.$this->decodeStringValue();
			return 'Seperator: '. $this->getValue();
		}
	}
}
