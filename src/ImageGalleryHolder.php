<?php

class ImageGalleryHolder extends Page
{
    private static $icon = 'imagegallery_basic/images/treeicons/ImageGalleryHolder';

    private static $allowed_children = array('ImageGalleryPage');

    private static $default_child = 'ImageGalleryPage';

    private static $description = "This page is the parent page for image galleries. ";
}


/**
  * ### @@@@ START REPLACEMENT @@@@ ###
  * WHY: upgrade to SS4
  * OLD: _Controller extends Page_Controller (case sensitive)
  * NEW: Controller extends Page_Controller (COMPLEX)
  * EXP: Remove the underscore in your classname - check all references!
  * ### @@@@ STOP REPLACEMENT @@@@ ###
  */
class ImageGalleryHolderController extends Page_Controller
{
    public function MyChildGalleries()
    {
        return ImageGalleryPage::get()->filter(array("ParentID" => $this->ID, "ShowInSearch" => 1));
    }
}
