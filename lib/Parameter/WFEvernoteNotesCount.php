<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFEvernoteNotesCount
 * @author Matthias Bilger
 */

class WFEvernoteNotesCount extends WFParameter
{
	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'Count';
	}
}
