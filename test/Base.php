<?php
namespace Test;

require_once(__DIR__ . '/../bootstrap.php');

use Guzzle\Http\Client;

class Base extends \PHPUnit_Framework_TestCase {
	
	/** @var Guzzle\Http\Client */
	private $client;
	
	/**
	 * Returns an instance of the entityManager
	 *
	 * @return Doctrine\ORM\EntityManager
	 */
	protected function entityManager()
	{
		return \Lib\Database::$entityManager;
	}
	
	/**
	 * Returns a shared instance of the http client
	 *
	 * @return Guzzle\Http\Client
	 */
	protected function httpClient()
	{
		if(!$this->client) {
			$this->client = new Client('http://addressbook.nickbabenko.com', array(
				'request.options' => array(
				    'exceptions' => false,
				)
			));
		}
		
		return $this->client;
	}
	
}
