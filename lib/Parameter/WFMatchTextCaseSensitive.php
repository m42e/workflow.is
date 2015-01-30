<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFMatchTextCaseSensitive
 * @author Matthias Bilger
 */

class WFMatchTextCaseSensitive extends WFParameter
{
	public function getInfo(){
		return 'CaseSensitive';
	}

}
