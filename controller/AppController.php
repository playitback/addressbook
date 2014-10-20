<?php
namespace Controller;

class AppController extends \Lib\Controller {
	
	/**
	 * Render the app index view
	 *
	 * @return Lib\Response
	 */
	public function indexAction()
	{
		return $this->loadView('public/index');
	}
	
}