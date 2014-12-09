<?php

namespace YAFF\Database\Entity;

/**
 * @Table(name="yaff_general_configuration")
 * @Entity
 */
class GeneralConfiguration {
	/**
	 * @Id
	 * @Column(type="integer")
	 * @GeneratedValue
	 */
	private $id;
	
	/**
	 * @Column(type="integer")
	 */
	private $columns;  
	
	/**
	 * @Column(type="integer")
	 */
	private $rows;
	
	/**
	 * Constructor
	 */
	public function __construct() {
	}
	
	/**
	 * Gets the id
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Gets the columns
	 */
	public function getcolumns()
	{
		return $this->columns;
	}
	
	/**
	 * Sets the columns
	 */
	public function setcolumns($value)
	{
		$this->columns = $value;
	}
	
	/**
	 * Sets the rows
	 */
	public function getrows()
	{
		return $this->rows;
	}
	
	public function setrows($value)
	{
		$this->rows = $value;
	}
}
?>