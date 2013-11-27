<?php
/**
 * @author Christoph Bessei
 * @version
 */

class Option_Page {
	private $name;
	private $title;
	private $option_groups;


	/**
	 * Create new option page
	 *
	 * @param $name  string unique name of the option page
	 * @param $title string title which is show in the menu and as title on the page
	 */
	public function __construct( $name, $title ) {
		$this->name  = $name;
		$this->title = $title;
	}

	public function add_option_group( Option_Group $option_group ) {
		$this->option_groups[] = $option_group;
	}

	/**
	 * @param Option_Group[] $option_groups
	 */
	public function set_option_groups( array $option_groups ) {
		$this->option_groups = $option_groups;
	}

	/**
	 * @return Option_Group[]
	 */
	public function get_option_groups() {
		return $this->option_groups;
	}

	/**
	 * @param mixed $name
	 */
	public function set_name( $name ) {
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * @param mixed $title
	 */
	public function set_title( $title ) {
		$this->title = $title;
	}

	/**
	 * @return mixed
	 */
	public function get_title() {
		return $this->title;
	}

} 