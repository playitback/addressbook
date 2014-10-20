<?php
namespace Lib;

class Response {
	
	/** @var string	The string body to send in the response */
	private $body;
	/** @var mixed[]	An array of headers formatted with the key value being the key value of the header */
	private $headers 	= array();
	/** @var int		The response status code. Defaults to 200 OK */
	private $status 	= 200;
	
	/**
	 * Set body
	 *
	 * @param	mixed $body	The response body
	 * @return Response
	 */
	public function setBody($body)
	{
		$this->body = $body;
		
		return $this;
	}
	
	/**
	 * Get body
	 *
	 * @return mixed
	 */
	public function getBody()
	{
		return $this->body;
	}
	
	/**
	 * Set headers
	 *
	 * @param	array $headers	An array of values with a key=>value format
	 * @return Response
	 */
	public function setHeaders(array $headers)
	{
		$this->headers = $headers;
		
		return $this;
	}
	
	/**
	 * Get headers
	 *
	 * @return array
	 */
	public function getHeaders()
	{
		return $headers;
	}
	
	/**
	 * Add header
	 *
	 * @param	string	$key	The header key to be set
	 * @param	string	$value	The header value to be set against the key
	 * @return Response
	 */
	public function addHeader($key, $value)
	{
		$this->headers[$key] = $value;
		
		return $this;
	}
	
	/**
	 * Set status
	 *
	 * @param	int	$status	The HTTP status code for the response
	 * @return Response
	 */
	public function setStatus($status)
	{
		$this->status = $status;
		
		return $this;
	}
	
	/**
	 * Get status
	 *
	 * @return int
	 */
	public function getStatus()
	{
		return $this->status;
	}
	
	/**
	 * Dispatches the current response, setting the status, headers and finally printing the body
	 *
	 * @return void
	 */
	public function dispatch()
	{
		http_response_code($this->status);
		
		$this->sendHeaders();
		
		echo $this->getBody();
		exit;
	}
	
	/**
	 * Iterate and send the headers on this response
	 *
	 * @return void
	 */
	private function sendHeaders()
	{
		foreach($this->headers as $key => $val)
			header($key . ': ' . $val);	
	}
	
}