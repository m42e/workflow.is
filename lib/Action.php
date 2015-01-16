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

		return new self($actionname, $action->get('WFWorkflowActionParameter'));

	}

	private function __construct($typename, $parameter){
		$this->parameters = $parameter;
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
	
	
}
