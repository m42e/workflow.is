<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFRepeatCount
 * @author Matthias Bilger
 */

class WFEvernoteNotesTitleSearch extends WFParameter
{
	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'Title';
	}
}
