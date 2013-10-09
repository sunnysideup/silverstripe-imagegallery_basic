<?php

class ImageGalleryEntry extends DataObject {

	private static $db = array(
		"Title" => "Varchar(100)",
		"Sort" => "Int"
	);

	private static $has_one = array(
		"Parent" => "SiteTree",
		"Image" => "Image"
	);

	private static $searchable_fields = array(
		"Title" => "PartialMatchFilter"
	);

	private static $summary_fields = array(
		"Title" => "Title",
	);

	private static $field_labels = array(
		"Sort" => "Sorting Index Number (lower numbers show first)"
	);

	private static $singular_name = "ImageGalleryEntry";

	private static $plural_name = "ImageGalleryEntries";
	//CRUD settings

	private static $default_sort = "Sort ASC, Title ASC";

	private static $defaults = array(
		"Sort" => 100
	);

	public function populateDefaults() {
		parent::populateDefaults();
		$this->Sort = 100;
	}

}
