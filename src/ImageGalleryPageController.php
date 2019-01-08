<?php

namespace Sunnysideup\ImageGalleryBasic;

use Page;




use DataObjectSorterController;





use PrettyPhoto;
use Sunnysideup\ImageGalleryBasic\ImageGalleryPage;
use SilverStripe\Assets\Folder;
use Sunnysideup\ImageGalleryBasic\Model\ImageGalleryEntry;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Assets\Image;
use PageController;

class ImageGalleryPageController extends PageController
{
    private static $allowed_actions = array(
        "updateimagegalleryentries" => "ADMIN"
    );

    public function init()
    {
        parent::init();
        if (class_exists("PrettyPhoto")) {
            PrettyPhoto::include_code();
        }
    }

    public function updateimagegalleryentries()
    {
        $this->onBeforeWrite();
        return array();
    }
}
