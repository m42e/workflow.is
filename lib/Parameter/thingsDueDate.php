<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFSendMessageActionRecipients
 * @author Matthias Bilger
 */

class thingsDueDate extends WFParameter
{
	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'Due date:';
	}
}

