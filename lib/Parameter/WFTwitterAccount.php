<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFTwitterAccount
 * @author Matthias Bilger
 */

class WFTwitterAccount extends WFParameter
{

	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'Twitter account';
	}
}
