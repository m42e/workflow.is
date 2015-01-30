<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFTextCustomSeparator
 * @author Matthias Bilger
 */

class WFTextCustomSeparator extends WFParameter
{

	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'Separator';
	}
}
