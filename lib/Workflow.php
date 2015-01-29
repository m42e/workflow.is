<?php

namespace M42e\WorkflowIs;

use \CFPropertyList\CFPropertyList;


class Workflow {
	const WORKFLOW_NAME_EXTENSION = 'name';
	const WORKFLOW_ID_REGEX = '/(?P<id>[a-y0-9]*)/';
	const WORKFLOW_URL_REGEX = '/(?P<url>https?:\/\/workflow.is\/workflows\/(?P<id>[a-y0-9]*))/';
	const WORKFLOW_URL_BASE = 'https://workflow.is/workflows/';
	const WORKFLOW_IMPORT_BASE = 'workflow://import-workflow/?url=';
	const WORKFLOW_IMAGE_URL = 'https://workflow-gallery.s3.amazonaws.com/workflow_icons/';
	const WORKFLOW_IMAGE_EXTENSION = 'png';
	const WORKFLOW_IMAGE_SIZE = 30;
	const WORKFLOW_FILE_URL = 'https://workflow-gallery.s3.amazonaws.com/workflows/';
	const WORKFLOW_FILE_EXTENSION = 'wflow';

	static $targetdir = __DIR__;

	/**
	 * The unique id of the workflow which is assigned on upload.
	 * @author Matthias Bilger
	 **/
	private $workflowId = '';
	/**
	 * The name of the workflow.
	 * This will be grabbed from the webview of the workflow.
	 * @author Matthias Bilger
	 **/
	private $name = '';
	/**
	 * The plist of the workflow.
	 * @see CFPropertyList
	 * @author Matthias Bilger
	 **/
	private $plist = null;
	/**
	 * Actions will be saved here if used.
	 *
	 * @var array of Action
	 */
	private $actions = null;
	/**
	 * Description of the workflow.
	 * @author Matthias Bilger
	 **/
	private $description = '';
	/**
	 * The last error occured.
	 * @author Matthias Bilger
	 **/
	private $error = '';

	/**
	 * Default Constructor 
	 * @author Matthias Bilger
	 **/
	private function __construct($workflowId, $name = '', $plist = null){
		$this->name = $name;
		$this->workflowId = $workflowId;
		$this->plist = $plist;
	}
	/**
	 * Extracts all workflow urls of a string.
	 * @author Matthias Bilger
	 **/
	public static function extractWorkflowUrls($text){
		preg_match_all(self::WORKFLOW_URL_REGEX, $text, $matches);
		return $matches['url'];
	}
	/**
	 * Creates a new workflow from given url.
	 *
	 * @author Matthias Bilger
	 **/
	public static function createFromUrl($url, $download = false){
		if(!preg_match(self::WORKFLOW_URL_REGEX, $url, $matches)){
			return new self('');
		}
		$workflow = new self($matches['id']);
		$workflow->loadName();
		if($download){
			$workflow->download();
		}
		return $workflow;
	}
	/**
	 * createFromId
	 * @return Workflow The new workflow.
	 * @author Matthias Bilger
	 **/
	public static function createFromId($workflowId, $loadName = true, $download = false)
	{
		if(!preg_match(self::WORKFLOW_ID_REGEX, $workflowId, $matches)){
			return new self('');
		}
		$workflow = new self($workflowId);
		if($loadName){
			$workflow->loadName();
		}
		if($download){
			$workflow->download();
		}
		return $workflow;
	}
	/**
	 * initialize static content
	 * @return void
	 * @author Matthias Bilger
	 **/
	private function staticInit()
	{

	}

	/*
	 * Getter for workflow filename.
	 */
	public function getFilename()
	{
		return $this->getWorkflowFilename();;
	}
	/*
	 * Getter for image filename.
	 */
	public function getImageFilename()
	{
		return $this->getWorkflowFilename(self::WORKFLOW_IMAGE_EXTENSION);;
	}
	

