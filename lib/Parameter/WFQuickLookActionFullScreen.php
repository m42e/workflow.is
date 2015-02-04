<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFQuickLookActionFullScreen
 * @author Matthias Bilger
 */

class WFQuickLookActionFullScreen extends WFParameter
{

	public function getInfo(){
		return ($this->data->getValue() == 1)?'Fullscreen':null;
	}
}
