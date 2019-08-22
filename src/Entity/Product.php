<?php

// src/Entity/Product.php
namespace App\Entity;

class Product
{
	protected $name;
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
