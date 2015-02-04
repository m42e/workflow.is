<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFDropboxFilePath
 * @author Matthias Bilger
 */

class WFDropboxFilePath extends WFParameter
{

	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'Filename';
	}
}
