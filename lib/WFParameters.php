<?php

namespace M42e\WorkflowIs;
use \CFPropertyList\CFPropertyList;
use \CFPropertyList\CFDictionary;

/**
 * Action element of workflow
 *
 * @package default
 * @subpackage default
 * @author Matthias Bilger
 */
class WFParameters{
	private $params;
	public function __construct($parameters){
		//$this->data = $parameters;
		$this->params = array();
		foreach($parameters as $key => $param){
			$class = __NAMESPACE__.'\\Parameter\\'.$key;
			if(class_exists($class)){
				array_push($this->params, new $class($param));
			}
		}
	}
	public function getValue(){
		return $this->data->getValue();
	}
	public function get($param){
		return $this->data->get($param);
	}
	public function getInfo(){
		$info = array();
		foreach($this->params as $value){
			array_push($info, $value->getInfo());
		}
		return $info;
	}

	public function getControlFlowMode(){
		$element = $this->data->get('WFControlFlowMode');
		if($element == null){
			return 0;
		}
		return $element->getValue();
	}
	public function getNestingId(){
		return 1 ;
	}
}
