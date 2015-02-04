<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFSendEmailActionToRecipients
 * @author Matthias Bilger
 */

class WFSendEmailActionToRecipients extends WFParameter
{

	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'To';
	}
}
