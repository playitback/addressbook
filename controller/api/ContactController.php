<?php
namespace Controller\Api;

class ContactController extends \Lib\Controller {
	
	/**
	 * Returns a serialised copy of all available contacts
	 *
	 * @return	Lib\Response
	 */
	public function getIndex()
	{
		$contacts = \Lib\Database::$entityManager->getRepository('Model\Contact')
			->findAll();
		
		return $this->serializeJsonResponse($contacts);
	}
	
	/**
	 * Creates a new contact using the request body
	 */
	public function postIndex()
	{
		$contact = $this->bindBody(new \Model\Contact, false);
		
		// JMS Serializer/Doctrine doesn't automatically inverse relations
		// So to get the relation to persist, we need to assign the contact on the attribute
		foreach($contact->getAttributes() as $attribute)
		{
			$attribute->setContact($contact);
			
			\Lib\Database::$entityManager->persist($attribute);
		}
		
		\Lib\Database::$entityManager->persist($contact);
		\Lib\Database::$entityManager->flush();
		
		return $this->serializeJsonResponse($contact);
	}
	
	/**
	 * Updates an existing contact with the request body
	 *
	 * @param	integer	$id	The unique identifier of the contact to update
	 * @return Lib\Response
	 */
	public function putIndex($id)
	{
		$contact = \Lib\Database::$entityManager->getRepository('Model\Contact')
			->findOneById($id);
			
		if(!$contact)
			return $this->notFoundResponse();
			
		// Clean all existing attributes
		$attributes = $contact->getAttributes();
		foreach($attributes as $attribute)
			\Lib\Database::$entityManager->remove($attribute);
			
		\Lib\Database::$entityManager->flush();
		$contact->setAttributes(new \Doctrine\Common\Collections\ArrayCollection);
		
		// Bind the contact data to the object
		$contact = $this->bindBody($contact);
		
		// Merging the existing model with the new data clears the attributes
		// Otherwise it'll create a new contact
		// So we need to manually extract the attributes and bind them manually to the contact
		$manuallyDecodedContact = json_decode($this->requestBody());
		if(isset($manuallyDecodedContact->attributes))
		{
			$attributes = $this->bindData(
				json_encode($manuallyDecodedContact->attributes),
				'array<Model\ContactAttribute>'
			);
				
			foreach($attributes as $attribute)
				$contact->getAttributes()->add($attribute);
		}
		
		// JMS Serializer/Doctrine doesn't automatically inverse relations
		// So to get the relation to persist, we need to assign the contact on the attribute
		foreach($contact->getAttributes() as $attribute)
		{
			$attribute->setContact($contact);
			
			\Lib\Database::$entityManager->persist($attribute);
		}
		
		\Lib\Database::$entityManager->flush();
		
		return $this->serializeJsonResponse($contact);
	}
	
	/**
	 * 
	 * 
	 * @return	Lib\Response
	 */
	public function deleteIndex($id)
	{
		$contact = \Lib\Database::$entityManager->getRepository('Model\Contact')
			->findOneById($id);
			
		if(!$contact)
			return $this->notFoundResponse();
		
		\Lib\Database::$entityManager->remove($contact);
		\Lib\Database::$entityManager->flush();
		
		return $this->serializeJsonResponse(array());
	}
	
}