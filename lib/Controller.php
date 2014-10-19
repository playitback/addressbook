<?php
namespace Lib;

class Controller {
	
	private $serializer = null;
	private $requestBody = null;
	
	private function serializer()
	{
		if(!$this->serializer) {
			$this->serializer = \JMS\Serializer\SerializerBuilder::create()
				->build();
		}
		
		return $this->serializer;
	}
	
	protected function serializeJsonResponse($serializableData)
	{
		$response = new Response();
				
		$response->addHeader('Content-Type', 'application/json');
		$response->setBody($this->serializer()->serialize($serializableData, 'json'));
		
		return $response;
	}
	
	protected function notFoundResponse()
	{
		$response = new Response();
		
		$response->addHeader('Content-Type', 'application/json');
		$response->setStatus(404);
		
		return $response;
	}
	
	protected function requestBody()
	{
		if(!$this->requestBody)
			$this->requestBody = file_get_contents('php://input');
		
		return $this->requestBody;
	}
	
	protected function bindBody($model, $merge = true)
	{
		$model = $this->bindData(
			$this->requestBody(),
			get_class($model));
					
		if($merge)
			$model = Database::$entityManager->merge($model);
		
		return $model;
	}
	
	protected function bindData($data, $class)
	{
		return $this->serializer()->deserialize(
			$data,
			$class,  
			'json');
	}
	
	protected function loadView($name)
	{
		$viewPath = '../view/' . $name . '.php';
		
		if(file_exists($viewPath))
			return include($viewPath);
	}
	
}