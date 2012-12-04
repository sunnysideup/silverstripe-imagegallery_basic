<?php

class ImageGalleryEntry extends DataObject {

	static $db = array(
		"Title" => "Varchar(100)",
		"Sort" => "Int"
	);

	static $has_one = array(
		"Parent" => "SiteTree",
		"Image" => "Image"
	);

	static function get_has_many_complex_table_field($controller, $name) {
		return new HasManyComplexTableField(
			$controller,
			$name,
			"ImageGalleryEntry",
			$fieldList = self::$summary_fields,
			$detailFormFields = null,
			$sourceFilter = "ParentID = ".$controller->ID,
			$sourceSort = "Sort ASC, Title ASC",
			$sourceJoin = ""
		);
	}

	public static $searchable_fields = array(
		"Title" => "PartialMatchFilter"
	);

	public static $summary_fields = array(
		"Title" => "Title",
	);

	public static $field_labels = array(
		"Sort" => "Sorting Index Number (lower numbers show first)"
	);

	public static $singular_name = "ImageGalleryEntry";

	public static $plural_name = "ImageGalleryEntries";
	//CRUD settings

	public static $default_sort = "Sort ASC, Title ASC";

	public static $defaults = array(
		"Sort" => 100
	);

	public function populateDefaults() {
		parent::populateDefaults();
		$this->Sort = 100;
	}

}
