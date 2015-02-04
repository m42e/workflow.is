<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFDropboxShowSave
 * @author Matthias Bilger
 */

class WFDropboxShowSave extends WFParameter
{

	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'Show save';
	}
}
