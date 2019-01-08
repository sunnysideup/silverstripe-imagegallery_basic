<?php

namespace Sunnysideup\ImageGalleryBasic;

use Page;
use PageController;

use Sunnysideup\ImageGalleryBasic\ImageGalleryPage;

class ImageGalleryHolderController extends PageController
{
    public function MyChildGalleries()
    {
        return ImageGalleryPage::get()->filter(array("ParentID" => $this->ID, "ShowInSearch" => 1));
    }
}
