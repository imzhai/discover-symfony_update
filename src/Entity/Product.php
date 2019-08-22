<?php

// src/Entity/Product.php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Product
{
    /** 
     * @Assert\NotBlank()
     */
    protected $name;
    
    /** 
     * @Assert\NotBlank()
     * @Assert\Length(min=10) 
     */
	protected $description;

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(string $name): Product
	{
		$this->name = $name;

		return $this;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setDescription(string $description): Product
	{
		$this->description = $description;

		return $this;
	}
}
