<?php
namespace Model;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;

/**
 * Contact model
 * 
 * @ORM\Entity
 * @ORM\Table(name="contact")
 */
class Contact {
	
	/* !Properties */
	
	/** 
	 * @Type("integer")
	 * @ORM\Id 
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer") 
	 */
	private $id;
	
	/** 
	 * @Type("string") 
	 * @ORM\Column(name="first_name", type="string", length=255, nullable=false)
	 */
	private $firstName;
	
	/** 
	 * @Type("string") 
	 * @ORM\Column(name="last_name", type="string", length=255, nullable=false)
	 */
	private $lastName;
	
	/** 
	 * @Type("string") 
	 * @ORM\Column(name="company_name", type="string", length=255, nullable=true)
	 */
	private $companyName;
	
	/**
	 * @Type("ArrayCollection<Model\ContactAttribute>") 
	 * @ORM\OneToMany(targetEntity="ContactAttribute", mappedBy="contact", cascade={"persist", "remove"}) 
	 */
	private $attributes;
	
	
	/* !Data Helpers */
	
	public function bind(array $data)
	{
		if(isset($data['first_name']))
			$this->firstName = $data['first_name'];
		if(isset($data['last_name']))
			$this->lastName = $data['last_name'];
	}
	
	public function validate()
	{
		if(!isset($this->firstName) || empty($this->firstName))
			throw new Lib/Exception/ValidationException("First name field is required");
	}
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attributes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Contact
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * Set firstName
     *
     * @param string $firstName
     * @return Contact
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Contact
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set companyName
     *
     * @param string $companyName
     * @return Contact
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string 
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }
    
    /**
	 * Set attributes
	 *
	 * @param	\Doctrine\Common\Collections\ArrayCollection
	 * @return Contact
	 */
	public function setAttributes(\Doctrine\Common\Collections\ArrayCollection $attributes)
	{
		$this->attributes = $attributes;
		
		return $this;
	}

    /**
     * Add attributes
     *
     * @param \Model\ContactAttribute $attributes
     * @return Contact
     */
    public function addAttribute(\Model\ContactAttribute $attribute)
    {
        $this->attributes[] = $attribute;
        
        $attribute->setContact($this);

        return $this;
    }

    /**
     * Remove attributes
     *
     * @param \Model\ContactAttribute $attributes
     */
    public function removeAttribute(\Model\ContactAttribute $attributes)
    {
        $this->attributes->removeElement($attributes);
    }

    /**
     * Get attributes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
}
