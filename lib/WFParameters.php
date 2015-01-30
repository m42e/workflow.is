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
				$this->params[$key] = new $class($param);
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
			$val = $value->getInfo();
			if($val != null){
				array_push($info, $value->getInfo());
			}
		}
		return $info;
	}

	public function getControlFlowMode(){
		if(!array_key_exists('WFControlFlowMode', $this->params)){
			return null;
		}
		return $this->params['WFControlFlowMode']->getValue();
	}
	public function getNestingId(){
		if($this->hasGroupingId()){
			return $this->params['GroupingIdentifier']->getValue();
		}
		return 0;
	}
	private function hasGroupingId(){
		return array_key_exists('GroupingIdentifier', $this->params);
	}
}
