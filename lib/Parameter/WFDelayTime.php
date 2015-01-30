<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFDelayTime
 * @author Matthias Bilger
 */

class WFDelayTime extends WFParameter
{
	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'Delay';
	}

}
