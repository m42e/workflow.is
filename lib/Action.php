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
class Action{

	/**
	 * Type of action 
	 * @author Matthias Bilger
	 **/
	protected $typename;

	/**
	 * value of the action 
	 *
	 * @var string
	 */
	protected $parameters;

	/**
	 * Create a new Action;
	 *
	 * @return Action
	 * @author Matthias Bilger
	 */
	public static function createAction(CFDictionary $action){
		$actionname = $action->get('WFWorkflowActionIdentifier')->getValue();
		$actionname = str_replace('is.workflow.actions.', '', $actionname);
		$actionname = str_replace('.', ' ', $actionname);
		$actionname = ucwords($actionname);

		return new self($actionname, $action->get('WFWorkflowActionParameters'));

	}

	private function __construct($typename, $parameter){
		$this->parameters = new WFParameters($parameter);
		$this->typename = $typename;
	}

	/*
	 * Getter for typename
	 */
	public function getTypename()
	{
		return $this->typename;
	}
	/*
	 * Getter for parameters
	 */
	public function getParameters()
	{
		return $this->parameters;
	}
	
	public function getInfo(){
		return $this->parameters->getInfo();
	}

	public function nesting(array &$nestingStack){
		$pushed =false;	
		$nesting = array('increase' => false, 'decrease' => false);
		if($this->_increaseNesting($nestingStack[0])){
			$nesting['increase'] = true;
			if($nestingStack[0]['id'] != $this->parameters->getNestingId()){
				array_unshift($nestingStack, array('id'=>$this->parameters->getNestingId(), 'count' => $this->getConditionalCount()));
				$pushed =  true;
			}
		}
		if(!$pushed && $this->_decreaseNesting($nestingStack[0])){
			if($nestingStack[0]['count'] == 1){
				array_shift($nestingStack);
			}else{
				$nestingStack[0]['count'] -= 1;
			}
			$nesting['decrease'] = true;
		}
		return $nesting;
	}
	private function getConditionalCount(){
		if($this->typename == 'Conditional'){
			return 2;
		}
		return 1;
	}
	/**
	 * decreaseNesting
	 * @return boolean
	 * @author Matthias Bilger
	 **/
	private function _decreaseNesting($element)
	{
		$decrease = false;
		if($this->typename == 'Conditional' && $this->parameters->getNestingId() == $element['id']){
			$decrease = true;
		}
		if(($this->typename == 'Repeat Each' || $this->typename == 'Repeat Count') && $this->parameters->getNestingId() == $element['id']){
			$decrease = true;
		}
		if($this->typename == 'Choosefrommenu' && $this->parameters->getControlFlowMode() == 2){
			$decrease = true;
		}
		return $decrease;
	}
	/**
	 * increaseNesting
	 * @return boolean
	 * @author Matthias Bilger
	 **/
	private function _increaseNesting($element)
	{
		$increase = false;
		if($this->typename == 'Conditional' && ($this->parameters->getNestingId() != $element['id'] || ($this->parameters->getNestingId() == $element['id'] && $element['count'] >= 2))){
			$increase = true;
		}
		if(($this->typename == 'Repeat Each' || $this->typename == 'Repeat Count') && $this->parameters->getNestingId() != $element['id']){
			$increase = true;
		}
		if($this->typename == 'Choosefrommenu' && $this->parameters->getControlFlowMode() == 0){
			$increase = true;
		}
		return $increase;
	}
	
}
