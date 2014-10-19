<?php
namespace Lib;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Database {
	
	public static $entityManager;
	
	public static function configure()
	{
		$databaseParams = include(__DIR__ . '/../config.php');
		
		if(!isset($databaseParams['database']))
			throw new Exception('Database configuration not set');
		else
			$databaseParams = $databaseParams['database'];
		
		$config = Setup::createAnnotationMetadataConfiguration(
			array(
				__DIR__ . '/../model'
			),
			true,
			__DIR__ . '/../tmp/proxies',
			null,
			false);
		
		self::$entityManager = EntityManager::create($databaseParams, $config);
		
		\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
			'JMS\Serializer\Annotation', __DIR__ . '/../vendor/jms/serializer/src'
		);
	}
	
}