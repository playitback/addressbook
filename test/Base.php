<?php
namespace Test;

require_once(__DIR__ . '/../bootstrap.php');

use Guzzle\Http\Client;

class Base extends \PHPUnit_Framework_TestCase {
	
	private $client;
	
	protected function entityManager()
	{
		return \Lib\Database::$entityManager;
	}
	
	protected function httpClient()
	{
		if(!$this->client) {
			$this->client = new Client('http://addressbook.dev', array(
				'request.options' => array(
				    'exceptions' => false,
				)
			));
		}
		
		return $this->client;
	}
	
}