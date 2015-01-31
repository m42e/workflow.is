<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFMathOperation
 * @author Matthias Bilger
 */

class WFVolume extends WFParameter
{
	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'Volume';
	}

}