	/**
	 * Get the workflow id.
	 * @return string Workflow id.
	 * @author Matthias Bilger
	 **/
	public function getId(){
		return $this->workflowId;
	}
	/**
	 * Get the name of the workflow.
	 * @return string Name of the Workflow.
	 * @author Matthias Bilger
	 **/
	public function getName(){
		return $this->name;
	}
	/**
	 * Get the plist of the workflow.
	 * Loads the file if neccessary.
	 * @return CFPropertyList Workflow
	 * @author Matthias Bilger
	 **/
	public function getPlist(){
		$this->loadPlist();
		return $this->plist;
	}

	/**
	 * Load the filename from the workflow webview.
	 * @return void
	 * @author Matthias Bilger
	 **/
	public function loadName(){
		$localNameFile = $this->getWorkflowFilename(self::WORKFLOW_NAME_EXTENSION);
		if(!file_exists($localNameFile)){
			$website = file_get_contents(self::WORKFLOW_URL_BASE.$this->workflowId);

			if(!preg_match('/<title>(?P<name>.*?)( \(v[0-9.]*?\))?<\/title>/', $website, $namematches)){
				$this->workflowId = '';
				$this->name = '';
				$this->error = 'invalid url';
			}else{
				$this->name = html_entity_decode($namematches['name']);
				file_put_contents($localNameFile, $this->name);
				chmod($localNameFile, 0644);
				if(preg_match('/<h2>(?P<description>.*?)<\/h2>/', $website, $descmatches)){
					$this->description = $descmatches['description'];
				}
			}
		}else{
			$this->name = file_get_contents($localNameFile);
		}
	}

	/**
	 * Download the image and the file of the workflow.
	 * @return void
	 * @author Matthias Bilger
	 **/
	public function download(){
		if($this->workflowId == ''){
			$this->error = 'No id';
			return;
		}

		$this->downloadImage();
		$this->downloadFile();
	}

