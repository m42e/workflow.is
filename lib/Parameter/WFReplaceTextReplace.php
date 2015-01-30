<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFReplaceTextReplace
 * @author Matthias Bilger
 */

class WFReplaceTextReplace extends WFParameter
{
	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'Replace';
	}
}
