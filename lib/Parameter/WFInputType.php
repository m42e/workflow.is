<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFInputType
 * @author Matthias Bilger
 */

class WFInputType extends WFParameter
{
	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'Type';
	}

}
