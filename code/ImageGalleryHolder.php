<?php

class ImageGalleryHolder extends Page {

	private static $icon = 'imagegallery_basic/images/treeicons/ImageGalleryHolder';

	private static $allowed_children = array('ImageGalleryPage');

	private static $default_child = 'ImageGalleryPage';

	private static $description = "This page is the parent page for image galleries. ";


}

class ImageGalleryHolder_Controller extends Page_Controller {

	function MyChildGalleries(){
		return ImageGalleryPage::get()->filter(array("ParentID" => $this->ID, "ShowInSearch" => 1));
	}


}
