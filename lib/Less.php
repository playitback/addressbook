<?php
namespace Lib;

use LessElephant\LessProject;

class Less {
	
	public static function configure()
	{
		$project = new LessProject(__DIR__ . '/../public/assets/less', 'style.less', 
			__DIR__ . '/../public/assets/css/style.css');
			
		if(!$project->isClean())
			$project->compile(); // compile the project
	}
	
}