	/**
	 * Download and resizes the workflow image.
	 * @return void
	 * @author Matthias Bilger
	 **/
	private function downloadImage(){
		$workflowfile = $this->getWorkflowFilename(self::WORKFLOW_IMAGE_EXTENSION);
		$this->doDownloadFile($workflowfile, $this->buildImageUrl());
		$img = imagecreatefrompng($workflowfile);
		list($width, $height) = getimagesize($workflowfile);
		$newHeight = ($height / $width) * self::WORKFLOW_IMAGE_SIZE;
		$tmp = imagecreatetruecolor(self::WORKFLOW_IMAGE_SIZE, $newHeight);
		imagealphablending($tmp, false);
		imagesavealpha($tmp,true);
		imagecopyresampled($tmp, $img, 0, 0, 0, 0, self::WORKFLOW_IMAGE_SIZE, $newHeight, $width, $height);

		if (file_exists($workflowfile)) {
			unlink($workflowfile);
		}
		imagepng($tmp, $workflowfile);
		chmod($workflowfile, 0644);
	}
	/**
	 * Creates a filename for the workflow.
	 *
	 * The filename is dependent to the global setting of targetdir.
	 * A subfolder based on the last two chars of the workflowid is created if not exists.
	 *
	 * @return void
	 * @author Matthias Bilger
	 */
	private function getWorkflowFilename($extraExtension = ''){
		$subdir = substr($this->workflowId, -2);
		$targetdir = self::$targetdir.'/'.$subdir.'/';
		if (!file_exists($targetdir)) {
			mkdir($targetdir, 0777, true);
			chmod($targetdir, 0755);
		}
		return $targetdir.$this->workflowId.'.wflow'.(($extraExtension != '')?'.'.$extraExtension:'');
	}
	/**
	 * Build the url for the image.
	 *
	 * @return string URL for workflow image.
	 * @author Matthias Bilger
	 */
	private function buildImageUrl(){
		return $this->buildDownloadUrl(self::WORKFLOW_IMAGE_URL, self::WORKFLOW_IMAGE_EXTENSION);
	}
	/**
	 * Uuild a download url.
	 *
	 * @return string URL
	 * @author Matthias Bilger
	 */
	private function buildDownloadUrl($base, $extension = ''){
		return $base.$this->workflowId.(($extension != '')?'.'.$extension:'');
	}
	/**
	 * Download workflow file.
	 *
	 * @return void
	 * @author Matthias Bilger
	 */
	private function downloadFile(){
		$workflowfile = $this->getWorkflowFilename();
		$this->doDownloadFile($workflowfile, $this->buildFileUrl());
	}
	/**
	 * Build the URL for the workflow file.
	 *
	 * @return string URL for workflow file.
	 * @author Matthias Bilger
	 */
	private function buildFileUrl(){
		return $this->buildDownloadUrl(self::WORKFLOW_FILE_URL, self::WORKFLOW_FILE_EXTENSION);
	}
	/**
	 * Download file to folder.
	 * @param $target The target file of the download.
	 * @param $source The source URL.
	 * @param $force If true the download will also be done if file already exists.
	 *
	 * @return void
	 * @author Matthias Bilger
	 */
	private function doDownloadFile($target, $source, $force = false){
		if(!$force && file_exists($target)){
			return;
		}
		file_put_contents($target, fopen($source, 'r'));
		chmod($target, 0644);
	}
	/**
	 * Load the workflow file into a plist.
	 *
	 * @return void
	 * @author Matthias Bilger
	 */
	private function loadPlist(){
		if($this->plist == null){
			$workflowfile = $this->getWorkflowFilename();
			$this->plist = new CFPropertyList($workflowfile, CFPropertyList::FORMAT_AUTO);
		}
	}
	/**
	 * getActions
	 * @return CFArray
	 * @author Matthias Bilger
	 **/
	public function getActions()
	{
		$this->loadPlist();
		return $this->plist->getValue()->get('WFWorkflowActions');
	}
	/**
	 * Get the description of the workflow, if it follows the following conditions:
	 * A text block placed after an "Exit Workflow" block.
	 * @return string Description of the workflow.
	 * @author Matthias Bilger
	 **/
	public function getDescription()
	{
		if($this->description == ''){
			$actions = $this->getActions()->toArray();
			if($actions[count($actions)-2]['WFWorkflowActionIdentifier'] == 'is.workflow.actions.exit'){
				if($actions[count($actions)-1]['WFWorkflowActionIdentifier'] == 'is.workflow.actions.gettext'){
					$this->description = $actions[count($actions)-1]['WFWorkflowActionParameters']['WFTextActionText']['Value']['string'];
				}
			}
		}
		return $this->description;
	}
	/**
	 * getWorkflowSteps
	 * @return array of workflow steps
	 * @author Matthias Bilger
	 **/
	public function getWorkflowSteps()
	{
		if($this->actions == null){
			$this->actions = array();
			foreach($this->getActions() as $action){
				$this->actions[] = Action::createAction($action);
			}
		}
		return $this->actions;
	}
	/**
	 * getWorkflowStepsArray
	 * @return void
	 * @author John Doe
	 **/
	public function getWorkflowStepsArray()
	{
		$val = array();
		$nestingStack = array(array('id'=>'0'));
		foreach($this->getWorkflowSteps() as $action){
			$val[] = array(
				'name' => $action->getTypename(),
				'info' => $action->getInfo(),
				'nesting' => $action->nesting($nestingStack),
			);
		}
		return $val;
	}
	/**
	 * Check for a valid workflow id.
	 *
	 * @return boolean
	 * @author Matthias Bilger
	 */
	public function isEmpty(){
		return $this->workflowId == '';
	}
	/**
	 * getWorkflowUrl
	 * @return string
	 * @author Matthias Bilger
	 **/
	public function getWorkflowUrl()
	{
		return $this->buildDownloadUrl(self::WORKFLOW_URL_BASE);
	}
}

