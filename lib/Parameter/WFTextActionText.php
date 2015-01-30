<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFTextActionText
 * @author Matthias Bilger
 */

class WFTextActionText extends WFParameter
{
	public function getInfo(){
		return $this->decodeStringValue();
	}

}
