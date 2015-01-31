<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFSendEmailActionSubject
 * @author Matthias Bilger
 */

class WFSendEmailActionSubject extends WFParameter
{

	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'Subject';
	}
}
