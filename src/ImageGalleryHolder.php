<?php

namespace Sunnysideup\ImageGalleryBasic;

use Page;

use Sunnysideup\ImageGalleryBasic\ImageGalleryPage;
use PageController;

class ImageGalleryHolder extends Page
{
    private static $table_name = 'ImageGalleryHolder';

    private static $icon = 'imagegallery_basic/images/treeicons/ImageGalleryHolder';

    private static $allowed_children = array(ImageGalleryPage::class);

    private static $default_child = ImageGalleryPage::class;

    private static $description = "This page is the parent page for image galleries. ";
}
