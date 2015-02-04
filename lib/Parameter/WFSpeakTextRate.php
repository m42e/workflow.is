<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFSpeakTextRate
 * @author Matthias Bilger
 */

class WFSpeakTextRate extends WFParameter
{
	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'Speak rate';
	}

}
