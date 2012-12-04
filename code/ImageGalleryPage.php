<?php

class ImageGalleryPage extends Page {

	static $icon = "imagegallery_basic/images/treeicons/ImageGalleryPage";

	static $allowed_children = array("ImageGalleryPage"); //can also be "none";

	static $default_child = "ImageGalleryPage";

	static $db = array();

	static $has_one = array(
		"AutomaticallyIncludedFolder" => "Folder"
	);

	static $has_many = array(
		"ImageGalleryEntries" => "ImageGalleryEntry"
	);

	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab("Root.Content.Gallery", new TreeDropdownField($name = "AutomaticallyIncludedFolderID", $title = "Automatically Included Folder (save page to update) - go to Files and Images section to create folder and upload images.", $sourceObjectName = "Folder"));
		$fields->addFieldToTab("Root.Content.Gallery", ImageGalleryEntry::get_has_many_complex_table_field($this, "ImageGalleryEntries"));
		return $fields;
	}

	public function onBeforeWrite() {
		parent::onBeforeWrite();
		$imageAdded = false;
		if($this->AutomaticallyIncludedFolderID) {
			if($folder = DataObject::get_by_id("Folder", $this->AutomaticallyIncludedFolderID)) {
				if($files = DataObject::get("Image", "ParentID = ".$folder->ID)) {
					foreach($files as $file) {
						if(DataObject::get_one("ImageGalleryEntry", "ImageID = ".$file->ID." AND ParentID = ".$this->ID)) {
							//do nothing
						}
						else {
							$ImageGalleryEntry = new ImageGalleryEntry();
							$ImageGalleryEntry->Title = $file->Title;
							$ImageGalleryEntry->ImageID = $file->ID;
							$ImageGalleryEntry->ParentID = $this->ID;
							$ImageGalleryEntry->write();
							$imageAdded = true;
						}
					}
				}
			}
		}
		if($ImageGalleryEntries = DataObject::get("ImageGalleryEntry", "ParentID = ".$this->ID)){
			foreach($ImageGalleryEntries as $ImageGalleryEntry) {
				if($image = DataObject::get_one("Image", "File.ID = ".$ImageGalleryEntry->ImageID." AND File.Title <> '".$ImageGalleryEntry->Title."'")) {
					$image->Title = $image->Name = $ImageGalleryEntry->Title;
					$image->write();
				}
			}
		}
		if($imageAdded) {
			LeftAndMain::ForceReload();
		}
	}

	function NextGallery(){
		$extension = '';
		if(Versioned::current_stage() == "Live") {
			$extension = "_Live";
		}
		$pages = $livePage = DataObject::get("ImageGalleryPage", "ImageGalleryPage$extension.ID <> ".$this->ID." AND TimeDiff(\"Created\",'".$this->Created."') > 0", "\"Created\" ASC", null,1 );
		if($pages) {
			foreach($pages as $page) {
				return $page;
			}
		}
	}

	function PreviousGallery(){
		$extension = '';
		if(Versioned::current_stage() == "Live") {
			$extension = "_Live";
		}
		$pages = DataObject::get("ImageGalleryPage", "ImageGalleryPage$extension.ID <> ".$this->ID." AND TimeDiff(\"Created\",'".$this->Created."') < 0", "\"Created\" DESC", null,1 );
		if($pages) {
			foreach($pages as $page) {
				return $page;
			}
		}
	}



}

class ImageGalleryPage_Controller extends Page_Controller {

	public function init() {
		parent::init();
		if(class_exists("PrettyPhoto")) {
			PrettyPhoto::include_code();
		}
	}

	function updateimagegalleryentries() {
		$this->onBeforeWrite();
		return array();
	}


}
