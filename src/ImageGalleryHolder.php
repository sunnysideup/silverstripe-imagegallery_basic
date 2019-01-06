<?php

namespace Sunnysideup\ImagegalleryBasic;

use Page;

use Sunnysideup\ImagegalleryBasic\ImageGalleryPage;
use PageController;



class ImageGalleryHolder extends Page
{
    private static $icon = 'imagegallery_basic/images/treeicons/ImageGalleryHolder';

    private static $allowed_children = array(ImageGalleryPage::class);

    private static $default_child = ImageGalleryPage::class;

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
class ImageGalleryHolderController extends PageController
{
    public function MyChildGalleries()
    {
        return ImageGalleryPage::get()->filter(array("ParentID" => $this->ID, "ShowInSearch" => 1));
    }
}
