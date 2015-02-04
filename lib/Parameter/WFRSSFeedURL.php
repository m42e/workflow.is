<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFRSSFeedURL
 * @author Matthias Bilger
 */

class WFRSSFeedURL extends WFParameter
{

	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'Feed URL';
	}
}
