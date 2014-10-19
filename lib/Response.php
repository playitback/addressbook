<?php
namespace Lib;

class Response {
	
	/** @var string	The string body to send in the response */
	private $body;
	/** @var mixed[]	An array of headers formatted with the key value being the key value of the header */
	private $headers 	= array();
	/** @var int		The response status code. Defaults to 200 OK */
	private $status 	= 200;
	
	public function setBody($body)
	{
		$this->body = $body;
		
		return $this;
	}
	
	public function getBody()
	{
		return $this->body;
	}
	
	
	public function setHeaders(array $headers)
	{
		$this->headers = $headers;
		
		return $this;
	}
	
	public function getHeaders()
	{
		return $headers;
	}
	
	public function addHeader($key, $value)
	{
		$this->headers[$key] = $value;
		
		return $this;
	}
	
	public function setStatus($status)
	{
		$this->status = $status;
		
		return $this;
	}
	
	public function getStatus()
	{
		return $this->status;
	}
	
	public function dispatch()
	{
		http_response_code($this->status);
		
		$this->sendHeaders();
		
		echo $this->getBody();
		exit;
	}
	
	private function sendHeaders()
	{
		foreach($this->headers as $key => $val)
			header($key . ': ' . $val);	
	}
	
}