<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFMenuItems
 * @author Matthias Bilger
 */

class WFMenuItems extends WFParameter
{
	public function getInfo(){
			$listitem = '';
			if(is_array($this->data->getValue())){
				$listitem = "Items:\n";
				foreach($this->data->getValue() as $element){
					$listitem .= '- '.$element->getValue()."\n";
				}
				return $listitem;
			}
			return null;
	}
}
