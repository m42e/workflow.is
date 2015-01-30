<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFVariableName
 * @author Matthias Bilger
 */

class WFVariableName extends WFParameter
{

	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'Variable Name';
	}
}
