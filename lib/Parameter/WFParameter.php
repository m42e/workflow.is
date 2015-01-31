<?php

namespace M42e\WorkflowIs\Parameter;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * Action element of workflow
 *
 * @package default
 * @subpackage default
 * @author Matthias Bilger
 */
class WFParameter{
	protected $data = null;
	protected $label = null;
	public function __construct($options){
		$this->data = $options;
	}
	public function getValue(){
		return $this->data->getValue();
	}
	private function defaultInfo(){

	}

	public function getInfo(){
		if($this->label != null){
			if($this->hasValueElement()){
				if($this->isStringValue()){
					return $this->label.': '.$this->decodeStringValue();
				}else if($this->isAsk()){
					return $this->label.': Ask';
				}else if($this->isVariable()){
					return $this->label.': {{{'.$this->getValueElement()->get('VariableName')->getValue().'}}}';
				}else if($this->isClipboard()){
					return $this->label.': Clipboard';
				}
									
			}
			if($this->isDate()){
				return $this->getDate();
			}
			if($this->isContact()){
				return $this->getContacts();
			}
			if(is_array($this->data->getValue())){
				echo '<pre>';
				var_dump(get_class($this));
				var_dump($this->data->getValue());
				return $this->label.': '.join(' ', $this->data->getValue());
			}
			return $this->label.': '.$this->data->getValue();
		}
		return null;
	}
	private function getContacts(){
		if($this->getValueElement()->get('WFContactFieldValues') != null && is_array($this->getValueElement()->get('WFContactFieldValues')->getValue())){
			$listitem = $this->label.":\n";
			foreach($this->getValueElement()->get('WFContactFieldValues')->getValue() as $element){
				if(get_class($element) != 'CFPropertyList\CFDictionary'){
					$listitem .= '- '.$element->getValue()."\n";
				}else if($element->get('WFContactData')){
					$listitem .= '- VCARD';//base64_decode($element->get('WFContactData')->getValue())."\n";
				}
			}
			return $listitem;
		}
		return null;
	}

	public function getControlFlowMode(){
		if(get_class($this) == 'WFControlFlowMode'){
			return 0;
		}
		return $this->getValue();
	}
	public function getNestingId(){
		return $this->get('GroupingIdentifier')->getValue();
	}

	protected function getValueElementType(){
		if (!$this->hasValueElement())
			return '';
		$valueElement = $this->getValueElement();
		if($valueElement->get('Type') == null){
			return null;
		}
		return $this->getValueElement()->get('Type')->getValue();
	}
	protected function getValueElement(){
		return $this->data->get('Value');
	}
	protected function hasValueElement(){
		return $this->has('Value') != null;
	}
	private function isType($type){
		return $this->has('Value') 
			&& $this->getValueElement()->get('Type') != null
			&& $this->getValueElement()->get('Type')->getValue() == $type;
	}
	protected function isClipboard(){
		return $this->isType('Clipboard');
	}
	protected function isAsk(){
		return $this->isType('Ask');
	}
	protected function isVariable(){
		return $this->isType('Variable');
	}
	protected function getDate(){
		return date(DATE_RFC2822, $this->data->getValue());
	}
	protected function isDate(){
		return get_class($this->data) == 'CFPropertyList\CFDate';
	}
	protected function isContact(){
		return $this->has('Value') 
			&& $this->getValueElement()->get('WFContactFieldValues') != null;
	}
	protected function isStringValue(){
		return $this->has('Value') 
			&& $this->getValueElement()->get('string') != null
			&& $this->getValueElement()->get('attachmentsByRange');
	}
	protected function decodeStringValue(){
		if(!$this->isStringValue()){
			return null;
		}

		$value = $this->getValueElement();
		$string = $value->get('string')->getValue();
		$array = $value->get('attachmentsByRange')->toArray();
		$vararray = array();
		foreach($array as $key => $attachment){
			if(preg_match('/\{\s*(?P<pos>\d+)\s*,\s*(?P<len>\d+)\s*\}/', $key, $matches)){
				if(array_key_exists('VariableUUID', $attachment) && $attachment['VariableUUID'] == "00000000-0000-0000-0000-000000000000"){
					$vararray[$matches['pos']] = 'Input';
				}else if(array_key_exists('VariableName', $attachment)){
					$vararray[$matches['pos']] = $attachment['VariableName'];
				}else{
					$vararray[$matches['pos']] = $attachment['Type'];
				}
			}
		}
		if(count($vararray) != 0){
			krsort($vararray);
			//$string = mb_convert_encoding($string, 'ASCII');
			$encoding = 'UTF-8';
			$convmap = array(0, 0xffff, 0, 0xffff);

			$string = preg_replace('/\xef../s', '', $string);

			$offset = count($vararray)-1;
			foreach($vararray as $key => $var){
				$string = mb_substr($string, 0, $key - $offset).'{{{'.$var.'}}}'.mb_substr($string, $key - $offset );
				$offset--;
			}
		}
		return $string;
	}
	protected function has($id){
		if(get_class($this->data) != 'CFPropertyList\CFDictionary'){
			return false;
		}
		return $this->data != null && $this->data->get($id) != null;
	}
	protected function get($id){
		if(!$this->has($id))
			return null;
		return $this->data->get($id)->getValue();
	}
}
