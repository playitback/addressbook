<?php
namespace Model;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;

/**
 * Contact model
 * 
 * @ORM\Entity
 * @ORM\Table(name="contact_attribute")
 */
class ContactAttribute {
	
	/**
	 * @Type("integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;
	
	/** 
	 * @Type("string")
	 * @ORM\Column(type="string", length=100, nullable=false)
	 */
	private $label;
	
	/** 
	 * @Type("string")
	 * @ORM\Column(type="string", length=100, nullable=false)
	 */
	private $value;
	
	/**
	 * @Type("Contact")
	 * @ORM\ManyToOne(targetEntity="Contact", inversedBy="attributes", cascade={"persist"})
	 */
	private $contact;
	

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set label
     *
     * @param string $label
     * @return ContactAttribute
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string 
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return ContactAttribute
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set contact
     *
     * @param \Model\Contact $contact
     * @return ContactAttribute
     */
    public function setContact(\Model\Contact $contact = null)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \Model\Contact 
     */
    public function getContact()
    {
        return $this->contact;
    }
}
