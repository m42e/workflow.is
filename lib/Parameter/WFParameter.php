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
	public function __construct($options){
		$this->data = $options;
	}
	public function getValue(){
		return $this->data->getValue();
	}
	public function get($param){
		return $this->data->get($param);
	}
	public function getInfo(){
		return null;
	}

	private function getValueInfo($element){
		$info = '';
		if(is_array($element)){
			foreach($element as $key => $sub){
				if(is_array($sub)){
					if(array_key_exists('Type', $sub)){
						switch($sub['Type']){
						case 'Variable':
							$info .= $sub['VariableName'].' ';
							break 2;
						case 'GroupingIdentifier':
							break;
						case 'Ask':
							$info .= 'Ask';
							break;
						default:
							$info .='!!!'.$sub['Type'].' ';
							break;
						}
					}else{
						$info .= $this->getValueInfo($sub);
					}
				}else{
					if(is_numeric($key)){
						$info .= $sub."\n";
					}else{
					switch($key){
					case 'string':
						$info .= $sub;
						break;
					case 'WFSerializationType':
						break;
					default:
						$info .= '('.$key.'==>'.$sub.') ';
					}
					}
				}
			}
		}else{
			$info = $element;
		}
		return $info;
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
}
