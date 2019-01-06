<?php

namespace Sunnysideup\ImagegalleryBasic\Model;


use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;



class ImageGalleryEntry extends DataObject
{
    private static $singular_name = "Image Gallery Picture";

    private static $plural_name = "Image Gallery Pictures";

    private static $db = array(
        "Title" => "Varchar(100)",
        "Sort" => "Int"
    );

    private static $has_one = array(
        "Parent" => SiteTree::class,
        "Image" => Image::class
    );

    private static $searchable_fields = array(
        "Title" => "PartialMatchFilter"
    );

    private static $summary_fields = array(
        "Image.CMSThumbNail" => "Image",
        "Title" => "Title"
    );

    private static $field_labels = array(
        "Sort" => "Sorting Index Number (lower numbers show first)"
    );

    private static $casting = array(
        "BestTitle" => "Varchar"
    );

    //CRUD settings

    private static $default_sort = "Sort ASC, Title ASC";

    private static $defaults = array(
        "Sort" => 100
    );

    public function getBestTitle()
    {
        $image = $this->Image();
        if ($image && $image->exists()) {
            if ($image->Title) {
                if ($this->Title !== $image->Title) {
                    $this->Title = $image->Title;
                    $this->write();
                }
                return $image->Title;
            }
        }
        return $this->Title;
    }

    public function populateDefaults()
    {
        parent::populateDefaults();
        $this->Sort = 100;
    }

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeFieldFromTab('Root.Main', 'Title');

        return $fields;
    }
}
