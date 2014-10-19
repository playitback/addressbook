<?php
namespace Test;

class ContactsTest extends Base {
	
	public function __construct()
	{
		$this->deleteAllContacts();
	}
	
	public function testCreate()
	{
		$originalData = array(
			'first_name'		=> 'Test',
			'last_name' 		=> 'Contact',
			'company_name'	=> 'Test Company',
			'attributes'		=> array(
				array(
					'label'				=> 'email',
					'value'				=> 'joebloggs@me.com'
				)
			)
		);
		
		$request = $this->httpClient()
			->post('/api/contact', null, json_encode($originalData));
		$response = $request->send();
		
		$this->assertModifyResponse($response, $originalData);
	}
	
	public function testGet()
	{
		$request = $this->httpClient()
			->get('/api/contacts');
		$response = $request->send();
		
		// Test response
		$this->assertEquals(200, $response->getStatusCode());
		
		$data = json_decode($response->getBody(true));
		
		$this->assertNotNull($data);
		$this->assertNotEmpty($data);
		
		
		// Test db
		$contacts = $this->entityManager()->getRepository('Model\Contact')
			->findAll();
		
		$this->assertNotNull($contacts);
		$this->assertNotEmpty($contacts);
	}
	
	public function testUpdate()
	{
		$contact = $this->entityManager()->getRepository('Model\Contact')
			->findOneByFirstName('Test');
			
		$this->assertNotNull($contact);
		
		$originalData = array(
			'id'				=> $contact->getId(),
			'first_name'		=> 'TestUD',
			'last_name' 		=> 'ContactUD',
			'company_name'	=> 'Test CompanyUD',
			'attributes'		=> array(
				array(
					'label'				=> 'email',
					'value'				=> 'joebloggs@me.comUD'	
				)
			)
		);
		
		$request = $this->httpClient()
			->put('/api/contact/' . $contact->getId(), null, json_encode($originalData));
		$response = $request->send();
		
		$this->assertModifyResponse($response, $originalData);

	}
	
	public function testDelete()
	{
		$contact = $this->entityManager()->getRepository('Model\Contact')
			->findOneByFirstName('TestUD');
			
		$this->assertNotNull($contact);
		
		$request = $this->httpClient()
			->delete('/api/contact/' . $contact->getId());
		$response = $request->send();
		
		$this->assertEquals(200, $response->getStatusCode());
		
		$contact = $this->entityManager()->getRepository('Model\Contact')
			->findOneByFirstName('TestUD');
			
		$this->assertNull($contact);
	}
	
	private function deleteAllContacts()
	{
		$contacts = $this->entityManager()->getRepository('Model\Contact')
			->findAll();
		
		foreach($contacts as $contact)
			$this->entityManager()->remove($contact);
		
		$this->entityManager()->flush();
		$this->entityManager()->clear();
	}
	
	private function assertModifyResponse($response, $originalData)
	{
		// Ensure the data store is up to date
		$this->entityManager()->clear();
		
		// Test response
		$this->assertEquals(200, $response->getStatusCode());
		
		$data = json_decode($response->getBody(true), true);
		
		$this->assertArrayHasKey('id', $data);
		$this->assertArrayHasKey('first_name', $data);
		$this->assertEquals($data['first_name'], $originalData['first_name']);
		$this->assertArrayHasKey('last_name', $data);
		$this->assertEquals($data['last_name'], $originalData['last_name']);
		$this->assertArrayHasKey('company_name', $data);
		$this->assertEquals($data['company_name'], $originalData['company_name']);
		$this->assertArrayHasKey('attributes', $data);
		$this->assertNotEmpty($data['attributes']);
		
		$attributeData = $data['attributes'][0];
		$this->assertArrayHasKey('id', $attributeData);
		$this->assertArrayHasKey('label', $attributeData);
		$this->assertEquals($attributeData['label'], $originalData['attributes'][0]['label']);
		$this->assertArrayHasKey('value', $attributeData);
		$this->assertEquals($attributeData['value'], $originalData['attributes'][0]['value']);
		
		
		// Test db data
		$contact = $this->entityManager()->getRepository('Model\Contact')
			->findOneById($data['id']);
		
		$this->assertNotNull($contact);
		$this->assertEquals($contact->getId(), $data['id']);
		$this->assertEquals($contact->getFirstName(), $data['first_name']);
		$this->assertEquals($contact->getLastName(), $data['last_name']);
		$this->assertEquals($contact->getCompanyName(), $data['company_name']);
		$this->assertNotEmpty($contact->getAttributes());
		
		$attribute = $contact->getAttributes()[0];
		$this->assertEquals($attribute->getId(), $attributeData['id']);
		$this->assertEquals($attribute->getLabel(), $attributeData['label']);
		$this->assertEquals($attribute->getValue(), $attributeData['value']);
	}
	
}