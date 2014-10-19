<?php
$this->add('app', '/')
	->addValues(array(
		'controller' 	=> 'AppController',
		'action' 		=> 'indexAction'
	));

$this->addGet('getContacts', '/api/contacts')
	->addValues(array(
		'controller'	=> 'Api\ContactController',
		'action'		=> 'getIndex'
	));

$this->addPost('createContact', '/api/contact')
	->addValues(array(
		'controller'	=> 'Api\ContactController',
		'action'		=> 'postIndex'
	));
	
$this->addPut('updateContact', '/api/contact/{id}')
	->addValues(array(
		'controller'	=> 'Api\ContactController',
		'action'		=> 'putIndex'
	));

$this->addDelete('deleteContact', '/api/contact/{id}')
	->addValues(array(
		'controller'	=> 'Api\ContactController',
		'action'		=> 'deleteIndex'
	));