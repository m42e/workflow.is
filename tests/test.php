<?php

namespace M42e\Workflow\Tests;
use M42e\Workflow\Workflow;
require (__DIR__.'/../vendor/autoload.php');

Workflow::$targetdir = '/tmp/workflow';
$wf = Workflow::createFromUrl('https://workflow.is/workflows/dc4c0bdfe3c94d1d9147ff57a7d50af3');
var_dump($wf);
$wf->download();
$wf->loadPlist();
var_dump($wf);
