<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFGetLatestPhotoCount
 * @author Matthias Bilger
 */

class WFGetLatestPhotoCount extends WFParameter
{
	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'Count';
	}
}
