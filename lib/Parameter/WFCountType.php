<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFCountType
 * @author Matthias Bilger
 */

class WFCountType extends WFParameter
{

	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'Count';
	}
}
