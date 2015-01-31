<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * ShortURL
 * @author Matthias Bilger
 */

class ShortURL extends WFParameter
{

	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'Short url';
	}
}
