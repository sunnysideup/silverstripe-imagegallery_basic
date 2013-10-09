<?php

class ImageGalleryPage extends Page {

	private static $icon = "imagegallery_basic/images/treeicons/ImageGalleryPage";

	private static $allowed_children = array("ImageGalleryPage"); //can also be "none";

	private static $default_child = "ImageGalleryPage";

	private static $description = "Page used to display images in a gallery";

	private static $has_one = array(
		"AutomaticallyIncludedFolder" => "Folder"
	);

	private static $has_many = array(
		"ImageGalleryEntries" => "ImageGalleryEntry"
	);

	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab("Root.Gallery", new TreeDropdownField($name = "AutomaticallyIncludedFolderID", $title = "Automatically Included Folder (save page to update) - go to Files and Images section to create folder and upload images.", $sourceObjectName = "Folder"));
		$gridField = new GridField('images', 'Linked images', $this->ImageGalleryEntries(), GridFieldConfig_RelationEditor::create());
		$fields->addFieldToTab("Root.Gallery", $gridField);
		return $fields;
	}

	public function onBeforeWrite() {
		parent::onBeforeWrite();
		$imageAdded = false;
		if($this->AutomaticallyIncludedFolderID) {
			if($folder = Folder::get()->byID($this->AutomaticallyIncludedFolderID)) {
				if($files = Image::get()->filter("ParentID",$folder->ID)) {
					foreach($files as $file) {
						if(ImageGalleryEntry::get()->filter(array("ImageID" => $file->ID, "ParentID" => $this->ID))) {
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
		if($ImageGalleryEntries = ImageGalleryEntry::get()->filter(array("ParentID" => $this->ID))){
			foreach($ImageGalleryEntries as $ImageGalleryEntry) {
				$image = Image::get()
					->filter(array("ID" => $ImageGalleryEntry->ImageID))
					->exclude(array("Title" => $ImageGalleryEntry->Title))
					->First();
				if($image) {
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
		$pages = ImageGalleryPage::get()
			->exclude(array("ID" => $this->ID))
			->where("TimeDiff(\"Created\",'".$this->Created."') > 0")
			->sort("Created", "ASC")
			->limit(1);
		if($pages) {
			foreach($pages as $page) {
				return $page;
			}
		}
	}

	function PreviousGallery(){
		$pages = ImageGalleryPage::get()
			->exclude(array("ID" => $this->ID))
			->where("TimeDiff(\"Created\",'".$this->Created."') < 0")
			->sort("Created", "DESC")
			->limit(1);
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
