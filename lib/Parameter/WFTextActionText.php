<?php

namespace M42e\WorkflowIs\Parameter;
use \M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * WFTextActionText
 * @author Matthias Bilger
 */

class WFTextActionText extends WFParameter
{

	public function getInfo(){
		$value = $this->data->get('Value');
		if($value != null){
			$string = $value->get('string')->getValue();
			foreach($value->get('attachmentsByRange') as $key => $attachment){
				if(preg_match('/\{\s*(?P<pos>\d+)\s*,\s*(?P<len>\d+)\s*\}/', $key, $matches)){
					$insertString = $attachment->get('VariableName');
					if($insertString != null)
					$string = substr($string, 0, $matches['pos']).$insertString->getValue().substr($string, $matches['pos']+$matches['len']);
				}
			}
			return $string;
		}
		return null;
	}

}
