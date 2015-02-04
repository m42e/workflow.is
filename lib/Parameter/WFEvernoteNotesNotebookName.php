<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFEvernoteNotesNotebookName
 * @author Matthias Bilger
 */

class WFEvernoteNotesNotebookName extends WFParameter
{
	public function __construct($options){
		 parent::__construct($options);
		 $this->label = 'Notebook';
	}
}
