<?php
namespace Controller;

class AppController extends \Lib\Controller {
	
	public function indexAction()
	{
		return $this->loadView('public/index');
	}
	
}