<?php
namespace Lib;

class Controller {
	
	/** @var \JMS\Serializer\Serializer */
	private $serializer = null;
	/** @var mixed */
	private $requestBody = null;
	
	/**
	 * Get an instance of the serializer
	 *
	 * @return	\JMS\Serializer\Serializer
	 */
	private function serializer()
	{
		if(!$this->serializer) {
			$this->serializer = \JMS\Serializer\SerializerBuilder::create()
				->build();
		}
		
		return $this->serializer;
	}
	
	/**
	 * Creates a response object for json content and sets the response body
	 *
	 * @param	mixed	$serializableData	The data to be serialized and set as the response body
	 * @return Lib\Response
	 */
	protected function serializeJsonResponse($serializableData)
	{
		$response = new Response();
				
		$response->addHeader('Content-Type', 'application/json');
		$response->setBody($this->serializer()->serialize($serializableData, 'json'));
		
		return $response;
	}
	
	/**
	 * Returns a 404 api-specific response
	 *
	 * @return Lib\Response
	 */
	protected function notFoundResponse()
	{
		$response = new Response();
		
		$response->addHeader('Content-Type', 'application/json');
		$response->setStatus(404);
		
		return $response;
	}
	
	/**
	 * Returns a response with a loaded view as the content body
	 *
	 * @param	string	$name	The name of the view
	 * @return Lib\Response
	 */
	protected function loadView($name)
	{
		$response = new Response();
		
		$response->addHeader('Content-Type', 'text/html');
		
		$viewPath = '../view/' . $name . '.php';
		
		if(file_exists($viewPath))
			$response->setBody(include($viewPath));
		
		return $response;
	}
	
	
	/**
	 * Gets the current request body
	 *
	 * @return	mixed
	 */
	protected function requestBody()
	{
		if(!$this->requestBody)
			$this->requestBody = file_get_contents('php://input');
		
		return $this->requestBody;
	}
	
	/**
	 * Binds the de-serialised request body to an object
	 *
	 * @param	mixed	$model	An object to be used to determine which class to be binded to and to be merged with
	 * @param	boolean	$merge	If true, the serialized object will be merged with the passed model
	 * @return mixed
	 */
	protected function bindBody($model, $merge = true)
	{
		$model = $this->bindData(
			$this->requestBody(),
			get_class($model));
					
		if($merge)
			$model = Database::$entityManager->merge($model);
		
		return $model;
	}
	
	/**
	 * Binds a json string to a model class
	 *
	 * @param	mixed	$data	The data to be de-serialised against the model class given
	 * @param	string	$class 	The name of the class to be used when deserializing the json string
	 * @return mixed	An instance of the class given, with the data binded
	 */
	protected function bindData($data, $class)
	{
		return $this->serializer()->deserialize(
			$data,
			$class,  
			'json');
	}
}